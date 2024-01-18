<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DefermentApplication>
 */
class DefermentApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['rejected','approved','reviewing','process','draft','pending']);
        return [
            'student_id' => Student::factory()->create()->id,
            'Status' => $status,
            'submitted_at' => $status == 'draft' ? null : fake()->time(),
            'semester' => fake()->randomElement(['2022/2023-2', '2022/2023-1', '2023/2024-1', '2023/2024-2']),
            'type' => fake()->randomElement(['academic', 'personal', 'medical', 'other']),
            'details' => fake()->paragraph,
        ];
    }
}
