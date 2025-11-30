@extends('layout')

@section('title', 'Material Requests')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Material Requests</h1>
            <p class="text-gray-600 mt-1">Manage material request workflow</p>
        </div>
        <a href="{{ route('material-requests.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
            + New Request
        </a>
    </div>

    <!-- Status Filters -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex gap-2 flex-wrap">
            <a href="{{ route('material-requests.index') }}" class="px-4 py-2 rounded-lg font-medium {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                All
            </a>
            @foreach(['Pending', 'Supervisor Approved', 'Manager Approved', 'Partially Issued', 'Issued', 'Rejected', 'Cancelled'] as $status)
                <a href="{{ route('material-requests.index', ['status' => $status]) }}" class="px-4 py-2 rounded-lg font-medium {{ request('status') === $status ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ $status }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Requests Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Project</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Requested By</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Items</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Date Needed</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($requests as $request)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-mono text-sm">{{ $request->id }}</td>
                        <td class="px-6 py-3">{{ $request->project->name }}</td>
                        <td class="px-6 py-3">{{ $request->requester->name }}</td>
                        <td class="px-6 py-3 text-center">{{ $request->items->count() }}</td>
                        <td class="px-6 py-3">{{ $request->date_needed->format('M d, Y') }}</td>
                        <td class="px-6 py-3 text-center">
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $request->status_color }}">
                                {{ $request->status }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-center">
                            <a href="{{ route('material-requests.show', $request) }}" class="text-blue-600 hover:text-blue-900 text-sm">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            No requests found. <a href="{{ route('material-requests.create') }}" class="text-blue-600 hover:text-blue-700">Create one</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($requests->hasPages())
        <div class="flex justify-center">
            {{ $requests->links() }}
        </div>
    @endif
</div>
@endsection
