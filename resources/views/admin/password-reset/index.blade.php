@extends('layouts.admin')

@section('title', 'Password Reset Requests')

@section('main')
    <div class="container mx-auto px-4 py-6">
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg my-4">
                {{ session('success') }}
            </div>
        @endif
        <div class="flex flex-col md:flex-row justify-center items-center md:justify-between md:items-center mb-6">
            <nav class="flex mb-4 md:mb-0" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.withdraw') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-5 h-5 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                            </svg>
                            Password Reset
                        </a>
                    </li>
                </ol>
            </nav>
            <h2 class="text-2xl font-semibold capitalize">Password Reset Requests</h2>
        </div>

        <!-- Table to display password reset requests -->
        <div class="overflow-x-auto relative">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resetRequests as $resetRequest)
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4">{{ $resetRequest->id }}</td>
                            <td class="px-6 py-4">{{ $resetRequest->user->name }}</td>
                            <td class="px-6 py-4">{{ $resetRequest->user->email }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-block px-3 py-1 text-xs font-semibold text-white rounded-full {{ $resetRequest->password_reset === 'no' ? 'bg-gray-400' : 'bg-green-500' }}">
                                    {{ ucfirst($resetRequest->password_reset) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 flex space-x-4">
                                <a href="{{ route('admin.password.change', ['reset'=> $resetRequest->id,'user' => $resetRequest->user->id]) }}"
                                    class="text-indigo-600 hover:underline">Change</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="my-3 text-end">
            @if ($resetRequests->hasPages())
                <nav aria-label="Page navigation example">
                    <ul class="inline-flex -space-x-px text-sm">
                        {{-- Previous Page Link --}}
                        @if ($resetRequests->onFirstPage())
                            <li>
                                <span
                                    class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg cursor-not-allowed">Previous</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $resetRequests->previousPageUrl() }}"
                                    class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">Previous</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($resetRequests->links()->elements as $element)
                            @if (is_string($element))
                                <li>
                                    <span
                                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300">{{ $element }}</span>
                                </li>
                            @endif

                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    <li>
                                        <a href="{{ $url }}"
                                            class="flex items-center justify-center px-3 h-8 {{ $page === $resetRequests->currentPage() ? 'text-blue-600 bg-blue-50' : 'text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700' }} border border-gray-300">{{ $page }}</a>
                                    </li>
                                @endforeach
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($resetRequests->hasMorePages())
                            <li>
                                <a href="{{ $resetRequests->nextPageUrl() }}"
                                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700">Next</a>
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
@endsection
