<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ApplicationLog;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(1)->create(['role' => 'staff']);
        $sv = Supervisor::factory()->create();
        $svs = Supervisor::factory(3)->create();
        $students =  Student::factory(5)->create();
        foreach ($students as $student){
            foreach ($svs as $inx => $sv){
                $supervisorType = 0 == $inx ?'main':'co';
                $student->supervisors()->attach($sv->id,['supervisor_type' => $supervisorType]);
            }
            $student->supervisors()->attach($sv->id,['supervisor_type' => 'coordinator']);
        }
    }
}
