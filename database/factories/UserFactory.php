<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->userName(), // Уникальное имя пользователя
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'user',
            'is_blocked' => false,
            'avatar' => null,
            'bio' => fake()->optional()->paragraph(),
        ];
    }

    /**
     * Indicate that the user should be an admin.
     */
    public function admin(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'admin',
        ]);
    }

    /**
     * Indicate that the user should be blocked.
     */
    public function blocked(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_blocked' => true,
        ]);
    }

    /**
     * Indicate that the user should have an avatar.
     */
    public function withAvatar(): static
    {
        return $this->state(fn(array $attributes) => [
            'avatar' => 'avatars/' . fake()->uuid() . '.jpg',
        ]);
    }
}