<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            'Laravel',
            'PHP',
            'Vue.js',
            'React',
            'REST API',
            'PostgreSQL',
            'MySQL',
            'UI/UX Design',
            'Figma',
            'Flutter',
            'Docker',
            'Testing',
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(['name' => $skill]);
        }
    }
}
