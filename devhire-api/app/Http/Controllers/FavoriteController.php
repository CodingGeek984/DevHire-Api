<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $query = Favorite::with(['user', 'project']);

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->integer('user_id'));
        }

        return response()->json([
            'favorites' => $query->latest()->get(),
            'success' => true,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'project_id' => ['required', 'exists:projects,id'],
        ]);

        $favorite = Favorite::firstOrCreate($data);

        return response()->json([
            'favorite' => $favorite->load(['user', 'project']),
            'message' => 'Project added to favorites',
            'success' => true,
        ], 201);
    }

    public function show(Favorite $favorite)
    {
        return response()->json([
            'favorite' => $favorite->load(['user', 'project']),
            'success' => true,
        ]);
    }

    public function destroy(Favorite $favorite)
    {
        $favorite->delete();

        return response()->json([
            'message' => 'Favorite deleted',
            'success' => true,
        ]);
    }
}
