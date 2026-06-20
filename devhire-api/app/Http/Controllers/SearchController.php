<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'q' => ['nullable', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'in:all,projects,users,skills'],
        ]);

        $term = $data['q'] ?? '';
        $type = $data['type'] ?? 'all';

        return response()->json([
            'query' => $term,
            'type' => $type,
            'results' => [
                'projects' => in_array($type, ['all', 'projects'], true) ? $this->projects($term) : [],
                'users' => in_array($type, ['all', 'users'], true) ? $this->users($term) : [],
                'skills' => in_array($type, ['all', 'skills'], true) ? $this->skills($term) : [],
            ],
            'success' => true,
        ]);
    }

    private function projects(string $term)
    {
        return Project::with('client')
            ->when($term !== '', function ($query) use ($term) {
                $query->where(function ($query) use ($term) {
                    $query->where('title', 'like', "%{$term}%")
                        ->orWhere('description', 'like', "%{$term}%")
                        ->orWhere('status', 'like', "%{$term}%");
                });
            })
            ->latest()
            ->limit(20)
            ->get();
    }

    private function users(string $term)
    {
        return User::query()
            ->when($term !== '', function ($query) use ($term) {
                $query->where(function ($query) use ($term) {
                    $query->where('name', 'like', "%{$term}%")
                        ->orWhere('email', 'like', "%{$term}%")
                        ->orWhere('role', 'like', "%{$term}%");
                });
            })
            ->with(['profile'])
            ->latest()
            ->limit(20)
            ->get();
    }

    private function skills(string $term)
    {
        return Skill::query()
            ->when($term !== '', fn ($query) => $query->where('name', 'like', "%{$term}%"))
            ->orderBy('name')
            ->limit(20)
            ->get();
    }
}
