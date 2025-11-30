@extends('layout')

@section('title', $material->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-start">
        <div>
            <a href="{{ route('materials.index') }}" class="text-blue-600 hover:text-blue-700">← Back to Materials</a>
            <h1 class="text-3xl font-bold text-gray-900 mt-2">{{ $material->name }}</h1>
            <p class="text-gray-600 mt-1">SKU: <span class="font-mono">{{ $material->sku }}</span></p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('materials.edit', $material) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                Edit
            </a>
            <form method="POST" action="{{ route('materials.destroy', $material) }}" class="inline" onsubmit="return confirm('Delete this material?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <!-- Stock Status -->
    <div class="grid grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-6">
            <span class="text-gray-600 text-sm">Current Stock</span>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $material->quantity_in_stock }}</p>
            <p class="text-gray-600 text-sm mt-1">{{ $material->unit_of_measure }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <span class="text-gray-600 text-sm">Status</span>
            <p class="text-lg font-bold mt-2">
                <span class="px-3 py-1 rounded-full text-sm {{ $material->stock_status_color }}">
                    {{ $material->stock_status }}
                </span>
            </p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <span class="text-gray-600 text-sm">Unit Price</span>
            <p class="text-2xl font-bold text-blue-600 mt-1">₱ {{ number_format($material->unit_price, 2) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <span class="text-gray-600 text-sm">Total Value</span>
            <p class="text-2xl font-bold text-green-600 mt-1">₱ {{ number_format($material->total_inventory_value, 2) }}</p>
        </div>
    </div>

    <!-- Material Info -->
    <div class="grid grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Material Information</h2>
            <div class="space-y-4">
                <div>
                    <span class="text-gray-600 text-sm">Category</span>
                    <p class="text-gray-900 font-medium mt-1">{{ $material->category->name }}</p>
                </div>
                <div>
                    <span class="text-gray-600 text-sm">Description</span>
                    <p class="text-gray-700 mt-1">{{ $material->description ?? 'No description' }}</p>
                </div>
                <div>
                    <span class="text-gray-600 text-sm">Reorder Level</span>
                    <p class="text-gray-900 font-medium mt-1">{{ $material->reorder_level }} {{ $material->unit_of_measure }}</p>
                </div>
                @if ($material->notes)
                    <div>
                        <span class="text-gray-600 text-sm">Notes</span>
                        <p class="text-gray-700 mt-1">{{ $material->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Suppliers -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Suppliers</h2>
            @if ($material->suppliers->count())
                <div class="space-y-3">
                    @foreach ($material->suppliers as $supplier)
                        <div class="border border-gray-200 rounded-lg p-3">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium text-gray-900">{{ $supplier->supplier->name }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $supplier->supplier->email ?? 'N/A' }}</p>
                                </div>
                                @if ($supplier->is_preferred)
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded font-medium">★ Preferred</span>
                                @endif
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-sm mt-2">
                                <div>
                                    <span class="text-gray-600">Price</span>
                                    <p class="font-medium">₱ {{ number_format($supplier->supplier_price, 2) }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-600">Lead Time</span>
                                    <p class="font-medium">{{ $supplier->lead_time_days }} days</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No suppliers assigned.</p>
            @endif
        </div>
    </div>

    <!-- Stock Management -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Stock Management</h2>
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('materials.add-stock', $material) }}" class="bg-green-50 hover:bg-green-100 border border-green-200 rounded-lg p-4 text-center">
                <p class="text-green-600 font-medium">➕ Add Stock</p>
                <p class="text-sm text-gray-600 mt-1">Increase inventory</p>
            </a>
            <a href="{{ route('materials.remove-stock', $material) }}" class="bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg p-4 text-center">
                <p class="text-red-600 font-medium">➖ Remove Stock</p>
                <p class="text-sm text-gray-600 mt-1">Record usage or damage</p>
            </a>
        </div>
    </div>

    <!-- Stock Transactions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Stock Transactions</h2>
        @if ($material->transactions->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-gray-900">Date</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-900">Type</th>
                            <th class="px-4 py-2 text-center font-medium text-gray-900">Quantity</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-900">Recorded By</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-900">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($material->transactions->sortByDesc('created_at') as $transaction)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 text-gray-700">{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 rounded text-xs font-medium {{ $transaction->type_color }}">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-center font-medium text-gray-900">{{ $transaction->quantity }}</td>
                                <td class="px-4 py-2 text-gray-700">{{ $transaction->recordedBy->name ?? 'System' }}</td>
                                <td class="px-4 py-2 text-gray-600">{{ $transaction->notes ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">No transactions recorded yet.</p>
        @endif
    </div>
</div>
@endsection
