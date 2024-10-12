@extends('layouts.layout')

@section('title', 'Profile')

@section('main')

    @include('include.header')

    <div class="max-w-screen-lg mx-auto">
        <!-- Success message -->
        @if (session('success'))
            <div class="flex justify-center">
                <div class="bg-green-500 text-white p-4 rounded-lg my-4 w-full max-w-md">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- User Information Section -->
        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h2 class="text-2xl font-bold mb-4">Personal Information</h2>
            <div class="grid grid-cols-2 gap-4">
                <!-- User Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name:</label>
                    <p class="text-gray-800">{{ $user->name }}</p>
                </div>
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email:</label>
                    <p class="text-gray-800">{{ $user->email }}</p>
                </div>
                <!-- Country -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Country:</label>
                    <p class="text-gray-800">{{ $user->country }}</p>
                </div>
                <!-- City -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">City:</label>
                    <p class="text-gray-800">{{ $user->city }}</p>
                </div>
                <!-- Address -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Address:</label>
                    <p class="text-gray-800">{{ $user->address }}</p>
                </div>
            </div>
        </div>

        <!-- Bank Account Information Section -->
        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h2 class="text-2xl font-bold mb-4">Bank Account Information</h2>
            <div class="grid grid-cols-2 gap-4">
                <!-- Account Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Account Name:</label>
                    <p class="text-gray-800">{{ $user->account->account_name }}</p>
                </div>
                <!-- Bank Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Bank Name:</label>
                    <p class="text-gray-800">{{ $user->account->bank_name }}</p>
                </div>
                <!-- Account Title -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Account Number:</label>
                    <p class="text-gray-800">{{ $user->account->account_number }}</p>
                </div>
            </div>
        </div>

    </div>

    @include('include.footer')

@endsection
