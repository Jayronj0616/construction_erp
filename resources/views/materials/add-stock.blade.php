@extends('layout')

@section('title', 'Add Stock')

@section('content')
<div class="max-w-2xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Add Stock</h1>
        <a href="{{ route('materials.show', $material) }}" class="text-gray-600 hover:text-gray-900">← Back</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">{{ $material->name }}</h2>
                <p class="text-gray-600 mt-1">SKU: {{ $material->sku }}</p>
            </div>
            <div class="text-right">
                <span class="text-gray-600 text-sm">Current Stock</span>
                <p class="text-2xl font-bold text-gray-900">{{ $material->quantity_in_stock }} {{ $material->unit_of_measure }}</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('materials.store-stock', $material) }}" class="bg-white rounded-lg shadow p-6 space-y-6">
        @csrf

        <!-- Quantity -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Quantity to Add *</label>
            <input type="number" name="quantity" value="{{ old('quantity') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" min="1" required autofocus>
            <p class="text-sm text-gray-600 mt-1">Enter in {{ $material->unit_of_measure }}</p>
            @error('quantity')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Notes -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Notes</label>
            <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="e.g., Purchase Order #123, Supplier ABC">{{ old('notes') }}</textarea>
            @error('notes')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Buttons -->
        <div class="flex gap-3">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium">
                ✓ Add Stock
            </button>
            <a href="{{ route('materials.show', $material) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-medium">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
