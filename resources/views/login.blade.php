@extends('layouts.app')

@section('title', 'Login - SOFT Gag')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[70vh] relative">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg h-64 bg-gradient-to-r from-orange-400/20 to-rose-400/20 blur-3xl -z-10 rounded-full"></div>

    <div class="w-full max-w-md bg-white/70 dark:bg-[#1A1721]/70 backdrop-blur-3xl p-10 sm:p-12 rounded-[3.5rem] shadow-[0_20px_40px_rgb(0,0,0,0.05)] dark:shadow-[0_20px_40px_rgb(0,0,0,0.2)] border border-white/60 dark:border-white/10 text-center transition-all hover:-translate-y-1 duration-500 relative overflow-hidden group">

        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/80 dark:via-white/20 to-transparent z-10"></div>

        <div class="mb-8 inline-flex p-4 bg-white/60 dark:bg-white/5 backdrop-blur-md rounded-[2rem] shadow-sm border border-white/80 dark:border-white/10 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">
            <svg class="w-10 h-10 text-orange-400 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>

        <h1 class="text-3xl sm:text-4xl font-black mb-3 text-[#4A3728] dark:text-white tracking-tight">Welcome home!</h1>
        <p class="text-[#8C7A6B] dark:text-gray-400 mb-10 text-sm font-medium">Grab a coffee, settle in, and browse the best memes on the web.</p>

        <div class="flex justify-center hover:scale-105 transition-transform duration-300">
            <div id="google-signin-button" class="g_id_signin shadow-lg" data-type="standard" data-shape="pill" data-theme="filled_blue" data-text="continue_with" data-size="large" data-logo_alignment="left"></div>
        </div>

        <p class="mt-10 text-[10px] text-[#A69689] dark:text-gray-500 uppercase tracking-widest font-black">
            No passwords. Just one tap.
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const renderGoogleButton = setInterval(() => {
        if (typeof google !== 'undefined' && google.accounts && google.accounts.id) {
            google.accounts.id.initialize({
                client_id: '{{ config('services.google.client_id') }}',
                callback: handleCredentialResponse,
            });

            const isDark = document.documentElement.classList.contains('dark');

            google.accounts.id.renderButton(
                document.getElementById("google-signin-button"),
                {
                    theme: isDark ? 'filled_black' : 'outline',
                    size: "large",
                    shape: "pill",
                    type: "standard",
                    text: "signin_with"
                }
            );

            clearInterval(renderGoogleButton);
        }
    }, 100);

    document.getElementById('theme-toggle')?.addEventListener('click', () => {
        setTimeout(() => {
            const isDark = document.documentElement.classList.contains('dark');
            document.getElementById("google-signin-button").innerHTML = '';
            google.accounts.id.renderButton(
                document.getElementById("google-signin-button"),
                { theme: isDark ? 'filled_black' : 'outline', size: "large", shape: "pill", type: "standard" }
            );
        }, 50);
    });
</script>
@endpush
