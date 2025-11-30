@extends('layout')

@section('title', 'Workers')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Workers</h1>
            <p class="text-gray-600 mt-1">Manage construction workforce</p>
        </div>
        <a href="{{ route('workers.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
            + Add Worker
        </a>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <span class="text-gray-600 text-sm">Total Workers</span>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ \App\Models\Worker::count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <span class="text-gray-600 text-sm">Active</span>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $activeCount }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <span class="text-gray-600 text-sm">On Leave</span>
            <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $onLeaveCount }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <span class="text-gray-600 text-sm">Quick Links</span>
            <div class="flex gap-2 mt-2">
                <a href="{{ route('worker-positions.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Positions</a>
                <a href="{{ route('worker-categories.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Categories</a>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-lg shadow p-4">
        <form method="GET" action="{{ route('workers.search') }}" class="flex gap-2">
            <input type="text" name="q" placeholder="Search by name, ID, or position..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="{{ request('q') }}">
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium">Search</button>
        </form>
    </div>

    <!-- Workers Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Position</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Category</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Phone</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($workers as $worker)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-mono text-sm">{{ $worker->worker_id }}</td>
                        <td class="px-6 py-3 font-medium text-gray-900">{{ $worker->full_name }}</td>
                        <td class="px-6 py-3 text-gray-700">{{ $worker->position->name }}</td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded text-sm">{{ $worker->category->name }}</span>
                        </td>
                        <td class="px-6 py-3 text-gray-700">{{ $worker->phone }}</td>
                        <td class="px-6 py-3 text-center">
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $worker->status_color }}">
                                {{ $worker->status }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-center">
                            <div class="flex gap-1 justify-center">
                                <a href="{{ route('workers.show', $worker) }}" class="text-blue-600 hover:text-blue-900 text-sm">View</a>
                                <a href="{{ route('workers.edit', $worker) }}" class="text-gray-600 hover:text-gray-900 text-sm">Edit</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            No workers found. <a href="{{ route('workers.create') }}" class="text-blue-600 hover:text-blue-700 font-medium">Add one</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($workers->hasPages())
        <div class="flex justify-center">
            {{ $workers->links() }}
        </div>
    @endif
</div>
@endsection
