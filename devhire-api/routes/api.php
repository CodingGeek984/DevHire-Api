<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/health', fn () => response()->json(['status' => 'ok']));

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::apiResource('users', UserController::class)->only(['index', 'show', 'update', 'destroy']);
Route::apiResource('profiles', ProfileController::class);
Route::apiResource('projects', ProjectController::class);
Route::apiResource('applications', ApplicationController::class);
Route::post('/applications/{application}/accept', [ApplicationController::class, 'accept']);
Route::post('/applications/{application}/reject', [ApplicationController::class, 'reject']);
Route::apiResource('skills', SkillController::class);
Route::apiResource('messages', MessageController::class)->only(['index', 'store', 'show']);
Route::apiResource('conversations', ConversationController::class)->only(['index', 'store', 'show']);
Route::apiResource('portfolios', PortfolioController::class);
Route::apiResource('reviews', ReviewController::class);
Route::get('/users/{user}/reviews', [ReviewController::class, 'userReview']);
Route::apiResource('favorites', FavoriteController::class)->only(['index', 'store', 'show', 'destroy']);
Route::apiResource('notifications', NotificationController::class)->only(['index', 'store', 'show', 'destroy']);
Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead']);
Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
Route::get('/search', [SearchController::class, 'index']);
Route::get('/stats', [StatsController::class, 'index']);
Route::apiResource('reports', ReportController::class)->only(['store', 'show', 'destroy']);
Route::post('/reports/{report}/resolve', [ReportController::class, 'resolve']);
Route::post('/reports/{report}/reject', [ReportController::class, 'reject']);
Route::apiResource('contracts', ContractController::class)->only(['index', 'show']);
Route::post('/contracts/{contract}/complete', [ContractController::class, 'complete']);
Route::post('/contracts/{contract}/cancel', [ContractController::class, 'cancel']);

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/users', [AdminController::class, 'users']);
    Route::get('/reports', [AdminController::class, 'reports']);
    Route::get('/projects', [AdminController::class, 'projects']);
    Route::post('/users/{user}/ban', [AdminController::class, 'banUser']);
    Route::post('/users/{user}/unban', [AdminController::class, 'unBanUser']);
    Route::delete('/projects/{project}', [AdminController::class, 'deleteProject']);
});
