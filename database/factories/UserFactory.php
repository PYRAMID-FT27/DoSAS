<?php

namespace Database\Factories;

use App\Models\User;
use http\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
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
        $user = User::orderBy('id', 'desc')->first();
        $lastInsertId = empty($user)?0:(int)$user->id;
        $lastInsertId++;
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'metric_no' => $this->generateMatric($lastInsertId),
            'role' => fake()->randomElement(['faculty', 'student', 'assistant']),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'phone_number' => fake()->phoneNumber()
        ];
    }


    protected function generateMatric($id)
    {
        return sprintf('%s%s%04d', 'MAN', date('y'), $id);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
