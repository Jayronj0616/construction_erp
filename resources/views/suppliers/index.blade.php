@extends('layout')

@section('title', 'Suppliers')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Suppliers</h1>
            <p class="text-gray-600 mt-1">Manage material suppliers and contacts</p>
        </div>
        <a href="{{ route('suppliers.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
            + New Supplier
        </a>
    </div>

    @if ($suppliers->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($suppliers as $supplier)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-6">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $supplier->name }}</h3>
                    
                    <div class="mt-3 space-y-2 text-sm">
                        @if ($supplier->contact_person)
                            <p class="text-gray-600">👤 {{ $supplier->contact_person }}</p>
                        @endif
                        @if ($supplier->email)
                            <p class="text-gray-600">📧 {{ $supplier->email }}</p>
                        @endif
                        @if ($supplier->phone)
                            <p class="text-gray-600">☎️ {{ $supplier->phone }}</p>
                        @endif
                        @if ($supplier->address)
                            <p class="text-gray-600">📍 {{ $supplier->address }}</p>
                        @endif
                    </div>

                    <div class="mt-4 pt-4 border-t">
                        <span class="text-gray-600 text-sm">Materials: </span>
                        <span class="font-bold text-gray-900">{{ $supplier->materials_count }}</span>
                    </div>

                    <div class="flex gap-2 mt-4">
                        <a href="{{ route('suppliers.edit', $supplier) }}" class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-2 rounded text-center font-medium text-sm">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}" class="flex-1" onsubmit="return confirm('Delete this supplier?');">
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

        @if ($suppliers->hasPages())
            <div class="flex justify-center">
                {{ $suppliers->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-12 bg-white rounded-lg">
            <p class="text-gray-500">No suppliers found.</p>
            <a href="{{ route('suppliers.create') }}" class="text-blue-600 hover:text-blue-700 mt-2">Create your first supplier</a>
        </div>
    @endif
</div>
@endsection
