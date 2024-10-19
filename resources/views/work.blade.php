@extends('layouts.layout')

@section('title', 'Work')

@section('main')

    @include('include.header')

    <div class="max-w-screen-lg mx-auto mb-20 sm:mb-20 md:mb-0">
        @if ($user->verified_deposit == 'pending')
            <div class="flex justify-center">
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative my-4"
                    role="alert">
                    <strong class="font-bold">Note:</strong>
                    <span class="block sm:inline">Your jobs will appear here after verifying your initial deposit.</span>

                </div>
            </div>
        @endif

        @if ($user->verified_deposit == 'verified')
            <div class="mt-6 mx-3">
                <h2 class="text-2xl font-bold mb-4">Your Work</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach ($works as $work)
                        <div id="work-{{ $work->id }}"
                            class="bg-white shadow-lg rounded-lg p-6 transition-transform transform hover:scale-105">
                            <h3 class="text-lg font-semibold mb-2">Work #{{ $loop->iteration }}</h3>
                            <p class="text-gray-700">Click on the link below:</p>
                            <form action="{{ route('work.track', ['user' => $user->id, 'work' => $work->id]) }}"
                                method="POST" class="work-form" data-work-id="{{ $work->id }}" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="button" class="text-blue-600 hover:underline"
                                    onclick="trackWork({{ $work->id }})">
                                    {{ $work->url }}
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

        @endif

    </div>

    @include('include.footer')

    <script>
        function trackWork(workId) {
            const form = document.querySelector(`form[data-work-id="${workId}"]`);
            const formData = new FormData(form);
            const liElement = document.getElementById(`work-${workId}`);

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        _method: 'PUT',
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.redirect_url) {
                        // Remove the <li> element from the DOM
                        liElement.remove();

                        // Redirect to the URL returned by the server
                        window.open(data.redirect_url, '_blank');

                    } else {
                        console.error('Error: Redirect URL not found');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>

@endsection
