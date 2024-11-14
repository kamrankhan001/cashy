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
                <p class="text-4xl font-semibold">Total Members: {{ $totalMembers }}</p>
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
                    @if ($member->inviteeUser->verified_deposit == 'verified')
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
                    @endif
                @empty
                    <div class="p-4 text-gray-500 text-center text-xl">No member found.</div>
                @endforelse
            </div>
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
