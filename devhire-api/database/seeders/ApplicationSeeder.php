<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apiProject = Project::where('title', 'Build DevHire marketplace API')->firstOrFail();
        $designProject = Project::where('title', 'Design freelancer profile screens')->firstOrFail();
        $mobileProject = Project::where('title', 'Mobile app MVP')->firstOrFail();

        $backend = User::where('email', 'backend@devhire.test')->firstOrFail();
        $designer = User::where('email', 'designer@devhire.test')->firstOrFail();
        $mobile = User::where('email', 'mobile@devhire.test')->firstOrFail();

        $applications = [
            [
                'project_id' => $apiProject->id,
                'freelancer_id' => $backend->id,
                'cover_letter' => 'I can build the Laravel API, migrations, seeders and tests for this marketplace.',
                'proposed_price' => 1700,
                'status' => 'accepted',
            ],
            [
                'project_id' => $designProject->id,
                'freelancer_id' => $designer->id,
                'cover_letter' => 'I will design a polished profile flow in Figma with reusable components.',
                'proposed_price' => 700,
                'status' => 'pending',
            ],
            [
                'project_id' => $mobileProject->id,
                'freelancer_id' => $mobile->id,
                'cover_letter' => 'I can deliver a Flutter MVP connected to your API.',
                'proposed_price' => 2400,
                'status' => 'pending',
            ],
            [
                'project_id' => $mobileProject->id,
                'freelancer_id' => $backend->id,
                'cover_letter' => 'I can prepare the backend integration and API support for the mobile MVP.',
                'proposed_price' => 900,
                'status' => 'pending',
            ],
        ];

        foreach ($applications as $application) {
            Application::updateOrCreate(
                [
                    'project_id' => $application['project_id'],
                    'freelancer_id' => $application['freelancer_id'],
                ],
                $application,
            );
        }
    }
}
