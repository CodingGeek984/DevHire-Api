<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    
    public function index()
    {

        return response()->json(User::all());

    }

    public function show(string $id) 
    {

        $user = User::findOrFail($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        };

        return response()->json([
            'user' => $user,
            'success' => true 
        ], 200);

    }

    public function update(Request $request, string $userId)
    {
        $user = User::findOrFail($userId);

        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'unique:users,email,'.$user->id],
            'password' => ['sometimes', 'string', 'min:8'],
            'role' => ['sometimes', 'string', 'in:client,freelancer,admin'],
            'is_banned' => ['sometimes', 'boolean'],
        ]);

        $user->update($data);

        return response()->json([
            'user' => $user,
            'success' => true,
        ]);

    }

    public function destroy(string $userId)
    {

        $user = User::findOrFail($userId);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
                'success' => false
            ], 404);
        };

        $user->delete();

        return response()->json([
            'message' => "User deleted",
            'success' => true 
        ], 200);

    }

}
