<footer class="bg-indigo-900 text-white py-4 fixed bottom-0 left-0 right-0 mx-auto">
    <nav class="flex justify-center space-x-10 items-center">
        <a href="{{route('dashboard')}}" class="hover:underline">
            <img src="https://img.icons8.com/fluency/48/000000/home.png" alt="Home" title="Home"/>
        </a>
        <a href="{{ route('profile', ['user' => auth()->user()->id]) }}" class="hover:underline">
            <img src="https://img.icons8.com/color/48/000000/user.png" alt="Profile"title="Profile" />
        </a>
        <a href="{{ route('wallet', ['user' => auth()->user()->id]) }}" class="hover:underline">
            <img src="https://img.icons8.com/fluency/48/000000/wallet.png" alt="Wallet" title="Wallet"/>
        </a>
        <a href="{{route('settings')}}" class="hover:underline">
            <img src="https://img.icons8.com/fluency/48/000000/settings.png" alt="Settings" title="Settings"/>
        </a>
        <!-- Logout Button -->
        <form action="{{ route('logout') }}" method="POST" class="inline" title="Logout">
            @csrf
            <button type="submit" class="text-sm text-indigo-600 hover:underline">
                <img src="https://img.icons8.com/fluency/48/000000/exit.png" alt="Log Out" />
            </button>
        </form>
    </nav>
</footer>
