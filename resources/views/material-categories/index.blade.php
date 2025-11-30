@extends('layout')

@section('title', 'Material Categories')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Material Categories</h1>
            <p class="text-gray-600 mt-1">Manage material types and categories</p>
        </div>
        <a href="{{ route('material-categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
            + New Category
        </a>
    </div>

    @if ($categories->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($categories as $category)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-6">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h3>
                    <p class="text-gray-600 text-sm mt-2">{{ $category->description ?? 'No description' }}</p>
                    <div class="mt-4 pt-4 border-t">
                        <span class="text-gray-600 text-sm">Materials: </span>
                        <span class="font-bold text-gray-900">{{ $category->materials_count }}</span>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <a href="{{ route('material-categories.edit', $category) }}" class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-2 rounded text-center font-medium text-sm">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('material-categories.destroy', $category) }}" class="flex-1" onsubmit="return confirm('Delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 px-3 py-2 rounded font-medium text-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($categories->hasPages())
            <div class="flex justify-center">
                {{ $categories->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-12 bg-white rounded-lg">
            <p class="text-gray-500">No categories found.</p>
            <a href="{{ route('material-categories.create') }}" class="text-blue-600 hover:text-blue-700 mt-2">Create your first category</a>
        </div>
    @endif
</div>
@endsection
