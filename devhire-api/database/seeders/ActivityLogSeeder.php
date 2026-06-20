<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@devhire.test')->firstOrFail();
        $client = User::where('email', 'client@devhire.test')->firstOrFail();

        $logs = [
            [
                'user_id' => $admin->id,
                'action' => 'seed_database',
                'description' => 'Demo database was seeded.',
            ],
            [
                'user_id' => $client->id,
                'action' => 'project_created',
                'description' => 'Client created demo projects.',
            ],
        ];

        foreach ($logs as $log) {
            ActivityLog::updateOrCreate(
                [
                    'user_id' => $log['user_id'],
                    'action' => $log['action'],
                ],
                $log,
            );
        }
    }
}
