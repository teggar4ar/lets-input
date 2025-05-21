<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LetsInput-Tajurhalang') }}</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('img/favicon.svg') }}" type="image/svg+xml">
        <link rel="shortcut icon" href="{{ asset('img/favicon.svg') }}" type="image/svg+xml">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-b from-green-800 to-green-900">
            <div>
                <a href="/">
                    <x-tajurhalang-logo class="w-32 h-32" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg border-t-4 border-yellow-500">
                <div class="text-center mb-5">
                    <h2 class="text-2xl font-bold text-green-800">Sistem Informasi Kependudukan</h2>
                    <p class="text-gray-600">Desa Tajurhalang</p>
                </div>
                {{ $slot }}
            </div>

            <div class="mt-6 text-yellow-100 text-center">
                <p>© {{ date('Y') }} Pemerintah Desa Tajurhalang</p>
                <p class="text-sm mt-1">Kabupaten Bogor - Jawa Barat</p>
            </div>
        </div>
    </body>
</html>
