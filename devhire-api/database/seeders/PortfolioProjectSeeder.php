<?php

namespace Database\Seeders;

use App\Models\PortfolioProject;
use App\Models\User;
use Illuminate\Database\Seeder;

class PortfolioProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            'backend@devhire.test' => [
                'title' => 'Marketplace REST API',
                'description' => 'Laravel API with auth, projects, applications and contracts.',
                'project_url' => 'https://example.com/marketplace-api',
                'image' => 'portfolio/api.png',
            ],
            'designer@devhire.test' => [
                'title' => 'Freelancer Dashboard UI',
                'description' => 'Dashboard, profile and portfolio UI kit for a hiring product.',
                'project_url' => 'https://example.com/dashboard-ui',
                'image' => 'portfolio/dashboard.png',
            ],
            'mobile@devhire.test' => [
                'title' => 'Job Search Mobile App',
                'description' => 'Flutter app with project feed, chat and profile screens.',
                'project_url' => 'https://example.com/mobile-mvp',
                'image' => 'portfolio/mobile.png',
            ],
        ];

        foreach ($items as $email => $portfolio) {
            $user = User::where('email', $email)->firstOrFail();

            PortfolioProject::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'title' => $portfolio['title'],
                ],
                $portfolio + ['user_id' => $user->id],
            );
        }
    }
}
