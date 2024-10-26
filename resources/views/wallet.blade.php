@extends('layouts.layout')

@section('title', 'Wallet')

@section('main')

    @include('include.header')

    <div class="max-w-screen-lg mx-auto mb-28">
        @if (session('warning'))
            <div class="bg-yellow-200 p-4 rounded-lg my-4">
                {{ session('warning') }}
            </div>
        @endif
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg my-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Wallet Balance Section -->
        <div class="mt-6 mx-3">
            <h2 class="text-2xl font-bold mb-4">Wallet</h2>
            <p class="bg-yellow-500 text-white p-4 rounded-lg my-4">You can withdraw once amount in PKR is more then 200
                rupees</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-6 text-center">
                <div class="bg-white border rounded-lg p-6 shadow-md">
                    <h2 class="text-2xl font-bold mb-4 capitalize">Earning</h2>
                    <p class="text-gray-800 text-3xl font-semibold mb-6">{{ $user?->wallet?->amount }} Coins</p>
                </div>

                <div class="bg-white border rounded-lg p-6 shadow-md">
                    <h2 class="text-2xl font-bold mb-4 capitalize">Daily Earning</h2>
                    <p class="text-gray-800 text-3xl font-semibold mb-6">{{ $user?->wallet?->daily_earning }} Coins</p>
                </div>

                <div class="bg-white border rounded-lg p-6 shadow-md">
                    <h2 class="text-2xl font-bold mb-4 capitalize">Earning in PKR</h2>
                    <p class="text-gray-800 text-3xl font-semibold mb-6">Rs {{ $amount }} + {{ $referralAmount ?? 0 }}
                        = {{ $totalAmount }}</p>
                    <small class="text-gray-500">This price is after converting into PKR. 1 coin price is 0.2 PKR</small>
                </div>

                <div class="bg-white border rounded-lg p-6 shadow-md">
                    <h2 class="text-2xl font-bold mb-4 capitalize">Extra Coins</h2>
                    <p class="text-gray-800 text-3xl font-semibold mb-6">{{ $user?->wallet?->extra_coins ?? 0 }}</p>
                    @if ($user?->level >= 2 && $user?->wallet?->extra_coins > 0)
                        <a href="{{route('extra.coins.convert', ['user'=>$user->id])}}"
                            class="px-2 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">
                            Convert
                        </a>
                    @else
                        <small class="text-gray-500">You can withdraw this at level 2.</small>
                    @endif
                </div>

            </div>
            @if ($user->verified_deposit == 'verified')
                <div class="text-end my-3">
                    <button data-modal-target="exchangeModal" data-modal-toggle="exchangeModal"
                        class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">
                        Withdraw Now
                    </button>
                </div>
            @else
                <small class="text-red-600">You can withdraw this after verified.</small>
            @endif
        </div>

        <!-- Transaction History Section -->
        <div class="bg-white p-6 rounded-lg shadow-md mt-6 mx-3">
            <h2 class="text-2xl font-bold mb-4">Transaction History</h2>
            <div class="space-y-4">
                <!-- Loop through transactions (dummy data for now) -->
                @foreach ($user->withDrawRequests()->latest()->get() as $withDrawRequest)
                    <div id="work-{{ $withDrawRequest->id }}"
                        class="bg-gray-50 p-4 rounded-lg shadow-sm flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold mb-1">Transaction on
                                {{ $withDrawRequest->updated_at->format('M d, Y') }}</h3>
                            <p class="text-gray-700">Time: {{ $withDrawRequest->updated_at->format('H:i:s') }}</p>
                            <p class="text-gray-700">Amount: {{ $withDrawRequest->amount }} Coins</p>
                        </div>
                        <span
                            class="inline-block px-3 py-1 text-xs font-semibold text-white rounded-full {{ $withDrawRequest->status == 'pending' ? 'bg-gray-400' : 'bg-green-500' }}">
                            {{ $withDrawRequest->status }}
                        </span>
                    </div>
                @endforeach
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
                                    required @if ($totalAmount < 200) disabled @endif>
                            </div>
                            <p>PKR {{ $totalAmount }}</p>
                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                @if ($totalAmount >= 200)
                                    <button type="submit"
                                        class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">
                                        Submit Request
                                    </button>
                                @else
                                    <p class="text-sm text-red-500">You have insufficient balance.</p>
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
