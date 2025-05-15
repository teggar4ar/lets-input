@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-xl mx-auto bg-white rounded-lg shadow-md p-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-orange-600 mb-4">419</h1>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Page Expired</h2>
            <p class="text-gray-600 mb-6">Your session has expired. Please refresh and try again.</p>
            <a href="{{ url()->previous() }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                Try Again
            </a>
        </div>
    </div>
</div>
@endsection
