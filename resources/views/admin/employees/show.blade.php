<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Employee Details
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow rounded">

                <div class="mb-4">
                    <strong>Name:</strong>
                    {{ $employee->name }}
                </div>

                <div class="mb-4">
                    <strong>Email:</strong>
                    {{ $employee->email }}
                </div>

                <div class="mb-4">
                    <strong>Status:</strong>
                    {{ ucfirst($employee->status) }}
                </div>

                <div class="mb-4">
                    <strong>Joined:</strong>
                    {{ $employee->created_at->format('d M Y') }}
                </div>

                <a
                    href="{{ route('admin.employees.edit', $employee) }}"
                    class="bg-green-600 text-white px-4 py-2 rounded">
                    Edit
                </a>

                <a
                    href="{{ route('admin.employees.index') }}"
                    class="ml-2 text-gray-600">
                    Back
                </a>

            </div>

        </div>

    </div>

</x-app-layout>