<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Conversation;

class ConversationController extends Controller
{
    
    public function index() 
    {

        $conversations = Conversation::orderBy('created_at', 'desc')->get();
        $result = [];

        foreach ($conversations as $conversation) {
            $result[] = [
                'id' => $conversation->id
            ];
        };

        return response()->json([
            'conversations' => $result,
            'success' => true
        ], 200);
    }

    public function store(Request $request) 
    {
        $data = $request->validate([
            'first_user_id' => ['required', 'exists:users,id'],
            'second_user_id' => ['required', 'exists:users,id', 'different:first_user_id'],
        ]);

        $conversation = Conversation::firstOrCreate($data);

        return response()->json([
            'conversation' => $conversation,
            'success' => true,
            'message' => 'Conversation created'
        ], 201);

    }

    public function show(string $id) 
    {

        $conversation = Conversation::findOrFail($id);

        if (!$conversation) {
            return response()->json([
                'message' => 'Conversation not found',
                'success' => false,
            ], 404);
        };

        return response()->json([
            'conversation' => $conversation,
            'success' => true
        ], 200);

    }
    
}
