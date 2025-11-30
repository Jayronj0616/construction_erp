@extends('layout')

@section('title', 'Create Material Request')

@section('content')
<div class="max-w-4xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">New Material Request</h1>
        <a href="{{ route('material-requests.index') }}" class="text-gray-600 hover:text-gray-900">← Back</a>
    </div>

    <form method="POST" action="{{ route('material-requests.store') }}" class="bg-white rounded-lg shadow p-6 space-y-6">
        @csrf

        <!-- Project & Date -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Project *</label>
                <select name="project_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <option value="">-- Select Project --</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
                @error('project_id')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Date Needed *</label>
                <input type="date" name="date_needed" value="{{ old('date_needed') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                @error('date_needed')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>
        </div>

        <!-- Purpose -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Purpose</label>
            <textarea name="purpose" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="What is this material for?">{{ old('purpose') }}</textarea>
            @error('purpose')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Materials Section -->
        <div>
            <label class="block text-gray-700 font-bold mb-4">Materials *</label>
            <div id="materials-container" class="space-y-4">
                <div class="material-item border border-gray-300 rounded-lg p-4">
                    <div class="grid grid-cols-3 gap-4 mb-3">
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Material</label>
                            <select name="materials[0][material_id]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                                <option value="">-- Select Material --</option>
                                @foreach ($materials as $material)
                                    <option value="{{ $material->id }}" data-stock="{{ $material->quantity_in_stock }}">
                                        {{ $material->name }} (Stock: {{ $material->quantity_in_stock }} {{ $material->unit_of_measure }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Quantity</label>
                            <input type="number" name="materials[0][quantity]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" min="1" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-1">Notes</label>
                            <input type="text" name="materials[0][notes]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Optional">
                        </div>
                    </div>
                    <button type="button" class="remove-material text-red-600 hover:text-red-900 text-sm font-medium">Remove</button>
                </div>
            </div>

            <button type="button" id="add-material" class="mt-4 bg-blue-50 hover:bg-blue-100 text-blue-600 px-4 py-2 rounded-lg font-medium">
                + Add Another Material
            </button>
            @error('materials')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Buttons -->
        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                Submit Request
            </button>
            <a href="{{ route('material-requests.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-medium">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
let materialCount = 1;

document.getElementById('add-material').addEventListener('click', function() {
    const container = document.getElementById('materials-container');
    const newItem = document.querySelector('.material-item').cloneNode(true);
    
    // Update names
    newItem.querySelectorAll('input, select').forEach(field => {
        const name = field.getAttribute('name');
        if (name) {
            field.setAttribute('name', name.replace(/\[0\]/, `[${materialCount}]`));
            field.value = '';
        }
    });
    
    container.appendChild(newItem);
    attachRemoveListener(newItem);
    materialCount++;
});

function attachRemoveListener(item) {
    const removeBtn = item.querySelector('.remove-material');
    if (removeBtn) {
        removeBtn.addEventListener('click', function() {
            item.remove();
        });
    }
}

// Attach listeners to existing remove buttons
document.querySelectorAll('.remove-material').forEach(attachRemoveListener);
</script>
@endsection
