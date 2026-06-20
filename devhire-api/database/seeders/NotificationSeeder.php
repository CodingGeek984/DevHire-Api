<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = [
            'backend@devhire.test' => [
                'title' => 'Application accepted',
                'message' => 'Your application for the DevHire API project was accepted.',
                'is_read' => false,
            ],
            'client@devhire.test' => [
                'title' => 'New proposal',
                'message' => 'A freelancer sent a proposal for your design project.',
                'is_read' => false,
            ],
            'admin@devhire.test' => [
                'title' => 'New report',
                'message' => 'A user report is waiting for moderation.',
                'is_read' => false,
            ],
        ];

        foreach ($notifications as $email => $notification) {
            $user = User::where('email', $email)->firstOrFail();

            Notification::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'title' => $notification['title'],
                ],
                $notification + ['user_id' => $user->id],
            );
        }
    }
}
