@props([
    'title' => null,
    'hideHeader' => false,
    'hideFooter' => false,
])
<!DOCTYPE html>
<html lang="id" class="h-full bg-[#F8FAF9] dark:bg-[#0E1713]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="SISPERKA - Sistem Pelaporan Perundungan resmi MTs Soebono Mantofani. Ruang aman, tenang, dan rahasia bagi peserta didik untuk bercerita tanpa rasa takut.">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sekolah.png') }}">
    <title>{{ $title ?? 'SISPERKA - Sistem Pelaporan Perundungan MTs Soebono Mantofani' }}</title>

    <script>
        try {
            if (localStorage.getItem('ui-theme') === 'dark' || (!('ui-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        } catch (_) {}
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col bg-[#F8FAF9] dark:bg-[#0E1713] text-slate-800 dark:text-slate-100 font-sans antialiased selection:bg-emerald-100 selection:text-emerald-900 transition-colors duration-200">
    @unless($hideHeader)
    {{-- Header Publik (Sesuai frontend/src/app/page.tsx:673-780) --}}
    <header 
        x-data="{ isScrolled: false, mobileMenuOpen: false }"
        @scroll.window="isScrolled = (window.pageYOffset > 20)"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 border-b"
        :class="isScrolled ? 'bg-white/95 backdrop-blur-md border-slate-200 shadow-xs dark:bg-[#0B110E]/95 dark:border-slate-800' : 'bg-white/85 backdrop-blur-md border-slate-200/80 dark:bg-[#0B110E]/85 dark:border-slate-800'"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Brand Logo --}}
                <div class="flex items-center gap-3">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                        <img src="{{ asset('logo-sekolah.png') }}" 
                             alt="Logo MTs Soebono Mantofani" 
                             class="w-10 h-10 object-contain shrink-0" />
                        <div class="flex flex-col">
                            <span class="font-extrabold text-base sm:text-lg text-slate-900 dark:text-slate-100 tracking-tight leading-tight">
                                SIPERKA
                            </span>
                            <span class="text-[9px] uppercase tracking-wider text-slate-500 dark:text-slate-400 font-semibold hidden sm:inline">
                                Sistem Pelaporan Sekolah
                            </span>
                        </div>
                    </a>
                </div>

                {{-- Desktop Navigation --}}
                <nav class="hidden md:flex items-center gap-8">
                    <a href="{{ url('/#tentang') }}"
                       class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                        Tentang
                    </a>
                    <a href="{{ url('/#cara-kerja') }}"
                       class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                        Cara Kerja
                    </a>
                    <a href="{{ url('/#pengguna') }}"
                       class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                        Fitur Peran
                    </a>
                </nav>

                {{-- Right Actions --}}
                <div class="hidden md:flex items-center gap-3">
                    {{-- ThemeToggle --}}
                    <button type="button" 
                            onclick="try { const isDark = document.documentElement.classList.toggle('dark'); localStorage.setItem('ui-theme', isDark ? 'dark' : 'light'); } catch(_) {}"
                            class="w-8 h-8 flex items-center justify-center rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400 transition-colors duration-150"
                            aria-label="Mode Terang/Gelap"
                            title="Ganti Tema">
                        <svg class="w-4 h-4 hidden dark:block text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        <svg class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                    </button>

                    @auth
                        <a href="{{ url('/dashboard') }}" 
                           class="px-3 py-1.5 text-xs rounded-lg gap-1.5 h-8 font-semibold bg-primary-600 text-white hover:bg-primary-700 active:bg-primary-800 shadow-xs transition-colors inline-flex items-center justify-center">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline-flex items-center">
                            @csrf
                            <button type="submit" 
                                    class="px-3 py-1.5 text-xs rounded-lg gap-1.5 h-8 font-semibold bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-100 hover:bg-slate-200 dark:hover:bg-slate-700 active:bg-slate-300 transition-colors inline-flex items-center justify-center"
                                    title="Keluar dari Akun">
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" 
                           class="px-3 py-1.5 text-xs rounded-lg gap-1.5 h-8 font-semibold bg-primary-600 text-white hover:bg-primary-700 active:bg-primary-800 shadow-xs transition-colors inline-flex items-center justify-center">
                            Lapor Sekarang
                        </a>
                    @endauth
                </div>

                {{-- Mobile Actions --}}
                <div class="flex md:hidden items-center gap-2">
                    <button type="button" 
                            onclick="try { const isDark = document.documentElement.classList.toggle('dark'); localStorage.setItem('ui-theme', isDark ? 'dark' : 'light'); } catch(_) {}"
                            class="w-8 h-8 flex items-center justify-center rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400 transition-colors duration-150"
                            aria-label="Mode Terang/Gelap">
                        <svg class="w-4 h-4 hidden dark:block text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        <svg class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                    </button>
                    <button type="button" 
                            @click="mobileMenuOpen = !mobileMenuOpen"
                            class="p-2 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg"
                            aria-label="Toggle menu">
                        <svg x-show="!mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileMenuOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu Dropdown --}}
        <div x-show="mobileMenuOpen" 
             x-cloak
             class="md:hidden absolute top-16 left-0 right-0 bg-white dark:bg-[#101713] border-b border-slate-200 dark:border-slate-800 shadow-md p-4 flex flex-col gap-3">
            <a href="{{ url('/#tentang') }}" 
               @click="mobileMenuOpen = false"
               class="text-sm font-medium text-slate-700 dark:text-slate-200 py-2 border-b border-slate-100 dark:border-slate-800">
                Tentang
            </a>
            <a href="{{ url('/#cara-kerja') }}" 
               @click="mobileMenuOpen = false"
               class="text-sm font-medium text-slate-700 dark:text-slate-200 py-2 border-b border-slate-100 dark:border-slate-800">
                Cara Kerja
            </a>
            <a href="{{ url('/#pengguna') }}" 
               @click="mobileMenuOpen = false"
               class="text-sm font-medium text-slate-700 dark:text-slate-200 py-2 border-b border-slate-100 dark:border-slate-800">
                Fitur Peran
            </a>
            @auth
                <a href="{{ url('/dashboard') }}" 
                   @click="mobileMenuOpen = false"
                   class="w-full mt-2 inline-flex items-center justify-center px-4 py-2.5 text-sm rounded-xl font-semibold bg-primary-600 text-white hover:bg-primary-700 transition">
                    Buka Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full py-2.5 text-sm rounded-xl font-semibold text-rose-700 dark:text-rose-300 bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-900 mt-1">
                        Keluar dari Akun
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" 
                   @click="mobileMenuOpen = false"
                   class="w-full mt-2 inline-flex items-center justify-center px-4 py-2.5 text-sm rounded-xl font-semibold bg-primary-600 text-white hover:bg-primary-700 shadow-xs transition">
                    Mulai Menggunakan SIPERKA
                </a>
            @endauth
        </div>
    </header>
    @endunless

    {{-- Flash Messages Hook for SweetAlert2 --}}
    <div id="sisperka-flash-messages" class="hidden"
        @if(session('success')) data-success="{{ session('success') }}" @endif
        @if(session('error')) data-error="{{ session('error') }}" @endif
        @if(session('status')) data-status="{{ session('status') }}" @endif
        @if(session('warning')) data-warning="{{ session('warning') }}" @endif
    ></div>

    {{-- Notifikasi Flash --}}
    @if (session('status') || session('success') || session('error') || session('warning'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 w-full">
            @if (session('status') || session('success'))
                <x-alert type="success" :message="session('status') ?? session('success')" />
            @endif
            @if (session('error'))
                <x-alert type="error" :message="session('error')" />
            @endif
            @if (session('warning'))
                <x-alert type="warning" :message="session('warning')" />
            @endif
        </div>
    @endif

    {{-- Konten Utama --}}
    <main class="flex-1 w-full {{ $hideHeader ? '' : 'pt-16' }}">
        {{ $slot }}
    </main>

    {{-- Footer (Sesuai Desain frontend/src/app/page.tsx:1264-1289) --}}
    @if(!$hideFooter)
    <footer class="bg-white dark:bg-[#0B110E] py-12 border-t border-slate-200/90 dark:border-slate-800 transition-colors mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center text-center">
            <div class="mb-4">
                <img src="{{ asset('logo-sekolah.png') }}" alt="Logo MTs Soebono Mantofani" class="w-14 h-14 object-contain" />
            </div>

            <h4 class="text-lg font-extrabold text-slate-900 dark:text-white mb-1 tracking-tight">
                SIPERKA
            </h4>

            <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">
                Sistem Informasi Pelaporan Kasus Perundungan &bull; {{ \App\Models\Setting::get('school_name', 'MTs Soebono Mantofani') }}
            </p>

            <div class="w-12 h-px bg-slate-200 dark:bg-slate-800 mb-6"></div>

            <p class="text-sm font-medium text-slate-600 dark:text-slate-300 max-w-md">
                Bersama mewujudkan lingkungan sekolah yang aman, inklusif, dan saling menghargai.
            </p>

            <p class="text-xs text-slate-400 dark:text-slate-600 mt-8">
                &copy; {{ date('Y') }} SIPERKA &bull; {{ \App\Models\Setting::get('school_name', 'MTs Soebono Mantofani') }}. All rights reserved.
            </p>
        </div>
    </footer>
    @endif
</body>
</html>
