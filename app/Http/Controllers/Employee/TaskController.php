<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()
            ->assignedTasks()
            ->with(['creator']);

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");

            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $tasks = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('employee.tasks.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);

        $task->load([
            'creator',
            'comments.user',
        ]);

        return view('employee.tasks.show', compact('task'));
    }

    public function updateStatus(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'status' => [
                'required',
                'in:pending,in_progress,completed',
            ],
        ]);

        $task->update([
            'status' => $validated['status'],
        ]);

        return back()->with(
            'success',
            'Task status updated successfully.'
        );
    }
}