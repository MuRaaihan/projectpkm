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
    <meta name="description" content="SIPERKA - Sistem Pelaporan Perundungan resmi MTs Soebono Mantofani. Ruang aman, tenang, dan rahasia bagi peserta didik untuk bercerita tanpa rasa takut.">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sekolah.png') }}">
    <title>{{ $title ?? 'SIPERKA - Sistem Pelaporan Perundungan MTs Soebono Mantofani' }}</title>

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
                        <img src="{{ asset('images/logo-sekolah.png') }}" 
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
    <div id="siperka-flash-messages" class="hidden"
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

    {{-- Footer Resmi Sekolah & SIPERKA --}}
    @if(!$hideFooter)
    @php
        $schoolName = \App\Models\Setting::get('school_name', 'MTs Soebono Mantofani');
        $schoolAddress = \App\Models\Setting::get('school_address', 'Jl. Nurul Huda No. 27, RT 03/01, Jombang, Kec. Ciputat, Kota Tangerang Selatan, Banten 15414');
        $schoolPhone = \App\Models\Setting::get('school_phone', '(021) 745-1234');
        $schoolEmail = \App\Models\Setting::get('school_email', 'bk@mtssoebonomantofani.sch.id');
        $counselingLocation = \App\Models\Setting::get('counseling_location', 'Ruang Bimbingan & Konseling (BK), Gedung Utama MTs Soebono Mantofani');
        $counselingHours = \App\Models\Setting::get('counseling_hours', 'Senin – Jumat, pukul 07.30 – 14.30 WIB');
        $emergencyContact = \App\Models\Setting::get('emergency_contact', 'Hubungi Ruang BK atau wali kelas masing-masing');
    @endphp
    <footer class="bg-white dark:bg-[#0B110E] border-t border-slate-200 dark:border-slate-800 transition-colors mt-auto">
        {{-- Konten Utama Footer --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-10">
                {{-- Kolom 1: Identitas & Visi Aplikasi (span 4 di desktop) --}}
                <div class="lg:col-span-4 flex flex-col items-start text-left">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo-sekolah.png') }}" alt="Logo {{ $schoolName }}" class="w-12 h-12 object-contain shrink-0" />
                        <div>
                            <span class="block font-black text-xl text-slate-900 dark:text-white tracking-tight leading-tight">
                                SIPERKA
                            </span>
                            <span class="block text-xs font-semibold text-primary-700 dark:text-[#5AE39D]">
                                {{ $schoolName }}
                            </span>
                        </div>
                    </div>

                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-5">
                        Sistem Informasi Pelaporan Kasus Perundungan resmi madrasah. Ruang aman, rahasia, dan terpercaya bagi peserta didik untuk bercerita tanpa rasa takut dengan pendampingan langsung dari Guru Bimbingan & Konseling (BK).
                    </p>

                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-primary-50 dark:bg-primary-950/50 border border-primary-200/80 dark:border-primary-900/60 text-[11px] font-semibold text-primary-800 dark:text-primary-300">
                        <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>Madrasah Ramah Anak &bull; Kerahasiaan Terjamin</span>
                    </div>
                </div>

                {{-- Kolom 2: Kontak & Lokasi Madrasah (span 3 di desktop) --}}
                <div class="lg:col-span-3 text-left">
                    <h5 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-slate-100 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-3.5 bg-primary-600 dark:bg-[#5AE39D] rounded-full"></span>
                        Informasi Madrasah
                    </h5>

                    <ul class="space-y-3.5 text-xs text-slate-600 dark:text-slate-400">
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="leading-relaxed">
                                <strong class="text-slate-800 dark:text-slate-200 block font-semibold mb-0.5">Alamat Kampus:</strong>
                                {{ $schoolAddress }}
                            </span>
                        </li>

                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>
                                <span class="text-slate-500 dark:text-slate-400">Telepon:</span>
                                <a href="tel:{{ preg_replace('/[^0-9]/', '', $schoolPhone) }}" class="font-semibold text-slate-800 dark:text-slate-200 hover:text-primary-600 dark:hover:text-[#5AE39D] transition-colors ml-1">
                                    {{ $schoolPhone }}
                                </a>
                            </span>
                        </li>

                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span class="truncate">
                                <span class="text-slate-500 dark:text-slate-400">Email:</span>
                                <a href="mailto:{{ $schoolEmail }}" class="font-semibold text-slate-800 dark:text-slate-200 hover:text-primary-600 dark:hover:text-[#5AE39D] transition-colors ml-1 truncate" title="{{ $schoolEmail }}">
                                    {{ $schoolEmail }}
                                </a>
                            </span>
                        </li>
                    </ul>
                </div>

                {{-- Kolom 3: Layanan Bimbingan & Konseling (span 3 di desktop) --}}
                <div class="lg:col-span-3 text-left">
                    <h5 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-slate-100 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-3.5 bg-primary-600 dark:bg-[#5AE39D] rounded-full"></span>
                        Layanan Konseling (BK)
                    </h5>

                    <ul class="space-y-3.5 text-xs text-slate-600 dark:text-slate-400">
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span class="leading-relaxed">
                                <strong class="text-slate-800 dark:text-slate-200 block font-semibold mb-0.5">Ruang Konseling:</strong>
                                {{ $counselingLocation }}
                            </span>
                        </li>

                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="leading-relaxed">
                                <strong class="text-slate-800 dark:text-slate-200 block font-semibold mb-0.5">Jam Layanan Konseling:</strong>
                                {{ $counselingHours }}
                            </span>
                        </li>

                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="leading-relaxed text-slate-600 dark:text-slate-300">
                                <strong class="text-amber-700 dark:text-amber-400 block font-semibold mb-0.5">Bantuan Darurat:</strong>
                                {{ $emergencyContact }}
                            </span>
                        </li>
                    </ul>
                </div>

                {{-- Kolom 4: Navigasi & Tautan Penting (span 2 di desktop) --}}
                <div class="lg:col-span-2 text-left">
                    <h5 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-slate-100 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-3.5 bg-primary-600 dark:bg-[#5AE39D] rounded-full"></span>
                        Tautan Cepat
                    </h5>

                    <ul class="space-y-2.5 text-xs">
                        <li>
                            <a href="{{ url('/') }}" class="text-slate-600 dark:text-slate-400 hover:text-primary-600 dark:hover:text-[#5AE39D] font-medium transition-colors flex items-center gap-1.5">
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                <span>Beranda</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('privacy') }}" class="text-slate-600 dark:text-slate-400 hover:text-primary-600 dark:hover:text-[#5AE39D] font-medium transition-colors flex items-center gap-1.5">
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                <span>Kebijakan Privasi</span>
                            </a>
                        </li>
                        @auth
                            <li>
                                <a href="{{ url('/dashboard') }}" class="text-slate-600 dark:text-slate-400 hover:text-primary-600 dark:hover:text-[#5AE39D] font-medium transition-colors flex items-center gap-1.5">
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    <span>Buka Dashboard</span>
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}" class="text-slate-600 dark:text-slate-400 hover:text-primary-600 dark:hover:text-[#5AE39D] font-medium transition-colors flex items-center gap-1.5">
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    <span>Masuk ke Akun</span>
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>

            {{-- Garis Pemisah & Hak Cipta --}}
            <div class="pt-8 mt-10 border-t border-slate-200/90 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500 dark:text-slate-400">
                <p class="text-center sm:text-left">
                    &copy; {{ date('Y') }} <strong class="text-slate-700 dark:text-slate-200">SIPERKA</strong> &bull; {{ $schoolName }}. Seluruh hak cipta dilindungi undang-undang.
                </p>

                <div class="flex items-center gap-4 text-slate-500 dark:text-slate-400">
                    <a href="{{ route('privacy') }}" class="hover:text-primary-600 dark:hover:text-[#5AE39D] transition-colors">
                        Kebijakan Privasi
                    </a>
                    <span>&bull;</span>
                    <span class="inline-flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>Sistem Terenkripsi</span>
                    </span>
                </div>
            </div>
        </div>
    </footer>
    @endif
    {{-- Tombol Scroll Kembali ke Atas (Back to Top) --}}
    <div
        x-data="{ showScrollTop: false }"
        @scroll.window="showScrollTop = (window.pageYOffset > 300)"
        class="fixed bottom-6 right-6 z-40 sm:bottom-8 sm:right-8"
        x-cloak
    >
        <button
            type="button"
            x-show="showScrollTop"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-90"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-90"
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            aria-label="Kembali ke atas"
            title="Kembali ke atas"
            class="group w-11 h-11 sm:w-12 sm:h-12 rounded-full flex items-center justify-center bg-primary-600 hover:bg-primary-700 text-white shadow-lg shadow-primary-950/25 dark:shadow-black/60 border border-primary-500/40 hover:border-primary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-[#0E1713] transition-all active:scale-95 cursor-pointer"
        >
            <svg class="w-5 h-5 sm:w-6 sm:h-6 transition-transform duration-200 group-hover:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
            </svg>
        </button>
    </div>
</body>
</html>
