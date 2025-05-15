@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-xl mx-auto bg-white rounded-lg shadow-md p-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-teal-600 mb-4">429</h1>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Too Many Requests</h2>
            <p class="text-gray-600 mb-6">You have made too many requests recently. Please wait before trying again.</p>
            <p class="text-sm text-gray-500 mb-6">This limit helps protect our service from automated attacks.</p>
            <a href="{{ url('/') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                Return Home
            </a>
        </div>
    </div>
</div>
@endsection
