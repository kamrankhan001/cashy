@extends('layouts.admin')

@section('title', 'Manage Work')

@section('main')

    <div class="container mx-auto px-4 py-6">
        <div class="flex flex-col md:flex-row justify-center items-center md:justify-between md:items-center mb-6">
            <nav class="flex mb-4 md:mb-0" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.works') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-5 h-5 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                            </svg>
                            Manage Work
                        </a>
                    </li>
                </ol>
            </nav>
            <h2 class="text-2xl font-semibold capitalize">Manage Work</h2>
        </div>

        <div class="flex justify-end items-center mb-6">
            <!-- Button to open modal -->
            <button data-modal-target="addWorkModal" data-modal-toggle="addWorkModal"
                class="p-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">
                Add Work
            </button>
        </div>

        <!-- Table to display works -->
        <div class="overflow-x-auto relative">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Work URL</th>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($works as $work)
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4">{{ $work->id }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ $work->url }}" class="text-blue-600 hover:underline" target="_blank">
                                    {{ $work->url }}
                                </a>
                            </td>
                            <td class="px-6 py-4 flex space-x-4">
                                <!-- Edit Button -->
                                <button data-modal-target="editWorkModal" data-modal-toggle="editWorkModal"
                                    data-work-id="{{ $work->id }}" data-work-url="{{ $work->url }}"
                                    class="text-yellow-500 hover:underline">
                                    Edit
                                </button>

                                <!-- Delete Button -->
                                <button data-modal-target="deleteConfirmModal" data-modal-toggle="deleteConfirmModal"
                                    data-work-id="{{ $work->id }}" class="text-red-600 hover:underline">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>



    <!-- Pagination (if necessary) -->
    <div class="my-3 text-end">
        @if ($works->hasPages())
            <nav aria-label="Page navigation example">
                <ul class="inline-flex -space-x-px text-sm">
                    {{-- Previous Page Link --}}
                    @if ($works->onFirstPage())
                        <li>
                            <span
                                class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg cursor-not-allowed">Previous</span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $works->previousPageUrl() }}"
                                class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($works->links()->elements as $element)
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
                                @if ($page == $works->currentPage())
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
                    @if ($works->hasMorePages())
                        <li>
                            <a href="{{ $works->nextPageUrl() }}"
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

    <!-- Add Work Modal -->
    <div id="addWorkModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto fixed inset-0 z-50 flex justify-center items-center">
        <div class="relative w-full max-w-md p-4">
            <div class="bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="flex justify-between items-start p-4 border-b">
                    <h3 class="text-xl font-semibold">Add Work</h3>
                    <button data-modal-hide="addWorkModal" class="text-gray-400 hover:text-gray-900">
                        ×
                    </button>
                </div>
                <form action="{{ route('admin.works.store') }}" method="POST">
                    @csrf
                    <div class="p-6">
                        <div class="mb-4">
                            <label for="url" class="block text-sm font-medium text-gray-700">Work URL</label>
                            <input type="text" name="url" id="url"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                        @error('url')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="p-4 border-t flex justify-end space-x-2">
                        <button type="submit"
                            class="p-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">Add
                            Work</button>
                        <button type="button" data-modal-hide="addWorkModal"
                            class="p-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-300 transition duration-200">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Work Modal -->
    <div id="editWorkModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto fixed inset-0 z-50 flex justify-center items-center">
        <div class="relative w-full max-w-md p-4">
            <div class="bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="flex justify-between items-start p-4 border-b">
                    <h3 class="text-xl font-semibold">Edit Work</h3>
                    <button data-modal-hide="editWorkModal" class="text-gray-400 hover:text-gray-900">
                        ×
                    </button>
                </div>
                <form action="{{ route('admin.works.update', ['work' => ':id']) }}" method="POST" id="editWorkForm">
                    @csrf
                    @method('PUT')
                    <div class="p-6">
                        <div class="mb-4">
                            <label for="edit-url" class="block text-sm font-medium text-gray-700">Work URL</label>
                            <input type="text" name="url" id="edit-url"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                    </div>
                    <div class="p-4 border-t flex justify-end space-x-2">
                        <button type="submit"
                            class="p-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">Update</button>
                        <button type="button" data-modal-hide="editWorkModal"
                            class="p-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-300 transition duration-200">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto fixed inset-0 z-50 flex justify-center items-center">
        <div class="relative w-full max-w-md p-4">
            <div class="bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="flex justify-between items-start p-4 border-b">
                    <h3 class="text-xl font-semibold">Delete Work</h3>
                    <button data-modal-hide="deleteConfirmModal" class="text-gray-400 hover:text-gray-900">
                        ×
                    </button>
                </div>
                <div class="p-6 text-center">
                    <h3 class="text-lg font-normal text-gray-500">Are you sure you want to delete this work?</h3>
                    <form action="{{ route('admin.works.destroy', ['work' => ':id']) }}" method="POST"
                        id="deleteWorkForm">
                        @csrf
                        @method('DELETE')
                        <div class="mt-6 flex justify-center space-x-4">
                            <button type="submit"
                                class="p-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition duration-200">Yes,
                                Delete</button>
                            <button type="button" data-modal-hide="deleteConfirmModal"
                                class="p-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-300 transition duration-200">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        // For Edit Modal
        document.querySelectorAll('[data-modal-target="editWorkModal"]').forEach(button => {
            button.addEventListener('click', () => {
                const workId = button.getAttribute('data-work-id');
                const workUrl = button.getAttribute('data-work-url');
                const form = document.getElementById('editWorkForm');
                form.action = form.action.replace(':id', workId);
                document.getElementById('edit-url').value = workUrl;
            });
        });

        // For Delete Modal
        document.querySelectorAll('[data-modal-target="deleteConfirmModal"]').forEach(button => {
            button.addEventListener('click', () => {
                const workId = button.getAttribute('data-work-id');
                const form = document.getElementById('deleteWorkForm');
                form.action = form.action.replace(':id', workId);
            });
        });
    </script>
@endsection
