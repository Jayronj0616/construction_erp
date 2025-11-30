@extends('layout')

@section('title', 'Resubmit Request')

@section('content')
<div class="max-w-3xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Resubmit Request</h1>
        <a href="{{ route('material-requests.show', $materialRequest) }}" class="text-gray-600 hover:text-gray-900">← Back</a>
    </div>

    <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold text-red-900 mb-2">Rejection Reason</h2>
        <p class="text-red-700">{{ $materialRequest->rejection_reason }}</p>
    </div>

    <form method="POST" action="{{ route('material-requests.resubmit-store', $materialRequest) }}" class="bg-white rounded-lg shadow p-6 space-y-6">
        @csrf

        <div>
            <label class="block text-gray-700 font-medium mb-2">Your Response *</label>
            <textarea name="reason" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Explain why you're resubmitting or what changes you've made..." required></textarea>
        </div>

        <div>
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Adjust Quantities</h2>
            <div class="space-y-4">
                @foreach ($materialRequest->items as $item)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-3">
                            <div>
                                <h3 class="font-medium text-gray-900">{{ $item->material->name }}</h3>
                                <p class="text-sm text-gray-600">Stock available: {{ $item->available_stock }}</p>
                            </div>
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm rounded font-medium">
                                Previously requested: {{ $item->quantity_requested }}
                            </span>
                        </div>
                        <label class="block text-gray-700 font-medium text-sm mb-2">New Quantity</label>
                        <input type="hidden" name="materials[{{ $loop->index }}][item_id]" value="{{ $item->id }}">
                        <input type="number" 
                               name="materials[{{ $loop->index }}][quantity]" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                               min="1"
                               value="{{ $item->quantity_requested }}"
                               required>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                🔄 Resubmit Request
            </button>
            <a href="{{ route('material-requests.show', $materialRequest) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-medium">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
