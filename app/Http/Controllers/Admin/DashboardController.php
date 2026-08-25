<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = User::where('role', 'employee')->count();

        $totalTasks = Task::count();

        $pendingTasks = Task::where('status', 'pending')->count();

        $inProgressTasks = Task::where('status', 'in_progress')->count();

        $completedTasks = Task::where('status', 'completed')->count();

        $overdueTasks = Task::whereDate('due_date', '<', today())
            ->where('status', '!=', 'completed')
            ->count();

        return view('admin.dashboard', compact(
            'totalEmployees',
            'totalTasks',
            'pendingTasks',
            'inProgressTasks',
            'completedTasks',
            'overdueTasks'
        ));
    }
}