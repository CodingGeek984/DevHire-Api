<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;
use App\Models\Project;

class AdminController extends Controller
{
    
    public function dashboard()
    {

        $users = User::orderBy('id')->get();
        $result = [];

        foreach ($users as $user) {

            $result[] = [
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => $user->password
                ]   
            ];

        };

        return response()->json([
            'users' => $result
        ], 200);


    }

    public function users()
    {

        return response()->json(User::all());

    }

    public function reports()
    {

        return response()->json(Report::all());

    }

    public function projects()
    {

        return response()->json(Project::all());

    }

    public function banUser(Request $request, string $id)
    {

        $user = User::findOrFail($id);

        if (!$user) {
            return response()->json([
                'message'=> 'User not found'
            ], 404);
        };

        $user->update([
            'is_banned' => true 
        ]);

        return response()->json([
            'message' => 'User banned',
            'success' => true
        ], 200);

    }

    public function unBanUser(string $id)
    {

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message'=> 'User not found'
            ], 404);
        };

        $user->update([
            'is_banned' => false
        ]);

        return response()->json([
            'message' => 'User unbanned',
            'success' => true 
        ], 200);

    }

    public function deleteProject(string $id)
    {

        $project = Project::findOrFail($id);

        if (!$project) {
            return response()->json([
                'message' => 'Project not found',
                'success' => false
            ], 404);
        };

        $project->delete();

        return response()->json([
            'message' => 'Project deleted',
            'success' => true
        ], 200);
    }
    
}
