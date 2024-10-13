@extends('layouts.layout')

@section('title', 'Initial Deposit')

@section('main')
    <div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-r from-purple-400 to-indigo-500 p-4">
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-screen-md w-full text-center overflow-hidden">
            <h2 class="text-2xl font-bold mb-4">Please Deposit Your Initial Amount</h2>
            <p class="text-gray-700 mb-6">
                <span class="font-semibold">Note: Only JazzCash and Easypaisa are allowed</span>
            </p>

            <!-- Payment Method Images -->
            <div class="flex flex-wrap justify-around mb-6">
                <div class="flex flex-col items-center">
                    <img src="{{ asset('imgs/jazzcash.png') }}" alt="JazzCash" class="w-20 h-20 mb-2" />
                    <p>
                        <strong>Account Title:</strong> {{$settings->jazzcash_account_title}}
                    </p>
                    <p>
                        <strong>Account number:</strong> {{$settings->jazzcash_account_number}}
                    </p>
                    <p>
                        <strong>Bank Name:</strong> JazzCash
                    </p>
                </div>
                <div class="flex flex-col items-center mt-4 md:mt-0">
                    <img src="{{ asset('imgs/easypasa.jpeg') }}" alt="Easypaisa" class="w-20 h-20 mb-2" />
                    <p>
                        <strong>Account Title:</strong> {{$settings->easy_asa_account_title}}
                    </p>
                    <p>
                        <strong>Account number:</strong> {{$settings->easy_asa_account_number}}
                    </p>
                    <p>
                        <strong>Bank Name:</strong> EasyPaisa
                    </p>
                </div>
            </div>

            <p class="text-gray-700 mb-4">After sending this, please fill the following form:</p>

            <!-- Deposit Form -->
            <form action="{{ route('store.deposit') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="mb-4 text-start">
                    <label for="bank_name" class="block text-left text-gray-700">Bank Name</label>
                    <input type="text" id="bank_name" name="bank_name" placeholder="Enter your bank name" required
                        class="mt-1 p-3 border border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('bank_name') border-red-500 @enderror" value="{{old('bank_name')}}">
                    @error('bank_name')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4 text-start">
                    <label for="account_name" class="block text-left text-gray-700">Account Name</label>
                    <input type="text" id="account_name" name="account_name" placeholder="Enter your account name"
                        required
                        class="mt-1 p-3 border border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('account_name') border-red-500 @enderror" value="{{old('account_name')}}">
                    @error('account_name')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4 text-start">
                    <label for="account_number" class="block text-left text-gray-700">Account Number</label>
                    <input type="text" id="account_number" name="account_number" placeholder="Enter your account number"
                        required
                        class="mt-1 p-3 border border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('account_number') border-red-500 @enderror" value="{{old('account_number')}}">
                    @error('account_number')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4 text-start">
                    <label for="amount" class="block text-left text-gray-700">Deposit Amount</label>
                    <input type="text" id="amount" name="amount" placeholder="Enter your deposit amount" required
                        class="mt-1 p-3 border border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('amount') border-red-500 @enderror" value="{{old('amount')}}">
                    @error('amount')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4 text-start">
                    <label for="deposit_picture" class="block text-left text-gray-700">Deposit Picture</label>
                    <input type="file" id="deposit_picture" name="deposit_picture" accept="image/*" required
                        class="mt-1 p-3 border border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('deposit_picture') border-red-500 @enderror">
                    @error('deposit_picture')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit"
                        class="bg-indigo-600 text-white py-2 px-6 rounded-lg hover:bg-indigo-500 transition duration-300">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
