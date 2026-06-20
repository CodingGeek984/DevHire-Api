<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Seeder;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pairs = [
            ['client@devhire.test', 'backend@devhire.test'],
            ['client@devhire.test', 'designer@devhire.test'],
            ['startup@devhire.test', 'mobile@devhire.test'],
        ];

        foreach ($pairs as [$firstEmail, $secondEmail]) {
            $firstUser = User::where('email', $firstEmail)->firstOrFail();
            $secondUser = User::where('email', $secondEmail)->firstOrFail();

            Conversation::updateOrCreate([
                'first_user_id' => $firstUser->id,
                'second_user_id' => $secondUser->id,
            ]);
        }
    }
}
