<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PortfolioProject;


class PortfolioController extends Controller
{
    
    public function index()
    {

        return response()->json([
            'portfolios' => PortfolioProject::all(),
            'success'=> true
        ], 200);

    }

    public function store(Request $request) 
    {

        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'project_url' => ['nullable', 'url'],
            'image' => ['nullable', 'string'],
        ]);

        $portfolio = PortfolioProject::create($data);

        return response()->json([
            'portfolio' => $portfolio,
            'success' => true,
            'message' => 'Portfolio created'
        ], 201);

    }

    public function show(string $id)
    {

        $portfolio = PortfolioProject::findOrFail($id);

        if (!$portfolio) {
            return response()->json([
                'message' => 'Portfolio not found'
            ], 404);
        };

        return response()->json([
            'portfolio' => $portfolio,
            'success' => true 
        ], 200);

    }

    public function update(Request $request, string $id)
    {

        $portfolio = PortfolioProject::findOrFail($id);

        $data = $request->validate([
            'user_id' => ['sometimes', 'exists:users,id'],
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'project_url' => ['nullable', 'url'],
            'image' => ['nullable', 'string'],
        ]);

        $portfolio->update($data);

        return response()->json([
            'portfolio' => $portfolio,
            'success' => true 
        ], 200);

    }

    public function destroy(string $id) 
    {

        $portfolio = PortfolioProject::find($id);

        if (!$portfolio) {
            return response()->json([
                'message' => 'Potfolio not found'
            ], 404);
        };

        $portfolio->delete();

        return response()->json([
            'message' => 'Portfolio deleted',
            'success' => true 
        ], 200);

    }

}
