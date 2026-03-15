@extends('layouts.app')

@section('title', $post->title . ' - SOFT Gag')

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

        <div class="p-6 flex items-center justify-between bg-white/30 dark:bg-transparent">
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
