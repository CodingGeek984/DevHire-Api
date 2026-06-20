<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Contract;
use App\Models\Favorite;
use App\Models\Message;
use App\Models\Notification;
use App\Models\PortfolioProject;
use App\Models\Project;
use App\Models\Report;
use App\Models\Review;
use App\Models\Skill;
use App\Models\User;

class StatsController extends Controller
{
    public function index()
    {
        return response()->json([
            'stats' => [
                'users' => [
                    'total' => User::count(),
                    'clients' => User::where('role', 'client')->count(),
                    'freelancers' => User::where('role', 'freelancer')->count(),
                    'admins' => User::where('role', 'admin')->count(),
                    'banned' => User::where('is_banned', true)->count(),
                ],
                'projects' => [
                    'total' => Project::count(),
                    'open' => Project::where('status', 'open')->count(),
                    'in_progress' => Project::where('status', 'in_progress')->count(),
                    'completed' => Project::where('status', 'completed')->count(),
                ],
                'applications' => [
                    'total' => Application::count(),
                    'pending' => Application::where('status', 'pending')->count(),
                    'accepted' => Application::where('status', 'accepted')->count(),
                    'rejected' => Application::where('status', 'rejected')->count(),
                ],
                'contracts' => [
                    'total' => Contract::count(),
                    'active' => Contract::where('status', 'active')->count(),
                    'completed' => Contract::where('status', 'completed')->count(),
                    'cancelled' => Contract::where('status', 'cancelled')->count(),
                ],
                'content' => [
                    'skills' => Skill::count(),
                    'portfolio_projects' => PortfolioProject::count(),
                    'reviews' => Review::count(),
                    'favorites' => Favorite::count(),
                    'messages' => Message::count(),
                    'notifications_unread' => Notification::where('is_read', false)->count(),
                    'reports_pending' => Report::where('status', 'pending')->count(),
                ],
            ],
            'success' => true,
        ]);
    }
}
