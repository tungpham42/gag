@extends('layouts.app')

@section('title', 'Admin Hub')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="text-center py-4">
        <h1 class="text-3xl font-black text-[#4A3728] dark:text-white">Admin Hub</h1>
        <p class="text-sm text-[#8C7A6B] dark:text-gray-400">Select a segment to manage your community.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @php
            $segments = [
                [
                    'label' => 'Users',
                    'count' => $users_count,
                    'color' => 'orange',
                    'route' => 'admin.users.index',
                    'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197'
                ],
                [
                    'label' => 'Posts',
                    'count' => $posts_count,
                    'color' => 'rose',
                    'route' => 'admin.posts.index',
                    'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'
                ],
                [
                    'label' => 'Categories',
                    'count' => $categories_count,
                    'color' => 'indigo',
                    'route' => 'admin.categories.index',
                    'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'
                ]
            ];
        @endphp

        @foreach($segments as $segment)
        <a href="{{ route($segment['route']) }}" class="group relative bg-white dark:bg-[#1C1926] p-8 rounded-[2rem] border border-orange-50 dark:border-white/5 shadow-sm hover:shadow-xl hover:scale-[1.02] transition-all duration-300 text-center">
            <div class="absolute top-4 right-6 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-12 h-12 text-{{ $segment['color'] }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $segment['icon'] }}"></path>
                </svg>
            </div>

            <span class="block font-black text-5xl text-{{ $segment['color'] }}-500 mb-2">
                {{ $segment['count'] }}
            </span>
            <span class="text-xs text-[#8C7A6B] dark:text-gray-500 uppercase font-black tracking-[0.2em] group-hover:text-{{ $segment['color'] }}-600 transition-colors">
                {{ $segment['label'] }}
            </span>

            <div class="mt-4 flex justify-center">
                <span class="text-[10px] font-bold py-1 px-3 rounded-full bg-{{ $segment['color'] }}-50 dark:bg-{{ $segment['color'] }}-500/10 text-{{ $segment['color'] }}-600 dark:text-{{ $segment['color'] }}-400 opacity-0 group-hover:opacity-100 transition-opacity">
                    Manage →
                </span>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection
