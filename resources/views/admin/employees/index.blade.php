<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                Employees
            </h2>

            <a href="{{ route('admin.employees.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                Add Employee
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

            {{-- Search --}}

            <div class="bg-white p-4 mb-4 rounded shadow">

                <form method="GET"
                      action="{{ route('admin.employees.index') }}"
                      class="flex gap-3">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search name or email..."
                        class="border rounded px-3 py-2 flex-1"
                    >

                    <button
                        type="submit"
                        class="bg-gray-800 text-white px-5 py-2 rounded">
                        Search
                    </button>

                    <a
                        href="{{ route('admin.employees.index') }}"
                        class="bg-gray-400 text-white px-5 py-2 rounded">
                        Reset
                    </a>

                </form>

            </div>

            {{-- Employee Table --}}

            <div class="bg-white shadow rounded overflow-hidden">

                <table class="w-full">

                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">Name</th>
                            <th class="p-3 text-left">Email</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Created</th>
                            <th class="p-3 text-left">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($employees as $employee)

                            <tr class="border-t">

                                <td class="p-3">
                                    {{ $employee->name }}
                                </td>

                                <td class="p-3">
                                    {{ $employee->email }}
                                </td>

                                <td class="p-3">

                                    @if($employee->status === 'active')

                                        <span class="text-green-600">
                                            Active
                                        </span>

                                    @else

                                        <span class="text-red-600">
                                            Inactive
                                        </span>

                                    @endif

                                </td>

                                <td class="p-3">
                                    {{ $employee->created_at->format('d M Y') }}
                                </td>

                                <td class="p-3">

                                    <div class="flex gap-2">

                                        <a
                                            href="{{ route('admin.employees.show', $employee) }}"
                                            class="text-blue-600">
                                            View
                                        </a>

                                        <a
                                            href="{{ route('admin.employees.edit', $employee) }}"
                                            class="text-green-600">
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('admin.employees.destroy', $employee) }}"
                                            method="POST"
                                            onsubmit="return confirm('Delete this employee?')">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="text-red-600">
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="p-5 text-center">
                                    No employees found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-4">
                {{ $employees->links() }}
            </div>

        </div>
    </div>

</x-app-layout>