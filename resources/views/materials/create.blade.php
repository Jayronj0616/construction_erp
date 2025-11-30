@extends('layout')

@section('title', 'Create Material')

@section('content')
<div class="max-w-2xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Add New Material</h1>
        <a href="{{ route('materials.index') }}" class="text-gray-600 hover:text-gray-900">← Back</a>
    </div>

    <form method="POST" action="{{ route('materials.store') }}" class="bg-white rounded-lg shadow p-6 space-y-6">
        @csrf

        <!-- SKU -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">SKU *</label>
            <input type="text" name="sku" value="{{ old('sku') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="e.g., CEMENT-001" required>
            @error('sku')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Name -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Material Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="e.g., Portland Cement" required>
            @error('name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Description -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description') }}</textarea>
            @error('description')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Category -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Category *</label>
            <select name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Unit of Measure -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Unit of Measure *</label>
            <select name="unit_of_measure" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                <option value="">-- Select Unit --</option>
                <option value="bag" {{ old('unit_of_measure') == 'bag' ? 'selected' : '' }}>Bag</option>
                <option value="piece" {{ old('unit_of_measure') == 'piece' ? 'selected' : '' }}>Piece</option>
                <option value="kg" {{ old('unit_of_measure') == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                <option value="meter" {{ old('unit_of_measure') == 'meter' ? 'selected' : '' }}>Meter (m)</option>
                <option value="liter" {{ old('unit_of_measure') == 'liter' ? 'selected' : '' }}>Liter (L)</option>
                <option value="box" {{ old('unit_of_measure') == 'box' ? 'selected' : '' }}>Box</option>
                <option value="bundle" {{ old('unit_of_measure') == 'bundle' ? 'selected' : '' }}>Bundle</option>
                <option value="roll" {{ old('unit_of_measure') == 'roll' ? 'selected' : '' }}>Roll</option>
                <option value="sheet" {{ old('unit_of_measure') == 'sheet' ? 'selected' : '' }}>Sheet</option>
                <option value="gallon" {{ old('unit_of_measure') == 'gallon' ? 'selected' : '' }}>Gallon</option>
            </select>
            @error('unit_of_measure')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Stock & Reorder Level -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Initial Stock *</label>
                <input type="number" name="quantity_in_stock" value="{{ old('quantity_in_stock', 0) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" min="0" required>
                @error('quantity_in_stock')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Reorder Level *</label>
                <input type="number" name="reorder_level" value="{{ old('reorder_level', 10) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" min="0" required>
                <p class="text-xs text-gray-600 mt-1">Alert when stock drops below this</p>
                @error('reorder_level')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
        </div>

        <!-- Unit Price -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Unit Price (₱) *</label>
            <input type="number" name="unit_price" step="0.01" value="{{ old('unit_price') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="0.00" required>
            @error('unit_price')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Suppliers -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Suppliers</label>
            <div class="space-y-2">
                @foreach ($suppliers as $supplier)
                    <label class="flex items-center">
                        <input type="checkbox" name="suppliers[]" value="{{ $supplier->id }}" {{ in_array($supplier->id, old('suppliers', [])) ? 'checked' : '' }} class="rounded border-gray-300">
                        <span class="ml-2 text-gray-700">{{ $supplier->name }}</span>
                    </label>
                @endforeach
            </div>
            @error('suppliers')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Notes -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Notes</label>
            <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('notes') }}</textarea>
            @error('notes')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Buttons -->
        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                Add Material
            </button>
            <a href="{{ route('materials.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-medium">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
