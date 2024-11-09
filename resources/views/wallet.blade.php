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
                    <h2 class="text-2xl font-bold mb-4 capitalize">Coins</h2>
                    <p class="text-gray-800 text-3xl font-semibold mb-6">{{ $user?->wallet?->amount ?? 0 }}</p>
                    @if ($user?->wallet?->amount > 0)
                        <a href="{{ route('convert.to.pkr', ['user' => $user, 'isExtraCoins' => 0]) }}"
                            class="px-2 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">
                            Exchange to PKR
                        </a>
                    @else
                        <button disabled title="not enough coins"
                            class="px-2 py-2 bg-indigo-500 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">
                            Exchange to PKR
                        </button>
                    @endif

                </div>

                {{-- <div class="bg-white border rounded-lg p-6 shadow-md">
                    <h2 class="text-2xl font-bold mb-4 capitalize">Daily Earning</h2>
                    <p class="text-gray-800 text-3xl font-semibold mb-6">{{ $user?->wallet?->daily_earning }} Coins</p>
                </div>

                <div class="bg-white border rounded-lg p-6 shadow-md">
                    <h2 class="text-2xl font-bold mb-4 capitalize">Earning in PKR</h2>
                    <p class="text-gray-800 text-3xl font-semibold mb-6">Rs {{ $amount }} + {{ $referralAmount ?? 0 }}
                        = {{ $totalAmount }}</p>
                    <small class="text-gray-500">This price is after converting into PKR. 1 coin price is 0.2 PKR</small>
                </div> --}}

                <div class="bg-white border rounded-lg p-6 shadow-md">
                    <h2 class="text-2xl font-bold mb-4 capitalize">Extra Coins</h2>
                    <p class="text-gray-800 text-3xl font-semibold mb-6">{{ $user?->wallet?->extra_coins ?? 0 }}</p>
                    @if ($user?->level >= 2 && $user?->level != $user?->last_level)
                        @if ($user?->wallet?->extra_coins > 0)
                            <a href="{{ route('convert.to.pkr', ['user' => $user, 'isExtraCoins' => 1]) }}"
                                class="px-2 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">
                                Exchange to PKR
                            </a>
                        @else
                            <button disabled title="not enough coins"
                                class="px-2 py-2 bg-indigo-500 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">
                                Exchange to PKR
                            </button>
                        @endif
                    @else
                        <small class="text-gray-500">You can withdraw this at next level.</small>
                    @endif
                </div>

            </div>
            @if ($user->verified_deposit == 'verified')
                <div class="bg-white border rounded-lg p-6 shadow-md">
                    <h2 class="text-2xl font-bold mb-4 capitalize">Rs {{ $user?->wallet?->convert_to_pkr }}</h2>
                    @if ($user?->wallet?->convert_to_pkr > 0 && $user?->wallet?->convert_to_pkr >= 200)
                        @if ($user?->account)
                            <a href="{{ route('withdraw.request', ['user' => $user]) }}"
                                class="px-2 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">
                                Get in Your Bank
                            </a>
                        @else
                            <button onclick="toggleModal('AccountModal')"
                                class="px-2 py-2 bg-indigo-500 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">
                                Get in Your Bank
                            </button>
                        @endif
                    @else
                        <button disabled title="not enough balance"
                            class="px-2 py-2 bg-indigo-500 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">
                            Get in Your Bank
                        </button>
                    @endif
                </div>
                {{-- <div class="text-end my-3">
                    <button data-modal-target="exchangeModal" data-modal-toggle="exchangeModal"
                        class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">
                        Withdraw Now
                    </button>
                </div> --}}
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
                            <p class="text-gray-700">Amount: {{ $withDrawRequest->amount }} Rs</p>
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
        <div id="AccountModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 overflow-y-auto">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black opacity-50" onclick="toggleModal('AccountModal')"></div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative bg-white rounded-lg shadow-lg max-w-md w-full z-10">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center p-5 border-b">
                        <h3 class="text-lg font-medium text-gray-900">
                            Provide the Account information
                        </h3>
                        <button type="button" class="text-gray-400 hover:text-gray-500"
                            onclick="toggleModal('AccountModal')">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6">
                        <form action="{{ route('account.update', ['user'=>$user->id, 'withdraw' => 1]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Account Name -->
                            <div class="mb-4">
                                <label for="account_name" class="block text-sm font-medium text-gray-700">Account
                                    Name</label>
                                <input type="text" name="account_name" id="account_name" required
                                    {{ $user?->account ? 'disabled' : '' }} value="{{ $user?->account?->account_name }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 disabled:bg-gray-100 disabled:text-gray-500 disabled:border-gray-200">
                            </div>

                            <!-- Bank Name -->
                            <div class="mb-4">
                                <label for="bank_name" class="block text-sm font-medium text-gray-700">Bank Name</label>
                                <input type="text" name="bank_name" id="bank_name" required
                                    value="{{ $user?->account?->bank_name }}" {{ $user?->account ? 'disabled' : '' }}
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 disabled:bg-gray-100 disabled:text-gray-500 disabled:border-gray-200">
                            </div>

                            <!-- Account Number -->
                            <div class="mb-4">
                                <label for="account_number" class="block text-sm font-medium text-gray-700">Account
                                    Number</label>
                                <input type="text" name="account_number" id="account_number" required
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
                </div>
            </div>
        </div>

        <script>
            function toggleModal(modalId) {
                const modal = document.getElementById(modalId);
                modal.classList.toggle('hidden');
            }

            window.onclick = function(event) {
                const modal = document.getElementById('AccountModal');
                if (event.target === modal) {
                    modal.classList.add('hidden');
                }
            };
        </script>


    </div>

    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }

        // Optional: To close the modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('AccountModal');
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        };
    </script>


    @include('include.footer')

@endsection
