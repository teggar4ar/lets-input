@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 py-2 border-b-2 border-white text-sm font-medium leading-5 text-white bg-green-700 bg-opacity-50 rounded-t-lg focus:outline-none focus:border-white transition duration-150 ease-in-out'
            : 'inline-flex items-center px-3 py-2 border-b-2 border-transparent text-sm font-medium leading-5 text-white hover:text-white hover:bg-green-700 hover:bg-opacity-30 hover:border-green-300 focus:outline-none focus:text-white focus:border-green-300 rounded-t-lg transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
