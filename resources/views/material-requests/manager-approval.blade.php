@extends('layout')

@section('title', 'Manager Approval')

@section('content')
<div class="max-w-3xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Manager Approval</h1>
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
                <span class="text-gray-600 text-sm">Requested By</span>
                <p class="text-gray-900 font-medium">{{ $materialRequest->requester->name }}</p>
            </div>
            <div>
                <span class="text-gray-600 text-sm">Supervisor Approved</span>
                <p class="text-green-600 font-medium">✓ Yes</p>
            </div>
            <div>
                <span class="text-gray-600 text-sm">Date Needed</span>
                <p class="text-gray-900 font-medium">{{ $materialRequest->date_needed->format('M d, Y') }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Stock Availability Check</h2>
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left font-medium">Material</th>
                    <th class="px-4 py-2 text-center font-medium">Requested</th>
                    <th class="px-4 py-2 text-center font-medium">Available</th>
                    <th class="px-4 py-2 text-center font-medium">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($materialRequest->items as $item)
                    <tr>
                        <td class="px-4 py-2 font-medium">{{ $item->material->name }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->quantity_requested }}</td>
                        <td class="px-4 py-2 text-center font-bold">{{ $item->available_stock }}</td>
                        <td class="px-4 py-2 text-center">
                            @if ($item->available_stock >= $item->quantity_requested)
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">✓ OK</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium">✗ LOW</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <form method="POST" action="{{ route('material-requests.manager-approval-store', $materialRequest) }}" class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf

        <div>
            <label class="block text-gray-700 font-medium mb-4">Decision *</label>
            <div class="space-y-3">
                <label class="flex items-center">
                    <input type="radio" name="decision" value="approved" class="rounded border-gray-300" checked>
                    <span class="ml-3 text-gray-700 font-medium">✓ Approve & Allow Issuance</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="decision" value="rejected" class="rounded border-gray-300" onchange="toggleReasonField()">
                    <span class="ml-3 text-gray-700 font-medium">✗ Reject</span>
                </label>
            </div>
        </div>

        <div id="reason-field" style="display: none;">
            <label class="block text-gray-700 font-medium mb-2">Reason for Rejection</label>
            <textarea name="reason" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Why are you rejecting this request?"></textarea>
            @error('reason')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                Submit Decision
            </button>
            <a href="{{ route('material-requests.show', $materialRequest) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-medium">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
function toggleReasonField() {
    const decision = document.querySelector('input[name="decision"]:checked').value;
    const reasonField = document.getElementById('reason-field');
    reasonField.style.display = decision === 'rejected' ? 'block' : 'none';
}
</script>
@endsection
