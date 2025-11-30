@extends('layout')

@section('title', 'Edit Category')

@section('content')
<div class="max-w-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Category</h1>
        <a href="{{ route('material-categories.index') }}" class="text-gray-600 hover:text-gray-900">← Back</a>
    </div>

    <form method="POST" action="{{ route('material-categories.update', $materialCategory) }}" class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700 font-medium mb-2">Category Name *</label>
            <input type="text" name="name" value="{{ old('name', $materialCategory->name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
            @error('name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description', $materialCategory->description) }}</textarea>
            @error('description')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="flex gap-3">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                Update
            </button>
            <a href="{{ route('material-categories.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-900 px-4 py-2 rounded-lg font-medium text-center">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
