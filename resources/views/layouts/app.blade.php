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

    <style>
        /* Firefox Support */
        * {
            scrollbar-width: thin;
            scrollbar-color: #FB923C transparent; /* thumb | track */
        }

        input, textarea, select, button {
            outline-color: #FB923C !important;
            border-color: rgb(249 115 22 / 0.5) !important;
        }

        .dark * {
            scrollbar-color: #4A3728 transparent;
        }

        /* Chrome, Edge, and Safari Support */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        /* Light Mode Thumb */
        ::-webkit-scrollbar-thumb {
            background-color: #fed7aa; /* orange-200 */
            border-radius: 20px;
            border: 3px solid #FDF8F1; /* matches your light bg */
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #fb923c; /* orange-400 */
        }

        /* Dark Mode Thumb */
        .dark ::-webkit-scrollbar-thumb {
            background-color: #2D2A35; /* subtle dark purple/gray */
            border: 3px solid #121016; /* matches your dark bg */
        }

        .dark ::-webkit-scrollbar-thumb:hover {
            background-color: #ea580c; /* orange-600 */
        }
    </style>

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
    @guest
        <script src="https://accounts.google.com/gsi/client" async defer></script>
        <script>
            function handleCredentialResponse(response) {
                fetch('{{ route('auth.google.verify') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ credential: response.credential })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        console.error('Login failed:', data.message);
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text: 'Could not log in. Please try again.',
                            buttonsStyling: false,
                            customClass: {
                                popup: 'bg-white/90 dark:bg-[#1C1926]/90 backdrop-blur-2xl border border-orange-100/50 dark:border-white/5 rounded-[3rem] shadow-2xl shadow-orange-900/10 dark:shadow-black/40 p-8',
                                title: 'text-[#4A3728] dark:text-white font-black text-2xl mt-4',
                                htmlContainer: 'text-[#8C7A6B] dark:text-gray-400 mt-3 text-sm font-medium leading-relaxed',
                                confirmButton: 'w-full justify-center flex items-center bg-orange-400 hover:bg-orange-500 text-white px-6 py-3 rounded-full transition-all transform hover:scale-[1.02] font-bold shadow-lg shadow-orange-500/20 mt-6 border-none'
                            }
                        });
                    }
                })
                .catch(error => console.error('Network Error:', error));
            }

            window.onload = function () {
                google.accounts.id.initialize({
                    client_id: '{{ config('services.google.client_id') }}',
                    callback: handleCredentialResponse,
                    auto_select: false,
                    cancel_on_tap_outside: true
                });
                google.accounts.id.prompt();

                const loginBtn = document.getElementById('google-login-btn');
                if(loginBtn) {
                    loginBtn.addEventListener('click', () => {
                        google.accounts.id.prompt();
                    });
                }
            }
        </script>
    @endguest
        <div x-data="{
            showTop: false,
            showBottom: true,
            update() {
                this.showTop = window.pageYOffset > 400;
                this.showBottom = (window.innerHeight + window.pageYOffset) < (document.documentElement.scrollHeight - 400);
            }
        }"
        x-init="update()"
        @scroll.window="update()"
        class="fixed bottom-6 right-6 flex flex-col gap-3 z-50">

        <button
            x-show="showTop"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-end="opacity-0 translate-y-4"
            @click="window.scrollTo({top: 0, behavior: 'smooth'})"
            class="p-3 rounded-full bg-orange-400 dark:bg-orange-600 text-white shadow-lg hover:bg-orange-500 dark:hover:bg-orange-500 transition-all active:scale-90"
            title="Back to Top">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="Wait 5 10l7-7m0 0l7 7m-7-7v18" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
            </svg>
        </button>

        <button
            x-show="showBottom"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-end="opacity-0 -translate-y-4"
            @click="window.scrollTo({top: document.documentElement.scrollHeight, behavior: 'smooth'})"
            class="p-3 rounded-full bg-white/80 dark:bg-[#1C1926]/80 backdrop-blur-md text-[#4A3728] dark:text-[#E9DCC9] border border-orange-100 dark:border-white/10 shadow-lg hover:bg-orange-50 dark:hover:bg-white/10 transition-all active:scale-90"
            title="Scroll to Bottom">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
    </div>
</body>
</html>
