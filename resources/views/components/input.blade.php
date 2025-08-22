@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'border-gray-300 dark:border-gray-700 bg-chamos-naranja-oscuro text-black focus:border-chamos-beige focus:ring-chamos-amarillo rounded-md shadow-sm'
]) !!}>
