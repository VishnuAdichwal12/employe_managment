<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800">
            Task Details
        </h2>

    </x-slot>

    <div class="py-6">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))

                <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">

                    {{ session('success') }}

                </div>

            @endif

            <div class="bg-white p-6 shadow rounded">

                <h1 class="text-2xl font-bold mb-5">
                    {{ $task->title }}
                </h1>

                <div class="mb-5">

                    <strong>Description:</strong>

                    <p class="mt-2">
                        {{ $task->description }}
                    </p>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                    <div>

                        <strong>Created By:</strong>

                        {{ $task->creator->name ?? 'N/A' }}

                    </div>

                    <div>

                        <strong>Priority:</strong>

                        {{ ucfirst($task->priority) }}

                    </div>

                    <div>

                        <strong>Due Date:</strong>

                        {{ $task->due_date }}

                    </div>

                    <div>

                        <strong>Status:</strong>

                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}

                    </div>

                </div>

                {{-- Status Update --}}

                <div class="border-t pt-5">

                    <h3 class="text-lg font-bold mb-3">
                        Update Status
                    </h3>

                    <form
                        method="POST"
                        action="{{ route('employee.tasks.status', $task) }}">

                        @csrf
                        @method('PATCH')

                        <select
                            name="status"
                            class="border rounded px-3 py-2">

                            <option
                                value="pending"
                                {{ $task->status === 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>

                            <option
                                value="in_progress"
                                {{ $task->status === 'in_progress' ? 'selected' : '' }}>
                                In Progress
                            </option>

                            <option
                                value="completed"
                                {{ $task->status === 'completed' ? 'selected' : '' }}>
                                Completed
                            </option>

                        </select>

                        <button
                            type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded ml-2">

                            Update

                        </button>

                    </form>

                </div>

                {{-- Comments --}}

                <div class="border-t mt-6 pt-5">

                    <h3 class="text-lg font-bold mb-4">
                        Comments
                    </h3>

                    @forelse($task->comments as $comment)

                        <div class="border-b py-3">

                            <strong>
                                {{ $comment->user->name }}
                            </strong>

                            <p class="mt-1">
                                {{ $comment->comment }}
                            </p>

                            <small class="text-gray-500">
                                {{ $comment->created_at->format('d M Y H:i') }}
                            </small>

                        </div>

                    @empty

                        <p class="text-gray-500">
                            No comments yet.
                        </p>

                    @endforelse

                </div>

                <div class="mt-6">

                    <a
                        href="{{ route('employee.tasks.index') }}"
                        class="text-gray-600">

                        ← Back to My Tasks

                    </a>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>