@props(['name', 'required' => false, 'options' => [], 'value' => '', 'placeholder' => 'Select...'])

<select 
    name="{{ $name }}"
    id="{{ $name }}"
    @if($required) required @endif
    {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm ' . ($errors->has($name) ? 'border-red-300' : '')]) }}
>
    @if($placeholder)
        <option value="">{{ $placeholder }}</option>
    @endif
    {{ $slot }}
</select>
