@extends('layouts.layout')

@section('title', 'Confirm Email')

@section('main')
<div class="h-screen flex justify-center items-center bg-gradient-to-r from-purple-400 to-indigo-500">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-sm text-center">
        <img src="https://img.icons8.com/?size=100&id=13826&format=png&color=000000" alt="Email Sent" class="mx-auto mb-4" />
        <h2 class="text-3xl font-bold mb-4">Email Confirmation</h2>
        <p class="text-gray-600 mb-6">
            We have sent you an email. Please confirm your email address to continue.
        </p>
        <a href="{{ route('dashboard') }}" class="bg-indigo-600 text-white py-2 px-6 rounded-lg hover:bg-indigo-500 transition duration-300">
            Go to Home
        </a>
    </div>
</div>
@endsection
