@extends('layouts.layout')

@section('title', 'dashboard')

@section('main')

    @include('include.header')

    <div class="max-w-screen-lg mx-auto">
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg my-4">
                {{ session('success') }}
            </div>
        @endif
        @if (auth()->user()->email_verified_at)
            <!-- Card Section -->
            <section class="flex justify-center mt-6">
                <div class="w-96 bg-gradient-to-r from-green-400 to-indigo-500 text-white p-4 rounded-lg shadow-lg">
                    <div class="text-2xl font-semibold">{{auth()->user()?->account->account_number}}</div>
                    <div class="flex my-3 gap-1 items-center justify-between">
                        <h3>CARD HOLDER</h3>
                        <h4>{{auth()->user()->name}}</h4>
                    </div>
                    <div class="flex my-3 gap-1 items-center justify-between">
                        <h3> USER LEVEL</h3>
                        <h4>{{auth()->user()->level}}</h4>
                    </div>
                </div>
            </section>

            <!-- Icons Section -->
            <section class="grid grid-cols-2 gap-4 p-4 max-w-lg mx-auto mb-32">
                <a href="{{ route('work', ['user' => auth()->user()->id]) }}" class="bg-white shadow-lg p-6 rounded-lg text-center">
                    <img src="https://img.icons8.com/?size=100&id=K2e3XRZlbIp2&format=png&color=000000" class="mx-auto mb-4"
                        alt="Daily Work" />
                    <h2 class="text-xl font-bold">Daily Work</h2>
                </a>
                <a href="{{ route('profile', ['user' => auth()->user()->id]) }}" class="block bg-white shadow-lg p-6 rounded-lg text-center">
                    <img src="https://img.icons8.com/color/96/000000/user.png" class="mx-auto mb-4" alt="My Profile" />
                    <h2 class="text-xl font-bold">My Profile</h2>
                </a>
                <a href="{{ route('wallet', ['user' => auth()->user()->id]) }}" class="block bg-white shadow-lg p-6 rounded-lg text-center">
                    <img src="https://img.icons8.com/fluency/96/000000/wallet.png" class="mx-auto mb-4" alt="My Wallet" />
                    <h2 class="text-xl font-bold">My Wallet</h2>
                </a>
                <a href="{{ route('team', ['user' => auth()->user()->id]) }}" class="block bg-white shadow-lg p-6 rounded-lg text-center">
                    <img src="https://img.icons8.com/?size=100&id=S46Zmx6vqojg&format=png&color=000000" class="mx-auto mb-4" alt="My Wallet" />
                    <h2 class="text-xl font-bold">My Team</h2>
                </a>
                <a href="{{ route('settings') }}" class="col-span-2 block bg-white shadow-lg p-6 rounded-lg text-center">
                    <img src="https://img.icons8.com/fluency/96/000000/settings.png" class="mx-auto mb-4" alt="Settings" />
                    <h2 class="text-xl font-bold">Settings</h2>
                </a>
            </section>

            <!-- Footer -->
        @else
            <!-- Warning Alert -->
            <a href="{{route('initial.deposit')}}" class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative my-4 block"
                role="alert">
                <strong class="font-bold">Warning!</strong>
                <span class="block sm:inline">Please deposit initial amount</span>
            </a>

            <form action="{{ route('logout') }}" method="POST" class="text-center">
                @csrf
                <button type="submit" class="text-sm text-indigo-600 hover:underline">
                    Logout
                </button>
            </form>
        @endif

        @include('include.footer')

    </div>
@endsection
