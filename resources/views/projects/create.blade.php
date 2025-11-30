@extends('layout')

@section('title', 'Create Project')

@section('content')
<div class="max-w-2xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Create New Project</h1>
        <a href="{{ route('projects.index') }}" class="text-gray-600 hover:text-gray-900">← Back</a>
    </div>

    <form method="POST" action="{{ route('projects.store') }}" class="bg-white rounded-lg shadow p-6 space-y-6">
        @csrf

        <!-- Project Name -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Project Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="e.g., House Renovation, Road Repair" required>
            @error('name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Description -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Project details...">{{ old('description') }}</textarea>
            @error('description')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Client -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Client *</label>
            <select name="client_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                <option value="">-- Select Client --</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                        {{ $client->name }}
                    </option>
                @endforeach
            </select>
            @error('client_id')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Location -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Location *</label>
            <input type="text" name="location" value="{{ old('location') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Project address/location" required>
            @error('location')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Start and End Date -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Start Date *</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                @error('start_date')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">End Date *</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                @error('end_date')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
        </div>

        <!-- Budget -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Budget (₱) *</label>
            <input type="number" name="budget" step="0.01" value="{{ old('budget') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="0.00" required>
            @error('budget')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Status -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Status *</label>
            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                <option value="Planning" {{ old('status') == 'Planning' ? 'selected' : '' }}>Planning</option>
                <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="On-Hold" {{ old('status') == 'On-Hold' ? 'selected' : '' }}>On-Hold</option>
                <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @error('status')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Manager -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Project Manager</label>
            <select name="manager_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">-- Select Manager --</option>
                @foreach ($managers as $manager)
                    <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                        {{ $manager->name }}
                    </option>
                @endforeach
            </select>
            @error('manager_id')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Buttons -->
        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                Create Project
            </button>
            <a href="{{ route('projects.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-medium">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
