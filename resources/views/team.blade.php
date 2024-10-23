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


        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-10 mx-3">
            <!-- Level 2 Card -->
            <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center space-y-4">
                <div class="flex items-center justify-center w-16 h-16 bg-green-100 rounded-full">
                    <!-- Heroicon for Coins -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-8 h-8 text-green-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-6l-9 9m0 0l-3-3m3 3v1.5A9 9 0 0012 3V1.5A9 9 0 0112 21v-1.5" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold">Level 2</h3>
                <p class="text-gray-600 text-center">When 20 members join through your link, your level moves to Level 2.
                </p>
                <p class="text-green-600 text-lg font-semibold">10 Daily Task Links</p>
            </div>

            <!-- Level 3 Card -->
            <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center space-y-4">
                <div class="flex items-center justify-center w-16 h-16 bg-green-100 rounded-full">
                    <!-- Heroicon for Coins -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-8 h-8 text-green-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-6l-9 9m0 0l-3-3m3 3v1.5A9 9 0 0012 3V1.5A9 9 0 0112 21v-1.5" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold">Level 3</h3>
                <p class="text-gray-600 text-center">When 40 members join through your link, you reach Level 3.</p>
                <p class="text-green-600 text-lg font-semibold">20 Daily Task Links</p>
            </div>

            <!-- Level 4 Card -->
            <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center space-y-4">
                <div class="flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full">
                    <!-- Heroicon for Task -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-8 h-8 text-blue-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-6l-9 9m0 0l-3-3m3 3v1.5A9 9 0 0012 3V1.5A9 9 0 0112 21v-1.5" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold">Level 4</h3>
                <p class="text-gray-600 text-center">When 70 members join through your link, you move to Level 4.</p>
                <p class="text-green-600 text-lg font-semibold">30 Daily Task Links</p>
            </div>

            <!-- Level 5 Card -->
            <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center space-y-4">
                <div class="flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full">
                    <!-- Heroicon for Tasks -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-8 h-8 text-indigo-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-6l-9 9m0 0l-3-3m3 3v1.5A9 9 0 0012 3V1.5A9 9 0 0112 21v-1.5" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold">Level 5</h3>
                <p class="text-gray-600 text-center">When 100 members join through your link, you reach Level 5.</p>
                <p class="text-green-600 text-lg font-semibold">45 Daily Task Links</p>
            </div>
        </div>

        <!-- Transaction History Section -->
        <div class="bg-white p-6 rounded-lg shadow-md mt-6 mx-3">
            <h2 class="text-2xl font-bold mb-4">Members</h2>
            <div class="space-y-4">
                @foreach ($user->references()->latest()->get() as $member)
                    <div id="member-{{ $member->id }}" class="bg-gray-50 p-4 rounded-lg shadow-sm flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold mb-1">{{ $member->inviteeUser->name }}</h3>
                            <p class="text-gray-700">Email: {{ $member->inviteeUser->email }}</p>
                            <p class="text-gray-700">Joined on: {{ $member->created_at->format('M d, Y') }}</p>
                        </div>
                        <span class="inline-block px-3 py-1 text-xs font-semibold text-white rounded-full {{ $member->status == 'active' ? 'bg-green-500' : 'bg-gray-400' }}">
                            {{ $member->status }}
                        </span>
                    </div>
                @endforeach
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
