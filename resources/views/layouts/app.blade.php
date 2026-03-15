<!DOCTYPE html>
<html lang="en"
      x-data="{ theme: localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light') }"
      :class="{ 'dark': theme === 'dark' }"
      class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SOFT Gag')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="SOFT Gag - Your go-to platform for sharing memes and funny content online with ease and security." />

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.tailwindcss.css">

    @stack('styles')

    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Lexend Deca"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-HHXZSNQ65X"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag() { dataLayer.push(arguments); }
      gtag("js", new Date());
      gtag("config", "G-HHXZSNQ65X");
    </script>
</head>
<body class="transition-colors duration-500 bg-[#FDF8F1] text-[#4A3728] dark:bg-[#121016] dark:text-[#E9DCC9] font-sans antialiased selection:bg-orange-200 selection:text-orange-900">

    @guest
    <div id="g_id_onload" data-client_id="{{ config('services.google.client_id') }}" data-callback="handleCredentialResponse" data-auto_prompt="true"></div>
    @endguest

    @include('layouts.navigation')

    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-full h-full -z-10 overflow-hidden opacity-30 dark:opacity-20 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-orange-200/60 dark:bg-orange-900/40 rounded-full blur-[140px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-rose-200/50 dark:bg-rose-900/30 rounded-full blur-[140px]"></div>
    </div>

    <main class="max-w-[800px] mx-auto py-10 px-4 sm:px-6">
        @guest
            <div class="h-40 w-full max-w-7xl mx-auto mb-6 block text-center overflow-hidden">
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3585118770961536"
                    crossorigin="anonymous"></script>
                <!-- GAG_res -->
                <ins class="adsbygoogle"
                    style="display:block"
                    data-ad-client="ca-pub-3585118770961536"
                    data-ad-slot="1220526671"
                    data-ad-format="auto"
                    data-full-width-responsive="true"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        @endguest
        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.tailwindcss.js"></script>

    @stack('scripts')
    <script>
        function handleCredentialResponse(response) {
            fetch("{{ route('auth.google.verify') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ credential: response.credential })
            })
            .then(res => {
                if (res.ok) {
                    // Force a redirect to the home page on successful authentication
                    window.location.href = "/";
                } else {
                    console.error("Google authentication failed on the server.");
                }
            })
            .catch(error => {
                console.error('Error during Google authentication request:', error);
            });
        }
    </script>
    @guest
        <script>
            window.addEventListener('load', function() {
                // Wait a couple of seconds to give AdSense time to load naturally
                setTimeout(function() {
                    // If window.adsbygoogle doesn't exist or hasn't been fully loaded, an ad blocker is likely active
                    const isAdBlockActive = typeof window.adsbygoogle === 'undefined' || window.adsbygoogle.loaded !== true;

                    // Additionally, check if the ad container itself was forcefully hidden by a cosmetic filter
                    const adContainer = document.querySelector('ins.adsbygoogle');
                    const isHidden = adContainer && window.getComputedStyle(adContainer).display === 'none';

                    if (isAdBlockActive || isHidden) {
                        Swal.fire({
                            title: 'Ad Blocker Detected 🛑',
                            html: `
                                It looks like you are using an ad blocker.<br><br>
                                Ads help keep <strong>SOFT Gag</strong> running and free for everyone.
                                Please consider whitelisting our site or
                                <a href="/login" class="font-bold text-orange-500 hover:text-orange-600 dark:text-orange-400 dark:hover:text-orange-300">
                                    login with an account
                                </a>!<br><br>
                                Thank you for your support!
                            `,
                            icon: 'warning',
                            confirmButtonText: 'I Understand',
                            allowOutsideClick: false,
                            buttonsStyling: false,
                            customClass: {
                                popup: `
                                    bg-white dark:bg-[#1C1926]
                                    border border-orange-100 dark:border-white/5
                                    rounded-[1.5rem]
                                    shadow-[0_20px_60px_rgba(120,60,20,0.15)]
                                    dark:shadow-none
                                `,
                                title: `
                                    text-[#4A3728] dark:text-white
                                    font-black text-xl tracking-tight
                                `,
                                htmlContainer: `
                                    text-[#8C7A6B] dark:text-gray-400
                                    mt-2 text-sm leading-relaxed
                                `,
                                confirmButton: `
                                    w-full flex items-center justify-center
                                    bg-gradient-to-r from-orange-500 to-rose-500
                                    hover:scale-105 hover:shadow-lg
                                    text-white px-5 py-2.5
                                    rounded-2xl font-bold text-sm
                                    transition-all mt-4
                                `
                            }
                        });
                    }
                }, 2000); // 2000ms delay prevents false positives on slow connections
            });
        </script>
    @endguest
</body>
</html>
