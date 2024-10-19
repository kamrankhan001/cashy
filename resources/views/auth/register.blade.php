@extends('layouts.layout')

@section('title', 'Register')

@section('main')
    <div class="h-screen flex justify-center items-center bg-gradient-to-r from-purple-400 to-indigo-500">
        <form action="{{ route('register') }}" method="POST" class="w-full max-w-2xl p-8 bg-white rounded-lg shadow-lg"
            novalidate>
            @csrf
            <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Register</h2>

            <!-- Name and Email in one row for larger screens, stacked on smaller -->
            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4 mb-4">
                <input type="hidden" name="inviter" value="{{ $user }}">
                <!-- Name Input -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" placeholder="Full Name" value="{{ old('name') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        autocomplete="off" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        autocomplete="off" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Country and City in one row for larger screens, stacked on smaller -->
            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4 mb-4">
                <!-- Country Input -->
                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                    <input type="text" name="country" id="country" placeholder="Country" value="{{ old('country') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                    @error('country')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- City Input -->
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                    <input type="text" name="city" id="city" placeholder="City" value="{{ old('city') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                    @error('city')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Address and Phone in one row for larger screens, stacked on smaller -->
            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4 mb-4">
                <!-- Address Input -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" id="address" placeholder="Address" value="{{ old('address') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Input -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="tel" name="phone" id="phone" placeholder="Phone Number"
                        value="{{ old('phone') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Password and Password Confirmation in one row for larger screens, stacked on smaller -->
            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4 mb-6">
                <!-- Password Input with Eye Icon -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div
                        class="flex items-center border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-blue-400">
                        <input type="password" name="password" id="password" placeholder="Password"
                            class="w-full px-4 py-3 border-none focus:outline-none" required>
                        <!-- Eye Icon -->
                        <span class="cursor-pointer px-3 flex items-center" onclick="togglePassword('password')">
                            <svg id="eyeIconPassword" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

                <!-- Password Confirmation Input with Eye Icon -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                        Password</label>
                    <div
                        class="flex items-center border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-blue-400">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="Confirm Password" class="w-full px-4 py-3 border-none focus:outline-none" required>
                        <!-- Eye Icon -->
                        <span class="cursor-pointer px-3 flex items-center"
                            onclick="togglePassword('password_confirmation')">
                            <svg id="eyeIconPasswordConfirmation" xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between">
                <button type="submit"
                    class="w-full py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">Register</button>
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:underline">Already have an
                    account?</a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword(id) {
            const passwordInput = document.getElementById(id);
            const eyeIcon = passwordInput.nextElementSibling.querySelector('svg');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                // Replace the whole SVG icon for the "show" state
                eyeIcon.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 013.6-5.435m9.775 7.53a10.05 10.05 0 00-1.875 1.095m0 0A3 3 0 0112 15c-2.755 0-5.027-2.235-4.175-4.925M15 12a3 3 0 013 3M21 12c-1.274-4.057-5.064-7-9.542-7-4.478 0-8.268 2.943-9.542 7a10.05 10.05 0 001.542 3.825" />
                    </svg>`;

            } else {
                passwordInput.type = 'password';
                // Replace the whole SVG icon for the "hide" state
                eyeIcon.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                    </svg>`;
            }
        }
    </script>
@endsection
