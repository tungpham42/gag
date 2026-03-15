<article class="bg-white dark:bg-[#1C1926] border border-orange-100/50 dark:border-white/5 rounded-[2.5rem] overflow-hidden shadow-xl shadow-orange-900/5 dark:shadow-black/10 transition-all hover:-translate-y-1 hover:shadow-2xl hover:shadow-orange-900/10">

    <div class="p-5 sm:p-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            @if(isset($post->user))
                <img src="{{ $post->user->avatar }}" class="w-10 h-10 rounded-[1rem] object-cover shadow-sm ring-2 ring-orange-50 dark:ring-white/5">
            @endif
            <div>
                <h2 class="text-lg sm:text-xl font-black leading-tight">
                    <a href="{{ route('posts.show', $post) }}" class="text-[#4A3728] dark:text-white hover:text-orange-500 transition-colors">
                        {{ $post->title }}
                    </a>
                </h2>
                <div class="flex items-center gap-2 mt-1">
                    @if(isset($post->user))
                        <span class="text-xs font-bold text-[#8C7A6B] dark:text-gray-400">{{ $post->user->name }}</span>
                        <span class="text-[8px] text-orange-300">●</span>
                    @endif
                    <span class="text-[10px] text-orange-500 font-bold uppercase tracking-widest">
                        {{ $post->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full bg-orange-50/30 dark:bg-black/20 flex justify-center items-center">
        @if($post->media_type === 'video')
            <video controls loop class="max-h-[600px] w-auto max-w-full">
                <source src="{{ asset('storage/' . $post->media_path) }}" type="video/mp4">
            </video>
        @else
            <img src="{{ asset('storage/' . $post->media_path) }}" alt="{{ $post->title }}" class="max-h-[600px] w-auto max-w-full object-contain">
        @endif
    </div>

    <div class="px-5 py-4 sm:px-6 flex items-center justify-between border-t border-orange-50/50 dark:border-white/5 bg-white/50 dark:bg-transparent">

        <div class="flex items-center gap-1 bg-orange-50 dark:bg-white/5 p-1 rounded-2xl">
            <form action="{{ route('posts.upvote', $post) }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="p-2 rounded-xl hover:bg-white dark:hover:bg-white/10 text-[#4A3728] dark:text-gray-300 hover:text-orange-500 transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"></path></svg>
                </button>
            </form>

            <span class="font-black text-sm px-2 text-[#4A3728] dark:text-white">
                {{ $post->upvotes - $post->downvotes }}
            </span>

            <form action="{{ route('posts.downvote', $post) }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="p-2 rounded-xl hover:bg-white dark:hover:bg-white/10 text-[#4A3728] dark:text-gray-300 hover:text-rose-500 transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                </button>
            </form>
        </div>

        @if($post->category)
            <a href="{{ route('categories.show', $post->category->slug) }}"
            class="text-[10px] font-black text-[#8C7A6B] hover:text-orange-500 dark:text-gray-400 uppercase tracking-widest bg-white dark:bg-white/5 border border-orange-100 dark:border-white/5 px-4 py-2.5 rounded-xl transition-all hover:scale-105 hover:shadow-sm">
                {{ $post->category->name }}
            </a>
        @endif
    </div>
</article>
