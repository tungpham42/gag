@extends('layouts.app')

@section('title', $post->title . ' - SOFT Gag')

@section('og_image', asset('storage/' . $post->media_path))

@section('content')
<div class="space-y-6">
    <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-2 text-sm font-black text-[#8C7A6B] dark:text-gray-400 hover:text-orange-500 dark:hover:text-white transition-all group bg-white/60 dark:bg-[#1A1721]/60 backdrop-blur-md px-5 py-2.5 rounded-2xl border border-white/60 dark:border-white/10 shadow-sm hover:shadow-md hover:-translate-x-1">
        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Feed
    </a>

    <article class="bg-white/70 dark:bg-[#1A1721]/70 backdrop-blur-2xl rounded-[3rem] overflow-hidden border border-white/60 dark:border-white/10 shadow-[0_20px_50px_rgb(0,0,0,0.05)] dark:shadow-[0_20px_50px_rgb(0,0,0,0.2)] relative">
        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/80 dark:via-white/20 to-transparent z-10"></div>

        <div class="p-8 md:p-10 relative z-10">
            <div class="flex items-start justify-between mb-8">
                <div class="flex items-center gap-5">
                    <img src="{{ $post->user->avatar }}" class="w-14 h-14 rounded-2xl object-cover ring-4 ring-white/60 dark:ring-white/10 shadow-sm">
                    <div>
                        <div class="text-base font-black text-[#4A3728] dark:text-white leading-none mb-1.5">{{ $post->user->name }}</div>
                        <div class="text-[10px] text-orange-500 font-bold uppercase tracking-widest bg-orange-50 dark:bg-orange-500/10 px-2 py-1 rounded-md inline-block border border-orange-100/50 dark:border-white/5">{{ $post->created_at->format('F j, Y \a\t g:i A') }}</div>
                    </div>
                </div>

                <div x-data="{ shareOpen: false }" class="relative z-50">
                    <button @click="shareOpen = !shareOpen" @click.away="shareOpen = false" class="p-3 bg-white/50 dark:bg-white/5 text-[#8C7A6B] hover:text-orange-500 dark:text-gray-400 dark:hover:text-white transition-all rounded-2xl hover:bg-white dark:hover:bg-white/10 shadow-sm border border-transparent hover:border-white/60 dark:hover:border-white/10 hover:scale-105 active:scale-95">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                    </button>

                    <div x-show="shareOpen" x-transition.opacity.duration.200ms style="display: none;" class="absolute right-0 mt-2 w-48 bg-white/95 dark:bg-[#1A1721]/95 backdrop-blur-xl rounded-[1.5rem] shadow-2xl border border-white/60 dark:border-white/10 py-2 overflow-hidden">
                        <div class="px-4 py-2 text-[10px] font-black text-[#8C7A6B] dark:text-gray-500 uppercase tracking-widest border-b border-orange-50 dark:border-white/5 mb-1">Share Post</div>
                        <button onclick="navigator.clipboard.writeText('{{ route('posts.show', $post) }}');" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-bold text-[#8C7A6B] dark:text-gray-300 hover:text-[#E1306C] dark:hover:text-[#E1306C] hover:bg-orange-50 dark:hover:bg-white/5 transition-colors text-left">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163..."></path></svg> Copy Link
                        </button>
                    </div>
                </div>
            </div>
            <h1 class="text-3xl md:text-5xl font-black text-[#4A3728] dark:text-white leading-tight tracking-tight">
                {{ $post->title }}
            </h1>
        </div>

        <div class="bg-[#FDF8F1]/40 dark:bg-black/40 w-full flex justify-center items-center py-6 border-y border-white/50 dark:border-white/5 relative">
            <div class="absolute inset-0 bg-gradient-to-b from-black/5 to-transparent pointer-events-none"></div>
            @if($post->media_type === 'video')
                <video controls autoplay loop class="w-full max-h-[800px] object-contain rounded-2xl shadow-lg z-10">
                    <source src="{{ asset('storage/' . $post->media_path) }}" type="video/mp4">
                </video>
            @else
                <img src="{{ asset('storage/' . $post->media_path) }}" class="w-full max-h-[800px] object-contain drop-shadow-md z-10">
            @endif
        </div>

        <div class="p-8 flex flex-wrap items-center justify-between gap-6 bg-white/40 dark:bg-transparent">

            <div class="flex items-center gap-1 bg-white/80 dark:bg-black/20 p-2 rounded-[1.5rem] border border-white/60 dark:border-white/5 shadow-sm">
                <form action="{{ route('posts.upvote', $post) }}" method="POST" class="m-0">
                    @csrf
                    <button class="p-3 rounded-xl hover:bg-orange-50 dark:hover:bg-white/10 text-[#8C7A6B] dark:text-gray-400 hover:text-orange-500 active:scale-90 transition-all shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"></path></svg>
                    </button>
                </form>
                <span class="px-4 font-black text-xl text-[#4A3728] dark:text-white min-w-[3rem] text-center">{{ $post->upvotes - $post->downvotes }}</span>
                <form action="{{ route('posts.downvote', $post) }}" method="POST" class="m-0">
                    @csrf
                    <button class="p-3 rounded-xl hover:bg-rose-50 dark:hover:bg-rose-500/10 text-[#8C7A6B] dark:text-gray-400 hover:text-rose-500 active:scale-90 transition-all shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </form>
            </div>

            @if($post->category)
                <a href="{{ route('categories.show', $post->category->slug) }}"
                class="text-xs font-black text-[#8C7A6B] hover:text-orange-500 dark:text-gray-400 uppercase tracking-widest bg-white/80 dark:bg-white/5 border border-white/60 dark:border-white/5 px-6 py-3.5 rounded-2xl transition-all hover:scale-105 hover:shadow-md">
                    {{ $post->category->name }}
                </a>
            @endif
        </div>
    </article>
</div>
@endsection
