<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supervisor>
 */
class SupervisorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'department'=>fake()->randomElement(['AI','computer since','design','data mining','software engineering']),
            'title' =>fake()->randomElement(['Dr','Proof','Phd']),
            'research_interests'=>fake()->randomElement(['AI','data']),
            'office_location'=>'UTM KL, Razak merna ',
            'user_id' => User::factory(['role'=>'faculty'])->create()->id,
        ];
    }
}
