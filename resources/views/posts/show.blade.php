@extends('layouts.app')

@section('title', $post->title . ' - SOFT Gag')

@section('og_image', asset('storage/' . $post->media_path))

@section('content')
<div class="space-y-6">
    <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-[#8C7A6B] hover:text-orange-500 transition-colors group bg-white/50 dark:bg-white/5 px-4 py-2 rounded-xl border border-orange-100/50 dark:border-white/5">
        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Feed
    </a>

    <article class="bg-white dark:bg-[#1C1926] rounded-[2.5rem] overflow-hidden border border-orange-100/50 dark:border-white/5 shadow-2xl shadow-orange-900/5 dark:shadow-black/10">
        <div class="p-6 md:p-8">
            <div class="flex items-center gap-4 mb-6">
                <img src="{{ $post->user->avatar }}" class="w-12 h-12 rounded-2xl object-cover ring-4 ring-orange-50 dark:ring-white/5">
                <div>
                    <div class="text-sm font-black text-[#4A3728] dark:text-white leading-none mb-1">{{ $post->user->name }}</div>
                    <div class="text-[10px] text-orange-500 font-bold uppercase tracking-widest">{{ $post->created_at->format('F j, Y \a\t g:i A') }}</div>
                </div>
            </div>
            <h1 class="text-2xl md:text-4xl font-black text-[#4A3728] dark:text-white leading-tight">
                {{ $post->title }}
            </h1>
        </div>

        <div class="bg-orange-50/40 dark:bg-black/30 w-full flex justify-center py-4 border-y border-orange-50 dark:border-white/5">
            @if($post->media_type === 'video')
                <video controls autoplay loop class="w-full max-h-[800px] object-contain rounded-xl shadow-inner">
                    <source src="{{ asset('storage/' . $post->media_path) }}" type="video/mp4">
                </video>
            @else
                <img src="{{ asset('storage/' . $post->media_path) }}" class="w-full max-h-[800px] object-contain">
            @endif
        </div>

        <div class="p-6 flex flex-wrap items-center justify-between gap-4 bg-white/30 dark:bg-transparent">

            <div class="flex flex-wrap items-center gap-4 md:gap-6">
                <div class="flex items-center gap-1 bg-orange-50 dark:bg-white/5 p-1 rounded-2xl">
                    <form action="{{ route('posts.upvote', $post) }}" method="POST" class="m-0">
                        @csrf
                        <button class="p-2.5 rounded-xl hover:bg-white dark:hover:bg-white/10 text-[#4A3728] dark:text-gray-300 hover:text-orange-500 transition-all shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"></path></svg>
                        </button>
                    </form>
                    <span class="px-3 font-black text-lg text-[#4A3728] dark:text-white">{{ $post->upvotes - $post->downvotes }}</span>
                    <form action="{{ route('posts.downvote', $post) }}" method="POST" class="m-0">
                        @csrf
                        <button class="p-2.5 rounded-xl hover:bg-white dark:hover:bg-white/10 text-[#4A3728] dark:text-gray-300 hover:text-rose-500 transition-all shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                    </form>
                </div>

                <div class="flex items-center gap-2">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('posts.show', $post)) }}" target="_blank" class="p-2.5 text-[#8C7A6B] hover:text-[#1877F2] dark:text-gray-400 dark:hover:text-[#1877F2] bg-white dark:bg-white/5 border border-orange-100 dark:border-white/5 rounded-xl transition-all hover:scale-110 hover:shadow-sm" title="Share on Facebook">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                    </a>
                    <a href="https://x.com/intent/tweet?url={{ urlencode(route('posts.show', $post)) }}&text={{ urlencode($post->title) }}" target="_blank" class="p-2.5 text-[#8C7A6B] hover:text-black dark:text-gray-400 dark:hover:text-white bg-white dark:bg-white/5 border border-orange-100 dark:border-white/5 rounded-xl transition-all hover:scale-110 hover:shadow-sm" title="Share on X">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('posts.show', $post)) }}&title={{ urlencode($post->title) }}" target="_blank" class="p-2.5 text-[#8C7A6B] hover:text-[#0A66C2] dark:text-gray-400 dark:hover:text-[#0A66C2] bg-white dark:bg-white/5 border border-orange-100 dark:border-white/5 rounded-xl transition-all hover:scale-110 hover:shadow-sm" title="Share on LinkedIn">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </a>
                    <a href="https://reddit.com/submit?url={{ urlencode(route('posts.show', $post)) }}&title={{ urlencode($post->title) }}" target="_blank" class="p-2.5 text-[#8C7A6B] hover:text-[#FF4500] dark:text-gray-400 dark:hover:text-[#FF4500] bg-white dark:bg-white/5 border border-orange-100 dark:border-white/5 rounded-xl transition-all hover:scale-110 hover:shadow-sm" title="Share on Reddit">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 11.5c0-1.65-1.35-3-3-3-.96 0-1.86.48-2.42 1.24-1.64-1-3.75-1.64-6.07-1.72.08-1.1.4-3.05 1.52-3.7.72-.4 1.73-.24 3 .5C17.2 6.3 18.46 7.5 20 7.5c1.65 0 3-1.35 3-3s-1.35-3-3-3c-1.38 0-2.54.94-2.88 2.22-1.43-.72-2.64-.8-3.6-.25-1.64.94-1.95 3.47-2 4.55-2.33.08-4.45.7-6.1 1.72C4.86 8.98 3.96 8.5 3 8.5c-1.65 0-3 1.35-3 3 0 1.32.84 2.44 2.05 2.84-.03.22-.05.44-.05.66 0 3.86 4.5 7 10 7s10-3.14 10-7c0-.22-.02-.44-.05-.66 1.2-.4 2.05-1.54 2.05-2.84zM2.3 11.5c0-.94.76-1.7 1.7-1.7.67 0 1.27.38 1.54.96-1.34.62-2.5 1.48-3.18 2.4-.04-.54-.06-1.1-.06-1.66zm19.4 1.66c-.68-.92-1.84-1.78-3.18-2.4.27-.58.87-.96 1.54-.96.94 0 1.7.76 1.7 1.7 0 .56-.02 1.12-.06 1.66zM12 21.5c-4.4 0-8-2.7-8-6s3.6-6 8-6 8 2.7 8 6-3.6 6-8 6zm-3.5-6.5c-.83 0-1.5-.67-1.5-1.5S7.67 12 8.5 12s1.5.67 1.5 1.5S9.33 15 8.5 15zm7 0c-.83 0-1.5-.67-1.5-1.5S14.67 12 15.5 12s1.5.67 1.5 1.5S16.33 15 15.5 15zm-8.8 1.7c.33-1 2.33-1.8 5.3-1.8s4.97.8 5.3 1.8h-10.6z"/></svg>
                    </a>
                    <button onclick="navigator.clipboard.writeText('{{ route('posts.show', $post) }}');" class="p-2.5 text-[#8C7A6B] hover:text-[#E1306C] dark:text-gray-400 dark:hover:text-[#E1306C] bg-white dark:bg-white/5 border border-orange-100 dark:border-white/5 rounded-xl transition-all hover:scale-110 hover:shadow-sm" title="Copy Link for Instagram">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </button>
                </div>
            </div>

            @if($post->category)
                <a href="{{ route('categories.show', $post->category->slug) }}"
                class="text-[11px] font-black text-[#8C7A6B] hover:text-orange-500 dark:text-gray-400 uppercase tracking-widest bg-white dark:bg-white/5 border border-orange-100 dark:border-white/5 px-5 py-3 rounded-xl transition-all hover:scale-105 hover:shadow-sm">
                    {{ $post->category->name }}
                </a>
            @endif
        </div>
    </article>
</div>
@endsection
