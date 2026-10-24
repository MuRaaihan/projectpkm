@props([
    'title' => null,
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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col bg-[#F8FAF9] dark:bg-[#0E1713] text-slate-800 dark:text-slate-100 font-sans antialiased selection:bg-emerald-100 selection:text-emerald-900 transition-colors duration-200">
    {{-- Header Publik --}}
    <header class="sticky top-0 z-30 bg-white/95 dark:bg-[#14201A]/95 backdrop-blur border-b border-slate-200/90 dark:border-[#22342A] transition-colors" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20 gap-4">
                {{-- Brand Logo & Nama Sekolah --}}
                <a href="{{ url('/') }}" class="flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-primary-600 rounded-2xl p-1 shrink-0">
                    <img src="{{ asset('images/logo-sekolah.png') }}" 
                         alt="Logo MTs Soebono Mantofani" 
                         class="w-10 h-10 object-contain rounded-xl drop-shadow-xs" />
                    <div>
                        <span class="block font-black text-lg sm:text-xl text-slate-900 dark:text-slate-100 tracking-tight leading-tight">SISPERKA</span>
                        <span class="block text-xs sm:text-sm text-slate-500 dark:text-slate-400 font-semibold leading-none">MTs Soebono Mantofani</span>
                    </div>
                </a>

                {{-- Navigasi Tautan Publik Desktop (Sesuai frontend) --}}
                <nav class="hidden md:flex items-center gap-7 text-sm font-semibold text-slate-600 dark:text-slate-300">
                    <a href="{{ url('/') }}" class="hover:text-primary-600 dark:hover:text-[#5AE39D] transition py-1">Beranda</a>
                    <a href="{{ url('/#tentang') }}" class="hover:text-primary-600 dark:hover:text-[#5AE39D] transition py-1">Tentang</a>
                    <a href="{{ url('/#cara-kerja') }}" class="hover:text-primary-600 dark:hover:text-[#5AE39D] transition py-1">Cara Kerja</a>
                </nav>

                {{-- Action Navigasi & Dark Mode Toggle --}}
                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    {{-- Toggle Theme --}}
                    <button type="button" 
                            onclick="try { const isDark = document.documentElement.classList.toggle('dark'); localStorage.setItem('ui-theme', isDark ? 'dark' : 'light'); } catch(_) {}"
                            class="p-2.5 min-h-[44px] min-w-[44px] inline-flex items-center justify-center rounded-xl border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition"
                            aria-label="Alihkan tema gelap/terang"
                            title="Ganti Tema">
                        <svg class="w-4 h-4 hidden dark:block text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg class="w-4 h-4 block dark:hidden text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>


                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-4 py-2 min-h-[40px] text-xs sm:text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 active:bg-primary-800 rounded-xl shadow-xs transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-600">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ url('/login') }}" class="inline-flex items-center justify-center px-4.5 py-2 min-h-[40px] text-xs sm:text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 active:bg-primary-800 rounded-xl shadow-xs transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-600">
                            Lapor Sekarang
                        </a>
                    @endauth

                    {{-- Hamburger Mobile Button --}}
                    <button type="button" 
                            onclick="const m = document.getElementById('public-mobile-menu'); if(m) m.classList.toggle('hidden');"
                            class="md:hidden p-2 min-h-[44px] min-w-[44px] inline-flex items-center justify-center text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl"
                            aria-label="Toggle menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu Dropdown --}}
        <div id="public-mobile-menu" class="hidden md:hidden border-t border-slate-200 dark:border-slate-800 py-3 px-4 space-y-2 bg-white/95 dark:bg-[#14201A]/95 backdrop-blur">
            <a href="{{ url('/') }}" class="block font-medium text-slate-700 dark:text-slate-200 p-2 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg">Beranda</a>
            <a href="{{ url('/#tentang') }}" class="block font-medium text-slate-700 dark:text-slate-200 p-2 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg">Tentang</a>
            <a href="{{ url('/#cara-kerja') }}" class="block font-medium text-slate-700 dark:text-slate-200 p-2 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg">Cara Kerja</a>
            @guest
                <a href="{{ route('login') }}" class="block w-full text-center font-bold px-4 py-2.5 rounded-xl bg-primary-600 text-white mt-2">Mulai Menggunakan SIPERKA</a>
            @endguest
        </div>
    </header>

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
    <main class="flex-1 w-full">
        {{ $slot }}
    </main>

    {{-- Footer Resmi & Profesional Madrasah (FR-41) --}}
    @if(!$hideFooter)
    <footer class="bg-white dark:bg-[#080D0A] border-t border-slate-200/90 dark:border-[#1A2820] text-slate-600 dark:text-slate-400 text-sm transition-colors mt-auto">
        {{-- Konten Utama Footer --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-10">
                {{-- Kolom 1: Profil Madrasah & Identitas Sistem (lg:col-span-4) --}}
                <div class="lg:col-span-4 space-y-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-white dark:bg-[#121B16] border border-slate-200/80 dark:border-slate-800 p-1.5 flex items-center justify-center shadow-2xs shrink-0">
                            <img src="{{ asset('images/logo-sekolah.png') }}" 
                                 alt="Logo MTs Soebono Mantofani" 
                                 class="w-full h-full object-contain" />
                        </div>
                        <div>
                            <span class="block font-black text-xl text-slate-900 dark:text-slate-100 tracking-tight leading-tight">
                                SIPERKA
                            </span>
                            <span class="block text-xs font-semibold text-primary-700 dark:text-[#5AE39D]">
                                {{ \App\Models\Setting::get('school_name', 'MTs Soebono Mantofani') }}
                            </span>
                        </div>
                    </div>

                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed max-w-sm">
                        Sistem Informasi Pelaporan Kasus Perundungan resmi madrasah. Ruang aman, tenang, dan rahasia bagi peserta didik untuk bercerita tanpa rasa takut demi terwujudnya madrasah ramah anak.
                    </p>

                    <div class="pt-2 flex flex-col gap-2">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800/80 shadow-2xs w-fit">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Permendikbudristek No. 46 Tahun 2023</span>
                        </div>
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-50 dark:bg-[#121B16] text-slate-700 dark:text-slate-300 border border-slate-200/80 dark:border-slate-800 w-fit">
                            <svg class="w-3.5 h-3.5 text-primary-600 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span>Enkripsi Database & Perlindungan Pelapor</span>
                        </div>
                    </div>
                </div>

                {{-- Kolom 2: Navigasi Layanan (lg:col-span-2) --}}
                <div class="lg:col-span-2 space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-slate-100 flex items-center gap-2">
                        <span class="w-1.5 h-3.5 bg-primary-600 dark:bg-[#5AE39D] rounded-full"></span>
                        Navigasi
                    </h3>
                    <ul class="space-y-2.5 text-xs sm:text-sm">
                        <li>
                            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-primary-600 dark:hover:text-[#5AE39D] transition font-medium group">
                                <span class="text-slate-400 group-hover:translate-x-0.5 transition-transform font-bold">&rsaquo;</span>
                                <span>Beranda Utama</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/#tentang') }}" class="inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-primary-600 dark:hover:text-[#5AE39D] transition font-medium group">
                                <span class="text-slate-400 group-hover:translate-x-0.5 transition-transform font-bold">&rsaquo;</span>
                                <span>Tentang SIPERKA</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/#cara-kerja') }}" class="inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-primary-600 dark:hover:text-[#5AE39D] transition font-medium group">
                                <span class="text-slate-400 group-hover:translate-x-0.5 transition-transform font-bold">&rsaquo;</span>
                                <span>Tata Cara Pelaporan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-primary-600 dark:hover:text-[#5AE39D] transition font-medium group">
                                <span class="text-slate-400 group-hover:translate-x-0.5 transition-transform font-bold">&rsaquo;</span>
                                <span>Portal Masuk Siswa</span>
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Kolom 3: Kebijakan & Perlindungan (lg:col-span-2) --}}
                <div class="lg:col-span-2 space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-slate-100 flex items-center gap-2">
                        <span class="w-1.5 h-3.5 bg-primary-600 dark:bg-[#5AE39D] rounded-full"></span>
                        Perlindungan
                    </h3>
                    <ul class="space-y-2.5 text-xs sm:text-sm">
                        <li>
                            <a href="{{ url('/kebijakan-privasi') }}" class="inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-primary-600 dark:hover:text-[#5AE39D] transition font-medium group">
                                <span class="text-slate-400 group-hover:translate-x-0.5 transition-transform font-bold">&rsaquo;</span>
                                <span>Kebijakan Privasi</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/kebijakan-privasi#kerahasiaan') }}" class="inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-primary-600 dark:hover:text-[#5AE39D] transition font-medium group">
                                <span class="text-slate-400 group-hover:translate-x-0.5 transition-transform font-bold">&rsaquo;</span>
                                <span>Batas Kerahasiaan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/kebijakan-privasi#hak-siswa') }}" class="inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-primary-600 dark:hover:text-[#5AE39D] transition font-medium group">
                                <span class="text-slate-400 group-hover:translate-x-0.5 transition-transform font-bold">&rsaquo;</span>
                                <span>Hak Peserta Didik</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/kebijakan-privasi#alur-keamanan') }}" class="inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-primary-600 dark:hover:text-[#5AE39D] transition font-medium group">
                                <span class="text-slate-400 group-hover:translate-x-0.5 transition-transform font-bold">&rsaquo;</span>
                                <span>Independensi BK</span>
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Kolom 4: Layanan Bimbingan & Konseling (lg:col-span-4) --}}
                <div class="lg:col-span-4 space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-slate-100 flex items-center gap-2">
                            <span class="w-1.5 h-3.5 bg-primary-600 dark:bg-[#5AE39D] rounded-full"></span>
                            Layanan Bimbingan & Konseling
                        </h3>
                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-950/70 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            BK Aktif
                        </span>
                    </div>

                    {{-- Kotak Kontak Resmi BK --}}
                    <div class="bg-slate-50/80 dark:bg-[#121B16] border border-slate-200/80 dark:border-slate-800 rounded-2xl p-4 space-y-3.5 text-xs sm:text-sm shadow-2xs">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-xl bg-white dark:bg-[#192720] text-primary-600 dark:text-[#5AE39D] flex items-center justify-center shrink-0 border border-slate-200 dark:border-slate-700/80 shadow-2xs mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div class="space-y-0.5">
                                <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Alamat Madrasah</span>
                                <span class="text-slate-700 dark:text-slate-300 leading-snug font-medium block">
                                    {{ \App\Models\Setting::get('school_address', 'Jl. Nurul Huda No. 27, RT 01/RW 02, Jombang, Ciputat, Tangerang Selatan') }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 pt-1 border-t border-slate-200/70 dark:border-slate-800/80">
                            <div class="w-8 h-8 rounded-xl bg-white dark:bg-[#192720] text-[#8C6708] dark:text-[#FAD46B] flex items-center justify-center shrink-0 border border-slate-200 dark:border-slate-700/80 shadow-2xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="space-y-0.5">
                                <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Jam Layanan Konseling</span>
                                <span class="text-slate-700 dark:text-slate-300 font-semibold block text-xs">
                                    {{ \App\Models\Setting::get('counseling_hours', 'Senin - Jumat: 07.30 - 15.00 WIB') }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 pt-1 border-t border-slate-200/70 dark:border-slate-800/80">
                            <div class="w-8 h-8 rounded-xl bg-white dark:bg-[#192720] text-primary-600 dark:text-[#5AE39D] flex items-center justify-center shrink-0 border border-slate-200 dark:border-slate-700/80 shadow-2xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="space-y-0.5">
                                <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Surel Resmi BK</span>
                                <a href="mailto:{{ \App\Models\Setting::get('school_email', 'bk@mtssoebonomantofani.sch.id') }}" class="text-slate-700 dark:text-slate-300 hover:text-primary-600 dark:hover:text-[#5AE39D] transition font-medium block text-xs underline decoration-slate-300 dark:decoration-slate-700 underline-offset-2">
                                    {{ \App\Models\Setting::get('school_email', 'bk@mtssoebonomantofani.sch.id') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Baris Hak Cipta & Kredensial Bawah --}}
        <div class="border-t border-slate-200/80 dark:border-slate-800/80 bg-slate-50/70 dark:bg-[#050907]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-500 dark:text-slate-400">
                <div class="flex flex-col sm:flex-row items-center gap-2 text-center sm:text-left">
                    <p>
                        &copy; {{ date('Y') }} <span class="font-bold text-slate-800 dark:text-slate-200">SIPERKA</span> &bull; {{ \App\Models\Setting::get('school_name', 'MTs Soebono Mantofani') }}. Seluruh hak cipta dilindungi.
                    </p>
                </div>

                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 shadow-xs"></span>
                        <span class="font-medium text-slate-600 dark:text-slate-300">Madrasah Ramah Anak</span>
                    </div>

                    <span class="text-slate-300 dark:text-slate-700">|</span>

                    <button type="button" 
                            onclick="window.scrollTo({ top: 0, behavior: 'smooth' })" 
                            class="inline-flex items-center gap-1.5 text-slate-500 dark:text-slate-400 hover:text-primary-600 dark:hover:text-[#5AE39D] transition font-medium focus:outline-none">
                        <span>Ke Atas</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </footer>
    @endif
</body>
</html>
