<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Skill::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        if (!$request->name) {
            return response()->json([
                'message' => 'Name is required'
            ], 400);
        };

        $data = $request->validate([
            'name' => 'required|string'
        ]);

        Skill::create($data);

        return response()->json([
            'message' => 'Skill created',
            'success' => true 
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $skill = Skill::findOrFail($id);

        if (!$skill) {
            return response()->json([
                'message' => 'Skill not found'
            ], 404);
        };

        return response()->json([
            'skill' => $skill,
            'success' => true 
        ], 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $skill = Skill::findOrFail($id);
        
        $data = $request->validate([
            'name' => 'required|string'
        ]);

        $skill->update($data);

        return response()->json([
            'skill' => $skill,
            'success' => true 
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $skill = Skill::findOrFail($id);

        if (!$skill) {
            return response()->json([
                'message' => 'Skill not found'
            ], 404);
        };

        $skill->delete();

        return response()->json([
            'message' => 'Skill deleted',
            'success' => true 
        ], 200);

    }
    
}
