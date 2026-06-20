<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Contract;
use App\Models\Project;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        return response()->json([
            'applications' => Application::with(['project', 'freelancer'])->latest()->get(),
            'success' => true,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'freelancer_id' => ['required', 'exists:users,id'],
            'cover_letter' => ['required', 'string'],
            'proposed_price' => ['required', 'numeric', 'min:0'],
            'status' => ['sometimes', 'string', 'in:pending,accepted,rejected'],
        ]);

        $application = Application::create($data);

        return response()->json([
            'application' => $application->load(['project', 'freelancer']),
            'message' => 'Application created',
            'success' => true,
        ], 201);
    }

    public function show(Application $application)
    {
        return response()->json([
            'application' => $application->load(['project', 'freelancer']),
            'success' => true,
        ]);
    }

    public function update(Request $request, Application $application)
    {
        $data = $request->validate([
            'cover_letter' => ['sometimes', 'string'],
            'proposed_price' => ['sometimes', 'numeric', 'min:0'],
            'status' => ['sometimes', 'string', 'in:pending,accepted,rejected'],
        ]);

        $application->update($data);

        return response()->json([
            'application' => $application->fresh()->load(['project', 'freelancer']),
            'success' => true,
        ]);
    }

    public function destroy(Application $application)
    {
        $application->delete();

        return response()->json([
            'message' => 'Application deleted',
            'success' => true,
        ]);
    }

    public function accept(Application $application)
    {
        $application->update(['status' => 'accepted']);
        $project = Project::findOrFail($application->project_id);
        $project->update(['status' => 'in_progress']);

        $contract = Contract::firstOrCreate(
            [
                'project_id' => $application->project_id,
                'freelancer_id' => $application->freelancer_id,
            ],
            [
                'client_id' => $project->client_id,
                'agreed_price' => $application->proposed_price,
                'status' => 'active',
            ]
        );

        Application::where('project_id', $application->project_id)
            ->where('id', '!=', $application->id)
            ->where('status', 'pending')
            ->update(['status' => 'rejected']);

        return response()->json([
            'application' => $application->fresh(),
            'contract' => $contract,
            'success' => true,
            'message' => 'Application accepted',
        ]);
    }

    public function reject(Application $application)
    {
        $application->update(['status' => 'rejected']);

        return response()->json([
            'application' => $application->fresh(),
            'success' => true,
            'message' => 'Application rejected',
        ]);
    }
}
