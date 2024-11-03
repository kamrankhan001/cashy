@extends('layouts.admin')

@section('title', 'User Details')

@section('main')

    <div class="container mx-auto px-4 py-6">
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg my-4">
                {{ session('success') }}
            </div>
        @endif
        <div class="flex flex-col md:flex-row justify-center items-center md:justify-between md:items-center mb-6">
            <nav class="flex mb-4 md:mb-0" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.withdraw') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-5 h-5 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                            </svg>
                            Withdraw Request
                        </a>
                    </li>
                </ol>
            </nav>
            <h2 class="text-2xl font-semibold capitalize">User Details</h2>
        </div>

        <!-- User Information Section -->
        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h2 class="text-2xl font-bold mb-4">Personal Information</h2>
            <div class="grid grid-cols-2 gap-4">
                <!-- User Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name:</label>
                    <p class="text-gray-800">{{ $withdrawRequest?->user?->name }}</p>
                </div>
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email:</label>
                    <p class="text-gray-800">{{ $withdrawRequest?->user?->email }}</p>
                </div>
                <!-- Country -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Country:</label>
                    <p class="text-gray-800">{{ $withdrawRequest?->user?->country }}</p>
                </div>
                <!-- City -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">City:</label>
                    <p class="text-gray-800">{{ $withdrawRequest?->user?->city }}</p>
                </div>
                <!-- Address -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Address:</label>
                    <p class="text-gray-800">{{ $withdrawRequest?->user?->address }}</p>
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
                    <p class="text-gray-800">{{ $withdrawRequest?->user?->account?->account_name }}</p>
                </div>
                <!-- Account Title -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Account Number:</label>
                    <p class="text-gray-800">{{ $withdrawRequest?->user?->account?->account_number }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 shadow-lg rounded-lg my-6">
            <h3 class="text-xl font-semibold mb-4">Update Request Status</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex gap-1 items-center">
                    <label class="block text-sm font-medium text-gray-700">Request Status</label>
                    <span class="px-4 py-2 rounded-full">
                        <span
                            class="inline-block px-3 py-1 text-xs font-semibold text-white rounded-full {{ $withdrawRequest->status == 'pending' ? 'bg-gray-400' : 'bg-green-500' }}">
                            {{ $withdrawRequest->status }}
                        </span>
                    </span>
                </div>
            </div>

            <!-- Form to Update Deposit Verification -->
            <div class="mt-6">
                <form action="{{ route('admin.withdraw.request.update', $withdrawRequest?->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label for="request_status" class="block text-sm font-medium text-gray-700">Update Verification
                        Status:</label>
                    <select id="request_status" name="request_status"
                        class="p-2 border border-gray-300 rounded w-full mb-4">
                        <option value="pending" {{ $withdrawRequest->status == 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="verified" {{ $withdrawRequest->status == 'verified' ? 'selected' : '' }}>Verified
                        </option>
                    </select>
                    <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-500 transition duration-300">
                        Update Status
                    </button>
                </form>
            </div>
        </div>

    </div>


@endsection
