<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Track>
 */
class TrackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'cover_image' => 'covers/' . fake()->uuid() . '.jpg',
            'genre_id' => Genre::factory(),
            'user_id' => User::factory(),
        ];
    }

    /**
     * Indicate that the track should be soft deleted.
     */
    public function deleted(): static
    {
        return $this->state(fn(array $attributes) => [
            'deleted_at' => now(),
        ]);
    }

    /**
     * Indicate that the track should not have a cover image.
     */
    public function withoutCover(): static
    {
        return $this->state(fn(array $attributes) => [
            'cover_image' => null,
        ]);
    }
}
