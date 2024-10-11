@extends('layouts.layout')

@section('title', 'Initial Deposit')

@section('main')
<div class="h-screen flex flex-col justify-center items-center bg-gradient-to-r from-purple-400 to-indigo-500 p-4">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-screen-lg w-full text-center">
        <h2 class="text-2xl font-bold mb-4">Please Deposit Your Initial Amount</h2>
        <p class="text-gray-700 mb-6">
            Deposit at this number (3454534) <span class="font-semibold">(Note: Only JazzCash and Easypaisa are allowed)</span>
        </p>

        <!-- Payment Method Images -->
        <div class="flex justify-around mb-6">
            <img src="{{ asset('imgs/jazzcash.png') }}" alt="JazzCash" class="w-20 h-20"/>
            <img src="{{ asset('imgs/easypasa.jpeg') }}" alt="Easypaisa" class="w-20 h-20"/>
        </div>

        <p class="text-gray-700 mb-4">After sending this, please fill the following form</p>

        <!-- Deposit Form -->
        <form action="{{ route('store.deposit') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            <div class="mb-4 text-start">
                <label for="bank_name" class="block text-left text-gray-700">Bank Name</label>
                <input type="text" id="bank_name" name="bank_name" placeholder="Enter your bank name" required class="mt-1 p-3 border border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('bank_name') border-red-500 @enderror">
                @error('bank_name')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4 text-start">
                <label for="account_name" class="block text-left text-gray-700">Account Name</label>
                <input type="text" id="account_name" name="account_name" placeholder="Enter your account name" required class="mt-1 p-3 border border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('account_name') border-red-500 @enderror">
                @error('account_name')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4 text-start">
                <label for="account_number" class="block text-left text-gray-700">Account Number</label>
                <input type="text" id="account_number" name="account_number" placeholder="Enter your account number" required class="mt-1 p-3 border border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('account_number') border-red-500 @enderror">
                @error('account_number')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4 text-start">
                <label for="deposit_picture" class="block text-left text-gray-700">Deposit Picture</label>
                <input type="file" id="deposit_picture" name="deposit_picture" accept="image/*" required class="mt-1 p-3 border border-gray-300 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('deposit_picture') border-red-500 @enderror">
                @error('deposit_picture')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="text-end">
                <button type="submit" class="bg-indigo-600 text-white py-2 px-6 rounded-lg hover:bg-indigo-500 transition duration-300">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
