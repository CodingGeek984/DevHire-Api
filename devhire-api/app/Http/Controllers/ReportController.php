<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    
    public function store(Request $request)
    {

        $data = $request->validate([
            'reporter_id' => ['required', 'exists:users,id'],
            'reported_user_id' => ['required', 'exists:users,id', 'different:reporter_id'],
            'reason' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['sometimes', 'string'],
        ]);

        $report = Report::create($data);

        return response()->json([
            'report' => $report,
            'message' => 'Report created',
            'success' => true 
        ], 201);

    }

    public function show(string $id)
    {

        $report = Report::findOrFail($id);

        
        if (!$report) {
            return response()->json([
                'message' => 'Report not found'
            ], 404);
        };

        return response()->json([
            'report' => $report,
            'success' => true 
        ], 200);

    }

    public function MyrReports()
    {

        

    }

    public function resolve(Report $report)
    {
        $report->update(['status' => 'resolved']);

        return response()->json([
            'report' => $report->fresh(),
            'message' => 'Report resolved',
            'success' => true,
        ]);

    }

    public function reject(Report $report)
    {
        $report->update(['status' => 'rejected']);

        return response()->json([
            'report' => $report->fresh(),
            'message' => 'Report rejected',
            'success' => true 
        ], 200);

    }

    public function destroy(Report $report)
    {
        $report->delete();

        return response()->json([
            'message' => 'Report deleted',
            'success' => true,
        ]);
    }

}
