@extends('layout')

@section('title', 'Issue Materials')

@section('content')
<div class="max-w-3xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Issue Materials</h1>
        <a href="{{ route('material-requests.show', $materialRequest) }}" class="text-gray-600 hover:text-gray-900">← Back</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Request Details</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <span class="text-gray-600 text-sm">Project</span>
                <p class="text-gray-900 font-medium">{{ $materialRequest->project->name }}</p>
            </div>
            <div>
                <span class="text-gray-600 text-sm">For</span>
                <p class="text-gray-900 font-medium">{{ $materialRequest->requester->name }}</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('material-requests.issue-store', $materialRequest) }}" class="bg-white rounded-lg shadow p-6 space-y-6">
        @csrf

        <div>
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Issue Quantities</h2>
            <div class="space-y-4">
                @foreach ($materialRequest->items as $item)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="grid grid-cols-4 gap-4 items-end">
                            <div>
                                <label class="block text-gray-700 font-medium text-sm">Material</label>
                                <p class="text-gray-900 font-medium mt-1">{{ $item->material->name }}</p>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium text-sm">Requested</label>
                                <p class="text-gray-900 font-medium mt-1">{{ $item->quantity_requested }} {{ $item->material->unit_of_measure }}</p>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium text-sm">Already Issued</label>
                                <p class="text-gray-900 font-medium mt-1">{{ $item->quantity_issued }}</p>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium text-sm">Available Stock</label>
                                <p class="text-gray-900 font-medium mt-1 {{ $item->available_stock >= $item->remaining_quantity ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $item->available_stock }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t">
                            <label class="block text-gray-700 font-medium text-sm mb-2">
                                Quantity to Issue (Max: {{ $item->remaining_quantity }})
                            </label>
                            <input type="hidden" name="items[{{ $loop->index }}][item_id]" value="{{ $item->id }}">
                            <input type="number" 
                                   name="items[{{ $loop->index }}][quantity_to_issue]" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                   min="0"
                                   max="{{ $item->remaining_quantity }}"
                                   value="{{ $item->remaining_quantity }}">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Received By (Optional)</label>
                <select name="received_by" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Select Worker --</option>
                    @foreach (\App\Models\User::orderBy('name')->get() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Notes</label>
                <input type="text" name="notes" placeholder="Issuance notes" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium">
                ✓ Issue Materials
            </button>
            <a href="{{ route('material-requests.show', $materialRequest) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-medium">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
