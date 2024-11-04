@extends('layouts.layout')

@section('title', 'Term & Condition')

@section('main')
    @include('include.header')

    <div class="max-w-screen-lg mx-auto">
        @if (auth()->user()->email_verified_at)
            <div class="max-w-screen-lg mx-auto">
                <p class="text-center my-20 text-2xl">
                    Our team will confirm your remittance after complete verification and after that you will
                    be allowed to work sorry for the delay here every customer is allowed to work only after full verifcation.
                </p>
            </div>
        @else
            <!-- Warning Alert -->
            <a href="{{ route('initial.deposit') }}"
                class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative my-4 block"
                role="alert">
                <strong class="font-bold">Warning!</strong>
                <span class="block sm:inline">Please deposit initial amount</span>
            </a>
        @endif
    </div>

    @include('include.footer')

@endsection
