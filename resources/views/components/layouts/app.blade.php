<!DOCTYPE html>
<html lang="id" class="h-full bg-[#F8FAF9] dark:bg-[#0E1713]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sekolah.png') }}">
    <title>{{ $title ?? 'Dashboard' }} - SIPERKA</title>

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
<body class="min-h-full flex flex-col bg-[#F8FAF9] dark:bg-[#0E1713] text-slate-800 dark:text-slate-100 font-sans antialiased selection:bg-emerald-100 selection:text-emerald-900 transition-colors duration-200" x-data="{ mobileMenuOpen: false }">
    @php
        $user = auth()->user();
        $role = $user->role ?? 'siswa';
        $roleLabels = [
            'master' => 'Master Admin',
            'bk' => 'Guru BK',
            'siswa' => 'Siswa',
        ];
        $roleSubtitles = [
            'master' => 'Panel Admin',
            'bk' => 'Portal Guru BK',
            'siswa' => 'Ruang Aman Siswa',
        ];
        $unreadNotifCount = auth()->check() ? auth()->user()->unreadNotificationsCount() : 0;
        
        // User initials
        $nameParts = explode(' ', trim($user->name ?? 'Pengguna'));
        $initials = count($nameParts) >= 2 
            ? mb_substr($nameParts[0], 0, 1) . mb_substr($nameParts[1], 0, 1)
            : mb_substr($user->name ?? 'U', 0, 2);
        $initials = strtoupper($initials);
    @endphp

    <div class="min-h-screen flex w-full">
        {{-- =========================================================
             1. DESKTOP SIDEBAR (Sesuai SideNav, GBKSideNav, AdminSideNav)
             ========================================================= --}}
        <aside class="hidden lg:flex flex-col w-64 min-h-screen border-r fixed top-0 left-0 z-40 transition-theme"
               style="background-color: var(--sidebar-bg); border-color: var(--sidebar-border);" 
               aria-label="Navigasi Utama Desktop">
            {{-- Brand Logo & Title --}}
            <div class="h-16 flex items-center px-5 border-b shrink-0"
                 style="border-color: var(--sidebar-border);">
                <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 min-w-0 group">
                    <img src="{{ asset('logo-sekolah.png') }}" 
                         alt="Logo Sekolah" 
                         class="w-10 h-10 object-contain shrink-0 group-hover:scale-105 transition-transform" />
                    <div class="min-w-0">
                        <p class="text-sm font-black text-slate-900 dark:text-slate-100 leading-tight truncate">
                            SIPERKA
                        </p>
                        <p class="text-[10px] font-semibold text-slate-500 dark:text-slate-400 leading-tight truncate mt-0.5">
                            {{ $roleSubtitles[$role] ?? 'MTs Soebono Mantofani' }}
                        </p>
                    </div>
                </a>
            </div>

            {{-- Navigation Items --}}
            <nav class="flex-1 py-4 px-3 flex flex-col gap-1 overflow-y-auto" aria-label="Menu Utama">
                <p class="px-2.5 mb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                    Navigasi
                </p>

                @if ($role === 'siswa')
                    {{-- ── Nav Siswa (Sesuai SideNav.tsx) ────────────── --}}
                    @php
                        $isHomeActive = request()->routeIs('siswa.dashboard');
                        $isReportsActive = request()->routeIs('siswa.reports.*');
                        $isHelpActive = request()->routeIs('siswa.help');
                        $isProfileActive = request()->routeIs('siswa.profile');
                    @endphp

                    <a href="{{ route('siswa.dashboard') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150 group {{ $isHomeActive ? 'text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-slate-200' }}"
                       @if($isHomeActive) style="background-color: var(--sidebar-active-bg);" @endif>
                        @if ($isHomeActive)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-primary-600 dark:bg-[#5AE39D] rounded-r-md"></span>
                        @endif
                        <svg class="w-4 h-4 shrink-0 transition-colors {{ $isHomeActive ? 'text-primary-600 dark:text-[#5AE39D]' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-700 dark:group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Beranda</span>
                    </a>

                    <a href="{{ route('siswa.reports.create') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150 group {{ request()->routeIs('siswa.reports.create') ? 'text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-slate-200' }}"
                       @if(request()->routeIs('siswa.reports.create')) style="background-color: var(--sidebar-active-bg);" @endif>
                        @if(request()->routeIs('siswa.reports.create'))
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-primary-600 dark:bg-[#5AE39D] rounded-r-md"></span>
                        @endif
                        <svg class="w-4 h-4 shrink-0 text-primary-600 dark:text-[#5AE39D] transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span>Buat Laporan</span>
                        <span class="ml-auto text-[10px] font-bold px-1.5 py-0.5 rounded-md bg-[#B8E34B] text-[#176B4D]">Anonim</span>
                    </a>

                    <a href="{{ route('siswa.reports.index') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150 group {{ ($isReportsActive && !request()->routeIs('siswa.reports.create')) ? 'text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-slate-200' }}"
                       @if($isReportsActive && !request()->routeIs('siswa.reports.create')) style="background-color: var(--sidebar-active-bg);" @endif>
                        @if ($isReportsActive && !request()->routeIs('siswa.reports.create'))
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-primary-600 dark:bg-[#5AE39D] rounded-r-md"></span>
                        @endif
                        <svg class="w-4 h-4 shrink-0 transition-colors {{ ($isReportsActive && !request()->routeIs('siswa.reports.create')) ? 'text-primary-600 dark:text-[#5AE39D]' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-700 dark:group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Laporan Saya</span>
                    </a>

                    <a href="{{ route('siswa.help') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150 group {{ $isHelpActive ? 'text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-slate-200' }}"
                       @if($isHelpActive) style="background-color: var(--sidebar-active-bg);" @endif>
                        @if ($isHelpActive)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-primary-600 dark:bg-[#5AE39D] rounded-r-md"></span>
                        @endif
                        <svg class="w-4 h-4 shrink-0 transition-colors {{ $isHelpActive ? 'text-primary-600 dark:text-[#5AE39D]' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-700 dark:group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>Bantuan & Kontak</span>
                    </a>

                    <p class="px-2.5 mt-4 mb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        Akun
                    </p>

                    <a href="{{ route('siswa.profile') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150 group {{ $isProfileActive ? 'text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-slate-200' }}"
                       @if($isProfileActive) style="background-color: var(--sidebar-active-bg);" @endif>
                        @if ($isProfileActive)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-primary-600 dark:bg-[#5AE39D] rounded-r-md"></span>
                        @endif
                        <svg class="w-4 h-4 shrink-0 transition-colors {{ $isProfileActive ? 'text-primary-600 dark:text-[#5AE39D]' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-700 dark:group-hover:text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>Profil Saya</span>
                    </a>

                @elseif ($role === 'bk')
                    {{-- ── Nav Guru BK (Sesuai GBKSideNav) ────────────── --}}
                    @php
                        $isBkDashboard = request()->routeIs('bk.dashboard');
                        $isBkReports = request()->routeIs('bk.reports.*');
                        $isBkStats = request()->routeIs('bk.statistics.*');
                        $isBkNotif = request()->routeIs('notifications.*');
                        $isBkProfile = request()->routeIs('bk.profile.*');
                    @endphp

                    <a href="{{ route('bk.dashboard') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 group {{ $isBkDashboard ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/80 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white' }}">
                        @if ($isBkDashboard)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-primary-600 dark:bg-[#5AE39D] rounded-r-full"></span>
                        @endif
                        <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('bk.reports.index') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 group {{ $isBkReports ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/80 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white' }}">
                        @if ($isBkReports)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-primary-600 dark:bg-[#5AE39D] rounded-r-full"></span>
                        @endif
                        <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                        <span>Laporan Masuk</span>
                    </a>

                    <a href="{{ route('bk.statistics.index') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 group {{ $isBkStats ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/80 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white' }}">
                        @if ($isBkStats)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-primary-600 dark:bg-[#5AE39D] rounded-r-full"></span>
                        @endif
                        <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <span>Statistik</span>
                    </a>

                    <a href="{{ route('notifications.index') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 group {{ $isBkNotif ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/80 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white' }}">
                        @if ($isBkNotif)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-primary-600 dark:bg-[#5AE39D] rounded-r-full"></span>
                        @endif
                        <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span>Notifikasi</span>
                        @if($unreadNotifCount > 0)
                            <span class="ml-auto text-[10px] font-bold px-1.5 py-0.5 rounded-full bg-primary-600 text-white">
                                {{ $unreadNotifCount > 99 ? '99+' : $unreadNotifCount }}
                            </span>
                        @endif
                    </a>

                    <p class="px-2.5 mt-4 mb-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        Manajemen & Unduh
                    </p>

                    <a href="{{ route('bk.categories.index') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 group {{ request()->routeIs('bk.categories.*') ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/80 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        <span>Kategori Kasus</span>
                    </a>

                    <a href="{{ route('bk.reports.download.view') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 group {{ request()->routeIs('bk.reports.download.*') ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/80 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Unduh Laporan</span>
                    </a>

                    <a href="{{ route('periodic-reports.index') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 group {{ request()->routeIs('periodic-reports.*') ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/80 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Laporan Periodik</span>
                    </a>

                    <p class="px-2.5 mt-4 mb-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        Akun
                    </p>

                    <a href="{{ route('bk.profile.show') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 group {{ $isBkProfile ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/80 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white' }}">
                        @if ($isBkProfile)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-primary-600 dark:bg-[#5AE39D] rounded-r-full"></span>
                        @endif
                        <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>Profil Konselor</span>
                    </a>

                @elseif ($role === 'master')
                    {{-- ── Nav Master Admin (Sesuai AdminSideNav) ─────── --}}
                    @php
                        $isMasterDashboard = request()->routeIs('master.dashboard');
                        $isMasterStudents = request()->routeIs('master.students.*');
                        $isMasterBk = request()->routeIs('master.bk-users.*');
                        $isMasterImport = request()->routeIs('master.import.*');
                        $isMasterClasses = request()->routeIs('master.classes.*');
                        $isMasterYears = request()->routeIs('master.academic-years.*');
                        $isMasterOps = request()->routeIs('master.class-operations.*');
                        $isMasterNotif = request()->routeIs('notifications.*');
                        $isMasterPeriodic = request()->routeIs('periodic-reports.*');
                        $isMasterLogs = request()->routeIs('master.activity-logs.*');
                        $isMasterSettings = request()->routeIs('master.settings.*');
                    @endphp

                    <p class="px-2.5 mb-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        Menu Utama
                    </p>

                    <a href="{{ route('master.dashboard') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 group {{ $isMasterDashboard ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/80 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white' }}">
                        @if ($isMasterDashboard)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-primary-600 dark:bg-[#5AE39D] rounded-r-full"></span>
                        @endif
                        <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Dashboard</span>
                    </a>

                    <p class="px-2.5 mt-4 mb-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        Manajemen Pengguna
                    </p>

                    <a href="{{ route('master.students.index') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 group {{ $isMasterStudents ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/80 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white' }}">
                        @if ($isMasterStudents)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-primary-600 dark:bg-[#5AE39D] rounded-r-full"></span>
                        @endif
                        <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>Akun Siswa</span>
                    </a>

                    <a href="{{ route('master.bk-users.index') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 group {{ $isMasterBk ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/80 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white' }}">
                        @if ($isMasterBk)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-primary-600 dark:bg-[#5AE39D] rounded-r-full"></span>
                        @endif
                        <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span>Akun Guru BK</span>
                    </a>

                    <a href="{{ route('master.import.index') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 group {{ $isMasterImport ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/80 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white' }}">
                        @if ($isMasterImport)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-primary-600 dark:bg-[#5AE39D] rounded-r-full"></span>
                        @endif
                        <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        <span>Impor Excel</span>
                    </a>

                    <p class="px-2.5 mt-4 mb-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        Akademik
                    </p>

                    <a href="{{ route('master.classes.index') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 group {{ $isMasterClasses ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/80 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white' }}">
                        @if ($isMasterClasses)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-primary-600 dark:bg-[#5AE39D] rounded-r-full"></span>
                        @endif
                        <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Master Kelas</span>
                    </a>

                    <a href="{{ route('master.academic-years.index') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 group {{ $isMasterYears ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/80 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white' }}">
                        @if ($isMasterYears)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-primary-600 dark:bg-[#5AE39D] rounded-r-full"></span>
                        @endif
                        <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Tahun Ajaran</span>
                    </a>

                    <a href="{{ route('master.class-operations.index') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 group {{ $isMasterOps ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/80 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white' }}">
                        @if ($isMasterOps)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-primary-600 dark:bg-[#5AE39D] rounded-r-full"></span>
                        @endif
                        <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        <span>Kenaikan Kelas</span>
                    </a>

                    <p class="px-2.5 mt-4 mb-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        Audit & Sistem
                    </p>

                    <a href="{{ route('notifications.index') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 group {{ $isMasterNotif ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/80 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white' }}">
                        @if ($isMasterNotif)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-primary-600 dark:bg-[#5AE39D] rounded-r-full"></span>
                        @endif
                        <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span>Notifikasi</span>
                        @if($unreadNotifCount > 0)
                            <span class="ml-auto text-[10px] font-bold px-1.5 py-0.5 rounded-full bg-primary-600 text-white">
                                {{ $unreadNotifCount > 99 ? '99+' : $unreadNotifCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('periodic-reports.index') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 group {{ $isMasterPeriodic ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/80 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white' }}">
                        @if ($isMasterPeriodic)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-primary-600 dark:bg-[#5AE39D] rounded-r-full"></span>
                        @endif
                        <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Laporan Periodik</span>
                    </a>

                    <a href="{{ route('master.activity-logs.index') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 group {{ $isMasterLogs ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/80 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white' }}">
                        @if ($isMasterLogs)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-primary-600 dark:bg-[#5AE39D] rounded-r-full"></span>
                        @endif
                        <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Log Audit Aktivitas</span>
                    </a>

                    <a href="{{ route('master.settings.index') }}" 
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 group {{ $isMasterSettings ? 'bg-[#EAF5EE] dark:bg-[#1A3326] text-primary-700 dark:text-[#5AE39D]' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/80 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white' }}">
                        @if ($isMasterSettings)
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 bg-primary-600 dark:bg-[#5AE39D] rounded-r-full"></span>
                        @endif
                        <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Pengaturan Web</span>
                    </a>
                @endif
            </nav>

            {{-- Sidebar Footer: User Card & Theme Toggle (Sesuai SideNav.tsx, GBKSideNav.tsx, AdminSideNav.tsx) --}}
            <div class="px-3 py-4 border-t flex items-center justify-between gap-2 shrink-0" 
                 style="border-color: var(--sidebar-border);">
                <a href="{{ $role === 'siswa' ? route('siswa.profile') : ($role === 'bk' ? route('bk.profile.show') : route('master.settings.index')) }}"
                   class="flex items-center gap-3 px-2 py-1.5 rounded-xl hover:bg-slate-100/70 dark:hover:bg-slate-800/60 transition-colors flex-1 min-w-0 group cursor-pointer">
                    <div class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center shrink-0 shadow-2xs">
                        <span class="text-xs font-bold text-white">{{ $initials }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-slate-900 dark:text-slate-100 truncate">{{ $user->name ?? 'Pengguna' }}</p>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400 truncate">
                            {{ $role === 'siswa' ? 'Siswa' : ($role === 'bk' ? 'Guru BK / Konselor' : 'Master Admin') }}
                        </p>
                    </div>
                </a>

                <button type="button" 
                        onclick="try { const isDark = document.documentElement.classList.toggle('dark'); localStorage.setItem('ui-theme', isDark ? 'dark' : 'light'); } catch(_) {}"
                        class="w-8 h-8 flex items-center justify-center rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400 transition-colors duration-150 shrink-0"
                        aria-label="Mode Terang/Gelap"
                        title="Ganti Tema">
                    <svg class="w-4 h-4 hidden dark:block text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <svg class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>
            </div>
        </aside>

        {{-- =========================================================
             2. MAIN CONTENT AREA (dengan Desktop TopBar & Mobile Header)
             ========================================================= --}}
        <div class="flex-1 flex flex-col min-w-0 lg:ml-64 pb-20 lg:pb-8 transition-colors">
            {{-- Desktop TopBar --}}
            <header class="hidden lg:flex items-center justify-between h-16 px-8 border-b sticky top-0 z-30 shrink-0 transition-theme"
                    style="background-color: var(--topbar-bg); border-color: var(--topbar-border);">
                <div>
                    <h1 class="font-bold text-slate-900 dark:text-slate-100 text-base leading-tight">
                        {{ $title ?? 'Dashboard' }}
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        {{ $roleSubtitles[$role] ?? 'MTs Soebono Mantofani' }}
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    {{-- 2FA Badge for Staff --}}
                    @if(in_array($role, ['bk', 'master']))
                        <a href="{{ route('two-factor.setup') }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition">
                            <svg class="w-3.5 h-3.5 text-primary-600 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            <span>2FA</span>
                        </a>
                    @endif

                    {{-- Theme Toggle Desktop --}}
                    <button type="button" 
                            onclick="try { const isDark = document.documentElement.classList.toggle('dark'); localStorage.setItem('ui-theme', isDark ? 'dark' : 'light'); } catch(_) {}"
                            class="w-8 h-8 flex items-center justify-center rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400 transition-colors"
                            title="Ganti Tema">
                        <svg class="w-4 h-4 hidden dark:block text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <svg class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </button>

                    {{-- Notifikasi Lonceng --}}
                    <a href="{{ route('notifications.index') }}" 
                       class="relative w-9 h-9 flex items-center justify-center rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-300 transition-colors" 
                       title="Notifikasi">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        @if($unreadNotifCount > 0)
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-primary-600 rounded-full"></span>
                        @endif
                    </a>

                    {{-- Profile avatar link --}}
                    <a href="{{ $role === 'siswa' ? route('siswa.profile') : ($role === 'bk' ? route('bk.profile.show') : route('master.settings.index')) }}" 
                       class="flex items-center gap-2.5 ml-1 px-2.5 py-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                       title="Profil">
                        <div class="w-7 h-7 {{ $role === 'master' ? 'bg-slate-800 dark:bg-slate-700' : 'bg-primary-600' }} rounded-full flex items-center justify-center">
                            <span class="text-xs font-bold text-white">{{ $initials }}</span>
                        </div>
                        <div class="hidden xl:block">
                            <p class="text-xs font-semibold text-slate-900 dark:text-slate-100">{{ $user->name ?? 'User' }}</p>
                        </div>
                    </a>

                    {{-- Tombol Keluar (Button Keluar) --}}
                    <form method="POST" action="{{ route('logout') }}" class="inline-flex shrink-0">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 h-8 rounded-xl text-xs font-bold text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 dark:hover:bg-rose-900/40 border border-rose-200/80 dark:border-rose-900/60 transition-colors shadow-2xs cursor-pointer"
                                title="Keluar dari Akun">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </header>

            {{-- Mobile Sticky Top Header (Sesuai AppHeader.tsx) --}}
            <header class="lg:hidden sticky top-0 z-30 border-b transition-theme"
                    style="background-color: var(--topbar-bg); border-color: var(--topbar-border);">
                <div class="px-4 h-14 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <button type="button" 
                                @click="mobileMenuOpen = !mobileMenuOpen" 
                                class="p-1.5 -ml-1 text-slate-600 dark:text-slate-300 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" 
                                aria-label="Buka Menu Drawer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <a href="{{ url('/dashboard') }}" class="flex items-center gap-2.5 group">
                            <img src="{{ asset('logo-sekolah.png') }}" alt="Logo" class="w-10 h-10 object-contain shrink-0" />
                            <span class="font-bold text-sm text-slate-900 dark:text-slate-100 leading-tight">
                                SIPERKA
                            </span>
                        </a>
                    </div>

                    <div class="flex items-center gap-0.5">
                        {{-- Toggle Theme Mobile --}}
                        <button type="button" 
                                onclick="try { const isDark = document.documentElement.classList.toggle('dark'); localStorage.setItem('ui-theme', isDark ? 'dark' : 'light'); } catch(_) {}"
                                class="w-8 h-8 flex items-center justify-center rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400 transition-colors"
                                aria-label="Ganti Tema">
                            <svg class="w-4 h-4 hidden dark:block text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <svg class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        </button>

                        {{-- Notifikasi Lonceng Mobile --}}
                        <a href="{{ route('notifications.index') }}" 
                           class="relative w-8 h-8 flex items-center justify-center rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400 transition-colors" 
                           aria-label="Notifikasi">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            @if($unreadNotifCount > 0)
                                <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 bg-primary-500 rounded-full"></span>
                            @endif
                        </a>

                        {{-- User Avatar Link --}}
                        <a href="{{ $role === 'siswa' ? route('siswa.profile') : ($role === 'bk' ? route('bk.profile.show') : route('master.settings.index')) }}" 
                           class="w-7 h-7 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center ml-1 text-xs font-bold text-primary-700 dark:text-primary-400">
                            {{ $initials }}
                        </a>
                    </div>
                </div>
            </header>

            {{-- Mobile Drawer Backdrop & Menu --}}
            <div x-show="mobileMenuOpen" 
                 @click="mobileMenuOpen = false" 
                 class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs lg:hidden"
                 x-transition:enter="transition-opacity ease-linear duration-150"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 style="display: none;"></div>

            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-200 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-150 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-[#14201A] border-r border-slate-200 dark:border-[#22342A] p-5 flex flex-col justify-between lg:hidden shadow-xl"
                 style="display: none;">
                <div>
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800 mb-4">
                        <div class="flex items-center gap-2.5">
                            <img src="{{ asset('logo-sekolah.png') }}" alt="Logo" class="w-10 h-10 object-contain shrink-0" />
                            <div>
                                <span class="block font-black text-sm text-slate-900 dark:text-slate-100">SIPERKA</span>
                                <span class="block text-[11px] text-slate-500 dark:text-slate-400 font-semibold">{{ $roleLabels[$role] ?? $role }}</span>
                            </div>
                        </div>
                        <button type="button" @click="mobileMenuOpen = false" class="p-1.5 rounded-xl text-slate-400 hover:text-slate-700 dark:hover:text-slate-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div class="flex flex-col gap-1 text-sm font-semibold text-slate-700 dark:text-slate-200">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 px-2 py-1">Menu Utama</p>
                        @if ($role === 'siswa')
                            <a href="{{ route('siswa.dashboard') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Beranda</a>
                            <a href="{{ route('siswa.reports.create') }}" class="px-3 py-2 rounded-xl text-primary-600 dark:text-[#5AE39D] font-bold hover:bg-primary-50 dark:hover:bg-primary-950/40">Buat Laporan Baru</a>
                            <a href="{{ route('siswa.reports.index') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Laporan Saya</a>
                            <a href="{{ route('siswa.help') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Bantuan & Kontak</a>
                            <a href="{{ route('siswa.profile') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Profil Akun</a>
                        @elseif ($role === 'bk')
                            <a href="{{ route('bk.dashboard') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Dashboard</a>
                            <a href="{{ route('bk.reports.index') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Laporan Masuk</a>
                            <a href="{{ route('bk.statistics.index') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Statistik Kasus</a>
                            <a href="{{ route('bk.categories.index') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Kategori Kasus</a>
                            <a href="{{ route('bk.reports.download.view') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Unduh Laporan</a>
                            <a href="{{ route('periodic-reports.index') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Laporan Periodik</a>
                            <a href="{{ route('two-factor.setup') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Keamanan 2FA</a>
                            <a href="{{ route('bk.profile.show') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Profil Konselor</a>
                        @elseif ($role === 'master')
                            <a href="{{ route('master.dashboard') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Dashboard</a>
                            <a href="{{ route('master.students.index') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Akun Siswa</a>
                            <a href="{{ route('master.bk-users.index') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Akun Guru BK</a>
                            <a href="{{ route('master.import.index') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Impor Excel</a>
                            <a href="{{ route('master.classes.index') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Master Kelas</a>
                            <a href="{{ route('master.academic-years.index') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Tahun Ajaran</a>
                            <a href="{{ route('master.class-operations.index') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Kenaikan Kelas</a>
                            <a href="{{ route('periodic-reports.index') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Laporan Periodik</a>
                            <a href="{{ route('master.activity-logs.index') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Log Aktivitas</a>
                            <a href="{{ route('master.settings.index') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Pengaturan Web</a>
                            <a href="{{ route('two-factor.setup') }}" class="px-3 py-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800">Keamanan 2FA</a>
                        @endif
                        <a href="{{ route('password.change') }}" class="px-3 py-2 rounded-xl text-slate-500 hover:text-slate-900 dark:hover:text-white">Ganti Kata Sandi</a>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl text-xs font-bold text-red-600 bg-red-50 dark:bg-red-950/40 hover:bg-red-100 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span>Keluar dari Akun</span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Main Content Slot --}}
            <main class="flex-1 w-full min-w-0">
                {{-- Flash Message Helper for SweetAlert2 --}}
                <div id="sisperka-flash-messages" class="hidden"
                    @if(session('success')) data-success="{{ session('success') }}" @endif
                    @if(session('error')) data-error="{{ session('error') }}" @endif
                    @if(session('status')) data-status="{{ session('status') }}" @endif
                    @if(session('warning')) data-warning="{{ session('warning') }}" @endif
                ></div>

                {{-- Alert Notification Banner --}}
                @if (session('status') || session('success') || session('error') || session('warning') || session('info'))
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
                        @if (session('info'))
                            <x-alert type="info" :message="session('info')" />
                        @endif
                    </div>
                @endif

                {{-- Page Body --}}
                <div class="w-full">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    {{-- =========================================================
         3. MOBILE BOTTOM NAVIGATION (Sesuai BottomNavigation.tsx, GBKBottomNav.tsx, AdminBottomNav.tsx)
         ========================================================= --}}
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 z-40 border-t transition-theme" 
         style="background-color: var(--topbar-bg); border-color: var(--topbar-border);"
         aria-label="Navigasi Bawah Mobile">
        @if ($role === 'siswa')
            @php
                $isHome = request()->routeIs('siswa.dashboard');
                $isReports = request()->routeIs('siswa.reports.*');
                $isProfile = request()->routeIs('siswa.profile');
            @endphp
            <div class="max-w-sm mx-auto px-4 flex items-center justify-around h-16">
                {{-- Beranda --}}
                <a href="{{ route('siswa.dashboard') }}" 
                   class="flex flex-col items-center gap-1 py-1 px-4 min-w-[60px] relative transition-colors duration-150"
                   aria-current="{{ $isHome ? 'page' : 'false' }}">
                    @if ($isHome)
                        <span class="absolute -top-0.5 left-1/2 -translate-x-1/2 w-8 h-1 bg-primary-600 rounded-full"></span>
                    @endif
                    <svg class="w-5 h-5 transition-all duration-150 {{ $isHome ? 'text-primary-600 scale-110' : 'text-slate-500 dark:text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span class="text-[10px] font-semibold {{ $isHome ? 'text-primary-600' : 'text-slate-500 dark:text-slate-400' }}">Beranda</span>
                </a>

                {{-- Laporan --}}
                <a href="{{ route('siswa.reports.index') }}" 
                   class="flex flex-col items-center gap-1 py-1 px-4 min-w-[60px] relative transition-colors duration-150"
                   aria-current="{{ $isReports ? 'page' : 'false' }}">
                    @if ($isReports)
                        <span class="absolute -top-0.5 left-1/2 -translate-x-1/2 w-8 h-1 bg-primary-600 rounded-full"></span>
                    @endif
                    <svg class="w-5 h-5 transition-all duration-150 {{ $isReports ? 'text-primary-600 scale-110' : 'text-slate-500 dark:text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span class="text-[10px] font-semibold {{ $isReports ? 'text-primary-600' : 'text-slate-500 dark:text-slate-400' }}">Laporan</span>
                </a>

                {{-- Profil --}}
                <a href="{{ route('siswa.profile') }}" 
                   class="flex flex-col items-center gap-1 py-1 px-4 min-w-[60px] relative transition-colors duration-150"
                   aria-current="{{ $isProfile ? 'page' : 'false' }}">
                    @if ($isProfile)
                        <span class="absolute -top-0.5 left-1/2 -translate-x-1/2 w-8 h-1 bg-primary-600 rounded-full"></span>
                    @endif
                    <svg class="w-5 h-5 transition-all duration-150 {{ $isProfile ? 'text-primary-600 scale-110' : 'text-slate-500 dark:text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span class="text-[10px] font-semibold {{ $isProfile ? 'text-primary-600' : 'text-slate-500 dark:text-slate-400' }}">Profil</span>
                </a>
            </div>

        @elseif ($role === 'bk')
            @php
                $isBkHome = request()->routeIs('bk.dashboard');
                $isBkRep = request()->routeIs('bk.reports.*');
                $isBkNotif = request()->routeIs('notifications.*');
                $isBkProf = request()->routeIs('bk.profile.*');
            @endphp
            <div class="flex items-center justify-around px-2 h-16">
                <a href="{{ route('bk.dashboard') }}" 
                   class="flex flex-col items-center gap-1 py-2 px-3 rounded-2xl transition-colors duration-150 relative {{ $isBkHome ? 'text-primary-600' : 'text-slate-600 dark:text-slate-400 hover:text-slate-700' }}">
                    <svg class="w-5 h-5 {{ $isBkHome ? 'scale-110' : '' }} transition-transform duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span class="text-[10px] font-semibold">Dashboard</span>
                </a>

                <a href="{{ route('bk.reports.index') }}" 
                   class="flex flex-col items-center gap-1 py-2 px-3 rounded-2xl transition-colors duration-150 relative {{ $isBkRep ? 'text-primary-600' : 'text-slate-600 dark:text-slate-400 hover:text-slate-700' }}">
                    <svg class="w-5 h-5 {{ $isBkRep ? 'scale-110' : '' }} transition-transform duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    <span class="text-[10px] font-semibold">Laporan</span>
                </a>

                <a href="{{ route('notifications.index') }}" 
                   class="flex flex-col items-center gap-1 py-2 px-3 rounded-2xl transition-colors duration-150 relative {{ $isBkNotif ? 'text-primary-600' : 'text-slate-600 dark:text-slate-400 hover:text-slate-700' }}">
                    <div class="relative">
                        <svg class="w-5 h-5 {{ $isBkNotif ? 'scale-110' : '' }} transition-transform duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        @if($unreadNotifCount > 0)
                            <span class="absolute -top-1 -right-1.5 min-w-[16px] h-4 px-1 bg-primary-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center">
                                {{ $unreadNotifCount > 99 ? '99+' : $unreadNotifCount }}
                            </span>
                        @endif
                    </div>
                    <span class="text-[10px] font-semibold">Notifikasi</span>
                </a>

                <a href="{{ route('bk.profile.show') }}" 
                   class="flex flex-col items-center gap-1 py-2 px-3 rounded-2xl transition-colors duration-150 relative {{ $isBkProf ? 'text-primary-600' : 'text-slate-600 dark:text-slate-400 hover:text-slate-700' }}">
                    <svg class="w-5 h-5 {{ $isBkProf ? 'scale-110' : '' }} transition-transform duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span class="text-[10px] font-semibold">Profil</span>
                </a>
            </div>

        @elseif ($role === 'master')
            @php
                $isMHome = request()->routeIs('master.dashboard');
                $isMStd = request()->routeIs('master.students.*');
                $isMBk = request()->routeIs('master.bk-users.*');
                $isMNotif = request()->routeIs('notifications.*');
                $isMSettings = request()->routeIs('master.settings.*');
            @endphp
            <div class="flex items-center justify-around px-1 h-16">
                <a href="{{ route('master.dashboard') }}" 
                   class="flex flex-col items-center gap-1 py-2 px-2.5 rounded-2xl transition-colors duration-150 relative {{ $isMHome ? 'text-primary-600' : 'text-slate-600 dark:text-slate-400 hover:text-slate-700' }}">
                    <svg class="w-5 h-5 {{ $isMHome ? 'scale-110' : '' }} transition-transform duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span class="text-[10px] font-semibold">Dashboard</span>
                </a>

                <a href="{{ route('master.students.index') }}" 
                   class="flex flex-col items-center gap-1 py-2 px-2.5 rounded-2xl transition-colors duration-150 relative {{ $isMStd ? 'text-primary-600' : 'text-slate-600 dark:text-slate-400 hover:text-slate-700' }}">
                    <svg class="w-5 h-5 {{ $isMStd ? 'scale-110' : '' }} transition-transform duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span class="text-[10px] font-semibold">Siswa</span>
                </a>

                <a href="{{ route('master.bk-users.index') }}" 
                   class="flex flex-col items-center gap-1 py-2 px-2.5 rounded-2xl transition-colors duration-150 relative {{ $isMBk ? 'text-primary-600' : 'text-slate-600 dark:text-slate-400 hover:text-slate-700' }}">
                    <svg class="w-5 h-5 {{ $isMBk ? 'scale-110' : '' }} transition-transform duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span class="text-[10px] font-semibold">Guru BK</span>
                </a>

                <a href="{{ route('notifications.index') }}" 
                   class="flex flex-col items-center gap-1 py-2 px-2.5 rounded-2xl transition-colors duration-150 relative {{ $isMNotif ? 'text-primary-600' : 'text-slate-600 dark:text-slate-400 hover:text-slate-700' }}">
                    <div class="relative">
                        <svg class="w-5 h-5 {{ $isMNotif ? 'scale-110' : '' }} transition-transform duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        @if($unreadNotifCount > 0)
                            <span class="absolute -top-1 -right-1.5 min-w-[15px] h-4 px-1 bg-primary-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center">
                                {{ $unreadNotifCount > 99 ? '99+' : $unreadNotifCount }}
                            </span>
                        @endif
                    </div>
                    <span class="text-[10px] font-semibold">Notifikasi</span>
                </a>

                <a href="{{ route('master.settings.index') }}" 
                   class="flex flex-col items-center gap-1 py-2 px-2.5 rounded-2xl transition-colors duration-150 relative {{ $isMSettings ? 'text-primary-600' : 'text-slate-600 dark:text-slate-400 hover:text-slate-700' }}">
                    <svg class="w-5 h-5 {{ $isMSettings ? 'scale-110' : '' }} transition-transform duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="text-[10px] font-semibold">Setting</span>
                </a>
            </div>
        @endif
    </nav>
</body>
</html>
