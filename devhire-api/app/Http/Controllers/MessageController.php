<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Message;

class MessageController extends Controller
{
    
    public function index()
    {

        $messages = Message::orderBy('created_at', 'desc')->get();
        $result = [];

        foreach ($messages as $message) {

            $result[] = [
                'conversation_id' => $message->conversation_id,
                'sender_id' => $message->sender_id,
                'receiver_id' => $message->receiver_id,
                'message' => $message->message
            ];

        };

        return response()->json([
            'messages' => $result,
            'success' => true
        ], 200);

    }

    public function store(Request $request) 
    {

        $data = $request->validate([
            'conversation_id' => ['required', 'exists:conversations,id'],
            'sender_id' => ['required', 'exists:users,id'],
            'receiver_id' => ['required', 'exists:users,id'],
            'message' => ['required', 'string'],
        ]);

        $message = Message::create($data);

        return response()->json([
            'data' => $message,
            'message' => 'Message sent',
            'success' => true
        ], 201);

    }

    public function show(string $id) 
    {

        $message = Message::findOrFail($id);

        if (!$message) {
            return response()->json([
                'message' => 'Message not found'
            ], 404);
        };

        return response()->json([
            'message' => $message,
            'success' => true
        ], 200);

    }
    
}
