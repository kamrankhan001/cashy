@extends('layouts.admin')

@section('title', 'User View')

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
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Details</span>
                        </div>
                    </li>
                </ol>
            </nav>



            <h2 class="text-2xl font-semibold capitalize">User Details</h2>
        </div>

        <!-- Personal Details Section -->
        <div class="bg-white p-6 shadow-lg rounded-lg mb-6">
            <h3 class="text-xl font-semibold mb-4">Personal Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name:</label>
                    <p class="text-gray-600">{{ $user->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email:</label>
                    <p class="text-gray-600">{{ $user->email }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">City:</label>
                    <p class="text-gray-600">{{ $user->city }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Country:</label>
                    <p class="text-gray-600">{{ $user->country }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Address:</label>
                    <p class="text-gray-600">{{ $user->address }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 shadow-lg rounded-lg mb-6">
            <h3 class="text-xl font-semibold mb-4">Account Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Bank Name:</label>
                    <p class="text-gray-600">{{ $user?->account?->bank_name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Account Name:</label>
                    <p class="text-gray-600">{{ $user?->account?->account_name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Account Number:</label>
                    <p class="text-gray-600">{{ $user?->account?->account_number }}</p>
                </div>
            </div>
            <div class="text-end">
                <a href="{{route('admin.users.edit', ['user'=>$user->id])}}" class="text-indigo-600 hover:underline">Edit</a>
            </div>
        </div>

        <!-- Deposit Section -->
        <div class="bg-white p-6 shadow-lg rounded-lg mb-6">
            <h3 class="text-xl font-semibold mb-4">Deposit Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sender Name:</label>
                    <p class="text-gray-600">{{ $user?->firstDeposit?->sender_name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Trx Id:</label>
                    <p class="text-gray-600">{{ $user?->firstDeposit?->trx_id }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Account Number:</label>
                    <p class="text-gray-600">{{ $user?->firstDeposit?->sender_account }}</p>
                </div>
            </div>
        </div>

        <!-- Initial Deposit Section -->
        <div class="bg-white p-6 shadow-lg rounded-lg mb-6">
            <h3 class="text-xl font-semibold mb-4">Initial Deposit Verification</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- <div class="flex gap-1 items-center">
                    <label class="block text-sm font-medium text-gray-700">Deposit Amount</label>
                    <span class="px-4 py-2 rounded-full">
                        @if ($user?->payments[0] ?? false)
                            {{ $user->payments[0]->amount }}
                        @endif
                </div>
                <div class="flex gap-1 items-center">
                    <label class="block text-sm font-medium text-gray-700">Screen Shot</label>
                    @if ($user?->payments[0] ?? false)
                        <a href="{{ asset('storage/' . $user?->payments[0]?->deposit_picture) }}" target="_blank"
                            class="px-4 py-2">
                            <img src="{{ asset('storage/' . $user?->payments[0]?->deposit_picture) }}" alt="screen shot"
                                class="w-10 h-10 rounded-full">
                        </a>
                    @else
                        <span
                            class="px-2 py-1 rounded-full text-white bg-purple-500 }}">
                            no image
                        </span>
                    @endif
                </div> --}}
                <div class="flex gap-1 items-center">
                    <label class="block text-sm font-medium text-gray-700">Initial Deposit Status:</label>
                    <span
                        class="px-4 py-2 rounded-full text-white {{ $user->initial_deposit == 'yes' ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ ucfirst($user->initial_deposit) }}
                    </span>
                </div>
                <div class="flex gap-1 items-center">
                    <label class="block text-sm font-medium text-gray-700">Verified Deposit:</label>
                    <span
                        class="px-4 py-2 rounded-full text-white {{ $user->verified_deposit == 'verified' ? 'bg-green-500' : 'bg-gray-500' }}">
                        {{ ucfirst($user->verified_deposit) }}
                    </span>
                </div>
            </div>

            <!-- Form to Update Deposit Verification -->
            <div class="mt-6">
                <form action="{{ route('admin.users.updateDepositStatus', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label for="verified_deposit" class="block text-sm font-medium text-gray-700">Update Verification
                        Status:</label>
                    <select id="verified_deposit" name="verified_deposit"
                        class="p-2 border border-gray-300 rounded w-full mb-4">
                        <option value="pending" {{ $user->verified_deposit == 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="verified" {{ $user->verified_deposit == 'verified' ? 'selected' : '' }}>Verified
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
