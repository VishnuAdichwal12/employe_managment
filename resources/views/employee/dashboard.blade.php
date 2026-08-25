<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Tasks
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <table class="w-full border">

                        <thead>
                            <tr class="border-b">
                                <th class="p-3 text-left">Task</th>
                                <th class="p-3 text-left">Priority</th>
                                <th class="p-3 text-left">Due Date</th>
                                <th class="p-3 text-left">Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($tasks as $task)

                                <tr class="border-b">

                                    <td class="p-3">
                                        {{ $task->title }}
                                    </td>

                                    <td class="p-3">
                                        {{ ucfirst($task->priority) }}
                                    </td>

                                    <td class="p-3">
                                        {{ $task->due_date }}
                                    </td>

                                    <td class="p-3">
                                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" class="p-4 text-center">
                                        No tasks assigned.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                    <div class="mt-4">
                        {{ $tasks->links() }}
                    </div>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>