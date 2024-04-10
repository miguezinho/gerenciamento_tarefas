<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTasksController;
use App\Models\Project;
use App\Models\ProjectTasks;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        $projects = Project::with(['user', 'members.user'])
            ->where(function ($query) {
                $query->where('user_id', Auth::user()->id)
                    ->orWhereHas('members', function ($subquery) {
                        $subquery->where('user_id', Auth::user()->id);
                    });
            })
            ->get();

        $project_tasks_pending = ProjectTasks::with(['user', 'project'])
            ->where("status", "P")
            ->whereHas('project.members', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->get();

        $project_tasks_late = ProjectTasks::with(['user', 'project'])
            ->whereDate('due_date', '<', now())
            ->whereHas('project.members', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->get();

        return Inertia::render('Dashboard', [
            'projects' => $projects,
            'project_tasks_pending' => $project_tasks_pending,
            'project_tasks_late' => $project_tasks_late,
        ]);
    })->name('dashboard');

    Route::resource('/projects', ProjectController::class);
    Route::resource('/project_tasks', ProjectTasksController::class);

});
