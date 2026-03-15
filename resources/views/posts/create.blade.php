@extends('layouts.app')

@section('title', 'Share a Meme - SOFT Gag')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white dark:bg-[#1C1926] rounded-[3rem] border border-orange-50 dark:border-white/5 overflow-hidden shadow-xl shadow-black/[0.02] p-8">

        <div class="mb-8">
            <h1 class="text-3xl font-black text-[#4A3728] dark:text-white">Share a Smile</h1>
            <p class="text-[#8C7A6B] dark:text-gray-400">Upload your best meme and spread the joy.</p>
        </div>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-[#4A3728] dark:text-gray-300 mb-2 ml-2">Title</label>
                <input type="text" name="title" required
                    class="w-full px-6 py-4 rounded-[1.5rem] bg-orange-50/50 dark:bg-white/5 border-transparent focus:border-orange-200 dark:focus:border-orange-500/30 focus:ring-0 text-[#4A3728] dark:text-white transition-all"
                    placeholder="Enter a funny title...">
                @error('title') <p class="text-rose-500 text-xs mt-1 ml-2">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-[#4A3728] dark:text-gray-300 mb-2 ml-2">Category</label>
                <select name="category_id" required
                    class="w-full px-6 py-4 rounded-[1.5rem] bg-orange-50/50 dark:bg-white/5 border-transparent focus:border-orange-200 dark:focus:border-orange-500/30 focus:ring-0 text-[#4A3728] dark:text-white appearance-none transition-all">
                    <option value="" disabled selected>Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-rose-500 text-xs mt-1 ml-2">{{ $message }}</p> @enderror
            </div>

            <div x-data="{ fileName: '' }">
                <label class="block text-sm font-bold text-[#4A3728] dark:text-gray-300 mb-2 ml-2">Media (Image/Video)</label>
                <div class="relative">
                    <input type="file" name="file" id="file" @change="fileName = $event.target.files[0].name" required
                        class="hidden">
                    <label for="file"
                        class="flex items-center justify-center w-full px-6 py-10 border-2 border-dashed border-orange-100 dark:border-white/10 rounded-[2rem] cursor-pointer hover:bg-orange-50/30 dark:hover:bg-white/[0.02] transition-all group">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-orange-300 group-hover:text-orange-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-2 text-sm text-[#8C7A6B] dark:text-gray-400 font-medium" x-text="fileName ? fileName : 'Click to select or drag & drop'"></p>
                        </div>
                    </label>
                </div>
                @error('file') <p class="text-rose-500 text-xs mt-1 ml-2">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                class="w-full py-4 bg-gradient-to-r from-orange-400 to-rose-400 text-white rounded-[1.5rem] font-black text-lg shadow-lg shadow-orange-500/20 hover:scale-[1.02] active:scale-95 transition-all">
                Publish Meme
            </button>
        </form>
    </div>
</div>
@endsection
