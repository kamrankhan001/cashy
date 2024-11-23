@extends('layouts.layout')

@section('title', 'Password Forget')

@section('main')
    <div class="h-screen flex justify-center items-center bg-gradient-to-r from-purple-400 to-indigo-500">
        <div class="w-full max-w-md p-8">
            @if (session('success'))
                <div class="bg-green-500 text-white w-full max-w-md p-8 rounded-lg shadow mb-3">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-500 text-white w-full max-w-md p-8 rounded-lg shadow mb-3">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('password.forget.store') }}" method="POST"
                class="w-full p-8 bg-white rounded-lg shadow-lg" novalidate>
                @csrf
                <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Password Forget</h2>

                <!-- Email Input -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        autocomplete="off" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="w-full py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection
