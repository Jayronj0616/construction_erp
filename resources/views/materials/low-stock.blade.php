@extends('layout')

@section('title', 'Low Stock Materials')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">⚠️ Low Stock Materials</h1>
            <p class="text-gray-600 mt-1">Materials below reorder level</p>
        </div>
        <a href="{{ route('materials.index') }}" class="text-gray-600 hover:text-gray-900">← Back to Materials</a>
    </div>

    @if ($materials->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($materials as $material)
                <div class="bg-yellow-50 border-2 border-yellow-200 rounded-lg p-6">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $material->name }}</h3>
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-bold rounded">LOW</span>
                    </div>

                    <div class="bg-white rounded p-3 mb-3">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Current</span>
                            <span class="font-bold text-gray-900">{{ $material->quantity_in_stock }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Minimum</span>
                            <span class="font-bold text-red-600">{{ $material->reorder_level }}</span>
                        </div>
                    </div>

                    <p class="text-gray-600 text-sm mb-3">{{ $material->category->name }}</p>
                    <p class="text-gray-700 text-sm mb-4">SKU: <span class="font-mono">{{ $material->sku }}</span></p>

                    <div class="flex gap-2">
                        <a href="{{ route('materials.show', $material) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-center font-medium text-sm">
                            View
                        </a>
                        <a href="{{ route('materials.add-stock', $material) }}" class="flex-1 bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded text-center font-medium text-sm">
                            Add Stock
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if ($materials->hasPages())
            <div class="flex justify-center">
                {{ $materials->links() }}
            </div>
        @endif
    @else
        <div class="bg-green-50 border border-green-200 rounded-lg p-8 text-center">
            <p class="text-green-700 text-lg font-medium">✓ All materials are in good stock!</p>
        </div>
    @endif
</div>
@endsection
