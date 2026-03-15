@extends('layouts.app')

@section('content')
    <div class="space-y-8">

        <div class="flex gap-3 overflow-x-auto pb-4 scrollbar-hide snap-x items-center">
            <a href="{{ route('posts.index') }}"
               class="snap-start whitespace-nowrap px-6 py-2.5 rounded-full text-sm font-bold transition-all
               {{ !isset($category)
                  ? 'bg-gradient-to-r from-orange-400 to-rose-400 text-white shadow-lg shadow-orange-500/20 hover:scale-105'
                  : 'bg-white/60 dark:bg-[#1C1926]/60 text-[#8C7A6B] dark:text-[#E9DCC9] border border-orange-100/50 dark:border-white/5 hover:bg-white dark:hover:bg-white/10 hover:text-orange-500' }}">
                All Smiles
            </a>

            @foreach($categories as $cat)
                <a href="{{ route('categories.show', $cat->slug) }}"
                   class="snap-start whitespace-nowrap px-6 py-2.5 rounded-full text-sm font-bold transition-all
                   {{ isset($category) && $category->id === $cat->id
                      ? 'bg-gradient-to-r from-orange-400 to-rose-400 text-white shadow-lg shadow-orange-500/20 hover:scale-105'
                      : 'bg-white/60 dark:bg-[#1C1926]/60 text-[#8C7A6B] dark:text-[#E9DCC9] border border-orange-100/50 dark:border-white/5 hover:bg-white dark:hover:bg-white/10 hover:text-orange-500' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        <div class="space-y-8">
            @forelse ($posts as $post)
                @include('components.post-card', ['post' => $post])
            @empty
                <div class="flex flex-col items-center justify-center text-center py-16 bg-white dark:bg-[#1C1926] rounded-[3rem] border border-orange-100 dark:border-white/5 shadow-2xl shadow-orange-900/5 dark:shadow-black/10">
                    <div class="w-20 h-20 bg-orange-50 dark:bg-white/5 rounded-[2rem] flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-[#4A3728] dark:text-white mb-2">It's quiet in here...</h3>
                    <p class="text-sm font-medium text-[#8C7A6B] dark:text-gray-400 mb-6 max-w-xs">Be the pioneer of laughter. Upload the first meme and get the party started!</p>
                    <a href="/upload" class="bg-orange-500 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-orange-500/20 hover:scale-105 transition-transform">
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
