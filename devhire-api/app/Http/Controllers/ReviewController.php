<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'reviews' => Review::with(['reviewer', 'reviewedUser', 'contract'])->latest()->get(),
            'success' => true,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $data = $request->validate([
            'contract_id' => ['required', 'exists:contracts,id'],
            'reviewer_id' => ['required', 'exists:users,id'],
            'reviewed_user_id' => ['required', 'exists:users,id', 'different:reviewer_id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
        ]);

        $review = Review::create($data);

        return response()->json([
            'review' => $review,
            'success' => true,
            'message' => 'Review created'
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $review = Review::with(['reviewer', 'reviewedUser', 'contract'])->findOrFail($id);

        return response()->json([
            'review' => $review,
            'success' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $review = Review::findOrFail($id);

        $data = $request->validate([
            'contract_id' => ['sometimes', 'exists:contracts,id'],
            'reviewer_id' => ['sometimes', 'exists:users,id'],
            'reviewed_user_id' => ['sometimes', 'exists:users,id'],
            'rating' => ['sometimes', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
        ]);

        if (!$review) {
            return response()->json([
                'message' => 'Review not found'
            ], 404);
        };

        $review->update($data);

        return response()->json([
            'review' => $review,
            'success' => true 
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $review = Review::find($id);

        if (!$review){
            return response()->json([
                'message' => 'Review not found'
            ], 404);
        };

        $review->delete();

        return response()->json([
            'message' => 'Review deleted',
            'success' => true
        ], 200);

    }

    public function userReview(string $id)
    {

        $reviews = Review::with(['reviewer', 'contract'])
            ->where('reviewed_user_id', $id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'count' => $reviews->count(),
            'data' => $reviews
        ], 200);

    }
}
