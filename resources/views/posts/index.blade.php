@extends('layouts.app')

@section('content')
    <div class="space-y-6">

        <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide snap-x">

            <a href="{{ route('posts.index') }}"
               class="snap-start whitespace-nowrap px-5 py-2.5 rounded-2xl text-sm font-bold shadow-sm shadow-black/[0.02] transition-all
               {{ !isset($category)
                  ? 'bg-gradient-to-tr from-orange-400 to-rose-400 text-white font-black shadow-lg hover:scale-105'
                  : 'bg-white dark:bg-[#1C1926] text-[#4A3728] dark:text-[#E9DCC9] border border-orange-50 dark:border-white/5 hover:bg-orange-50 dark:hover:bg-white/10' }}">
                All
            </a>

            @foreach($categories as $cat)
                <a href="{{ route('categories.show', $cat->slug) }}"
                   class="snap-start whitespace-nowrap px-5 py-2.5 rounded-2xl text-sm font-bold shadow-sm shadow-black/[0.02] transition-all
                   {{ isset($category) && $category->id === $cat->id
                      ? 'bg-gradient-to-tr from-orange-400 to-rose-400 text-white font-black shadow-lg hover:scale-105'
                      : 'bg-white dark:bg-[#1C1926] text-[#4A3728] dark:text-[#E9DCC9] border border-orange-50 dark:border-white/5 hover:bg-orange-50 dark:hover:bg-white/10' }}">
                    {{ $cat->name }}
                </a>
            @endforeach

        </div>

        @forelse ($posts as $post)
            @include('components.post-card', ['post' => $post])
        @empty
            <div class="text-center py-12 bg-white dark:bg-[#1C1926] rounded-[2.5rem] border border-orange-50 dark:border-white/5 shadow-xl shadow-black/[0.02]">
                <h3 class="text-xl font-black text-[#4A3728] dark:text-white mb-2">No posts yet</h3>
                <p class="text-sm font-bold text-[#8C7A6B]">Be the first to upload something funny!</p>
            </div>
        @endforelse

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
