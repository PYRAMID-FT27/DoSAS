<?php

namespace Database\Factories;

use App\Models\DefermentApplication;
use App\Models\Supervisor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ApplicationLog>
 */
class ApplicationLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'application_id' => DefermentApplication::factory()->create()->id,
            'changed_by' => Supervisor::factory()->create()->id,
            'changed_at' => fake()->time(),
            'previous_status'=> fake()->randomElement(['rejected','approved','reviewing','process','draft','pending']),
            'new_status' =>fake()->randomElement(['rejected','approved','reviewing','process','draft','pending']),
        ];
    }
}
