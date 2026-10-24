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

                {{-- Navigasi Tautan Publik Desktop --}}
                <nav class="hidden md:flex items-center gap-6 text-sm font-semibold text-slate-600 dark:text-slate-300">
                    <a href="{{ url('/') }}" class="hover:text-primary-600 dark:hover:text-[#5AE39D] transition py-1">Beranda</a>
                    <a href="{{ url('/#tentang') }}" class="hover:text-primary-600 dark:hover:text-[#5AE39D] transition py-1">Tentang</a>
                    <a href="{{ url('/#cara-kerja') }}" class="hover:text-primary-600 dark:hover:text-[#5AE39D] transition py-1">Cara Kerja</a>
                    <a href="{{ url('/#pengguna') }}" class="hover:text-primary-600 dark:hover:text-[#5AE39D] transition py-1">Fitur Peran</a>
                    <a href="{{ url('/#alur-penanganan') }}" class="hover:text-primary-600 dark:hover:text-[#5AE39D] transition py-1">Alur Penanganan</a>
                    <a href="{{ url('/#faq') }}" class="hover:text-primary-600 dark:hover:text-[#5AE39D] transition py-1">FAQ</a>
                    <a href="{{ route('privacy') }}" class="hover:text-primary-600 dark:hover:text-[#5AE39D] transition py-1">Kebijakan Privasi</a>
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

                    {{-- Tombol Keluar Cepat --}}
                    <a href="https://www.google.com" 
                       rel="noopener noreferrer" 
                       title="Langsung menutup halaman ini dan membuka Google demi keamananmu"
                       class="inline-flex items-center gap-1.5 px-3 py-2 min-h-[40px] text-xs sm:text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950/40 border border-slate-300/80 dark:border-slate-800 hover:border-red-300 rounded-xl transition focus:outline-none focus:ring-2 focus:ring-red-600">
                        <svg class="w-4 h-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Keluar Cepat</span>
                    </a>

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
            <a href="{{ url('/#pengguna') }}" class="block font-medium text-slate-700 dark:text-slate-200 p-2 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg">Fitur Peran</a>
            <a href="{{ url('/#alur-penanganan') }}" class="block font-medium text-slate-700 dark:text-slate-200 p-2 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg">Alur Penanganan</a>
            <a href="{{ url('/#faq') }}" class="block font-medium text-slate-700 dark:text-slate-200 p-2 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg">FAQ</a>
            <a href="{{ route('privacy') }}" class="block font-medium text-slate-700 dark:text-slate-200 p-2 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg">Kebijakan Privasi</a>
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

    {{-- Footer Informasi Sekolah (FR-41) --}}
    @if(!$hideFooter)
    <footer class="bg-white dark:bg-[#14201A] border-t border-slate-200/90 dark:border-[#22342A] mt-auto text-sm text-slate-500 dark:text-slate-400 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Kolom 1: Profil Madrasah & SISPERKA --}}
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-sekolah.png') }}" 
                             alt="Logo" 
                             class="w-8 h-8 object-contain" />
                        <span class="font-black text-base text-slate-900 dark:text-slate-100 tracking-tight">SISPERKA</span>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        Sistem Pelaporan Perundungan resmi {{ \App\Models\Setting::get('school_name', 'MTs Soebono Mantofani') }}. Ruang aman, rahasia, dan terpercaya bagi peserta didik untuk saling menjaga lingkungan belajar yang ramah dan bermartabat.
                    </p>
                    <div class="pt-1">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                            <span class="w-2 h-2 rounded-full bg-emerald-600 dark:bg-[#5AE39D]"></span>
                            Permendikbudristek No. 46 Tahun 2023
                        </span>
                    </div>
                </div>

                {{-- Kolom 2: Tautan Penting --}}
                <div class="space-y-3">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200">
                        Tautan Cepat
                    </h2>
                    <ul class="space-y-2 text-xs sm:text-sm">
                        <li><a href="{{ url('/') }}" class="hover:text-primary-600 dark:hover:text-[#5AE39D] transition">Beranda Utama</a></li>
                        <li><a href="{{ url('/#tata-cara') }}" class="hover:text-primary-600 dark:hover:text-[#5AE39D] transition">Tata Cara Pelaporan</a></li>
                        <li><a href="{{ url('/#alur-penanganan') }}" class="hover:text-primary-600 dark:hover:text-[#5AE39D] transition">Alur Penanganan Laporan</a></li>
                        <li><a href="{{ url('/#faq') }}" class="hover:text-primary-600 dark:hover:text-[#5AE39D] transition">Pertanyaan Umum (FAQ)</a></li>
                        <li><a href="{{ route('privacy') }}" class="hover:text-primary-600 dark:hover:text-[#5AE39D] transition">Kebijakan Privasi & Batas Kerahasiaan</a></li>
                    </ul>
                </div>

                {{-- Kolom 3: Layanan Konseling & Kontak --}}
                <div class="space-y-3">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200">
                        Layanan Bimbingan & Konseling
                    </h2>
                    <div class="text-xs sm:text-sm space-y-2 text-slate-600 dark:text-slate-400">
                        <p class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>{{ \App\Models\Setting::get('school_address', 'Jl. Nurul Huda No. 27, RT 01/RW 02, Jombang, Ciputat, Tangerang Selatan') }}</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ \App\Models\Setting::get('counseling_hours', 'Senin - Jumat: 07.30 - 15.00 WIB') }}</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>{{ \App\Models\Setting::get('school_email', 'bk@mtssoebonomantofani.sch.id') }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} SISPERKA - MTs Soebono Mantofani. Seluruh hak cipta dilindungi undang-undang.</p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('privacy') }}" class="hover:text-primary-600 dark:hover:text-[#5AE39D] transition">Kebijakan Privasi & Batas Kerahasiaan</a>
                </div>
            </div>
        </div>
    </footer>
    @endif
</body>
</html>
