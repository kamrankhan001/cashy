@extends('layouts.layout')

@section('title', 'Profile')

@section('main')

    @include('include.header')

    <div class="max-w-screen-lg mx-auto">
        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-500 text-white font-semibold px-4 py-3 rounded-lg my-4 w-full">
                {{ session('success') }}
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
            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="bg-red-500 text-white font-semibold px-4 py-3 rounded-lg mb-4 w-full">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h2 class="text-2xl font-bold mb-4">Bank Account Information</h2>
            <div>
                {{-- <!-- Account Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Account Name:</label>
                    <p class="text-gray-800">{{ $user?->account?->account_name }}</p>
                </div>
                <!-- Bank Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Bank Name:</label>
                    <p class="text-gray-800">{{ $user?->account?->bank_name }}</p>
                </div>
                <!-- Account Number -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Account Number:</label>
                    <p class="text-gray-800">{{ $user?->account?->account_number }}</p>
                </div> --}}
                <form action="{{ route('account.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Account Name -->
                    <div class="mb-4">
                        <label for="account_name" class="block text-sm font-medium text-gray-700">Account Name</label>
                        <input type="text" name="account_name" id="account_name" {{ $user?->account ? 'disabled' : '' }}
                            value="{{ $user?->account?->account_name }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 disabled:bg-gray-100 disabled:text-gray-500 disabled:border-gray-200">
                    </div>

                    <!-- Bank Name -->
                    <div class="mb-4">
                        <label for="bank_name" class="block text-sm font-medium text-gray-700">Bank Name</label>
                        <input type="text" name="bank_name" id="bank_name" value="{{ $user?->account?->bank_name }}"
                            {{ $user?->account ? 'disabled' : '' }}
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 disabled:bg-gray-100 disabled:text-gray-500 disabled:border-gray-200">
                    </div>

                    <!-- Account Number -->
                    <div class="mb-4">
                        <label for="account_number" class="block text-sm font-medium text-gray-700">Account Number</label>
                        <input type="text" name="account_number" id="account_number"
                            {{ $user?->account ? 'disabled' : '' }} value="{{ $user?->account?->account_number }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 disabled:bg-gray-100 disabled:text-gray-500 disabled:border-gray-200">
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex justify-end">
                        @if (!$user?->account)
                            <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                                Save
                            </button>
                        @endif
                    </div>
                </form>

            </div>

            <!-- Update Button -->
            {{-- <div class="mt-4 text-right">
                <button onclick="toggleModal()"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">
                    Edit
                </button>
            </div> --}}
        </div>

        <!-- Update Account Modal -->
        {{-- <div id="updateAccountModal"
            class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
                <h3 class="text-xl font-semibold mb-4">Update Bank Account Details</h3>
                <form action="{{ route('account.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Account Name -->
                    <div class="mb-4">
                        <label for="account_name" class="block text-sm font-medium text-gray-700">Account Name</label>
                        <input type="text" name="account_name" id="account_name"
                            value="{{ $user?->account?->account_name }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>

                    <!-- Bank Name -->
                    <div class="mb-4">
                        <label for="bank_name" class="block text-sm font-medium text-gray-700">Bank Name</label>
                        <input type="text" name="bank_name" id="bank_name" value="{{ $user?->account?->bank_name }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>

                    <!-- Account Number -->
                    <div class="mb-4">
                        <label for="account_number" class="block text-sm font-medium text-gray-700">Account Number</label>
                        <input type="text" name="account_number" id="account_number"
                            value="{{ $user?->account?->account_number }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex justify-end">
                        <button type="button" onclick="toggleModal()"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg mr-2 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div> --}}

        <!-- JavaScript to Toggle Modal -->
        <script>
            function toggleModal() {
                const modal = document.getElementById('updateAccountModal');
                modal.classList.toggle('hidden');
            }
        </script>


    </div>

    @include('include.footer')

@endsection
