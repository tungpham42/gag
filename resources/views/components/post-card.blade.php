<article class="group bg-white/70 dark:bg-[#1A1721]/70 backdrop-blur-xl border border-white/60 dark:border-white/10 rounded-[2.5rem] overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.15)] transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_40px_rgb(234,88,12,0.1)] dark:hover:shadow-[0_20px_40px_rgb(0,0,0,0.4)] relative">

    <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/80 dark:via-white/20 to-transparent z-10"></div>

    <div class="p-6 sm:p-7 flex items-start justify-between relative z-10">
        <div class="flex items-center gap-4">
            @if(isset($post->user))
                <img src="{{ $post->user->avatar }}" class="w-12 h-12 rounded-[1.2rem] object-cover shadow-sm ring-2 ring-white/60 dark:ring-white/10 group-hover:ring-orange-300 transition-all duration-300">
            @endif
            <div>
                <h2 class="text-xl sm:text-2xl font-black leading-tight tracking-tight mb-1">
                    <a href="{{ route('posts.show', $post) }}" class="text-[#4A3728] dark:text-white hover:text-transparent hover:bg-clip-text hover:bg-gradient-to-r hover:from-orange-500 hover:to-rose-500 transition-all">
                        {{ $post->title }}
                    </a>
                </h2>
                <div class="flex items-center gap-2">
                    @if(isset($post->user))
                        <span class="text-xs font-bold text-[#8C7A6B] dark:text-gray-400">{{ $post->user->name }}</span>
                        <span class="text-[6px] text-orange-300 dark:text-white/20">●</span>
                    @endif
                    <span class="text-[10px] text-orange-500 font-bold uppercase tracking-widest bg-orange-50 dark:bg-orange-500/10 px-2 py-0.5 rounded-md border border-orange-100/50 dark:border-white/5">
                        {{ $post->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
        </div>

        <div x-data="{ shareOpen: false }" class="relative z-50 shrink-0 ml-4">
            <button @click="shareOpen = !shareOpen" @click.away="shareOpen = false" class="p-2.5 bg-white/50 dark:bg-white/5 text-[#8C7A6B] hover:text-orange-500 dark:text-gray-400 dark:hover:text-white transition-all rounded-xl hover:bg-white dark:hover:bg-white/10 shadow-sm border border-transparent hover:border-white/60 dark:hover:border-white/10 hover:scale-105 active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
            </button>

            <div x-show="shareOpen" x-transition.opacity.duration.200ms style="display: none;" class="absolute right-0 mt-2 w-48 bg-white/95 dark:bg-[#1A1721]/95 backdrop-blur-xl rounded-[1.5rem] shadow-2xl border border-white/60 dark:border-white/10 py-2 overflow-hidden">
                <div class="px-4 py-2 text-[10px] font-black text-[#8C7A6B] dark:text-gray-500 uppercase tracking-widest border-b border-orange-50 dark:border-white/5 mb-1">Share Post</div>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('posts.show', $post)) }}" target="_blank" class="flex items-center gap-3 px-4 py-2 text-sm font-bold text-[#8C7A6B] dark:text-gray-300 hover:text-[#1877F2] dark:hover:text-[#1877F2] hover:bg-orange-50 dark:hover:bg-white/5 transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg> Facebook
                </a>
                <a href="https://x.com/intent/tweet?url={{ urlencode(route('posts.show', $post)) }}&text={{ urlencode($post->title) }}" target="_blank" class="flex items-center gap-3 px-4 py-2 text-sm font-bold text-[#8C7A6B] dark:text-gray-300 hover:text-black dark:hover:text-white hover:bg-orange-50 dark:hover:bg-white/5 transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg> X (Twitter)
                </a>
                <button onclick="navigator.clipboard.writeText('{{ route('posts.show', $post) }}');" class="w-full flex items-center gap-3 px-4 py-2 text-sm font-bold text-[#8C7A6B] dark:text-gray-300 hover:text-[#E1306C] dark:hover:text-[#E1306C] hover:bg-orange-50 dark:hover:bg-white/5 transition-colors text-left">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg> Copy Link
                </button>
            </div>
        </div>
    </div>

    <div class="z-[-1] w-full bg-[#FDF8F1]/40 dark:bg-black/30 flex justify-center items-center relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-black/5 to-transparent pointer-events-none"></div>
        @if($post->media_type === 'video')
            <video controls loop class="max-h-[600px] w-auto max-w-full z-10">
                <source src="{{ asset('storage/' . $post->media_path) }}" type="video/mp4">
            </video>
        @else
            <img src="{{ asset('storage/' . $post->media_path) }}" alt="{{ $post->title }}" class="max-h-[600px] w-auto max-w-full object-contain z-10">
        @endif
    </div>

    <div class="px-6 py-5 flex flex-wrap gap-4 items-center justify-between border-t border-white/40 dark:border-white/5 bg-white/40 dark:bg-transparent">

        <div class="flex items-center gap-1 bg-white/80 dark:bg-black/20 p-1.5 rounded-[1.25rem] border border-white/60 dark:border-white/5 shadow-sm">
            <form action="{{ route('posts.upvote', $post) }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="p-2.5 rounded-xl hover:bg-orange-50 dark:hover:bg-white/10 text-[#8C7A6B] dark:text-gray-400 hover:text-orange-500 active:scale-90 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"></path></svg>
                </button>
            </form>

            <span class="font-black text-base px-3 text-[#4A3728] dark:text-white min-w-[2.5rem] text-center">
                {{ $post->upvotes - $post->downvotes }}
            </span>

            <form action="{{ route('posts.downvote', $post) }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="p-2.5 rounded-xl hover:bg-rose-50 dark:hover:bg-rose-500/10 text-[#8C7A6B] dark:text-gray-400 hover:text-rose-500 active:scale-90 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                </button>
            </form>
        </div>

        @if($post->category)
            <a href="{{ route('categories.show', $post->category->slug) }}"
            class="text-[11px] font-black text-[#8C7A6B] hover:text-orange-600 dark:text-gray-400 dark:hover:text-white uppercase tracking-widest bg-white/80 dark:bg-white/5 border border-white/60 dark:border-white/5 px-5 py-2.5 rounded-xl transition-all hover:-translate-y-0.5 hover:shadow-md">
                {{ $post->category->name }}
            </a>
        @endif
    </div>
</article>
