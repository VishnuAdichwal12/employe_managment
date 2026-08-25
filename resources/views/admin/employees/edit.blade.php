<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Employee
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow rounded">

                @if($errors->any())
                    <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    method="POST"
                    action="{{ route('admin.employees.update', $employee) }}">

                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label>Name</label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $employee->name) }}"
                            class="border rounded w-full px-3 py-2"
                            required>
                    </div>

                    <div class="mb-4">
                        <label>Email</label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $employee->email) }}"
                            class="border rounded w-full px-3 py-2"
                            required>
                    </div>

                    <div class="mb-4">
                        <label>
                            Password
                            <small>(Leave blank to keep current password)</small>
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="border rounded w-full px-3 py-2">
                    </div>

                    <div class="mb-4">

                        <label>Status</label>

                        <select
                            name="status"
                            class="border rounded w-full px-3 py-2">

                            <option
                                value="active"
                                {{ $employee->status === 'active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option
                                value="inactive"
                                {{ $employee->status === 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                    </div>

                    <button
                        type="submit"
                        class="bg-green-600 text-white px-5 py-2 rounded">
                        Update Employee
                    </button>

                    <a
                        href="{{ route('admin.employees.index') }}"
                        class="ml-2 text-gray-600">
                        Cancel
                    </a>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>