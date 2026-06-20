<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Admin DevHire', 'email' => 'admin@devhire.test', 'role' => 'admin'],
            ['name' => 'Aruzhan Client', 'email' => 'client@devhire.test', 'role' => 'client'],
            ['name' => 'Daniyar Startup', 'email' => 'startup@devhire.test', 'role' => 'client'],
            ['name' => 'Miras Backend', 'email' => 'backend@devhire.test', 'role' => 'freelancer'],
            ['name' => 'Aigerim Designer', 'email' => 'designer@devhire.test', 'role' => 'freelancer'],
            ['name' => 'Timur Mobile', 'email' => 'mobile@devhire.test', 'role' => 'freelancer'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make('password'),
                    'role' => $user['role'],
                    'is_banned' => false,
                    'email_verified_at' => now(),
                ],
            );
        }
    }
}
