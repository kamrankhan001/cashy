@extends('layouts.admin')

@section('title', 'User Edit')

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
                        <a href="{{ route('admin.users') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-5 h-5 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                            Users
                        </a>
                    </li>
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.users.view', ['user' => $user->id]) }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            Details
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Edit</span>
                        </div>
                    </li>
                </ol>
            </nav>



            <h2 class="text-2xl font-semibold capitalize">User Edit</h2>
        </div>

        <!-- Personal Details Section -->
        <div class="bg-white p-6 shadow-lg rounded-lg mb-6">
            <h3 class="text-xl font-semibold mb-4">Edit User Account</h3>
            <div class="grid grid-cols-1 gap-4">
                <form action="{{ route('account.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Account Name -->
                    <div class="mb-4">
                        <label for="account_name" class="block text-sm font-medium text-gray-700">Account Name</label>
                        <input type="text" name="account_name" id="account_name"
                            value="{{ $user?->account?->account_name }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 disabled:bg-gray-100 disabled:text-gray-500 disabled:border-gray-200">
                    </div>

                    <!-- Bank Name -->
                    <div class="mb-4">
                        <label for="bank_name" class="block text-sm font-medium text-gray-700">Bank Name</label>
                        <input type="text" name="bank_name" id="bank_name" value="{{ $user?->account?->bank_name }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 disabled:bg-gray-100 disabled:text-gray-500 disabled:border-gray-200">
                    </div>

                    <!-- Account Number -->
                    <div class="mb-4">
                        <label for="account_number" class="block text-sm font-medium text-gray-700">Account Number</label>
                        <input type="text" name="account_number" id="account_number"
                            value="{{ $user?->account?->account_number }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 disabled:bg-gray-100 disabled:text-gray-500 disabled:border-gray-200">
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
