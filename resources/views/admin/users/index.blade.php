@extends('layouts.admin')

@section('title', 'Users')

@section('main')
    <div class="container mx-auto px-4 py-6">
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg my-4">
                {{ session('success') }}
            </div>
        @endif
        <!-- Breadcrumb and Title Centered -->
        <div class="flex flex-col md:flex-row justify-center items-center md:justify-between md:items-center mb-6">
            <nav class="flex mb-4 md:mb-0" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.users') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-5 h-5 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                            Users
                        </a>
                    </li>
                </ol>
            </nav>
            <h2 class="text-2xl font-semibold capitalize">User List</h2>
        </div>

        <!-- Search Form -->
        <form action="{{ route('admin.users') }}" method="GET" class="mb-4 flex gap-1 justify-center">
            <div class="">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users"
                    class="p-2 border border-gray-300 rounded w-full">
            </div>
            <div class="">
                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-500 transition duration-300">
                    Search
                </button>
            </div>
        </form>

        <!-- User Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-lg rounded-lg">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="py-3 px-6 font-medium text-gray-600">Name</th>
                        <th class="py-3 px-6 font-medium text-gray-600">Email</th>
                        <th class="py-3 px-6 font-medium text-gray-600">Address</th>
                        <th class="py-3 px-6 font-medium text-gray-600">City</th>
                        <th class="py-3 px-6 font-medium text-gray-600">Country</th>
                        <th class="py-3 px-6 font-medium text-gray-600">Initial Deposit</th>
                        <th class="py-3 px-6 font-medium text-gray-600">Varify Deposit</th>

                        <th class="py-3 px-6 font-medium text-gray-600">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b">
                            <td class="py-3 px-6">{{ $user->name }}</td>
                            <td class="py-3 px-6">{{ $user->email }}</td>
                            <td class="py-3 px-6">
                                {{ Str::limit($user->address, 15) }}
                            </td>
                            <td class="py-3 px-6">{{ $user->city }}</td>
                            <td class="py-3 px-6">{{ $user->country }}</td>
                            <td class="py-3 px-6">
                                <span
                                    class="inline-block px-3 py-1 text-xs font-semibold text-white rounded-full {{ $user->initial_deposit == 'yes' ? 'bg-green-500' : 'bg-red-500' }}">
                                    {{ $user->initial_deposit }}
                                </span>
                            </td>
                            <td class="py-3 px-6">
                                <span
                                    class="inline-block px-3 py-1 text-xs font-semibold text-white rounded-full {{ $user->verified_deposit == 'pending' ? 'bg-gray-500' : 'bg-green-500' }}">
                                    {{ $user->verified_deposit }}
                                </span>
                            </td>

                            <td class="py-3 px-6">
                                <a href="{{ route('admin.users.view', ['user' => $user->id]) }}"
                                    class="text-indigo-600 hover:underline">View</a>
                                <button data-modal-target="popup-modal" data-modal-toggle="popup-modal"
                                    class="text-red-600 hover:underline ms-2 delete-button" type="button"
                                    data-user-id="{{ $user->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-3 px-6 text-center text-gray-600">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="my-3 text-end">
            @if ($users->hasPages())
                <nav aria-label="Page navigation example">
                    <ul class="inline-flex -space-x-px text-sm">
                        {{-- Previous Page Link --}}
                        @if ($users->onFirstPage())
                            <li>
                                <span
                                    class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg cursor-not-allowed">Previous</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $users->previousPageUrl() }}"
                                    class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($users->links()->elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <li>
                                    <span
                                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300">{{ $element }}</span>
                                </li>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $users->currentPage())
                                        <li>
                                            <a href="#" aria-current="page"
                                                class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{ $page }}</a>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ $url }}"
                                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($users->hasMorePages())
                            <li>
                                <a href="{{ $users->nextPageUrl() }}"
                                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                            </li>
                        @else
                            <li>
                                <span
                                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg cursor-not-allowed">Next</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            @endif
        </div>



    </div>

    <!-- Modal -->
    <div id="popup-modal" tabindex="-1"
        class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-screen bg-black bg-opacity-50">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-10 h-10 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete
                        this User?</h3>
                    <div style="margin-top: 20px;">
                        <form id="deleteForm" action="{{ route('admin.users.del') }}" method="post" class="inline">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="id" id="userId" value="">
                            <button type="submit"
                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Yes, I'm sure
                            </button>
                        </form>
                        <button data-modal-hide="popup-modal" type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                            cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function() {
                // Set the user ID in the hidden input
                const userId = this.getAttribute('data-user-id');
                document.getElementById('userId').value = userId;
            });
        });
    </script>



@endsection
