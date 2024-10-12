@extends('layouts.admin')

@section('title', 'Users')

@section('main')
    <div class="container mx-auto px-4 py-6">
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
                                <a href="{{route('admin.users.view', ['user'=>$user->id])}}" class="text-indigo-600 hover:underline">View</a>
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
        <!-- Pagination -->
        <div class="mt-4 flex justify-center">
            {{ $users->links() }}
        </div>
    </div>
@endsection
