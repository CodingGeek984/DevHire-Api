<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\User;
use App\Models\UserSkill;
use Illuminate\Database\Seeder;

class UserSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skillsByUser = [
            'backend@devhire.test' => ['Laravel', 'PHP', 'REST API', 'PostgreSQL', 'Docker', 'Testing'],
            'designer@devhire.test' => ['UI/UX Design', 'Figma'],
            'mobile@devhire.test' => ['Flutter', 'REST API'],
        ];

        foreach ($skillsByUser as $email => $skillNames) {
            $user = User::where('email', $email)->firstOrFail();

            foreach ($skillNames as $skillName) {
                $skill = Skill::where('name', $skillName)->firstOrFail();

                UserSkill::updateOrCreate([
                    'user_id' => $user->id,
                    'skill_id' => $skill->id,
                ]);
            }
        }
    }
}
