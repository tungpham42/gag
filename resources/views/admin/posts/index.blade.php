@extends('layouts.app')

@section('title', 'Manage Posts - SOFTGag')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-3xl font-black text-[#4A3728] dark:text-white">Meme Library</h1>
            <p class="text-[#8C7A6B] dark:text-gray-400">Total of {{ $posts->count() }} cozy captures.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-orange-500 hover:text-orange-600">
            &larr; Back to Hub
        </a>
    </div>

    <div class="bg-white dark:bg-[#1C1926] rounded-[2.5rem] border border-orange-50 dark:border-white/5 shadow-xl p-6">
        <table id="all-posts-table" class="w-full text-left">
            <thead>
                <tr class="text-xs uppercase tracking-wider text-[#8C7A6B] dark:text-gray-400 border-b border-orange-50 dark:border-white/5">
                    <th class="px-4 py-4 font-bold">Preview</th>
                    <th class="px-4 py-4 font-bold">Title & Category</th>
                    <th class="px-4 py-4 font-bold">Uploader</th>
                    <th class="px-4 py-4 font-bold">Stats</th>
                    <th class="px-4 py-4 font-bold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-orange-50 dark:divide-white/5">
                @foreach ($posts as $post)
                <tr class="hover:bg-orange-50/50 dark:hover:bg-white/[0.02] transition-colors">
                    <td class="px-4 py-3">
                        <div class="w-14 h-14 rounded-2xl overflow-hidden bg-gray-100 dark:bg-black shadow-inner">
                            @if ($post->media_type === 'video')
                                <div class="w-full h-full flex items-center justify-center bg-indigo-100 text-indigo-500">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
                                </div>
                            @else
                                <img src="{{ asset('storage/' . $post->media_path) }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="font-bold text-[#4A3728] dark:text-white truncate max-w-[180px]">{{ $post->title }}</div>
                        <span class="text-[10px] font-black uppercase text-orange-400 tracking-tighter">
                            {{ $post->category->name ?? 'Unsorted' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <img src="{{ $post->user->avatar }}" class="w-6 h-6 rounded-lg">
                            <span class="text-sm font-medium text-[#8C7A6B]">{{ $post->user->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="text-xs font-bold text-[#4A3728] dark:text-gray-300">
                            <span class="text-orange-500">↑ {{ $post->upvotes }}</span>
                            <span class="mx-1 text-gray-300">/</span>
                            <span class="text-rose-400">↓ {{ $post->downvotes }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="delete-post-form inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#all-posts-table').DataTable({
            responsive: true,
            language: { search: "", searchPlaceholder: "Search memes..." },
            columnDefs: [{ orderable: false, targets: [0, 4] }]
        });

        // Common Swal Styling Classes
        const swalCustomClasses = {
            popup: 'bg-white/90 dark:bg-[#1C1926]/90 backdrop-blur-2xl border border-orange-100/50 dark:border-white/5 rounded-[3rem] shadow-2xl p-6',
            title: 'text-[#4A3728] dark:text-white font-black text-2xl mt-2',
            htmlContainer: 'text-[#8C7A6B] dark:text-gray-400 mt-2 text-sm font-medium leading-relaxed',
            confirmButton: 'flex items-center justify-center bg-rose-500 hover:bg-rose-600 text-white px-6 py-3 rounded-full transition-all font-bold shadow-lg border-none mx-2 mt-4',
            cancelButton: 'flex items-center justify-center bg-gray-200 dark:bg-white/10 text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-white/20 px-6 py-3 rounded-full transition-all font-bold border-none mx-2 mt-4'
        };

        // Handle Delete Post Confirmation
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
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Handle Backend Session Messages (Errors & Successes)
        @if(session('error') || session('success'))
            Swal.fire({
                icon: '{{ session('error') ? 'error' : 'success' }}',
                title: '{{ session('error') ? 'Oops!' : 'Success!' }}',
                text: '{{ session('error') ?? session('success') }}',
                buttonsStyling: false,
                customClass: {
                    ...swalCustomClasses,
                    confirmButton: 'flex items-center justify-center bg-orange-400 hover:bg-orange-500 text-white px-6 py-3 rounded-full transition-all font-bold shadow-lg border-none mx-2 mt-4'
                }
            });
        @endif
    });
</script>
@endpush
@endsection
