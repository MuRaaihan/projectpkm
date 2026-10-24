<!DOCTYPE html>
<html lang="id" class="h-full bg-[#F8FAF9]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sekolah.png') }}">
    <title>{{ $title ?? 'Dashboard' }} - SISPERKA</title>

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
<body class="min-h-full flex flex-col bg-[#F8FAF9] dark:bg-[#0E1713] text-slate-800 dark:text-slate-100 font-sans antialiased selection:bg-emerald-100 selection:text-emerald-900 transition-colors duration-200" x-data="{ sidebarOpen: false }">
    @php
        $user = auth()->user();
        $role = $user->role ?? 'siswa';
        $roleLabels = [
            'master' => 'Master Administrator',
            'bk' => 'Guru Bimbingan & Konseling',
            'siswa' => 'Peserta Didik (Siswa)',
        ];
        $isStaff = in_array($role, ['master', 'bk']);
        $unreadNotifCount = auth()->check() ? auth()->user()->unreadNotificationsCount() : 0;
    @endphp

    {{-- Top Header / Topbar --}}
    <header class="sticky top-0 z-30 bg-white/95 dark:bg-[#14201A]/95 backdrop-blur border-b border-slate-200/90 dark:border-[#22342A] transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20 gap-4">
                {{-- Kiri: Hamburger (Staf) & Brand --}}
                <div class="flex items-center gap-3">
                    @if ($isStaff)
                        {{-- Tombol Hamburger Mobile --}}
                        <button type="button" 
                                @click="sidebarOpen = !sidebarOpen"
                                class="lg:hidden p-2 min-h-[44px] min-w-[44px] inline-flex items-center justify-center text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition focus:outline-none focus:ring-2 focus:ring-primary-600"
                                aria-label="Buka Menu Navigasi">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    @endif

                    <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 focus:outline-none focus:ring-2 focus:ring-primary-600 rounded-2xl p-1">
                        <img src="{{ asset('images/logo-sekolah.png') }}" 
                             alt="Logo" 
                             class="w-10 h-10 object-contain drop-shadow-xs" />
                        <div class="hidden sm:block">
                            <span class="block font-black text-base sm:text-lg text-slate-900 dark:text-slate-100 tracking-tight leading-tight">SISPERKA</span>
                            <span class="block text-xs text-slate-500 dark:text-slate-400 font-semibold leading-none">MTs Soebono Mantofani</span>
                        </div>
                    </a>

                    {{-- Badge Peran Desktop --}}
                    <span class="hidden md:inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                        {{ $roleLabels[$role] ?? ucfirst($role) }}
                    </span>

                    {{-- Navigasi Desktop Khusus Siswa --}}
                    @if ($role === 'siswa')
                        <nav class="hidden md:flex items-center gap-1 ml-4 text-sm font-semibold">
                            <a href="{{ route('siswa.dashboard') }}" class="px-3.5 py-2 rounded-xl transition min-h-[40px] inline-flex items-center {{ request()->routeIs('siswa.dashboard') ? 'text-primary-700 dark:text-[#5AE39D] bg-emerald-50 dark:bg-emerald-950/60' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                Beranda
                            </a>
                            <a href="{{ route('siswa.reports.create') }}" class="px-3.5 py-2 rounded-xl transition min-h-[40px] inline-flex items-center {{ request()->routeIs('siswa.reports.create') ? 'text-primary-700 dark:text-[#5AE39D] bg-emerald-50 dark:bg-emerald-950/60' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                Buat Laporan
                            </a>
                            <a href="{{ route('siswa.reports.index') }}" class="px-3.5 py-2 rounded-xl transition min-h-[40px] inline-flex items-center {{ request()->routeIs('siswa.reports.index') || request()->routeIs('siswa.reports.show') ? 'text-primary-700 dark:text-[#5AE39D] bg-emerald-50 dark:bg-emerald-950/60' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                Riwayat Laporan
                            </a>
                            <a href="{{ route('siswa.help') }}" class="px-3.5 py-2 rounded-xl transition min-h-[40px] inline-flex items-center {{ request()->routeIs('siswa.help') ? 'text-primary-700 dark:text-[#5AE39D] bg-emerald-50 dark:bg-emerald-950/60' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                Bantuan & Kontak
                            </a>
                        </nav>
                    @endif
                </div>

                {{-- Kanan: Theme Toggle, Keluar Cepat, Lonceng, Akun --}}
                <div class="flex items-center gap-2 sm:gap-3">
                    {{-- Toggle Theme --}}
                    <button type="button" 
                            onclick="const isDark = document.documentElement.classList.toggle('dark'); localStorage.setItem('ui-theme', isDark ? 'dark' : 'light');"
                            class="p-2.5 rounded-xl border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition"
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
                       title="Langsung mengalihkan ke Google demi keselamatanmu"
                       class="inline-flex items-center gap-1.5 px-3 py-2 min-h-[40px] text-xs sm:text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950/40 border border-slate-300/80 dark:border-slate-800 hover:border-red-300 rounded-xl transition focus:outline-none focus:ring-2 focus:ring-red-600">
                        <svg class="w-4 h-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="hidden sm:inline">Keluar Cepat</span>
                    </a>

                    {{-- Notifikasi Lonceng --}}
                    <a href="{{ route('notifications.index') }}" 
                       class="relative p-2.5 min-h-[40px] min-w-[40px] inline-flex items-center justify-center text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition focus:outline-none focus:ring-2 focus:ring-primary-600"
                       title="Notifikasi dalam website"
                       aria-label="Notifikasi">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @if($unreadNotifCount > 0)
                            <span class="absolute top-1 right-1 min-w-[18px] h-[18px] px-1 bg-primary-600 text-white text-[10px] font-bold rounded-full flex items-center justify-center ring-2 ring-white dark:ring-[#14201A]">
                                {{ $unreadNotifCount > 99 ? '99+' : $unreadNotifCount }}
                            </span>
                        @endif
                    </a>

                    {{-- Menu Akun --}}
                    <div class="flex items-center gap-2 pl-3 border-l border-slate-200 dark:border-slate-800" x-data="{ userMenuOpen: false }">
                        <div class="relative">
                            <button type="button" 
                                    @click="userMenuOpen = !userMenuOpen"
                                    class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition focus:outline-none focus:ring-2 focus:ring-primary-600"
                                    aria-label="Menu Akun">
                                <div class="w-9 h-9 rounded-xl bg-primary-100 dark:bg-primary-950/80 text-primary-800 dark:text-primary-300 border border-primary-200 dark:border-primary-800 font-black text-sm flex items-center justify-center">
                                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="text-left hidden lg:block">
                                    <span class="block text-xs font-bold text-slate-900 dark:text-slate-100 leading-tight max-w-[120px] truncate">{{ $user->name ?? 'Pengguna' }}</span>
                                    <span class="block text-[11px] text-slate-500 dark:text-slate-400 capitalize leading-none mt-0.5">{{ $role }}</span>
                                </div>
                                <svg class="w-4 h-4 text-slate-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            {{-- Dropdown Akun --}}
                            <div x-show="userMenuOpen" 
                                 @click.away="userMenuOpen = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-56 rounded-2xl bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 shadow-lg py-2 z-50 divide-y divide-slate-100 dark:divide-slate-800"
                                 style="display: none;">
                                <div class="px-4 py-2.5">
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Masuk sebagai</p>
                                    <p class="text-sm font-bold text-slate-900 dark:text-slate-100 truncate">{{ $user->name ?? 'Pengguna' }}</p>
                                    <p class="text-[11px] text-emerald-700 dark:text-[#5AE39D] font-semibold mt-0.5">{{ $roleLabels[$role] ?? ucfirst($role) }}</p>
                                </div>
                                <div class="py-1">
                                    @if ($role === 'siswa')
                                        <a href="{{ route('siswa.profile') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs sm:text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/60">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            Profil & Ganti Sandi
                                        </a>
                                    @elseif ($role === 'bk')
                                        <a href="{{ route('bk.profile.show') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs sm:text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/60">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            Profil Konselor
                                        </a>
                                        <a href="{{ route('two-factor.setup') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs sm:text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/60">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                            Keamanan 2FA TOTP
                                        </a>
                                    @elseif ($role === 'master')
                                        <a href="{{ route('master.settings.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs sm:text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/60">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            Pengaturan Website
                                        </a>
                                        <a href="{{ route('two-factor.setup') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs sm:text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/60">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                            Keamanan 2FA TOTP
                                        </a>
                                    @endif
                                    <a href="{{ route('password.change') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs sm:text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/60">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                        Ganti Kata Sandi
                                    </a>
                                </div>
                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left flex items-center gap-2.5 px-4 py-2 text-xs sm:text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/40">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            Keluar dari Akun
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- Layout Grid untuk Staf (Sidebar) & Siswa (Container) --}}
    <div class="flex-1 flex w-full">
        @if ($isStaff)
            {{-- Backdrop Sidebar Mobile --}}
            <div x-show="sidebarOpen" 
                 @click="sidebarOpen = false" 
                 class="fixed inset-0 z-40 bg-black/40 backdrop-blur-xs lg:hidden"
                 x-transition:enter="transition-opacity ease-linear duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 style="display: none;"></div>

            {{-- Sidebar Navigasi Staf (Desktop & Mobile Drawer) --}}
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
                   class="fixed lg:sticky top-0 lg:top-20 z-40 lg:z-10 w-68 h-screen lg:h-[calc(100vh-5rem)] bg-white dark:bg-[#14201A] border-r border-slate-200/90 dark:border-[#22342A] transition-transform duration-200 ease-in-out shrink-0 overflow-y-auto">
                <div class="p-4 flex flex-col gap-1.5 min-h-full">
                    {{-- Header Sidebar Mobile --}}
                    <div class="flex items-center justify-between pb-3 mb-2 border-b border-slate-100 dark:border-slate-800 lg:hidden">
                        <div class="flex items-center gap-2.5">
                            <img src="{{ asset('images/logo-sekolah.png') }}" alt="Logo" class="w-8 h-8 object-contain" />
                            <span class="font-bold text-sm text-slate-900 dark:text-slate-100">SISPERKA Menu</span>
                        </div>
                        <button type="button" @click="sidebarOpen = false" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    @if ($role === 'bk')
                        {{-- Menu Navigasi Guru BK --}}
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 px-3 py-1">Konseling & Pengaduan</p>
                        
                        <a href="{{ route('bk.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('bk.dashboard') ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Dashboard Utama</span>
                        </a>

                        <a href="{{ route('bk.reports.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('bk.reports.index') || request()->routeIs('bk.reports.show') ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Laporan Masuk</span>
                        </a>

                        <a href="{{ route('bk.categories.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('bk.categories.*') ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            <span>Kategori Perundungan</span>
                        </a>

                        <a href="{{ route('bk.statistics.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('bk.statistics.index') ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            <span>Statistik Kasus</span>
                        </a>

                        <a href="{{ route('bk.reports.download.view') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('bk.reports.download.*') ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Unduh Laporan Resmi</span>
                        </a>

                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 px-3 py-1 mt-4">Rekap & Keamanan</p>

                        <a href="{{ route('periodic-reports.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('periodic-reports.*') ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Laporan Periodik</span>
                        </a>

                        <a href="{{ route('two-factor.setup') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('two-factor.setup') ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            <span>Autentikasi 2FA TOTP</span>
                        </a>
                    @elseif ($role === 'master')
                        {{-- Menu Navigasi Master Administrator --}}
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 px-3 py-1">Manajemen & Sistem</p>

                        <a href="{{ route('master.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('master.dashboard') ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Dashboard Sistem</span>
                        </a>

                        <a href="{{ route('master.students.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('master.students.*') ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <span>Akun Siswa</span>
                        </a>

                        <a href="{{ route('master.bk-users.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('master.bk-users.*') ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <span>Akun Guru BK</span>
                        </a>

                        <a href="{{ route('master.import.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('master.import.*') ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            <span>Impor Excel</span>
                        </a>

                        <a href="{{ route('master.classes.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('master.classes.*') ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span>Master Kelas</span>
                        </a>

                        <a href="{{ route('master.academic-years.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('master.academic-years.*') ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Tahun Ajaran</span>
                        </a>

                        <a href="{{ route('master.class-operations.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('master.class-operations.*') ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                            <span>Operasi Massal Kelas</span>
                        </a>

                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 px-3 py-1 mt-4">Audit & Pengaturan</p>

                        <a href="{{ route('periodic-reports.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('periodic-reports.*') ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Laporan Periodik</span>
                        </a>

                        <a href="{{ route('master.activity-logs.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('master.activity-logs.*') ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Log Audit Aktivitas</span>
                        </a>

                        <a href="{{ route('master.settings.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('master.settings.*') ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Pengaturan Website</span>
                        </a>

                        <a href="{{ route('two-factor.setup') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('two-factor.setup') ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            <span>Autentikasi 2FA TOTP</span>
                        </a>
                    @endif
                </div>
            </aside>
        @endif

        {{-- Konten Utama Halaman --}}
        <main class="flex-1 w-full min-w-0 pb-24 lg:pb-12">
            {{-- Notifikasi Flash Pesan --}}
            @if (session('status') || session('success') || session('error') || session('warning') || session('info'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 w-full">
                    @if (session('status') || session('success'))
                        <x-alert type="success" :message="session('status') ?? session('success')" />
                    @endif
                    @if (session('error'))
                        <x-alert type="error" :message="session('error')" />
                    @endif
                    @if (session('warning'))
                        <x-alert type="warning" :message="session('warning')" />
                    @endif
                    @if (session('info'))
                        <x-alert type="info" :message="session('info')" />
                    @endif
                </div>
            @endif

            <div class="w-full">
                {{ $slot }}
            </div>
        </main>
    </div>

    {{-- Bottom Navigation Bar untuk Siswa di Mobile --}}
    @if ($role === 'siswa')
        <nav class="md:hidden fixed bottom-0 left-0 right-0 z-30 bg-white/95 dark:bg-[#14201A]/95 backdrop-blur border-t border-slate-200/90 dark:border-[#22342A] px-2 py-2" aria-label="Navigasi Bawah">
            <div class="grid grid-cols-4 max-w-md mx-auto">
                <a href="{{ route('siswa.dashboard') }}" class="flex flex-col items-center gap-1 py-1 px-2 rounded-xl {{ request()->routeIs('siswa.dashboard') ? 'text-primary-700 dark:text-[#5AE39D] font-bold' : 'text-slate-500 dark:text-slate-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span class="text-[11px]">Beranda</span>
                </a>
                <a href="{{ route('siswa.reports.create') }}" class="flex flex-col items-center gap-1 py-1 px-2 rounded-xl {{ request()->routeIs('siswa.reports.create') ? 'text-primary-700 dark:text-[#5AE39D] font-bold' : 'text-slate-500 dark:text-slate-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span class="text-[11px]">Buat Aduan</span>
                </a>
                <a href="{{ route('siswa.reports.index') }}" class="flex flex-col items-center gap-1 py-1 px-2 rounded-xl {{ request()->routeIs('siswa.reports.index') || request()->routeIs('siswa.reports.show') ? 'text-primary-700 dark:text-[#5AE39D] font-bold' : 'text-slate-500 dark:text-slate-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span class="text-[11px]">Riwayat</span>
                </a>
                <a href="{{ route('siswa.profile') }}" class="flex flex-col items-center gap-1 py-1 px-2 rounded-xl {{ request()->routeIs('siswa.profile') ? 'text-primary-700 dark:text-[#5AE39D] font-bold' : 'text-slate-500 dark:text-slate-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span class="text-[11px]">Profil</span>
                </a>
            </div>
        </nav>
    @endif
</body>
</html>
