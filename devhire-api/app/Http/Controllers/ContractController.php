<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\ActivityLog;
use App\Models\Project;

class ContractController extends Controller
{
    
    public function index() 
    {

        return response()->json(Contract::all());

    }

    public function show(string $id) 
    {

        $contract = Contract::findOrFail($id);

        if (!$contract) {
            return response()->json([
                'message' => 'Contract not found'
            ], 404);
        };

        return response()->json([
            'contract' => $contract,
            'success' => true
        ], 200);

    }

    public function complete(Contract $contract)
    {
        $contract->update(['status' => 'completed']);
        Project::whereKey($contract->project_id)->update(['status' => 'completed']);

        ActivityLog::create([
            'user_id' => $contract->client_id,
            'action' => 'contract_completed',
            'description' => "Contract #{$contract->id} completed",
        ]);

        return response()->json([
            'contract' => $contract->fresh(),
            'message' => 'Contract completed',
            'success' => true,
        ]);

    }

    public function cancel(Contract $contract)
    {
        $contract->update(['status' => 'cancelled']);

        return response()->json([
            'contract' => $contract->fresh(),
            'message' => 'Contract cancelled',
            'success' => true
        ], 200); 
        
    }

}
