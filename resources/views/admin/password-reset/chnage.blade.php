@extends('layouts.admin')

@section('title', 'Change Password')

@section('main')
    <div class="container mx-auto px-4 py-6">
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg my-4">
                {{ session('success') }}
            </div>
        @endif
        <!-- Breadcrumb and Title Centered -->
        <div class="flex flex-col md:flex-row justify-center items-center md:justify-between md:items-center mb-6">
            <nav class="flex mb-4 md:mb-0" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.password.reset') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-5 h-5 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                            </svg>
                            Password Reset
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Change</span>
                        </div>
                    </li>
                </ol>
            </nav>



            <h2 class="text-2xl font-semibold capitalize">Change Password</h2>
        </div>

        <!-- Personal Details Section -->
        <div class="bg-white p-6 shadow-lg rounded-lg mb-6">
            <h3 class="text-xl font-semibold mb-4">Change Password</h3>
            <div class="grid grid-cols-1 gap-4">
                <form action="{{ route('admin.password.change.done', ['reset'=>$reset->id, 'user'=>$user->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- New Password -->
                    <div class="mb-4">
                        <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="password" id="new_password" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400
                            @error('new_password') border-red-500 @enderror">
                        @error('new_password')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm New Password -->
                    <div class="mb-4">
                        <label for="confirm_new_password" class="block text-sm font-medium text-gray-700">Confirm New
                            Password</label>
                        <input type="password" name="password_confirmation" id="confirm_new_password" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400
                            @error('confirm_new_password') border-red-500 @enderror">
                        @error('confirm_new_password')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                            Update Password
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
@endsection
