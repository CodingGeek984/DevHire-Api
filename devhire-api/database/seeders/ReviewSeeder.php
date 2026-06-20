<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contract = Contract::firstOrFail();

        Review::updateOrCreate(
            [
                'contract_id' => $contract->id,
                'reviewer_id' => $contract->client_id,
                'reviewed_user_id' => $contract->freelancer_id,
            ],
            [
                'rating' => 5,
                'comment' => 'Great communication and clean Laravel code.',
            ],
        );
    }
}
