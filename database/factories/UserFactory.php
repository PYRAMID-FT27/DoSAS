<?php

namespace Database\Factories;

use http\Exception\InvalidArgumentException;
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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'metric_no' => $this->generateMatric(),
            'role' => fake()->randomElement(['faculty', 'student', 'assistant']),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'phone_number' => fake()->phoneNumber()
        ];
    }


    protected function generateMatric()
    {
        $prefixes = ['PAN', 'MAN'];
        $prefix = fake()->randomElement($prefixes);
        return sprintf('%s%s%03d', $prefix, date('y'), fake()->unique()->numberBetween(1, 9999));
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
