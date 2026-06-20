<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    
    public function register(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'sometimes|string|in:client,freelancer,admin',
        ]);

        if (!$request->name || !$request->email || !$request->password) {
            return response()->json([
                'message' => 'All field are required'
            ], 400);
        };

        $user = User::create($data);

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('api')->plainTextToken,
            'success' => true,
            'message' => 'User created'
        ], 201);

    }

    public function login(Request $request)
    {

        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::verify($data['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 404);
        };

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('api')->plainTextToken,
            'success' => true,
        ], 200);

    }

    public function me(Request $request)
    {

        return response()->json(['user' => $request->user()]);

    }

    public function logout()
    {
        request()->user()?->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Logged out',
            'success' => true,
        ]);

    }

}
