@extends('layout')

@section('title', 'Materials Inventory')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Materials Inventory</h1>
            <p class="text-gray-600 mt-1">Manage construction materials and stock levels</p>
        </div>
        <div class="flex gap-2">
            @if ($lowStockCount > 0)
                <a href="{{ route('materials.low-stock') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium">
                    ⚠️ {{ $lowStockCount }} Low Stock
                </a>
            @endif
            <a href="{{ route('materials.create') }}" onclick="event.preventDefault(); openFormModal('{{ route('materials.create') }}', 'Create New Material');" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                + Add Material
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <span class="text-gray-600 text-sm">Total Materials</span>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ \App\Models\Material::count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <span class="text-gray-600 text-sm">In Stock</span>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ \App\Models\Material::where('quantity_in_stock', '>', 0)->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <span class="text-gray-600 text-sm">Out of Stock</span>
            <p class="text-2xl font-bold text-red-600 mt-1">{{ \App\Models\Material::where('quantity_in_stock', 0)->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <span class="text-gray-600 text-sm">Inventory Value</span>
            <p class="text-2xl font-bold text-blue-600 mt-1">₱ {{ number_format(\App\Models\Material::selectRaw('SUM(quantity_in_stock * unit_price) as total')->value('total') ?? 0, 2) }}</p>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="bg-white rounded-lg shadow p-4">
        <form method="GET" action="{{ route('materials.search') }}" class="flex gap-2">
            <input type="text" name="q" placeholder="Search by name or SKU..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ request('q') }}">
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium">Search</button>
        </form>
    </div>

    <!-- Quick Links -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('material-categories.index') }}" class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
            <h3 class="font-semibold text-gray-900">📁 Categories</h3>
            <p class="text-gray-600 text-sm mt-1">Manage material categories</p>
        </a>
        <a href="{{ route('suppliers.index') }}" class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
            <h3 class="font-semibold text-gray-900">🏢 Suppliers</h3>
            <p class="text-gray-600 text-sm mt-1">Manage suppliers</p>
        </a>
        <a href="{{ route('materials.low-stock') }}" class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
            <h3 class="font-semibold text-gray-900">⚠️ Low Stock</h3>
            <p class="text-gray-600 text-sm mt-1">View low stock materials</p>
        </a>
    </div>

    <!-- Materials Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Material</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Category</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">SKU</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Stock</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Unit Price</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Status</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($materials as $material)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3">
                                <div class="font-medium text-gray-900">{{ $material->name }}</div>
                                <div class="text-sm text-gray-600">{{ $material->unit_of_measure }}</div>
                            </td>
                            <td class="px-6 py-3">
                                <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm">{{ $material->category->name }}</span>
                            </td>
                            <td class="px-6 py-3 text-gray-700">{{ $material->sku }}</td>
                            <td class="px-6 py-3 text-center">
                                <div class="font-medium text-gray-900">{{ $material->quantity_in_stock }}</div>
                                <div class="text-xs text-gray-600">Min: {{ $material->reorder_level }}</div>
                            </td>
                            <td class="px-6 py-3 text-center font-medium text-gray-900">
                                ₱ {{ number_format($material->unit_price, 2) }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $material->stock_status_color }}">
                                    {{ $material->stock_status }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-center">
                                <div class="flex gap-1 justify-center">
                                    <a href="{{ route('materials.show', $material) }}" class="text-blue-600 hover:text-blue-900 text-sm">View</a>
                                    <a href="{{ route('materials.edit', $material) }}" onclick="event.preventDefault(); openFormModal('{{ route('materials.edit', $material) }}', 'Edit Material');" class="text-gray-600 hover:text-gray-900 text-sm">Edit</a>
                                    <form id="delete-form-{{ $material->id }}" method="POST" action="{{ route('materials.destroy', $material) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete('delete-form-{{ $material->id }}')" class="text-red-600 hover:text-red-900 text-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                No materials found. <a href="{{ route('materials.create') }}" class="text-blue-600 hover:text-blue-700">Add one</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if ($materials->hasPages())
        <div class="flex justify-center">
            {{ $materials->links() }}
        </div>
    @endif
</div>
@endsection
