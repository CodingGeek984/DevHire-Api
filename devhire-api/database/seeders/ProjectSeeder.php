<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = User::where('email', 'client@devhire.test')->firstOrFail();
        $startup = User::where('email', 'startup@devhire.test')->firstOrFail();

        $projects = [
            [
                'client_id' => $client->id,
                'title' => 'Build DevHire marketplace API',
                'description' => 'Create a Laravel REST API for projects, applications, contracts, reviews and messages.',
                'budget' => 1800,
                'status' => 'in_progress',
                'deadline' => now()->addDays(21)->toDateString(),
            ],
            [
                'client_id' => $client->id,
                'title' => 'Design freelancer profile screens',
                'description' => 'Prepare clean UI/UX screens for freelancer profile, portfolio and reviews.',
                'budget' => 750,
                'status' => 'open',
                'deadline' => now()->addDays(14)->toDateString(),
            ],
            [
                'client_id' => $startup->id,
                'title' => 'Mobile app MVP',
                'description' => 'Build a Flutter MVP with auth, project list, chat and profile pages.',
                'budget' => 2500,
                'status' => 'open',
                'deadline' => now()->addDays(30)->toDateString(),
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['title' => $project['title']],
                $project,
            );
        }
    }
}
