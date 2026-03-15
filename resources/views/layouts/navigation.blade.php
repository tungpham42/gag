<nav class="sticky top-4 z-50 px-4 sm:px-6">
    <div class="max-w-[800px] mx-auto bg-white/70 dark:bg-[#1C1926]/70 backdrop-blur-xl border border-orange-100/50 dark:border-white/5 shadow-[0_8px_30px_rgb(120,60,20,0.05)] dark:shadow-none rounded-[2rem] px-4 sm:px-6 h-16 flex items-center justify-between transition-all">

        <a href="/" class="group flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-tr from-orange-400 to-rose-400 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-orange-500/20 group-hover:scale-105 group-hover:rotate-3 transition-all">
                <span class="font-black text-xl italic">S</span>
            </div>
            <span class="text-xl font-bold tracking-tight text-[#4A3728] dark:text-white hidden sm:block">SOFT<span class="text-orange-500 ml-1">Gag</span></span>
        </a>

        <div class="flex items-center gap-2 sm:gap-4">
            <button @click="theme = theme === 'dark' ? 'light' : 'dark'; localStorage.setItem('theme', theme)"
                    class="p-2.5 rounded-2xl bg-orange-50 dark:bg-white/5 hover:bg-orange-100 dark:hover:bg-white/10 transition-colors text-orange-500 dark:text-orange-300">
                <svg x-show="theme === 'dark'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z"></path></svg>
                <svg x-show="theme === 'light'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
            </button>

            @auth
                <a href="/upload" class="hidden sm:flex items-center justify-center bg-gradient-to-r from-[#4A3728] to-[#604938] dark:from-orange-500 dark:to-rose-500 text-white px-5 py-2.5 rounded-2xl font-bold text-sm hover:scale-105 hover:shadow-lg transition-all">
                    + Post
                </a>

                <div class="flex items-center gap-3 pl-2 sm:pl-4 border-l border-orange-100 dark:border-white/10" x-data="{ open: false }">
                    <div class="relative">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 group focus:outline-none">
                            <div class="text-right hidden md:block">
                                <div class="text-xs font-black text-[#4A3728] dark:text-white leading-none">
                                    {{ auth()->user()->name }}
                                </div>
                                <span class="text-[10px] text-orange-500 font-bold uppercase tracking-widest">Account</span>
                            </div>
                            <div class="w-10 h-10 rounded-2xl overflow-hidden ring-2 ring-orange-100 dark:ring-white/10 group-hover:ring-orange-400 transition-all shadow-sm">
                                <img src="{{ auth()->user()->avatar }}" class="w-full h-full object-cover">
                            </div>
                        </button>

                        <div x-show="open" style="display: none;"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            class="absolute right-0 mt-4 w-52 bg-white/95 dark:bg-[#1C1926]/95 backdrop-blur-xl border border-orange-100 dark:border-white/5 rounded-[1.5rem] shadow-2xl py-2 z-50">

                            @if(auth()->user()->is_admin)
                                <div class="px-5 py-2 text-[10px] font-black text-orange-400 uppercase tracking-widest border-b border-orange-50 dark:border-white/5 mb-1">
                                    Admin Tools
                                </div>
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-5 py-2.5 text-sm text-[#4A3728] dark:text-white hover:bg-orange-50 dark:hover:bg-white/5 transition-colors font-medium">
                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Management
                                </a>
                            @endif

                            <a href="/profile" class="flex items-center gap-3 px-5 py-2.5 text-sm text-[#4A3728] dark:text-white hover:bg-orange-50 dark:hover:bg-white/5 transition-colors font-medium">
                                <svg class="w-4 h-4 text-[#8C7A6B] dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                My Profile
                            </a>

                            <div class="h-px bg-orange-50 dark:bg-white/5 my-2"></div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-5 py-2.5 text-sm text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors font-bold text-left">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="font-bold text-sm bg-orange-100 dark:bg-white/10 text-orange-600 dark:text-white px-5 py-2.5 rounded-2xl hover:bg-orange-200 dark:hover:bg-white/20 transition-all">Login</a>
            @endauth
        </div>
    </div>
</nav>
