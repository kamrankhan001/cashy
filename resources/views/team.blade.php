@extends('layouts.layout')

@section('title', 'Team')

@section('main')

    @include('include.header')

    <div class="max-w-screen-lg mx-auto mb-24">
        <div
            class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 p-8 rounded-lg shadow-xl mt-6 text-center text-white mx-3">
            <!-- User Info -->
            <h2 class="text-3xl font-bold mb-4 capitalize">{{ $user?->name }}</h2>

            <!-- Total Members with Icon -->
            <div class="flex justify-center items-center mb-6 space-x-2">
                <!-- Icon for Total Members -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-300" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-4a1 1 0 012 0v1h-2v-1zM4.293 9.707a1 1 0 011.414 0L10 14.414l4.293-4.707a1 1 0 011.414 1.414l-5 5a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
                <p class="text-4xl font-semibold">Total Members: {{ $user?->references()->count() }}</p>
            </div>

            <!-- User Level with Icon -->
            <div class="flex justify-center items-center mb-6 space-x-2">
                <!-- Icon for Level -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-300" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
                </svg>
                <p class="text-2xl font-semibold">Your Level: {{ $user?->level }}</p>
            </div>

            <!-- Copy Link Button -->
            <button id="copyButton"
                class="px-6 py-3 bg-yellow-400 text-indigo-900 font-semibold rounded-full shadow-lg hover:bg-yellow-300 transition duration-200 focus:outline-none focus:ring-4 focus:ring-yellow-500"
                data-link="{{ $user->ref_link }}">
                Copy Link
            </button>
        </div>

        <div class="bg-white rounded-lg shadow-md mt-6 mx-3">
            <h2 class="text-2xl text-white font-bold mb-4 p-6 bg-indigo-900">Members</h2>
            <div class="space-y-4 px-2">
                @forelse ($user->references()->latest()->get() as $member)
                    <div id="member-{{ $member->id }}"
                        class="bg-gray-50 p-4 rounded-lg shadow-sm flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold mb-1">{{ $member->inviteeUser->name }}</h3>
                            <p class="text-gray-700">Email: {{ $member->inviteeUser->email }}</p>
                            <p class="text-gray-700">Joined on: {{ $member->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p>Initial Deposit</p>
                            <span
                                class="inline-block px-3 py-1 text-xs font-semibold text-white rounded-full {{ $member->inviteeUser->initial_deposit == 'yes' ? 'bg-green-500' : 'bg-gray-400' }}">
                                {{ $member->inviteeUser->initial_deposit }}
                            </span>
                        </div>
                        <div>
                            <p>Deposit Verify</p>
                            <span
                                class="inline-block px-3 py-1 text-xs font-semibold text-white rounded-full {{ $member->inviteeUser->verified_deposit == 'verified' ? 'bg-green-500' : 'bg-gray-400' }}">
                                {{ $member->inviteeUser->verified_deposit }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-gray-500 text-center text-xl">No member found.</div>
                @endforelse
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-10 mx-3">
            @foreach ($levels as $level)
                @if ($loop->index === 0)
                    @continue
                @endif

                @php
                    // Determine the color based on the level index, skipping the first level
                    $colorClass = '';
                    $adjustedIndex = $loop->index - 1; // Adjust the index to start from Level 2

                    if ($adjustedIndex < 3) {
                        $colorClass = 'text-green-500'; // First 3 levels (Green) (Level 2, 3, 4)
                    } elseif ($adjustedIndex < 6) {
                        $colorClass = 'text-blue-500'; // Next 3 levels (Blue) (Level 5, 6, 7)
                    } else {
                        $colorClass = 'text-yellow-500'; // Last 3 levels (Yellow) (Level 8, 9, 10)
                    }
                @endphp

                <!-- Level Card -->
                <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center space-y-4">
                    <div class="flex items-center justify-center w-16 h-16 {{ $colorClass }} rounded-full">
                        <!-- Heroicon for Coins -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8 {{ $colorClass }}">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3m6-6l-9 9m0 0l-3-3m3 3v1.5A9 9 0 0012 3V1.5A9 9 0 0112 21v-1.5" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold">Level {{ $level->level_number }}</h3>
                    <p class="text-gray-600 text-center">When {{ $level->members }} members join through your link, your
                        level moves to Level {{ $level->level_number }}.</p>

                    <!-- List with icons -->
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5 {{ $colorClass }} mr-2"> <!-- Removed colorClass -->
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                            </svg>
                            <span class="{{ $colorClass }} text-lg font-semibold">Task Income
                                {{ $level->task_income }}</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5 {{ $colorClass }} mr-2"> <!-- Removed colorClass -->
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                            </svg>
                            <span class="{{ $colorClass }} text-lg font-semibold">Referral Bonus
                                {{ $level->referral_bonus }} PKR</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5 {{ $colorClass }} mr-2"> <!-- Removed colorClass -->
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                            </svg>
                            <span class="{{ $colorClass }} text-lg font-semibold">Extra Coins {{ $level->extra_coins }}
                                Coins</span>
                        </li>
                    </ul>
                </div>
            @endforeach


        </div>

    </div>

    @include('include.footer')

    <script>
        document.getElementById('copyButton').addEventListener('click', function() {
            // Get the link from the data attribute
            const link = this.getAttribute('data-link');

            // Create a temporary input element to copy the link to clipboard
            const tempInput = document.createElement('input');
            tempInput.type = 'text';
            tempInput.value = link;
            document.body.appendChild(tempInput);

            // Select the text and copy it
            tempInput.select();
            document.execCommand('copy');

            // Remove the temporary input element
            document.body.removeChild(tempInput);

            // Optional: Show a confirmation message
            alert('Link copied to clipboard!');
        });
    </script>

@endsection
