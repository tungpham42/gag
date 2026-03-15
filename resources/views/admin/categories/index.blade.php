@extends('layouts.app')

@section('title', 'Manage Categories - SOFTGag')

@section('content')
<div class="space-y-6 px-4 sm:px-0">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <h1 class="text-2xl sm:text-3xl font-black text-[#4A3728] dark:text-white">Categories</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-orange-500 hover:text-orange-600 inline-flex items-center">
            &larr; Back to Hub
        </a>
    </div>

    <div class="bg-gradient-to-br from-orange-400 to-rose-400 p-[1px] rounded-[2rem] shadow-lg shadow-orange-500/10">
        <div class="bg-white dark:bg-[#1C1926] rounded-[2rem] p-5 sm:p-6">
            <h2 class="text-[10px] sm:text-xs font-black uppercase tracking-widest text-[#8C7A6B] mb-4">Create New Category</h2>
            <form action="{{ route('admin.categories.store') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                @csrf
                <input type="text" name="name" placeholder="Category Name (e.g. Wholesome)"
                       class="flex-1 bg-orange-50/50 dark:bg-white/5 border-none rounded-2xl px-5 py-3 text-[#4A3728] dark:text-white focus:ring-2 focus:ring-orange-200 outline-none transition-all" required>
                <button type="submit" class="bg-[#4A3728] dark:bg-orange-500 text-white px-8 py-3 rounded-2xl font-bold hover:scale-105 active:scale-95 transition-all whitespace-nowrap">
                    Add Category ✨
                </button>
            </form>
            @error('name') <p class="text-rose-500 text-xs mt-2 ml-4 font-bold">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="bg-white dark:bg-[#1C1926] rounded-[2rem] sm:rounded-[2.5rem] border border-orange-50 dark:border-white/5 shadow-xl p-4 sm:p-8 overflow-hidden">
        <div class="overflow-x-auto">
            <table id="categories-table" class="w-full text-left display nowrap">
                <thead>
                    <tr class="text-[10px] sm:text-xs uppercase tracking-widest text-[#8C7A6B] border-b border-orange-50 dark:border-white/5">
                        <th class="px-4 sm:px-6 py-4 font-bold">Name</th>
                        <th class="px-4 sm:px-6 py-4 font-bold">Slug</th>
                        <th class="px-4 sm:px-6 py-4 font-bold">Stats</th>
                        <th class="px-4 sm:px-6 py-4 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-orange-50 dark:divide-white/5">
                    @foreach ($categories as $category)
                    <tr class="hover:bg-orange-50/50 dark:hover:bg-white/[0.02] transition-colors group">
                        <td class="px-4 sm:px-6 py-4">
                            <span class="font-black text-sm sm:text-base text-[#4A3728] dark:text-white">{{ $category->name }}</span>
                        </td>
                        <td class="px-4 sm:px-6 py-4 text-[11px] sm:text-sm text-gray-400 font-mono">/{{ $category->slug }}</td>
                        <td class="px-4 sm:px-6 py-4">
                            <span class="inline-flex px-3 py-1 bg-indigo-50 dark:bg-indigo-500/10 text-indigo-500 rounded-full text-[10px] font-black whitespace-nowrap">
                                {{ $category->posts_count }} posts
                            </span>
                        </td>
                        <td class="px-4 sm:px-6 py-4 text-right">
                            @if($category->posts_count == 0)
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="delete-category-form inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-rose-400 hover:text-rose-600 font-bold text-[10px] sm:text-xs uppercase tracking-wider">Remove</button>
                                </form>
                            @else
                                <span class="text-[10px] text-gray-300 uppercase font-bold tracking-tight">In Use</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable with proper responsiveness
        $('#categories-table').DataTable({
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.childRowImmediate,
                    type: 'none',
                    target: ''
                }
            },
            autoWidth: false,
            dom: '<"flex flex-col sm:flex-row justify-between gap-4 mb-4"f>rt<"flex flex-col sm:flex-row justify-between items-center gap-4 mt-4"ip>',
            language: {
                search: "",
                searchPlaceholder: "Filter categories...",
                paginate: {
                    previous: "←",
                    next: "→"
                }
            }
        });

        // Styling adjustments
        $('.dataTables_filter input').addClass('bg-orange-50/50 dark:bg-white/5 border-none rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-orange-200 outline-none w-full sm:w-64');

        const swalCustomClasses = {
            popup: 'bg-white/90 dark:bg-[#1C1926]/90 backdrop-blur-2xl border border-orange-100/50 dark:border-white/5 rounded-[2.5rem] shadow-2xl p-6',
            title: 'text-[#4A3728] dark:text-white font-black text-2xl mt-2',
            htmlContainer: 'text-[#8C7A6B] dark:text-gray-400 mt-2 text-sm font-medium leading-relaxed',
            confirmButton: 'flex items-center justify-center bg-rose-500 hover:bg-rose-600 text-white px-8 py-3 rounded-full transition-all font-bold shadow-lg border-none mx-2 mt-4',
            cancelButton: 'flex items-center justify-center bg-gray-200 dark:bg-white/10 text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-white/20 px-8 py-3 rounded-full transition-all font-bold border-none mx-2 mt-4'
        };

        $('.delete-category-form').on('submit', function(e) {
            e.preventDefault();
            let form = this;
            Swal.fire({
                title: 'Delete Category?',
                text: "This category will be permanently removed. This cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: swalCustomClasses
            }).then((result) => { if (result.isConfirmed) form.submit(); });
        });

        @if(session('error') || session('success'))
            Swal.fire({
                icon: '{{ session('error') ? 'error' : 'success' }}',
                title: '{{ session('error') ? 'Oops!' : 'Success!' }}',
                text: '{{ session('error') ?? session('success') }}',
                buttonsStyling: false,
                customClass: {
                    ...swalCustomClasses,
                    confirmButton: 'flex items-center justify-center bg-orange-400 hover:bg-orange-500 text-white px-8 py-3 rounded-full transition-all font-bold shadow-lg border-none mx-2 mt-4'
                }
            });
        @endif
    });
</script>

<style>
    .dataTables_paginate .paginate_button {
        @apply px-3 py-1 mx-1 rounded-lg bg-orange-50 dark:bg-white/5 text-[#4A3728] dark:text-white font-bold cursor-pointer transition-all;
    }
    .dataTables_paginate .paginate_button.current {
        @apply bg-orange-400 text-white shadow-md;
    }
    .dataTables_paginate .paginate_button:hover:not(.current) {
        @apply bg-orange-100 dark:bg-white/10;
    }
</style>
@endpush
@endsection
