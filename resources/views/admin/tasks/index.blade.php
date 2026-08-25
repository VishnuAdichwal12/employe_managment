<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <h2 class="font-semibold text-xl text-gray-800">
                Tasks
            </h2>

            <a
                href="{{ route('admin.tasks.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded">
                Create Task
            </a>

        </div>

    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))

                <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                    {{ session('success') }}
                </div>

            @endif

            {{-- Filters --}}

            <div class="bg-white p-4 mb-4 rounded shadow">

                <form
                    method="GET"
                    action="{{ route('admin.tasks.index') }}">

                    <div class="grid grid-cols-1 md:grid-cols-5 gap-3">

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search task..."
                            class="border rounded px-3 py-2">

                        <select
                            name="status"
                            class="border rounded px-3 py-2">

                            <option value="">All Status</option>

                            <option
                                value="pending"
                                {{ request('status') === 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>

                            <option
                                value="in_progress"
                                {{ request('status') === 'in_progress' ? 'selected' : '' }}>
                                In Progress
                            </option>

                            <option
                                value="completed"
                                {{ request('status') === 'completed' ? 'selected' : '' }}>
                                Completed
                            </option>

                        </select>

                        <select
                            name="priority"
                            class="border rounded px-3 py-2">

                            <option value="">All Priority</option>

                            <option
                                value="low"
                                {{ request('priority') === 'low' ? 'selected' : '' }}>
                                Low
                            </option>

                            <option
                                value="medium"
                                {{ request('priority') === 'medium' ? 'selected' : '' }}>
                                Medium
                            </option>

                            <option
                                value="high"
                                {{ request('priority') === 'high' ? 'selected' : '' }}>
                                High
                            </option>

                        </select>

                        <select
                            name="assigned_to"
                            class="border rounded px-3 py-2">

                            <option value="">
                                All Employees
                            </option>

                            @foreach($employees as $employee)

                                <option
                                    value="{{ $employee->id }}"
                                    {{ request('assigned_to') == $employee->id ? 'selected' : '' }}>

                                    {{ $employee->name }}

                                </option>

                            @endforeach

                        </select>

                        <div class="flex gap-2">

                            <button
                                type="submit"
                                class="bg-gray-800 text-white px-4 py-2 rounded">
                                Filter
                            </button>

                            <a
                                href="{{ route('admin.tasks.index') }}"
                                class="bg-gray-400 text-white px-4 py-2 rounded">
                                Reset
                            </a>

                        </div>

                    </div>

                </form>

            </div>

            {{-- Task Table --}}

            <div class="bg-white shadow rounded overflow-hidden">

                <table class="w-full">

                    <thead class="bg-gray-100">

                        <tr>

                            <th class="p-3 text-left">
                                Title
                            </th>

                            <th class="p-3 text-left">
                                Employee
                            </th>

                            <th class="p-3 text-left">
                                Priority
                            </th>

                            <th class="p-3 text-left">
                                Status
                            </th>

                            <th class="p-3 text-left">
                                Due Date
                            </th>

                            <th class="p-3 text-left">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($tasks as $task)

                            <tr class="border-t">

                                <td class="p-3">
                                    {{ $task->title }}
                                </td>

                                <td class="p-3">
                                    {{ $task->assignedEmployee->name ?? 'N/A' }}
                                </td>

                                <td class="p-3">
                                    {{ ucfirst($task->priority) }}
                                </td>

                                <td class="p-3">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </td>

                                <td class="p-3">
                                    {{ $task->due_date }}
                                </td>

                                <td class="p-3">

                                    <div class="flex gap-2">

                                        <a
                                            href="{{ route('admin.tasks.show', $task) }}"
                                            class="text-blue-600">
                                            View
                                        </a>

                                        <a
                                            href="{{ route('admin.tasks.edit', $task) }}"
                                            class="text-green-600">
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('admin.tasks.destroy', $task) }}"
                                            onsubmit="return confirm('Delete this task?')">

                                            @csrf
                                            @method('DELETE')

                                            <button class="text-red-600">
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="p-5 text-center">

                                    No tasks found.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-4">
                {{ $tasks->links() }}
            </div>

        </div>

    </div>

</x-app-layout>