@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        @forelse ($posts as $post)
            @include('components.post-card', ['post' => $post])
        @empty
            <div class="text-center py-12 bg-white dark:bg-[#121212] rounded-md border border-gray-200 dark:border-gray-800">
                <h3 class="text-xl font-bold mb-2">No posts yet</h3>
                <p class="text-gray-500 dark:text-gray-400">Be the first to upload something funny!</p>
            </div>
        @endforelse

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
