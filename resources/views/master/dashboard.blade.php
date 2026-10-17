<x-layouts.app title="Dashboard Master Admin">
    <div class="space-y-6">
        {{-- Sambutan Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-slate-200">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <x-badge variant="purple">Master Administrator</x-badge>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                    Selamat datang, {{ auth()->user()->name }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Panel administrasi sistem pelaporan dan pengelolaan data pengguna MTs Soebono Mantofani.
                </p>
            </div>
        </div>

        {{-- Pemberitahuan Hak Akses Master --}}
        <div class="p-4 rounded-xl bg-purple-50/60 border border-purple-200/80 text-xs text-purple-900 leading-relaxed flex items-start gap-3">
            <svg class="w-5 h-5 text-purple-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <strong class="font-semibold block mb-0.5">Kebijakan Privasi Akun Master:</strong>
                Sesuai aturan keamanan SISPERKA, akun Master mengelola akun pengguna dan statistik agregat, serta <strong>tidak memiliki hak akses</strong> untuk melihat isi laporan maupun identitas pelapor.
            </div>
        </div>

        {{-- Kartu Ringkasan Kerangka --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <x-card class="p-4!">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Peran Anda</span>
                <span class="text-xl font-bold text-slate-900 mt-1 block">Master Admin</span>
                <span class="text-xs text-slate-400 mt-1 block">Akses Manajemen Pengguna</span>
            </x-card>

            <x-card class="p-4!">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Status Akun</span>
                <span class="text-xl font-bold text-emerald-600 mt-1 block">Aktif</span>
                <span class="text-xs text-slate-400 mt-1 block">Telah terverifikasi</span>
            </x-card>

            <x-card class="p-4!">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">ID Masuk</span>
                <span class="text-xl font-bold text-slate-900 mt-1 block">{{ auth()->user()->login_id }}</span>
                <span class="text-xs text-slate-400 mt-1 block">Username Master</span>
            </x-card>

            <x-card class="p-4!">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Login Terakhir</span>
                <span class="text-sm font-bold text-slate-800 mt-2 block">{{ auth()->user()->last_login_at?->format('d M Y, H:i') ?? 'Sesi ini' }}</span>
                <span class="text-xs text-slate-400 block">WIB</span>
            </x-card>
        </div>

        {{-- Area Fitur Modul Master (Fase 2) --}}
        <x-card title="Menu Administrasi" subtitle="Fitur manajemen akun dan data madrasah akan aktif pada Fase 2">
            <x-empty-state 
                title="Modul Master Segera Hadir" 
                description="Modul manajemen akun Guru BK, Siswa, impor Excel, dan kenaikan kelas akan diimplementasikan pada Fase 2."
            />
        </x-card>
    </div>
</x-layouts.app>
