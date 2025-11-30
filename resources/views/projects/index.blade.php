@extends('layout')

@section('title', 'Projects')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Projects</h1>
            <p class="text-gray-600 mt-1">Manage all construction projects</p>
        </div>
        <a href="{{ route('projects.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
            + New Project
        </a>
    </div>

    <!-- Search Bar -->
    <div class="bg-white rounded-lg shadow p-4">
        <form method="GET" action="{{ route('projects.search') }}" class="flex gap-2">
            <input type="text" name="q" placeholder="Search projects..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ request('q') }}">
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium">Search</button>
        </form>
    </div>

    <!-- Projects Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($projects as $project)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $project->name }}</h3>
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $project->status_color }}">
                            {{ $project->status }}
                        </span>
                    </div>

                    <p class="text-gray-600 text-sm mb-3">{{ $project->client->name }}</p>
                    <p class="text-gray-500 text-sm mb-4">📍 {{ $project->location }}</p>

                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-700">Progress</span>
                            <span class="text-gray-600 font-medium">{{ $project->progress }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $project->progress }}%"></div>
                        </div>
                    </div>

                    <!-- Project Info -->
                    <div class="grid grid-cols-2 gap-2 text-sm mb-4">
                        <div>
                            <span class="text-gray-500">Start</span>
                            <p class="text-gray-900 font-medium">{{ $project->start_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500">End</span>
                            <p class="text-gray-900 font-medium">{{ $project->end_date->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <div class="mb-4 pb-4 border-t">
                        <span class="text-gray-500 text-sm">Budget</span>
                        <p class="text-lg font-bold text-gray-900">₱ {{ number_format($project->budget, 2) }}</p>
                    </div>

                    <!-- Days Remaining -->
                    <div class="mb-4">
                        @if ($project->isOverdue())
                            <span class="px-2 py-1 bg-red-100 text-red-700 text-xs rounded">⚠️ Overdue</span>
                        @else
                            <span class="text-gray-600 text-sm">
                                📅 {{ $project->days_remaining }} days remaining
                            </span>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2">
                        <a href="{{ route('projects.show', $project) }}" class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-2 rounded text-center font-medium text-sm">
                            View
                        </a>
                        <a href="{{ route('projects.edit', $project) }}" class="flex-1 bg-gray-50 hover:bg-gray-100 text-gray-600 px-3 py-2 rounded text-center font-medium text-sm">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('projects.destroy', $project) }}" class="flex-1" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 px-3 py-2 rounded font-medium text-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500">No projects found.</p>
                <a href="{{ route('projects.create') }}" class="text-blue-600 hover:text-blue-700 mt-2">Create your first project</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($projects->hasPages())
        <div class="flex justify-center">
            {{ $projects->links() }}
        </div>
    @endif
</div>
@endsection
