<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profiles = [
            'backend@devhire.test' => [
                'title' => 'Laravel Backend Developer',
                'description' => 'Builds clean APIs, database schemas and integrations.',
                'hourly_rate' => 35,
                'experience_years' => 4,
                'country' => 'Kazakhstan',
            ],
            'designer@devhire.test' => [
                'title' => 'Product Designer',
                'description' => 'Designs dashboards, marketplaces and mobile interfaces.',
                'hourly_rate' => 30,
                'experience_years' => 5,
                'country' => 'Kazakhstan',
            ],
            'mobile@devhire.test' => [
                'title' => 'Flutter Developer',
                'description' => 'Creates cross-platform mobile apps and MVPs.',
                'hourly_rate' => 32,
                'experience_years' => 3,
                'country' => 'Kazakhstan',
            ],
        ];

        foreach ($profiles as $email => $profile) {
            $user = User::where('email', $email)->firstOrFail();

            Profile::updateOrCreate(
                ['user_id' => $user->id],
                $profile + ['user_id' => $user->id],
            );
        }
    }
}
