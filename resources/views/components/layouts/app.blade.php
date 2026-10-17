<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} - SISPERKA</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col text-slate-800 antialiased selection:bg-emerald-100 selection:text-emerald-900">
    {{-- Header Dashboard --}}
    <header class="sticky top-0 z-30 bg-white border-b border-slate-200/80 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 gap-4">
                {{-- Logo & Brand --}}
                <div class="flex items-center gap-3">
                    <a href="{{ url('/dashboard') }}" class="flex items-center gap-2.5 focus:outline-none focus:ring-2 focus:ring-emerald-500 rounded-lg p-1">
                        <div class="w-9 h-9 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-bold text-sm shadow-xs">
                            S
                        </div>
                        <div class="hidden sm:block">
                            <span class="block font-bold text-sm text-slate-900 leading-tight">SISPERKA</span>
                            <span class="block text-[11px] text-slate-500 font-medium leading-none">MTs Soebono Mantofani</span>
                        </div>
                    </a>

                    {{-- Peran Akun --}}
                    @auth
                        @php
                            $role = auth()->user()->role ?? 'siswa';
                            $roleLabels = [
                                'master' => 'Master Admin',
                                'bk' => 'Guru BK',
                                'siswa' => 'Siswa',
                            ];
                            $roleColors = [
                                'master' => 'bg-purple-100 text-purple-800 border-purple-200',
                                'bk' => 'bg-sky-100 text-sky-800 border-sky-200',
                                'siswa' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                            ];
                        @endphp
                        <span class="hidden md:inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $roleColors[$role] ?? 'bg-slate-100 text-slate-700' }}">
                            {{ $roleLabels[$role] ?? ucfirst($role) }}
                        </span>

                        @if($role === 'master')
                            <nav class="hidden xl:flex items-center gap-1 ml-4 text-xs font-medium text-slate-600">
                                <a href="{{ route('master.dashboard') }}" class="px-2 py-1 rounded-md hover:bg-slate-100 hover:text-slate-900 {{ request()->routeIs('master.dashboard') ? 'bg-purple-50 text-purple-700 font-semibold' : '' }}">Dashboard</a>
                                <a href="{{ route('master.students.index') }}" class="px-2 py-1 rounded-md hover:bg-slate-100 hover:text-slate-900 {{ request()->routeIs('master.students.*') ? 'bg-purple-50 text-purple-700 font-semibold' : '' }}">Siswa</a>
                                <a href="{{ route('master.bk-users.index') }}" class="px-2 py-1 rounded-md hover:bg-slate-100 hover:text-slate-900 {{ request()->routeIs('master.bk-users.*') ? 'bg-purple-50 text-purple-700 font-semibold' : '' }}">Guru BK</a>
                                <a href="{{ route('master.import.index') }}" class="px-2 py-1 rounded-md hover:bg-slate-100 hover:text-slate-900 {{ request()->routeIs('master.import.*') ? 'bg-purple-50 text-purple-700 font-semibold' : '' }}">Impor</a>
                                <a href="{{ route('master.class-operations.index') }}" class="px-2 py-1 rounded-md hover:bg-slate-100 hover:text-slate-900 {{ request()->routeIs('master.class-operations.*') ? 'bg-purple-50 text-purple-700 font-semibold' : '' }}">Operasi Kelas</a>
                                <a href="{{ route('master.classes.index') }}" class="px-2 py-1 rounded-md hover:bg-slate-100 hover:text-slate-900 {{ request()->routeIs('master.classes.*') ? 'bg-purple-50 text-purple-700 font-semibold' : '' }}">Kelas</a>
                                <a href="{{ route('master.academic-years.index') }}" class="px-2 py-1 rounded-md hover:bg-slate-100 hover:text-slate-900 {{ request()->routeIs('master.academic-years.*') ? 'bg-purple-50 text-purple-700 font-semibold' : '' }}">Tahun Ajaran</a>
                                <a href="{{ route('master.activity-logs.index') }}" class="px-2 py-1 rounded-md hover:bg-slate-100 hover:text-slate-900 {{ request()->routeIs('master.activity-logs.*') ? 'bg-purple-50 text-purple-700 font-semibold' : '' }}">Log</a>
                            </nav>
                        @endif
                    @endauth
                </div>

                {{-- Action Navigasi Kanan --}}
                <div class="flex items-center gap-2 sm:gap-3">
                    {{-- Tombol Keluar Cepat (Prioritas keamanan siswa) --}}
                    <a href="https://www.google.com" 
                       rel="noopener noreferrer" 
                       title="Langsung mengalihkan ke situs netral demi keselamatanmu"
                       class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium text-slate-600 hover:text-rose-600 hover:bg-rose-50 border border-slate-200 hover:border-rose-200 rounded-lg transition active:scale-[0.98]">
                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="hidden sm:inline">Keluar Cepat</span>
                    </a>

                    {{-- Notifikasi Lonceng --}}
                    @auth
                        <a href="{{ url('/notifikasi') }}" 
                           class="relative p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-emerald-500"
                           title="Notifikasi dalam website">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            {{-- Titik Notifikasi (dummy atau dynamic) --}}
                            @if(isset($unreadNotificationCount) && $unreadNotificationCount > 0)
                                <span class="absolute top-1.5 right-1.5 flex h-2 w-2">
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-600"></span>
                                </span>
                            @endif
                        </a>
                    @endauth

                    {{-- Menu Pengguna --}}
                    @auth
                        <div class="flex items-center gap-2 pl-2 border-l border-slate-200">
                            <div class="text-right hidden sm:block">
                                <span class="block text-xs font-semibold text-slate-900 leading-tight">{{ auth()->user()->name ?? 'Pengguna' }}</span>
                                <span class="block text-[11px] text-slate-500 leading-tight">{{ auth()->user()->login_id ?? '' }}</span>
                            </div>

                            <form method="POST" action="{{ url('/logout') }}" class="inline">
                                @csrf
                                <button type="submit" 
                                        title="Keluar dari akun"
                                        class="p-2 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-rose-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span class="sr-only">Keluar</span>
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
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

    {{-- Konten Utama Dashboard --}}
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        {{ $slot }}
    </main>

    {{-- Footer Mini --}}
    <footer class="bg-white border-t border-slate-200/80 py-4 text-center text-xs text-slate-500 mt-auto">
        <div class="max-w-7xl mx-auto px-4">
            <span>SISPERKA MTs Soebono Mantofani &bull; Ruang Aman & Rahasia</span>
        </div>
    </footer>
</body>
</html>
