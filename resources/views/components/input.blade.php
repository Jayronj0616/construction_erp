@props(['name', 'type' => 'text', 'required' => false, 'value' => ''])

<input 
    type="{{ $type }}"
    name="{{ $name }}"
    id="{{ $name }}"
    value="{{ old($name, $value) }}"
    @if($required) required @endif
    {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm ' . ($errors->has($name) ? 'border-red-300' : '')]) }}
/>
