@extends('layouts.layout')

@section('title', 'Registration Confirmation')

@section('main')
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
        <!-- Card Section -->
        <div class="bg-white p-8 rounded-lg shadow-lg text-center w-full max-w-md">
            <!-- Success Icon -->
            <div class="flex justify-center mb-4">
                <img src="https://img.icons8.com/fluency/96/000000/checked.png" alt="Success Icon" />
            </div>

            <!-- Title -->
            <h1 class="text-2xl font-bold text-indigo-900 mb-2">Registration Successful!</h1>

            <!-- Description -->
            <p class="text-gray-700 mb-6">
                Thank you for registering with us. Your account has been successfully created.
            </p>

            <p class="text-gray-700 mb-6">
                Click on blew button to continue.
            </p>

            <!-- Continue Button -->
            <a href="{{ route('initial.deposit') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition duration-300">
                Continue
            </a>
        </div>
    </div>
@endsection
