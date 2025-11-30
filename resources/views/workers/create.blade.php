@extends('layout')

@section('title', 'Add Worker')

@section('content')
<div class="max-w-2xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Add New Worker</h1>
        <a href="{{ route('workers.index') }}" class="text-gray-600 hover:text-gray-900">← Back</a>
    </div>

    <form method="POST" action="{{ route('workers.store') }}" class="bg-white rounded-lg shadow p-6 space-y-6">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Worker ID *</label>
                <input type="text" name="worker_id" value="{{ old('worker_id') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="e.g., EMP-001" required>
                @error('worker_id')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Hire Date *</label>
                <input type="date" name="hire_date" value="{{ old('hire_date') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                @error('hire_date')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-2">First Name *</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                @error('first_name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Last Name *</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                @error('last_name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                @error('email')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Phone *</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                @error('phone')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Position *</label>
                <select name="position_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                    <option value="">-- Select Position --</option>
                    @foreach ($positions as $position)
                        <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                            {{ $position->name }} (₱{{ number_format($position->base_daily_rate, 2) }}/day)
                        </option>
                    @endforeach
                </select>
                @error('position_id')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Category *</label>
                <select name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                    <option value="">-- Select Category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                Add Worker
            </button>
            <a href="{{ route('workers.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-medium">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
