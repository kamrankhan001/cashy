@extends('layouts.layout')

@section('title', 'Settings')

@section('main')

    @include('include.header')

    <div class="max-w-screen-lg mx-auto">
        @if (session('success'))
        <div class="flex justify-center">
            <div class="bg-green-500 text-white p-4 rounded-lg my-4 w-full max-w-md">
                {{ session('success') }}
            </div>
        </div>
        @endif
        <div class="flex justify-center mt-10">
            <form action="{{ route('password.update') }}" method="POST"
                class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg" novalidate>
                @csrf
                <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Change Password</h2>

                <!-- Current Password Input -->
                <div class="mb-4">
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                    <input type="password" name="current_password" id="current_password" placeholder="Current Password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password Input -->
                <div class="mb-4">
                    <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <input type="password" name="new_password" id="new_password" placeholder="New Password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                    @error('new_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm New Password Input -->
                <div class="mb-6">
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New
                        Password</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                        placeholder="Confirm New Password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                    @error('new_password_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="w-full py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">Change
                        Password</button>
                </div>
            </form>

        </div>
    </div>

    @include('include.footer')

@endsection
