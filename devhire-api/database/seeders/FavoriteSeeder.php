<?php

namespace Database\Seeders;

use App\Models\Favorite;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $freelancers = User::where('role', 'freelancer')->orderBy('id')->get();
        $projects = Project::where('status', 'open')->orderBy('id')->get();

        foreach ($freelancers as $index => $freelancer) {
            $project = $projects[$index % max($projects->count(), 1)] ?? null;

            if ($project === null) {
                continue;
            }

            Favorite::updateOrCreate([
                'user_id' => $freelancer->id,
                'project_id' => $project->id,
            ]);
        }
    }
}
