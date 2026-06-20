<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Project::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'budget' => ['required', 'numeric', 'min:0'],
            'status' => ['sometimes', 'string'],
            'deadline' => ['nullable', 'date'],
        ]);

        $project = Project::create($data);

        return response()->json([
            'project' => $project,
            'message' => 'Project created',
            'success' => true 
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        $project = Project::findOrFail($id);

        if (!$project) {
            return response()->json([
                'message' => 'Project not found'
            ], 404);
        };

        return response()->json([
            'project' => $project,
            'success' => true 
        ], 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $data = $request->validate([
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'budget' => ['sometimes', 'numeric', 'min:0'],
            'status' => ['sometimes', 'string'],
            'deadline' => ['nullable', 'date'],
        ]);

        $project = Project::find($id);

        if (!$project) {
            return response()->json([
                'message' => 'Project not found'
            ], 404);
        };

        $project->update($data);

        return response()->json([
            'project' => $project,
            'success' => true 
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $project = Project::find($id);

        if (!$project) {
            return response()->json([
                'message' => 'Project not found',
                'success' => false
            ], 404);
        };

        $project->delete();

        return response()->json([
            'message' => 'Project deleted',
            'success' => true
        ], 200);
        
    }
}
