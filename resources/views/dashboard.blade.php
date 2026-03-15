@extends('layouts.app')

@section('title', 'Admin Management - SOFT Gag')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <style>
        /* Extra "Soft" Styling for DataTables */
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            @apply bg-white dark:bg-white/5 border border-orange-100 dark:border-white/5 rounded-[1rem] px-4 py-2 text-sm focus:ring-4 focus:ring-orange-500/10 focus:border-orange-300 transition-all font-medium outline-none;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            @apply !rounded-xl !text-[#8C7A6B] !font-bold transition-colors border-none;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            @apply !bg-gradient-to-tr !from-orange-400 !to-rose-400 !text-white !shadow-md !shadow-orange-500/20;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current) {
            @apply !bg-orange-50 dark:!bg-white/10 !text-orange-600;
        }
        table.dataTable thead th {
            @apply border-b-2 border-orange-50 dark:border-white/5 text-[#8C7A6B] dark:text-gray-400 font-black uppercase tracking-widest text-[10px] pb-4;
        }
        table.dataTable.no-footer { border-bottom: none !important; }
        .dataTables_wrapper .dataTables_info {
            @apply !text-xs !font-bold !text-[#A69689] !mt-6 uppercase tracking-widest;
        }
    </style>
@endpush

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl sm:text-4xl font-black text-[#4A3728] dark:text-white tracking-tight">Management Hub</h1>
    </div>

    <div class="bg-white/80 dark:bg-[#1C1926]/80 backdrop-blur-xl rounded-[3rem] border border-orange-100/50 dark:border-white/5 p-8 shadow-2xl shadow-orange-900/5 dark:shadow-black/10">

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
                <tr class="hover:bg-orange-50/50 dark:hover:bg-white/[0.02] transition-colors group">
                    <td class="py-4 pl-2">
                        <div class="w-14 h-14 rounded-[1rem] bg-orange-50 dark:bg-black overflow-hidden shadow-sm border border-orange-100 dark:border-white/5">
                            @if($post->media_type === 'video')
                                <video class="w-full h-full object-cover"><source src="{{ asset('storage/' . $post->media_path) }}"></video>
                            @else
                                <img src="{{ asset('storage/' . $post->media_path) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="font-bold text-[#4A3728] dark:text-white text-sm mb-1">{{ $post->title }}</div>
                        <span class="text-[9px] px-2.5 py-1 rounded-lg bg-orange-50 dark:bg-white/5 border border-orange-100 dark:border-white/10 text-orange-600 dark:text-gray-300 font-black uppercase tracking-widest">
                            {{ $post->category->name ?? 'Uncategorized' }}
                        </span>
                    </td>
                    <td class="text-sm text-[#8C7A6B] dark:text-gray-400 font-medium">
                        {{ $post->user->name }}
                    </td>
                    <td class="text-xs text-[#8C7A6B] dark:text-gray-500 font-medium">
                        {{ $post->created_at->format('M d, Y') }}
                    </td>
                    <td class="text-right pr-2">
                        <button class="bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white dark:bg-rose-500/10 dark:hover:bg-rose-500 px-4 py-2 rounded-xl font-bold text-xs transition-all shadow-sm">
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#adminPostsTable').DataTable({
                pageLength: 10,
                order: [[3, 'desc']],
                language: {
                    search: "",
                    searchPlaceholder: "Search posts...",
                    lengthMenu: "Show _MENU_",
                },
                drawCallback: function() {
                    $('.dataTables_paginate').addClass('mt-6 flex justify-end gap-2');
                }
            });
        });
    </script>
@endpush
