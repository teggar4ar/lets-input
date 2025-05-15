@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-xl mx-auto bg-white rounded-lg shadow-md p-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-red-600 mb-4">500</h1>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Server Error</h2>
            <p class="text-gray-600 mb-6">We're experiencing some internal issues. Our team has been notified and is working to fix the problem.</p>
            <a href="{{ url('/') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                Return Home
            </a>
        </div>
    </div>
</div>
@endsection
