@extends('layouts.app')

@section('title', $user->name . "'s Profile - SOFT Gag")

@section('content')
<div class="space-y-8">
    <div class="bg-white dark:bg-[#1C1926] rounded-[2.5rem] p-8 border border-orange-50 dark:border-white/5 shadow-xl shadow-black/[0.02]">
        <div class="flex flex-col items-center text-center">
            <div class="relative group">
                <div class="w-24 h-24 rounded-[2rem] overflow-hidden ring-4 ring-orange-100 dark:ring-white/10 mb-4 transition-transform group-hover:scale-105">
                    <img src="{{ $user->avatar }}" class="w-full h-full object-cover" alt="{{ $user->name }}">
                </div>
            </div>

            <h1 class="text-2xl font-black text-[#4A3728] dark:text-white">{{ $user->name }}</h1>
            <p class="text-sm text-orange-500 font-bold uppercase tracking-widest mt-1">
                {{ $user->is_admin ? 'Administrator' : 'Community Member' }}
            </p>

            <div class="flex gap-8 mt-8 border-t border-orange-50 dark:border-white/5 pt-6 w-full justify-center">
                <div>
                    <div class="text-xl font-black text-[#4A3728] dark:text-white">{{ $posts->count() }}</div>
                    <div class="text-[10px] font-bold text-[#8C7A6B] uppercase tracking-tighter">Posts</div>
                </div>
                <div class="w-px h-8 bg-orange-50 dark:bg-white/5"></div>
                <div>
                    <div class="text-xl font-black text-[#4A3728] dark:text-white">{{ $posts->sum('upvotes') }}</div>
                    <div class="text-[10px] font-bold text-[#8C7A6B] uppercase tracking-tighter">Total Upvotes</div>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-4">
        <h2 class="text-lg font-black text-[#4A3728] dark:text-white px-2">My Submissions</h2>

        <div class="grid grid-cols-1 gap-6">
            @forelse($posts as $post)
                <div class="bg-white dark:bg-[#1C1926] rounded-[2rem] overflow-hidden border border-orange-50 dark:border-white/5">
                    <div class="p-4 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-black overflow-hidden flex-shrink-0">
                            <img src="{{ asset('storage/' . $post->media_path) }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-[#4A3728] dark:text-white text-sm line-clamp-1">{{ $post->title }}</h3>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-orange-50 dark:bg-orange-500/10 text-orange-600 dark:text-orange-400 font-bold">
                                {{ $post->category->name ?? 'Uncategorized' }}
                            </span>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-black text-[#4A3728] dark:text-white">{{ $post->upvotes }} ↑</div>
                            <div class="text-[9px] text-[#8C7A6B] font-medium">{{ $post->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-orange-50/50 dark:bg-white/5 rounded-[2.5rem] border-2 border-dashed border-orange-100 dark:border-white/10">
                    <p class="text-[#8C7A6B] font-medium">You haven't posted anything yet.</p>
                    <a href="{{ route('posts.create') }}" class="text-orange-500 font-bold text-sm mt-2 inline-block">Upload your first meme →</a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
