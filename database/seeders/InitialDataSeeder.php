<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::truncate();

        $faker = \Faker\Factory::create();
        $project_ids = [];

        // And now, let's create a few articles in our database:
        for ($i = 0; $i < 50; $i++) {
            $project = Project::create([
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'client' => $faker->name,
                'begin_at' => Carbon::now()->toDateString(),
                'finish_at' => Carbon::now()->addDays(10)->toDateString(),
            ]);
            $project_ids []= $project->id;
        }

        foreach ($project_ids as $id) {
            Task::create([
                'name' => 'Notify by email to: '.$faker->jobTitle,
                'completed' => false,
                'id_project' => $id
            ]);
        }
    }
}
