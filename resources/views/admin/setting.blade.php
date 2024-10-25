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
                <div class="grid grid-cols-1">
                    <div>
                        <label for="coin_price" class="block text-sm font-medium text-gray-700">Set Coin Price</label>
                        <input type="text" step="0.01" name="coin_price" id="coin_price" placeholder="Coin Price"
                            required value="{{$setting->per_coin_price}}"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('coin_price')
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

        {{-- Section 4: Levels Settings --}}
        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-xl font-semibold mb-4">Levels Settings</h3>
            <form action="{{ route('admin.levels.update') }}" method="POST">
                @csrf

                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Members</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task Income (PKR)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Referral Bonus (PKR)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Extra Coins</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($levels as $level)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $level->level_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="hidden" name="levels[{{ $loop->index }}][id]" value="{{ $level->id }}">
                                    <input type="number" name="levels[{{ $loop->index }}][members]" value="{{ old('levels.' . $loop->index . '.members', $level->members) }}" class="border rounded p-2">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="number" name="levels[{{ $loop->index }}][task_income]" step="0.01" value="{{ old('levels.' . $loop->index . '.task_income', $level->task_income) }}" class="border rounded p-2">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="number" name="levels[{{ $loop->index }}][referral_bonus]" step="0.01" value="{{ old('levels.' . $loop->index . '.referral_bonus', $level->referral_bonus) }}" class="border rounded p-2">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="number" name="levels[{{ $loop->index }}][extra_coins]" value="{{ old('levels.' . $loop->index . '.extra_coins', $level->extra_coins) }}" class="border rounded p-2">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    <button type="submit"  class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update Levels</button>
                </div>
            </form>
        </div>

    </div>

@endsection
