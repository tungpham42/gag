@extends('layouts.app')

@section('title', 'Manage Posts - SOFTGag')

@section('content')
<div class="space-y-6 px-4 sm:px-0">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-[#4A3728] dark:text-white text-center sm:text-left">Meme Library</h1>
            <p class="text-[#8C7A6B] dark:text-gray-400 text-sm text-center sm:text-left">Total of {{ $posts->count() }} cozy captures.</p>
        </div>
        <div class="flex justify-center">
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-orange-500 hover:text-orange-600 inline-flex items-center">
                &larr; Back to Hub
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-[#1C1926] rounded-[2rem] sm:rounded-[2.5rem] border border-orange-50 dark:border-white/5 shadow-xl p-4 sm:p-8 overflow-hidden">
        <div class="overflow-x-auto">
            <table id="all-posts-table" class="w-full text-left display nowrap">
                <thead>
                    <tr class="text-[10px] sm:text-xs uppercase tracking-widest text-[#8C7A6B] dark:text-gray-400 border-b border-orange-50 dark:border-white/5">
                        <th class="px-4 py-4 font-bold">Preview</th>
                        <th class="px-4 py-4 font-bold">Details</th>
                        <th class="px-4 py-4 font-bold">Uploader</th>
                        <th class="px-4 py-4 font-bold">Stats</th>
                        <th class="px-4 py-4 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-orange-50 dark:divide-white/5">
                    @foreach ($posts as $post)
                    <tr class="hover:bg-orange-50/50 dark:hover:bg-white/[0.02] transition-colors group">
                        <td class="px-4 py-3">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl overflow-hidden bg-gray-100 dark:bg-black shadow-inner ring-2 ring-orange-50 dark:ring-white/5">
                                @if ($post->media_type === 'video')
                                    <div class="w-full h-full flex items-center justify-center bg-indigo-100 dark:bg-indigo-500/20 text-indigo-500">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
                                    </div>
                                @else
                                    <img src="{{ asset('storage/' . $post->media_path) }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-bold text-sm sm:text-base text-[#4A3728] dark:text-white truncate max-w-[140px] sm:max-w-[200px]">{{ $post->title }}</div>
                            <span class="text-[9px] sm:text-[10px] font-black uppercase text-orange-400 tracking-tighter">
                                {{ $post->category->name ?? 'Unsorted' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <img src="{{ $post->user->avatar }}" class="w-6 h-6 rounded-lg object-cover">
                                <span class="text-xs sm:text-sm font-medium text-[#8C7A6B] dark:text-gray-400 truncate max-w-[80px] sm:max-w-none">{{ $post->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-[10px] sm:text-xs font-black whitespace-nowrap">
                                <span class="text-orange-500">↑ {{ $post->upvotes }}</span>
                                <span class="mx-0.5 text-gray-300">/</span>
                                <span class="text-rose-400">↓ {{ $post->downvotes }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('posts.show', $post) }}" target="_blank" class="p-2 text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 rounded-xl transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="delete-post-form inline m-0">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-xl transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
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
        // Initialize DataTable with responsive settings
        $('#all-posts-table').DataTable({
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
                searchPlaceholder: "Search memes...",
                paginate: {
                    previous: "←",
                    next: "→"
                }
            },
            columnDefs: [
                { orderable: false, targets: [0, 4] }
            ]
        });

        // Styling adjustments for DataTable Search and Info
        $('.dataTables_filter input').addClass('bg-orange-50 dark:bg-white/5 border-none rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-orange-200 outline-none w-full sm:w-64');
        $('.dataTables_info').addClass('text-[10px] sm:text-xs text-[#8C7A6B] font-bold uppercase tracking-wider');

        const swalCustomClasses = {
            popup: 'bg-white/90 dark:bg-[#1C1926]/90 backdrop-blur-2xl border border-orange-100/50 dark:border-white/5 rounded-[2.5rem] shadow-2xl p-6',
            title: 'text-[#4A3728] dark:text-white font-black text-2xl mt-2',
            htmlContainer: 'text-[#8C7A6B] dark:text-gray-400 mt-2 text-sm font-medium leading-relaxed',
            confirmButton: 'flex items-center justify-center bg-rose-500 hover:bg-rose-600 text-white px-8 py-3 rounded-full transition-all font-bold shadow-lg border-none mx-2 mt-4',
            cancelButton: 'flex items-center justify-center bg-gray-200 dark:bg-white/10 text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-white/20 px-8 py-3 rounded-full transition-all font-bold border-none mx-2 mt-4'
        };

        $('.delete-post-form').on('submit', function(e) {
            e.preventDefault();
            let form = this;
            Swal.fire({
                title: 'Delete this meme?',
                text: "This action cannot be undone. It will be lost forever!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
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
    /* Custom Pagination Styling matching your cozy theme */
    .dataTables_paginate .paginate_button {
        @apply px-3 py-1 mx-0.5 sm:mx-1 rounded-lg bg-orange-50 dark:bg-white/5 text-[#4A3728] dark:text-white font-bold cursor-pointer transition-all text-xs sm:text-sm;
    }
    .dataTables_paginate .paginate_button.current {
        @apply bg-orange-400 text-white shadow-md;
    }
    .dataTables_paginate .paginate_button:hover:not(.current) {
        @apply bg-orange-100 dark:bg-white/10;
    }
    .dataTables_wrapper .dataTables_paginate {
        @apply flex items-center mt-4 sm:mt-0;
    }
</style>
@endpush
@endsection
