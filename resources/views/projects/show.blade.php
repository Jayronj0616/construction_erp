@extends('layout')

@section('title', $project->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-start">
        <div>
            <a href="{{ route('projects.index') }}" class="text-blue-600 hover:text-blue-700">← Back to Projects</a>
            <h1 class="text-3xl font-bold text-gray-900 mt-2">{{ $project->name }}</h1>
            <p class="text-gray-600 mt-1">{{ $project->client->name }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('projects.edit', $project) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                Edit
            </a>
            <form method="POST" action="{{ route('projects.destroy', $project) }}" class="inline" onsubmit="return confirm('Are you sure?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <!-- Status & Progress -->
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow p-6">
            <span class="text-gray-600 text-sm">Status</span>
            <p class="text-2xl font-bold mt-1">
                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $project->status_color }}">
                    {{ $project->status }}
                </span>
            </p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <span class="text-gray-600 text-sm">Progress</span>
            <p class="text-2xl font-bold text-blue-600 mt-1">{{ $project->progress }}%</p>
            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $project->progress }}%"></div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <span class="text-gray-600 text-sm">Budget</span>
            <p class="text-2xl font-bold text-green-600 mt-1">₱ {{ number_format($project->budget, 2) }}</p>
        </div>
    </div>

    <!-- Project Details -->
    <div class="grid grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Project Information</h2>
            <div class="space-y-4">
                <div>
                    <span class="text-gray-600 text-sm">Location</span>
                    <p class="text-gray-900 font-medium">{{ $project->location }}</p>
                </div>
                <div>
                    <span class="text-gray-600 text-sm">Start Date</span>
                    <p class="text-gray-900 font-medium">{{ $project->start_date->format('M d, Y') }}</p>
                </div>
                <div>
                    <span class="text-gray-600 text-sm">End Date</span>
                    <p class="text-gray-900 font-medium">{{ $project->end_date->format('M d, Y') }}</p>
                </div>
                <div>
                    <span class="text-gray-600 text-sm">Duration</span>
                    <p class="text-gray-900 font-medium">{{ $project->start_date->diffInDays($project->end_date) }} days</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Client & Manager</h2>
            <div class="space-y-4">
                <div>
                    <span class="text-gray-600 text-sm">Client Name</span>
                    <p class="text-gray-900 font-medium">{{ $project->client->name }}</p>
                </div>
                <div>
                    <span class="text-gray-600 text-sm">Client Email</span>
                    <p class="text-gray-900">{{ $project->client->email ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-gray-600 text-sm">Project Manager</span>
                    <p class="text-gray-900 font-medium">{{ $project->manager->name ?? 'Not Assigned' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Description -->
    @if ($project->description)
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Description</h2>
            <p class="text-gray-700">{{ $project->description }}</p>
        </div>
    @endif

    <!-- Project Phases -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Project Phases</h2>
        @if ($project->phases->count())
            <div class="space-y-3">
                @foreach ($project->phases as $phase)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-medium text-gray-900">{{ $phase->phase_name }}</h3>
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $phase->status_color }}">
                                {{ $phase->status }}
                            </span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Start</span>
                                <p class="text-gray-900 font-medium">{{ $phase->start_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600">End</span>
                                <p class="text-gray-900 font-medium">{{ $phase->end_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600">Progress</span>
                                <p class="text-gray-900 font-medium">{{ $phase->progress }}%</p>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $phase->progress }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No phases defined for this project.</p>
        @endif
    </div>
</div>
@endsection
