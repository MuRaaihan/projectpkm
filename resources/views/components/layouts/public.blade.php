<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SISPERKA - Sistem Pelaporan Perundungan MTs Soebono Mantofani' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col text-slate-800 antialiased selection:bg-emerald-100 selection:text-emerald-900">
    {{-- Header Publik --}}
    <header class="sticky top-0 z-30 bg-white/95 backdrop-blur border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20 gap-4">
                {{-- Brand --}}
                <a href="{{ url('/') }}" class="flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-emerald-500 rounded-lg p-1">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-lg shadow-sm shadow-emerald-600/20 group-hover:bg-emerald-700 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <span class="block font-bold text-base sm:text-lg text-slate-900 tracking-tight leading-tight">SISPERKA</span>
                        <span class="block text-xs text-slate-500 font-medium leading-none">MTs Soebono Mantofani</span>
                    </div>
                </a>

                {{-- Action Navigasi --}}
                <div class="flex items-center gap-2 sm:gap-3">
                    {{-- Tombol Keluar Cepat --}}
                    <a href="https://www.google.com" 
                       rel="noopener noreferrer" 
                       title="Langsung menutup halaman ini dan membuka halaman netral demi keamananmu"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs sm:text-sm font-medium text-slate-600 hover:text-rose-600 hover:bg-rose-50 border border-slate-200 hover:border-rose-200 rounded-lg transition active:scale-[0.98]">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Keluar Cepat</span>
                    </a>

                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-sm transition active:scale-[0.98]">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ url('/login') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-sm transition active:scale-[0.98]">
                            Masuk
                        </a>
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

    {{-- Konten Utama --}}
    <main class="flex-1 w-full">
        {{ $slot }}
    </main>

    {{-- Footer Publik --}}
    <footer class="bg-white border-t border-slate-200/80 mt-auto text-sm text-slate-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-bold text-xs">
                            S
                        </div>
                        <span class="font-bold text-slate-900 tracking-tight">SISPERKA</span>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed mb-4">
                        Sistem Pelaporan Perundungan resmi MTs Soebono Mantofani. Ruang aman, rahasia, dan terpercaya bagi seluruh peserta didik madrasah.
                    </p>
                    <p class="text-xs text-slate-400">
                        &copy; {{ date('Y') }} MTs Soebono Mantofani. Seluruh hak cipta dilindungi.
                    </p>
                </div>

                <div>
                    <h3 class="font-semibold text-slate-900 text-xs uppercase tracking-wider mb-3">Layanan Konseling & Bantuan</h3>
                    <p class="text-xs text-slate-600 mb-2">
                        <span class="font-medium text-slate-700">Ruang Layanan:</span> Kantor Bimbingan & Konseling (BK) MTs Soebono Mantofani
                    </p>
                    <p class="text-xs text-slate-600 mb-2">
                        <span class="font-medium text-slate-700">Jam Layanan:</span> Senin – Jumat, 07.30 – 14.30 WIB
                    </p>
                    <p class="text-xs text-slate-500 italic">
                        *Laporan darurat di luar jam madrasah dapat disampaikan melalui wali kelas atau kontak darurat.
                    </p>
                </div>

                <div>
                    <h3 class="font-semibold text-slate-900 text-xs uppercase tracking-wider mb-3">Keamanan & Kebijakan</h3>
                    <ul class="space-y-2 text-xs">
                        <li>
                            <a href="{{ url('/kebijakan-privasi') }}" class="text-emerald-700 hover:text-emerald-800 underline underline-offset-2">
                                Kebijakan Privasi & Batas Kerahasiaan
                            </a>
                        </li>
                        <li class="text-slate-500">
                            Setiap laporan dilindungi kerahasiaannya sesuai ketentuan madrasah dan Permendikbudristek No. 46 Tahun 2023.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
