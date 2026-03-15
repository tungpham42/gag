@extends('layouts.app')

@section('title', 'Share a Meme - SOFT Gag')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white/80 dark:bg-[#1C1926]/80 backdrop-blur-xl rounded-[3rem] border border-orange-100/50 dark:border-white/5 overflow-hidden shadow-2xl shadow-orange-900/5 dark:shadow-black/10 p-8 sm:p-10">

        <div class="mb-8 text-center">
            <div class="w-16 h-16 bg-gradient-to-tr from-orange-300 to-rose-300 rounded-[2rem] mx-auto flex items-center justify-center mb-4 shadow-lg shadow-orange-500/20 text-white">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            </div>
            <h1 class="text-3xl font-black text-[#4A3728] dark:text-white">Share a Smile</h1>
            <p class="text-[#8C7A6B] dark:text-gray-400 mt-2 font-medium">Upload your best meme and spread the joy.</p>
        </div>

        <div class="mb-10 relative group">
            <div class="absolute -inset-1 bg-gradient-to-r from-orange-400 to-rose-400 rounded-[2rem] blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
            <div class="relative flex flex-col sm:flex-row items-center justify-between gap-4 p-5 bg-white dark:bg-[#121016] rounded-[1.8rem] border border-orange-100 dark:border-white/5">
                <div class="flex items-center gap-4 text-center sm:text-left">
                    <div class="hidden sm:flex w-12 h-12 shrink-0 bg-orange-50 dark:bg-orange-500/10 rounded-2xl items-center justify-center text-orange-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-[#4A3728] dark:text-white">Need to create a meme?</h4>
                        <p class="text-[11px] text-[#8C7A6B] dark:text-gray-500 font-medium">Use our online editor to make something funny.</p>
                    </div>
                </div>
                <a href="https://meme.soft.io.vn" target="_blank"
                   class="shrink-0 w-full sm:w-auto px-6 py-2.5 bg-orange-400 hover:bg-orange-500 text-white text-xs font-black uppercase tracking-widest rounded-full transition-all text-center">
                    Launch Editor
                </a>
            </div>
        </div>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-black text-[#8C7A6B] dark:text-gray-400 uppercase tracking-widest mb-2 ml-2">Title</label>
                <input type="text" name="title" required
                    class="w-full px-6 py-4 rounded-[1.5rem] bg-orange-50/50 dark:bg-white/5 border-2 border-transparent focus:border-orange-200 dark:focus:border-orange-500/50 focus:ring-4 focus:ring-orange-500/10 text-[#4A3728] dark:text-white transition-all font-medium placeholder:text-[#A69689]"
                    placeholder="Enter a funny title...">
                @error('title') <p class="text-rose-500 text-xs mt-2 ml-2 font-bold">{{ $message }}</p> @enderror
            </div>

            <div x-data="{
                open: false,
                selectedId: '{{ old('category_id') }}',
                selectedName: '{{ old('category_id') ? $categories->firstWhere('id', old('category_id'))->name : 'Select a vibe...' }}'
            }" class="relative">
                <label class="block text-xs font-black text-[#8C7A6B] dark:text-gray-400 uppercase tracking-widest mb-2 ml-2">Category</label>

                <input type="hidden" name="category_id" :value="selectedId" required>

                <button type="button" @click="open = !open"
                    :class="{ 'border-orange-200 dark:border-orange-500/50 ring-4 ring-orange-500/10': open }"
                    class="w-full flex items-center justify-between px-6 py-4 rounded-[1.5rem] bg-orange-50/50 dark:bg-white/5 border-2 border-transparent text-[#4A3728] dark:text-white transition-all font-medium text-left">
                    <span x-text="selectedName" :class="selectedId ? 'opacity-100' : 'opacity-50'"></span>
                    <svg class="w-5 h-5 text-orange-400 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                    @click.away="open = false"
                    class="absolute z-50 w-full mt-2 bg-white/90 dark:bg-[#1C1926]/90 backdrop-blur-2xl rounded-[1.5rem] border border-orange-100/50 dark:border-white/10 shadow-2xl shadow-orange-900/10 dark:shadow-black/40 overflow-hidden p-2">

                    <div class="max-h-60 overflow-y-auto custom-scrollbar">
                        @foreach($categories as $category)
                        <button type="button"
                            @click="selectedId = '{{ $category->id }}'; selectedName = '{{ $category->name }}'; open = false"
                            class="w-full flex items-center px-4 py-3 rounded-xl text-sm font-bold transition-all hover:bg-orange-50 dark:hover:bg-white/5"
                            :class="selectedId == '{{ $category->id }}' ? 'text-orange-500 bg-orange-50/50 dark:bg-orange-500/10' : 'text-[#4A3728] dark:text-gray-300'">

                            <span class="flex-1">{{ $category->name }}</span>

                            <svg x-show="selectedId == '{{ $category->id }}'" class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        @endforeach
                    </div>
                </div>

                @error('category_id') <p class="text-rose-500 text-xs mt-2 ml-2 font-bold">{{ $message }}</p> @enderror
            </div>

            <div x-data="{ fileName: '' }">
                <label class="block text-xs font-black text-[#8C7A6B] dark:text-gray-400 uppercase tracking-widest mb-2 ml-2">Media (Image/Video)</label>
                <div class="relative">
                    <input type="file" name="file" id="file" @change="fileName = $event.target.files[0].name" required
                        class="hidden">
                    <label for="file"
                        class="flex items-center justify-center w-full px-6 py-12 border-2 border-dashed border-orange-200 dark:border-white/10 rounded-[2rem] cursor-pointer bg-white/50 dark:bg-transparent hover:bg-orange-50 dark:hover:bg-white/[0.02] hover:border-orange-400 transition-all group">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-orange-50 dark:bg-white/5 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                                <svg class="h-8 w-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                            </div>
                            <p class="text-sm text-[#4A3728] dark:text-gray-300 font-bold" x-text="fileName ? fileName : 'Click to select or drag & drop'"></p>
                            <p class="text-[10px] text-[#8C7A6B] dark:text-gray-500 uppercase tracking-widest mt-2" x-show="!fileName">PNG, JPG, MP4 up to 10MB</p>
                        </div>
                    </label>
                </div>
                @error('file') <p class="text-rose-500 text-xs mt-2 ml-2 font-bold">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                class="w-full py-4 mt-4 bg-gradient-to-r from-orange-400 to-rose-400 text-white rounded-[1.5rem] font-black text-lg shadow-xl shadow-orange-500/20 hover:scale-[1.02] hover:shadow-2xl hover:shadow-orange-500/30 active:scale-95 transition-all">
                Publish Meme
            </button>
        </form>
    </div>
</div>
@endsection
