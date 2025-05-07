<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Request\UploadTrackRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{Track, File, Genre};
use Illuminate\Support\Facades\{Auth, Storage};

class TrackController extends Controller
{
    public function create() {
        return view('track.upload');
    }

    /**
     * Сохранить новый трек
     */
    public function store(UploadTrackRequest $request)
    {
        // Валидация данных
        $validated = $request->validate();

        // Обработка жанра - найти существующий или создать новый
        $genre = Genre::firstOrCreate(['name' => $validated['genre']]);

        // Обработка аудио файла
        $audioFile = $request->file('audio_file');
        $audioFileName = Str::uuid() . '.' . $audioFile->getClientOriginalExtension();
        $audioPath = $audioFile->storeAs('tracks', $audioFileName, 'public');

        // Создание записи файла
        $file = File::create([
            'original_name' => $audioFile->getClientOriginalName(),
            'path' => $audioPath,
            'hash' => md5_file($audioFile->getRealPath()),
            'size' => $audioFile->getSize(),
        ]);

        // Обработка обложки
        $coverImage = $request->file('cover_image');
        $coverFileName = Str::uuid() . '.' . $coverImage->getClientOriginalExtension();
        $coverPath = $coverImage->storeAs('covers', $coverFileName, 'public');

        // Создание трека
        $track = Track::create([
            'user_id' => Auth::id(),
            'file_id' => $file->id,
            'genre_id' => $genre->id,
            'title' => $validated['title'],
            'cover_image' => $coverPath,
        ]);

        return redirect()->route('tracks.show', $track)
            ->with('success', 'Трек успешно загружен!');
    }

    /**
     * Поиск жанров для автозаполнения
     */
    public function searchGenres(Request $request)
    {
        $query = $request->get('query');

        $genres = Genre::where('name', 'like', "%{$query}%")
            ->orderBy('name')
            ->limit(10)
            ->get();

        return response()->json($genres);
    }
}
