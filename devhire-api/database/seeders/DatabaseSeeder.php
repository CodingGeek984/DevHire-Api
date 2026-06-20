<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SkillSeeder::class,
            ProfileSeeder::class,
            UserSkillSeeder::class,
            ProjectSeeder::class,
            ApplicationSeeder::class,
            ContractSeeder::class,
            ConversationSeeder::class,
            MessageSeeder::class,
            PortfolioProjectSeeder::class,
            ReviewSeeder::class,
            FavoriteSeeder::class,
            ReportSeeder::class,
            NotificationSeeder::class,
            ActivityLogSeeder::class,
        ]);
    }
}
