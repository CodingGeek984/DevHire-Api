<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'profiles' => Profile::with('user')->latest()->get(),
            'success' => true,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'hourly_rate' => ['nullable', 'numeric', 'min:0'],
            'experience_years' => ['nullable', 'integer', 'min:0'],
            'country' => ['nullable', 'string', 'max:255'],
        ]);

        $profile = Profile::create($data);

        return response()->json([
            'profile' => $profile,
            'success' => true,
            'message' => 'Profile created',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        $profile = Profile::findOrFail($id);

        if (!$profile) {
            return response()->json([
                'message' => 'Profile not found'
            ], 404);
        };

        return response()->json([
            'profile' => $profile,
            'success'=> true 
        ], 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $profile = Profile::findOrFail($id);

        $data = $request->validate([
            'user_id' => ['sometimes', 'exists:users,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'hourly_rate' => ['nullable', 'numeric', 'min:0'],
            'experience_years' => ['nullable', 'integer', 'min:0'],
            'country' => ['nullable', 'string', 'max:255'],
        ]);
        
        $profile->update($data);

        return response()->json([
            'profile' => $profile,
            'success'=> true 
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $profile = Profile::findOrFail($id);

        if (!$profile) {
            return response()->json([
                'message' => 'Profile not found'
            ], 404);
        };

        $profile->delete();

        return response()->json([
            'message' => 'Profile deleted'
        ], 200);

    }
    
}
