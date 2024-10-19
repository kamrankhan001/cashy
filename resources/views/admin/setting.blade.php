@extends('layouts.admin')

@section('title', 'Settings')

@section('main')

    <div class="container mx-auto px-4 py-6 space-y-8">

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg my-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Section 1: Change Password --}}
        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-xl font-semibold mb-4">Change Password</h3>
            <form action="{{ route('password.update') }}" method="POST" novalidate>
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                        <input type="password" name="current_password" id="current_password" placeholder="Current Password"
                            required
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('current_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="new_password" id="new_password" placeholder="New Password" required
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('new_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New
                            Password</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                            placeholder="New Password Confirm" required
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update
                        Password</button>
                </div>
            </form>
        </div>

        {{-- Section 2: Account Settings --}}
        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-xl font-semibold mb-4">Account Settings</h3>
            <form action="{{ route('admin.update-accounts', ['setting'=>$setting->id]) }}" method="POST" novalidate>
                @csrf
                {{-- JazzCash Section --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h4 class="text-lg font-medium mb-2">JazzCash</h4>
                        <label for="jazzcash_title" class="block text-sm font-medium text-gray-700">Account Title</label>
                        <input type="text" name="jazzcash_title" id="jazzcash_title" placeholder="Account Title" required value="{{$setting->jazzcash_account_title}}"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('jazzcash_title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <label for="jazzcash_number" class="block text-sm font-medium text-gray-700 mt-4">Account
                            Number</label>
                        <input type="text" name="jazzcash_number" id="jazzcash_number" placeholder="Account Number"
                            required value="{{$setting->jazzcash_account_number}}"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('jazzcash_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- EasyPaisa Section --}}
                    <div>
                        <h4 class="text-lg font-medium mb-2">EasyPaisa</h4>
                        <label for="easypaisa_title" class="block text-sm font-medium text-gray-700">Account Title</label>
                        <input type="text" name="easypaisa_title" id="easypaisa_title" placeholder="Account Title"
                            required value="{{$setting->easy_asa_account_title}}"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('easypaisa_title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <label for="easypaisa_number" class="block text-sm font-medium text-gray-700 mt-4">Account
                            Number</label>
                        <input type="text" name="easypaisa_number" id="easypaisa_number" placeholder="Account Number"
                            required value="{{$setting->easy_asa_account_number}}"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('easypaisa_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Save
                        Account Info</button>
                </div>
            </form>
        </div>

        {{-- Section 3: Coin Settings --}}
        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-xl font-semibold mb-4">Coin Settings</h3>
            <form action="{{ route('admin.update-coins', ['setting'=>$setting->id]) }}" method="POST" novalidate>
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="coin_price" class="block text-sm font-medium text-gray-700">Set Coin Price</label>
                        <input type="text" step="0.01" name="coin_price" id="coin_price" placeholder="Coin Price"
                            required value="{{$setting->per_coin_price}}"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('coin_price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="coins_per_work" class="block text-sm font-medium text-gray-700">Coins per Work</label>
                        <input type="text" name="coins_per_work" id="coins_per_work" placeholder="Coins for one work"
                            required value="{{$setting->job_per_coin}}"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('coins_per_work')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Save Coin
                        Settings</button>
                </div>
            </form>
        </div>

    </div>

@endsection
