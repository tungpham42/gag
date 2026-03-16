@extends('layouts.app')

@section('content')
    <div class="space-y-8">

        <div class="flex gap-3 overflow-x-auto pb-4 scrollbar-hide snap-x items-center">
            <a href="{{ route('posts.index') }}"
               class="snap-start whitespace-nowrap px-6 py-2.5 rounded-full text-sm font-black transition-all duration-300
               {{ !isset($category)
                  ? 'bg-gradient-to-r from-orange-400 to-rose-400 text-white shadow-lg shadow-orange-500/20 scale-105 ring-2 ring-white/50 dark:ring-white/10'
                  : 'bg-white/60 dark:bg-white/5 backdrop-blur-md text-[#8C7A6B] dark:text-gray-400 border border-white/60 dark:border-white/5 hover:bg-white dark:hover:bg-white/10 hover:text-orange-500 dark:hover:text-white hover:-translate-y-0.5 shadow-sm' }}">
                All Smiles
            </a>

            @foreach($categories as $cat)
                <a href="{{ route('categories.show', $cat->slug) }}"
                   class="snap-start whitespace-nowrap px-6 py-2.5 rounded-full text-sm font-black transition-all duration-300
                   {{ isset($category) && $category->id === $cat->id
                      ? 'bg-gradient-to-r from-orange-400 to-rose-400 text-white shadow-lg shadow-orange-500/20 scale-105 ring-2 ring-white/50 dark:ring-white/10'
                      : 'bg-white/60 dark:bg-white/5 backdrop-blur-md text-[#8C7A6B] dark:text-gray-400 border border-white/60 dark:border-white/5 hover:bg-white dark:hover:bg-white/10 hover:text-orange-500 dark:hover:text-white hover:-translate-y-0.5 shadow-sm' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        <div class="space-y-8">
            @forelse ($posts as $post)
                @include('components.post-card', ['post' => $post])
            @empty
                <div class="flex flex-col items-center justify-center text-center py-20 bg-white/60 dark:bg-[#1A1721]/60 backdrop-blur-2xl rounded-[3rem] border border-white/60 dark:border-white/10 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                    <div class="w-24 h-24 bg-gradient-to-tr from-orange-100 to-rose-100 dark:from-orange-500/20 dark:to-rose-500/20 rounded-[2.5rem] flex items-center justify-center mb-6 shadow-inner border border-white/50 dark:border-white/5 animate-bounce">
                        <svg class="w-12 h-12 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-3xl font-black text-[#4A3728] dark:text-white tracking-tight mb-3">It's quiet in here...</h3>
                    <p class="text-sm font-medium text-[#8C7A6B] dark:text-gray-400 mb-8 max-w-sm">Be the pioneer of laughter. Upload the first meme and get the party started!</p>
                    <a href="/upload" class="bg-gradient-to-r from-orange-400 to-rose-400 text-white px-8 py-4 rounded-2xl font-black shadow-xl shadow-orange-500/20 hover:scale-105 active:scale-95 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                        Share a Meme
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
