@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[60vh]">
    <div class="w-full max-w-md bg-white dark:bg-[#1C1926] p-10 rounded-[3rem] shadow-2xl shadow-orange-500/5 border border-orange-50 dark:border-white/5 text-center">
        <div class="mb-6 inline-flex p-4 bg-orange-50 dark:bg-orange-500/10 rounded-3xl">
            <svg class="w-12 h-12 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h1 class="text-3xl font-black mb-3 text-[#4A3728] dark:text-white leading-tight">Welcome home!</h1>
        <p class="text-[#8C7A6B] dark:text-gray-400 mb-10 px-4">Grab a coffee, settle in, and browse the best memes on the web.</p>

        <div class="flex justify-center transform hover:scale-105 transition-transform">
            <div class="g_id_signin" data-type="standard" data-shape="pill" data-theme="filled_blue" data-text="continue_with" data-size="large" data-logo_alignment="left"></div>
        </div>

        <p class="mt-10 text-[11px] text-[#A69689] dark:text-gray-500 uppercase tracking-widest font-bold">
            No password needed. Just one tap.
        </p>
    </div>
</div>
@endsection
