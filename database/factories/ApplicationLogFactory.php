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
       $da =  DefermentApplication::factory()->create();
       $svs = Supervisor::factory(3)->create();
       $student =  $da->student()->first();
        foreach ($svs as $inx => $sv){
            $supervisorType = 0 == $inx ?'main':'co';
            $student->supervisors()->attach($sv->id,['supervisor_type' => $supervisorType]);
        }
        return [
            'application_id' => $da->id,
            'changed_by' => $svs[0],
            'changed_at' => fake()->time(),
            'previous_status'=> fake()->randomElement(['rejected','approved','reviewing','process','draft','pending']),
            'new_status' =>fake()->randomElement(['rejected','approved','reviewing','process','draft','pending']),
        ];

    }
}
