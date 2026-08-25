<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Create Task
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
                    action="{{ route('admin.tasks.store') }}">

                    @csrf

                    <div class="mb-4">

                        <label>Title</label>

                        <input
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            class="border rounded w-full px-3 py-2"
                            required>

                    </div>

                    <div class="mb-4">

                        <label>Description</label>

                        <textarea
                            name="description"
                            rows="5"
                            class="border rounded w-full px-3 py-2"
                            required>{{ old('description') }}</textarea>

                    </div>

                    <div class="mb-4">

                        <label>Assign Employee</label>

                        <select
                            name="assigned_to"
                            class="border rounded w-full px-3 py-2"
                            required>

                            <option value="">
                                Select Employee
                            </option>

                            @foreach($employees as $employee)

                                <option
                                    value="{{ $employee->id }}"
                                    {{ old('assigned_to') == $employee->id ? 'selected' : '' }}>

                                    {{ $employee->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>

                            <label>Priority</label>

                            <select
                                name="priority"
                                class="border rounded w-full px-3 py-2">

                                <option value="low">
                                    Low
                                </option>

                                <option value="medium" selected>
                                    Medium
                                </option>

                                <option value="high">
                                    High
                                </option>

                            </select>

                        </div>

                        <div>

                            <label>Status</label>

                            <select
                                name="status"
                                class="border rounded w-full px-3 py-2">

                                <option value="pending">
                                    Pending
                                </option>

                                <option value="in_progress">
                                    In Progress
                                </option>

                                <option value="completed">
                                    Completed
                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="mt-4 mb-4">

                        <label>Due Date</label>

                        <input
                            type="date"
                            name="due_date"
                            value="{{ old('due_date') }}"
                            class="border rounded w-full px-3 py-2"
                            required>

                    </div>

                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-5 py-2 rounded">

                        Create Task

                    </button>

                    <a
                        href="{{ route('admin.tasks.index') }}"
                        class="ml-2 text-gray-600">

                        Cancel

                    </a>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>