@extends('layouts.app')

@section('title', $post->title . ' - SOFT Gag')

@section('content')
<div class="space-y-6">
    <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-[#8C7A6B] hover:text-orange-500 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Feed
    </a>

    <article class="bg-white dark:bg-[#1C1926] rounded-[2.5rem] overflow-hidden border border-orange-50 dark:border-white/5 shadow-xl shadow-black/[0.02]">
        <div class="p-6 md:p-8">
            <div class="flex items-center gap-3 mb-4">
                <img src="{{ $post->user->avatar }}" class="w-8 h-8 rounded-lg object-cover">
                <div>
                    <div class="text-xs font-black text-[#4A3728] dark:text-white leading-none">{{ $post->user->name }}</div>
                    <div class="text-[10px] text-orange-500 font-bold uppercase tracking-tighter">{{ $post->created_at->diffForHumans() }}</div>
                </div>
            </div>
            <h1 class="text-2xl md:text-3xl font-black text-[#4A3728] dark:text-white leading-tight">
                {{ $post->title }}
            </h1>
        </div>

        <div class="bg-orange-50/30 dark:bg-black/20 w-full flex justify-center">
            @if($post->media_type === 'video')
                <video controls autoplay loop class="w-full max-h-[800px] object-contain">
                    <source src="{{ asset('storage/' . $post->media_path) }}" type="video/mp4">
                </video>
            @else
                <img src="{{ asset('storage/' . $post->media_path) }}" class="w-full max-h-[800px] object-contain">
            @endif
        </div>

        <div class="p-6 flex items-center justify-between border-t border-orange-50 dark:border-white/5">
            <div class="flex items-center gap-1 bg-orange-50/50 dark:bg-white/5 p-1.5 rounded-2xl">
                <form action="{{ route('posts.upvote', $post) }}" method="POST">
                    @csrf
                    <button class="p-2 rounded-xl hover:bg-white dark:hover:bg-white/10 text-[#4A3728] dark:text-white transition shadow-sm">
                        ↑
                    </button>
                </form>
                <span class="px-3 font-black text-sm">{{ $post->upvotes - $post->downvotes }}</span>
                <form action="{{ route('posts.downvote', $post) }}" method="POST">
                    @csrf
                    <button class="p-2 rounded-xl hover:bg-white dark:hover:bg-white/10 text-[#4A3728] dark:text-white transition shadow-sm">
                        ↓
                    </button>
                </form>
            </div>

            <div class="text-[11px] font-bold text-[#8C7A6B] uppercase tracking-widest bg-orange-50 dark:bg-white/5 px-4 py-2 rounded-xl">
                {{ $post->category->name ?? 'General' }}
            </div>
        </div>
    </article>
</div>
@endsection
