<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white p-6 rounded shadow">
                    <h3>Total Employees</h3>
                    <p class="text-3xl font-bold">
                        {{ $totalEmployees }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <h3>Total Tasks</h3>
                    <p class="text-3xl font-bold">
                        {{ $totalTasks }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <h3>Pending Tasks</h3>
                    <p class="text-3xl font-bold">
                        {{ $pendingTasks }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <h3>In Progress</h3>
                    <p class="text-3xl font-bold">
                        {{ $inProgressTasks }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <h3>Completed</h3>
                    <p class="text-3xl font-bold">
                        {{ $completedTasks }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <h3>Overdue</h3>
                    <p class="text-3xl font-bold text-red-600">
                        {{ $overdueTasks }}
                    </p>
                </div>

            </div>

        </div>
    </div>

</x-app-layout>