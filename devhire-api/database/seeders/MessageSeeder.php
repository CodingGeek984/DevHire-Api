<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $messages = [
            'Thanks for applying. Can you start this week?',
            'Yes, I can start tomorrow and send the first API draft quickly.',
            'Please share the Figma screens for the profile page first.',
            'Sure, I will prepare the first version today.',
            'For the mobile MVP, auth and project list will be the first milestone.',
        ];

        $conversations = Conversation::orderBy('id')->get();

        foreach ($conversations as $index => $conversation) {
            Message::updateOrCreate(
                [
                    'conversation_id' => $conversation->id,
                    'sender_id' => $conversation->first_user_id,
                    'receiver_id' => $conversation->second_user_id,
                    'message' => $messages[$index] ?? 'Hello, let us discuss the project details.',
                ],
            );
        }
    }
}
