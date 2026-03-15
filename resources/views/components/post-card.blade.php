<article class="bg-white dark:bg-[#121212] border border-gray-200 dark:border-gray-800 rounded-md overflow-hidden">
    <div class="p-4">
        <h2 class="text-xl font-bold leading-snug break-words">
            {{ $post->title }}
        </h2>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            Posted {{ $post->created_at->diffForHumans() }}
        </p>
    </div>

    <div class="w-full bg-gray-100 dark:bg-[#0a0a0a] flex justify-center items-center">
        @if($post->media_type === 'video')
            <video controls loop class="max-h-[700px] w-auto max-w-full">
                <source src="{{ asset('storage/' . $post->media_path) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        @else
            <img src="{{ asset('storage/' . $post->media_path) }}" alt="{{ $post->title }}" class="max-h-[700px] w-auto max-w-full object-contain">
        @endif
    </div>

    <div class="px-4 py-3 flex items-center justify-between border-t border-gray-100 dark:border-gray-800">

        <div class="flex items-center space-x-1 border border-gray-300 dark:border-gray-700 rounded-full p-1 bg-gray-50 dark:bg-[#1a1a1a]">

            <form action="{{ route('posts.show', $post) }}/upvote" method="POST" class="m-0">
                @csrf
                <button type="submit" class="p-1.5 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-500 dark:text-gray-400 hover:text-blue-500 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"></path>
                    </svg>
                </button>
            </form>

            <span class="font-bold text-sm px-2 text-gray-700 dark:text-gray-200">
                {{ $post->upvotes - $post->downvotes }}
            </span>

            <form action="{{ route('posts.show', $post) }}/downvote" method="POST" class="m-0">
                @csrf
                <button type="submit" class="p-1.5 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-500 dark:text-gray-400 hover:text-red-500 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </form>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('posts.show', $post) }}" class="flex items-center space-x-2 text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition font-semibold text-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <span>Comments</span>
            </a>
        </div>

    </div>
</article>
