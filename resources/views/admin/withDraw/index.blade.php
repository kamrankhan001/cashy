@extends('layouts.admin')

@section('title', 'Withdraw Request')

@section('main')

    <div class="container mx-auto px-4 py-6">
        <div class="flex flex-col md:flex-row justify-center items-center md:justify-between md:items-center mb-6">
            <nav class="flex mb-4 md:mb-0" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.withdraw') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-5 h-5 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                            </svg>
                            Withdraw Request
                        </a>
                    </li>
                </ol>
            </nav>
            <h2 class="text-2xl font-semibold capitalize">Withdraw Request</h2>
        </div>


        <!-- Table to display works -->
        <div class="overflow-x-auto relative">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Amount</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($withDrawRequests as $withDrawRequest)
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4">{{ $withDrawRequest->id }}</td>
                            <td class="px-6 py-4">
                                {{ $withDrawRequest->user->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $withDrawRequest->amount }}
                            </td>
                            <td class="px-6 py-4">
                                pending
                            </td>
                            <td class="px-6 py-4 flex space-x-4">
                                <a href="{{route('admin.withdraw.user', ['user'=>$withDrawRequest->user->id])}}" class="text-indigo-600 hover:underline">View</a>
                            </td>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>



    <!-- Pagination (if necessary) -->
    {{ $withDrawRequests->links() }}

@endsection
