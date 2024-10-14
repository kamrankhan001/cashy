@extends('layouts.layout')

@section('title', 'Team')

@section('main')

    @include('include.header')

    <div class="max-w-screen-lg mx-auto">
        <div class="flex justify-center">
            <div class="bg-white p-6 rounded-lg shadow-md mt-6 text-center">
                <h2 class="text-2xl font-bold mb-4 capitalize">{{ $user?->name }}</h2>
                <p class="text-gray-800 text-3xl font-semibold mb-6">
                    Total Member : {{ $user?->references()->count() }}
                </p>

                <button id="copyButton"
                    class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200"
                    data-link="{{ $link }}">
                    Copy Link
                </button>

            </div>
        </div>

        <!-- Transaction History Section -->
        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h2 class="text-2xl font-bold mb-4">Members</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white text-left border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-2 px-4 border-b">Name</th>
                            <th class="py-2 px-4 border-b">Email</th>
                            <th class="py-2 px-4 border-b">Join Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->references()->latest()->get() as $member)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $member->inviteeUser->name }}</td>
                                <td class="py-2 px-4 border-b">{{ $member->inviteeUser->email }}</td>
                                <td class="py-2 px-4 border-b">{{ $member->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
