<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ic' => $this->generatePassport(),
            'nationality'=>fake()->company,
            'program_code'=> fake()->randomElement(['PRTG','MANPA1CKA']),
            'user_id'=> User::factory()->create(['role'=>'student'])->id
        ];
    }

    protected function generatePassport()
    {
        return sprintf('%08d', fake()->unique()->numberBetween(1, 9999999));
    }
}
