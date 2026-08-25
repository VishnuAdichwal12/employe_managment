<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['assignedEmployee', 'creator']);

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

        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        $tasks = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $employees = User::where('role', 'employee')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.tasks.index', compact(
            'tasks',
            'employees'
        ));
    }

    public function create()
    {
        $employees = User::where('role', 'employee')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.tasks.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'assigned_to' => [
                'required',
                'exists:users,id',
            ],
            'priority' => [
                'required',
                'in:low,medium,high',
            ],
            'status' => [
                'required',
                'in:pending,in_progress,completed',
            ],
            'due_date' => [
                'required',
                'date',
            ],
        ]);

        $employee = User::where('id', $validated['assigned_to'])
            ->where('role', 'employee')
            ->where('status', 'active')
            ->first();

        if (!$employee) {
            return back()
                ->withErrors([
                    'assigned_to' => 'Selected employee is invalid or inactive.'
                ])
                ->withInput();
        }

        Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'assigned_to' => $employee->id,
            'created_by' => auth()->id(),
            'priority' => $validated['priority'],
            'status' => $validated['status'],
            'due_date' => $validated['due_date'],
        ]);

        return redirect()
            ->route('admin.tasks.index')
            ->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $task->load([
            'assignedEmployee',
            'creator',
            'comments.user',
        ]);

        return view('admin.tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $employees = User::where('role', 'employee')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.tasks.edit', compact(
            'task',
            'employees'
        ));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'assigned_to' => [
                'required',
                'exists:users,id',
            ],
            'priority' => [
                'required',
                'in:low,medium,high',
            ],
            'status' => [
                'required',
                'in:pending,in_progress,completed',
            ],
            'due_date' => [
                'required',
                'date',
            ],
        ]);

        $employee = User::where('id', $validated['assigned_to'])
            ->where('role', 'employee')
            ->where('status', 'active')
            ->first();

        if (!$employee) {
            return back()
                ->withErrors([
                    'assigned_to' => 'Selected employee is invalid or inactive.'
                ])
                ->withInput();
        }

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'assigned_to' => $employee->id,
            'priority' => $validated['priority'],
            'status' => $validated['status'],
            'due_date' => $validated['due_date'],
        ]);

        return redirect()
            ->route('admin.tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()
            ->route('admin.tasks.index')
            ->with('success', 'Task deleted successfully.');
    }
}