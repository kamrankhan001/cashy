@extends('layouts.layout')

@section('title', 'Login')

@section('main')
    <div class="h-screen flex justify-center items-center bg-gradient-to-r from-purple-400 to-indigo-500">
        <form action="{{ route('check.login') }}" method="POST" class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg"
            novalidate>
            @csrf
            <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Login</h2>

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

            <!-- Password Input with Eye Icon -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div
                    class="flex items-center border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-blue-400">
                    <input type="password" name="password" id="password" placeholder="Password"
                        class="w-full px-4 py-3 border-none focus:outline-none" required>
                    <!-- Eye Icon (Side by Side) -->
                    <span class="cursor-pointer px-3 flex items-center" onclick="togglePassword()">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </span>
                </div>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            <!-- Submit Button -->
            <div class="flex items-center justify-between">
                <button type="submit"
                    class="w-full py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">Login</button>
            </div>
            <div class="mt-4 flex justify-between">
                <div>
                    <a href="{{ route('register') }}" class="text-sm text-indigo-600 hover:underline">Don't have an account?</a>
                </div>
                <div>
                    <a href="{{ route('password.forget') }}" class="text-sm text-indigo-600 hover:underline">Forget Password?</a>
                </div>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 013.6-5.435m9.775 7.53a10.05 10.05 0 00-1.875 1.095m0 0A3 3 0 0112 15c-2.755 0-5.027-2.235-4.175-4.925M15 12a3 3 0 013 3M21 12c-1.274-4.057-5.064-7-9.542-7-4.478 0-8.268 2.943-9.542 7a10.05 10.05 0 001.542 3.825" />
                    </svg>`;
            } else {
                passwordField.type = 'password';
                eyeIcon.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                    </svg>`;
            }
        }
    </script>
@endsection
