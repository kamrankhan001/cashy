@extends('layouts.layout')

@section('title', 'Wallet')

@section('main')

    @include('include.header')

    <div class="max-w-screen-lg mx-auto">
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg my-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Wallet Balance Section -->
        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h2 class="text-2xl font-bold mb-4">Wallet Balance</h2>
            <p class="text-gray-800 text-3xl font-semibold mb-6">{{ $user?->wallet?->amount }} Coins</p>

            <!-- Exchange to PKR Button -->
            @if ($user->verified_deposit == 'verified')
            <button data-modal-target="exchangeModal" data-modal-toggle="exchangeModal"
                class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">
                Convert to PKR
            </button>
            @else
            <p>You can withdraw this after varified.</p>
            @endif
        </div>

        <!-- Transaction History Section -->
        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h2 class="text-2xl font-bold mb-4">Transaction History</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white text-left border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-2 px-4 border-b">Date</th>
                            <th class="py-2 px-4 border-b">Time</th>
                            <th class="py-2 px-4 border-b">Amount</th>
                            <th class="py-2 px-4 border-b">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through transactions (dummy data for now) -->
                        @foreach ($user->withDrawRequests()->latest()->get() as $withDrawRequest)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $withDrawRequest->updated_at->format('M d, Y') }}</td>
                                <td class="py-2 px-4 border-b">{{ $withDrawRequest->updated_at->format('H:i:s') }}</td>
                                <td class="py-2 px-4 border-b">{{ $withDrawRequest->amount }} Coins</td>
                                <td class="py-2 px-4 border-b">
                                    <span
                                        class="inline-block px-3 py-1 text-xs font-semibold text-white rounded-full {{ $withDrawRequest->status == 'pending' ? 'bg-gray-400' : 'bg-green-500' }}">
                                        {{ $withDrawRequest->status }}
                                    </span>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div id="exchangeModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative bg-white rounded-lg shadow-lg max-w-md w-full">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center p-5 border-b">
                        <h3 class="text-lg font-medium text-gray-900">
                            Convert Coins to PKR
                        </h3>
                        <button type="button" class="text-gray-400 hover:text-gray-500" data-modal-hide="exchangeModal">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6">
                        <form action="{{ route('request.withdraw', ['user' => $user->id]) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="amount" class="block text-sm font-medium text-gray-700">Enter Amount
                                    (Coins)</label>
                                <input type="number" name="amount" id="amount" placeholder="Enter amount"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    required @if($amount < 200) disabled @endif>
                            </div>
                            <p>PKR {{$amount}}</p>
                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                @if ($amount >= 200)
                                    <button type="submit"
                                        class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">
                                        Submit Request
                                    </button>
                                @else
                                    <p class="text-sm text-red-500">You have infuficent balance.</p>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('include.footer')

@endsection
