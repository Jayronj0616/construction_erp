@extends('layout')

@section('title', 'Material Request #' . $materialRequest->id)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-start">
        <div>
            <a href="{{ route('material-requests.index') }}" class="text-blue-600 hover:text-blue-700">← Back to Requests</a>
            <h1 class="text-3xl font-bold text-gray-900 mt-2">Material Request #{{ $materialRequest->id }}</h1>
            <p class="text-gray-600 mt-1">{{ $materialRequest->project->name }}</p>
        </div>
        <span class="px-4 py-2 rounded-lg text-lg font-semibold {{ $materialRequest->status_color }}">
            {{ $materialRequest->status }}
        </span>
    </div>

    <!-- Request Info -->
    <div class="grid grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <span class="text-gray-600 text-sm">Requested By</span>
            <p class="text-gray-900 font-medium mt-1">{{ $materialRequest->requester->name }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <span class="text-gray-600 text-sm">Date Needed</span>
            <p class="text-gray-900 font-medium mt-1">{{ $materialRequest->date_needed->format('M d, Y') }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <span class="text-gray-600 text-sm">Items Requested</span>
            <p class="text-gray-900 font-medium mt-1">{{ $materialRequest->total_requested }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <span class="text-gray-600 text-sm">Items Issued</span>
            <p class="text-gray-900 font-medium mt-1">{{ $materialRequest->total_issued }}/{{ $materialRequest->total_requested }}</p>
        </div>
    </div>

    <!-- Purpose -->
    @if ($materialRequest->purpose)
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Purpose</h2>
            <p class="text-gray-700">{{ $materialRequest->purpose }}</p>
        </div>
    @endif

    <!-- Rejection Reason -->
    @if ($materialRequest->rejection_reason)
        <div class="bg-red-50 border border-red-200 rounded-lg p-6">
            <h2 class="text-lg font-semibold text-red-900 mb-2">Rejection Reason</h2>
            <p class="text-red-700">{{ $materialRequest->rejection_reason }}</p>
        </div>
    @endif

    <!-- Materials Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Material</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Requested</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Issued</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Remaining</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Stock Available</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Notes</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($materialRequest->items as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">
                            <div class="font-medium text-gray-900">{{ $item->material->name }}</div>
                            <div class="text-sm text-gray-600">{{ $item->material->unit_of_measure }}</div>
                        </td>
                        <td class="px-6 py-3 text-center font-medium">{{ $item->quantity_requested }}</td>
                        <td class="px-6 py-3 text-center font-medium text-green-600">{{ $item->quantity_issued }}</td>
                        <td class="px-6 py-3 text-center font-medium text-blue-600">{{ $item->remaining_quantity }}</td>
                        <td class="px-6 py-3 text-center">
                            <span class="px-2 py-1 rounded text-sm font-medium {{ $item->hasEnoughStock() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $item->available_stock }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-gray-600">{{ $item->notes ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Approvals History -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Approvals</h2>
        @if ($materialRequest->approvals->count())
            <div class="space-y-3">
                @foreach ($materialRequest->approvals as $approval)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="font-medium text-gray-900">{{ ucfirst($approval->approval_level) }} Approval</h3>
                                <p class="text-sm text-gray-600">{{ $approval->approver->name }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $approval->decision_color }}">
                                {{ ucfirst($approval->decision) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600">{{ $approval->decided_at->format('M d, Y H:i') }}</p>
                        @if ($approval->reason)
                            <p class="text-sm text-gray-700 mt-2">{{ $approval->reason }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No approvals yet.</p>
        @endif
    </div>

    <!-- Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Actions</h2>
        <div class="flex gap-2 flex-wrap">
            @if ($materialRequest->canBeSupervisorApproved())
                <a href="{{ route('material-requests.supervisor-approval', $materialRequest) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                    👤 Supervisor Approval
                </a>
            @endif

            @if ($materialRequest->canBeManagerApproved())
                <a href="{{ route('material-requests.manager-approval', $materialRequest) }}" class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded-lg font-medium">
                    👔 Manager Approval
                </a>
            @endif

            @if ($materialRequest->canBeIssued())
                <a href="{{ route('material-requests.issue', $materialRequest) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">
                    📦 Issue Materials
                </a>
            @endif

            @if ($materialRequest->status === 'Rejected')
                <a href="{{ route('material-requests.resubmit', $materialRequest) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-medium">
                    🔄 Resubmit Request
                </a>
            @endif

            @if ($materialRequest->canBeRejected())
                <form method="POST" action="{{ route('material-requests.supervisor-approval-store', $materialRequest) }}" class="inline">
                    @csrf
                    <input type="hidden" name="decision" value="rejected">
                    <input type="hidden" name="reason" value="Rejected by requester">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium" onclick="return confirm('Cancel this request?');">
                        ❌ Cancel Request
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
