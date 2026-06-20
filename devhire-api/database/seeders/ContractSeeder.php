<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Contract;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $application = Application::where('status', 'accepted')->firstOrFail();
        $project = Project::findOrFail($application->project_id);

        Contract::updateOrCreate(
            [
                'project_id' => $project->id,
                'freelancer_id' => $application->freelancer_id,
            ],
            [
                'client_id' => $project->client_id,
                'agreed_price' => $application->proposed_price,
                'status' => 'active',
            ],
        );
    }
}
