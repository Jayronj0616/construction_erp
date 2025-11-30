@props(['name', 'label', 'required' => false])

<label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
    {{ $label }}
    @if($required)
        <span class="text-red-600">*</span>
    @endif
</label>
