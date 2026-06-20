<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::with('user');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->integer('user_id'));
        }

        if ($request->has('is_read')) {
            $query->where('is_read', $request->boolean('is_read'));
        }

        return response()->json([
            'notifications' => $query->latest()->get(),
            'success' => true,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'is_read' => ['sometimes', 'boolean'],
        ]);

        $notification = Notification::create($data);

        return response()->json([
            'notification' => $notification->load('user'),
            'message' => 'Notification created',
            'success' => true,
        ], 201);
    }

    public function show(Notification $notification)
    {
        return response()->json([
            'notification' => $notification->load('user'),
            'success' => true,
        ]);
    }

    public function markAsRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);

        return response()->json([
            'notification' => $notification->fresh(),
            'message' => 'Notification marked as read',
            'success' => true,
        ]);
    }

    public function markAllAsRead(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $updated = Notification::where('user_id', $data['user_id'])
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'updated' => $updated,
            'message' => 'Notifications marked as read',
            'success' => true,
        ]);
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();

        return response()->json([
            'message' => 'Notification deleted',
            'success' => true,
        ]);
    }
}
