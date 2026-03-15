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
                                popup: 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-xl',
                                title: 'text-slate-800 dark:text-white font-bold',
                                htmlContainer: 'text-slate-500 dark:text-slate-400 mt-2 text-sm',
                                confirmButton: 'w-full justify-center flex items-center bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl transition-all font-semibold shadow-sm mt-4'
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
</body>
</html>
