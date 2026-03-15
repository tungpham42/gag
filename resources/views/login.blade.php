@extends('layouts.app')

@section('title', 'Login - SOFT Gag')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[70vh]">
    <div class="w-full max-w-md bg-white/90 dark:bg-[#1C1926]/90 backdrop-blur-2xl p-10 sm:p-12 rounded-[3.5rem] shadow-2xl shadow-orange-900/10 dark:shadow-black/20 border border-orange-100/50 dark:border-white/5 text-center transition-all hover:-translate-y-1">

        <div class="mb-8 inline-flex p-4 bg-orange-50 dark:bg-white/5 rounded-[2rem] shadow-inner border border-orange-100/50 dark:border-white/5">
            <svg class="w-10 h-10 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>

        <h1 class="text-3xl font-black mb-3 text-[#4A3728] dark:text-white leading-tight">Welcome home!</h1>
        <p class="text-[#8C7A6B] dark:text-gray-400 mb-10 text-sm font-medium">Grab a coffee, settle in, and browse the best memes on the web.</p>

        <div class="flex justify-center transform hover:scale-105 transition-transform bg-white dark:bg-white/5 p-2 rounded-full border border-orange-50 dark:border-white/5 shadow-sm">
            <div class="g_id_signin" data-type="standard" data-shape="pill" data-theme="filled_blue" data-text="continue_with" data-size="large" data-logo_alignment="left"></div>
        </div>

        <p class="mt-10 text-[10px] text-[#A69689] dark:text-gray-500 uppercase tracking-widest font-black">
            No passwords. Just one tap.
        </p>
    </div>
</div>
@endsection
