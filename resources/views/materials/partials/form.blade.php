<form method="POST" action="{{ $action }}" class="space-y-4">
    @csrf
    @if($method ?? false)
        @method($method)
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- SKU -->
        <div>
            <x-input-label name="sku" label="SKU" required />
            <x-input name="sku" type="text" :value="$material->sku ?? ''" required />
            <x-input-error name="sku" />
        </div>

        <!-- Name -->
        <div>
            <x-input-label name="name" label="Material Name" required />
            <x-input name="name" type="text" :value="$material->name ?? ''" required />
            <x-input-error name="name" />
        </div>
    </div>

    <!-- Description -->
    <div>
        <x-input-label name="description" label="Description" />
        <x-textarea name="description" rows="3" :value="$material->description ?? ''" />
        <x-input-error name="description" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Category -->
        <div>
            <x-input-label name="category_id" label="Category" required />
            <x-select name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ ($material->category_id ?? old('category_id')) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </x-select>
            <x-input-error name="category_id" />
        </div>

        <!-- Unit of Measure -->
        <div>
            <x-input-label name="unit_of_measure" label="Unit of Measure" required />
            <x-select name="unit_of_measure" required>
                @foreach(['bag', 'piece', 'kg', 'meter', 'liter', 'box', 'bundle', 'roll', 'sheet', 'gallon'] as $unit)
                    <option value="{{ $unit }}" {{ ($material->unit_of_measure ?? old('unit_of_measure')) == $unit ? 'selected' : '' }}>
                        {{ ucfirst($unit) }}
                    </option>
                @endforeach
            </x-select>
            <x-input-error name="unit_of_measure" />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Quantity -->
        <div>
            <x-input-label name="quantity_in_stock" label="Quantity in Stock" required />
            <x-input name="quantity_in_stock" type="number" :value="$material->quantity_in_stock ?? '0'" required />
            <x-input-error name="quantity_in_stock" />
        </div>

        <!-- Reorder Level -->
        <div>
            <x-input-label name="reorder_level" label="Reorder Level" required />
            <x-input name="reorder_level" type="number" :value="$material->reorder_level ?? '0'" required />
            <x-input-error name="reorder_level" />
        </div>

        <!-- Unit Price -->
        <div>
            <x-input-label name="unit_price" label="Unit Price (₱)" required />
            <x-input name="unit_price" type="number" step="0.01" :value="$material->unit_price ?? '0'" required />
            <x-input-error name="unit_price" />
        </div>
    </div>

    <!-- Suppliers -->
    <div>
        <x-input-label name="suppliers" label="Suppliers" />
        <div class="mt-2 space-y-2 max-h-40 overflow-y-auto border border-gray-300 rounded-md p-3">
            @foreach($suppliers as $supplier)
                <label class="flex items-center">
                    <input type="checkbox" name="suppliers[]" value="{{ $supplier->id }}" 
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                           {{ in_array($supplier->id, $selectedSuppliers ?? []) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">{{ $supplier->name }}</span>
                </label>
            @endforeach
        </div>
        <x-input-error name="suppliers" />
    </div>

    <!-- Notes -->
    <div>
        <x-input-label name="notes" label="Notes" />
        <x-textarea name="notes" rows="3" :value="$material->notes ?? ''" />
        <x-input-error name="notes" />
    </div>

    <!-- Submit Buttons -->
    <div class="flex justify-end gap-3 pt-4 border-t">
        <button type="button" onclick="Swal.close()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
            Cancel
        </button>
        <x-button type="submit" variant="primary">
            {{ isset($material) && $material->exists ? 'Update Material' : 'Create Material' }}
        </x-button>
    </div>
</form>
