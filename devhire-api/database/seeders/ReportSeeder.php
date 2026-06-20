<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reporter = User::where('email', 'client@devhire.test')->firstOrFail();
        $reported = User::where('email', 'mobile@devhire.test')->firstOrFail();

        Report::updateOrCreate(
            [
                'reporter_id' => $reporter->id,
                'reported_user_id' => $reported->id,
                'reason' => 'Spam messages',
            ],
            [
                'description' => 'Demo report for admin moderation flow.',
                'status' => 'pending',
            ],
        );
    }
}
