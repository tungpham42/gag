@extends('layouts.app')

@section('title', 'Admin Management - SOFT Gag')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <style>
        /* Custom "Soft" Styling for DataTables */
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            @apply bg-orange-50/50 dark:bg-white/5 border-none rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-orange-200 transition-all;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            @apply !bg-orange-500 !border-none !text-white !rounded-xl !font-bold;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            @apply !bg-orange-100 dark:!bg-white/10 !border-none !rounded-xl !text-orange-600;
        }
        table.dataTable thead th {
            @apply border-b border-orange-50 dark:border-white/5 text-[#8C7A6B] dark:text-gray-500 font-bold uppercase tracking-widest text-[10px];
        }
        table.dataTable.no-footer { border-bottom: none !important; }
    </style>
@endpush

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-black text-[#4A3728] dark:text-white">Management Hub</h1>
    </div>

    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="bg-white dark:bg-[#1C1926] p-6 rounded-[2rem] border border-orange-50 dark:border-white/5 shadow-xl shadow-black/[0.02] text-center">
            <span class="block font-black text-4xl text-orange-500">{{ $users_count }}</span>
            <span class="text-xs text-[#8C7A6B] dark:text-gray-400 uppercase font-bold tracking-widest">Users</span>
        </div>
        </div>

    <div class="bg-white dark:bg-[#1C1926] rounded-[2rem] border border-orange-50 dark:border-white/5 p-6 shadow-xl shadow-black/[0.02]">
        <h2 class="font-bold text-lg text-[#4A3728] dark:text-white mb-6">All Posts</h2>

        <table id="adminPostsTable" class="w-full text-left">
            <thead>
                <tr>
                    <th>Media</th>
                    <th>Title & Category</th>
                    <th>Author</th>
                    <th>Created</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-orange-50 dark:divide-white/5">
                @foreach($recent_posts as $post)
                <tr class="hover:bg-orange-50/30 dark:hover:bg-white/[0.02] transition">
                    <td class="py-4">
                        <div class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-black overflow-hidden shadow-sm">
                            <img src="{{ asset('storage/' . $post->media_path) }}" class="w-full h-full object-cover">
                        </div>
                    </td>
                    <td>
                        <div class="font-semibold text-[#4A3728] dark:text-white text-sm">{{ $post->title }}</div>
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-bold">
                            {{ $post->category->name ?? 'Uncategorized' }}
                        </span>
                    </td>
                    <td class="text-sm text-[#8C7A6B] dark:text-gray-400 font-medium">
                        {{ $post->user->name }}
                    </td>
                    <td class="text-xs text-[#8C7A6B] dark:text-gray-500">
                        {{ $post->created_at->format('M d, Y') }}
                    </td>
                    <td class="text-right">
                        <button class="text-rose-500 hover:text-rose-600 font-bold text-xs">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#adminPostsTable').DataTable({
                pageLength: 10,
                order: [[3, 'desc']], // Sort by "Created" date by default
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search posts...",
                    lengthMenu: "Show _MENU_",
                },
                // Re-apply Tailwind classes on draw
                drawCallback: function() {
                    $('.dataTables_paginate').addClass('mt-4 flex justify-end gap-1');
                    $('.dataTables_info').addClass('text-xs text-[#8C7A6B] mt-4');
                }
            });
        });
    </script>
@endpush
