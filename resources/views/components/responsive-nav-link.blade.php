@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-3 border-l-4 border-white text-start text-base font-medium text-white bg-green-900 bg-opacity-50 focus:outline-none focus:text-white focus:bg-green-900 focus:border-white rounded-r-lg shadow-sm transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-3 border-l-4 border-transparent text-start text-base font-medium text-white hover:text-white hover:bg-green-900 hover:bg-opacity-30 hover:border-green-300 focus:outline-none focus:text-white focus:bg-green-900 focus:border-green-300 rounded-r-lg shadow-sm transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
