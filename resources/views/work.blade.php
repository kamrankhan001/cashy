@extends('layouts.layout')

@section('title', 'Work')

@section('main')

    @include('include.header')

    <div class="max-w-screen-lg mx-auto">
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
        <div class="mt-6">
            <h2 class="text-2xl font-bold mb-4">Your Jobs</h2>
            <ul class="list-disc list-inside">
                {{-- @foreach ($jobs as $job) --}}
                    <li>
                        <a href="#" class="text-blue-600 hover:underline">
                            {{-- {{ $job->title }} --}}jobs
                        </a>
                    </li>
                {{-- @endforeach --}}
            </ul>
        </div>
        @endif

    </div>

    @include('include.footer')

@endsection
