@extends('layouts.layout')

@section('title', 'Login')

@section('main')
    <div class="h-screen flex justify-center items-center bg-gradient-to-r from-purple-400 to-indigo-500">
        <form action="{{ route('check.login') }}" method="POST" class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg" novalidate>
            @csrf
            <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Login</h2>

            <!-- Email Input -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" autocomplete="off" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between">
                <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">Login</button>
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('register') }}" class="text-sm text-indigo-600 hover:underline">Don't have an account?</a>
            </div>
        </form>
    </div>
@endsection
