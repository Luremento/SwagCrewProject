<?php

namespace Tests\Feature;

use App\Http\Requests\UploadTrackRequest;
use App\Models\Genre;
use App\Models\Track;
use App\Models\User;
use App\Models\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class TrackControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Создаем тестового пользователя
        $this->user = User::factory()->create();

        // Настраиваем фейковое хранилище
        Storage::fake('public');
    }

    /** @test */
    public function authenticated_user_can_store_track_successfully()
    {
        // Arrange
        $this->actingAs($this->user);

        $trackData = [
            'title' => 'Test Track Title',
            'genre' => 'Electronic',
        ];

        // Создаем фейковые файлы
        $audioFile = UploadedFile::fake()->create('test-audio.mp3', 1024, 'audio/mpeg');
        $coverImage = UploadedFile::fake()->image('cover.jpg', 600, 600);

        // Act
        $response = $this->post(route('tracks.store'), array_merge($trackData, [
            'audio_file' => $audioFile,
            'cover_image' => $coverImage,
        ]));

        // Assert
        $track = Track::first();

        // Проверяем редирект
        $response->assertRedirect(route('tracks.show', $track));
        $response->assertSessionHas('success', 'Трек успешно загружен!');

        // Проверяем создание трека в БД
        $this->assertDatabaseHas('tracks', [
            'title' => 'Test Track Title',
            'user_id' => $this->user->id,
        ]);

        // Проверяем создание жанра
        $this->assertDatabaseHas('genres', [
            'name' => 'Electronic',
        ]);

        // Проверяем создание файла
        $this->assertDatabaseHas('files', [
            'original_name' => 'test-audio.mp3',
            'fileable_type' => Track::class,
            'fileable_id' => $track->id,
        ]);

        // Проверяем, что файлы сохранены
        Storage::disk('public')->assertExists($track->cover_image);

        $file = $track->files()->first();
        Storage::disk('public')->assertExists($file->path);

        // Проверяем связи
        $this->assertEquals($this->user->id, $track->user_id);
        $this->assertEquals('Electronic', $track->genre->name);
        $this->assertEquals(1, $track->files()->count());
    }

    /** @test */
    public function store_creates_new_genre_if_not_exists()
    {
        // Arrange
        $this->actingAs($this->user);

        $newGenreName = 'Unique Genre Name';

        // Убеждаемся, что жанр не существует
        $this->assertDatabaseMissing('genres', ['name' => $newGenreName]);

        // Act
        $response = $this->post(route('tracks.store'), [
            'title' => 'Test Track',
            'genre' => $newGenreName,
            'audio_file' => UploadedFile::fake()->create('audio.mp3', 1024, 'audio/mpeg'),
            'cover_image' => UploadedFile::fake()->image('cover.jpg', 600, 600),
        ]);

        // Assert
        $this->assertDatabaseHas('genres', ['name' => $newGenreName]);

        $track = Track::first();
        $this->assertEquals($newGenreName, $track->genre->name);
    }

    protected function tearDown(): void
    {
        // Очищаем моки
        \Mockery::close();
        parent::tearDown();
    }
}
