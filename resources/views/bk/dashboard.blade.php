<x-layouts.app title="Dashboard Guru BK">
    <div class="space-y-6">
        {{-- Sambutan Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-slate-200">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <x-badge variant="info">Guru Bimbingan & Konseling</x-badge>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                    Selamat datang, {{ auth()->user()->name }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Panel penanganan laporan dan pendampingan peserta didik MTs Soebono Mantofani.
                </p>
            </div>
        </div>

        {{-- Ringkasan Info Guru BK --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <x-card class="p-4!">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Peran</span>
                <span class="text-xl font-bold text-slate-900 mt-1 block">Guru BK</span>
                <span class="text-xs text-slate-400 mt-1 block">Konseling & Penanganan</span>
            </x-card>

            <x-card class="p-4!">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Status Akun</span>
                <span class="text-xl font-bold text-emerald-600 mt-1 block">Aktif</span>
                <span class="text-xs text-slate-400 mt-1 block">Layanan Konseling Siap</span>
            </x-card>

            <x-card class="p-4!">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">NIP / ID</span>
                <span class="text-xl font-bold text-slate-900 mt-1 block">{{ auth()->user()->login_id }}</span>
                <span class="text-xs text-slate-400 mt-1 block">Kredensial Resmi</span>
            </x-card>

            <x-card class="p-4!">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Login Terakhir</span>
                <span class="text-sm font-bold text-slate-800 mt-2 block">{{ auth()->user()->last_login_at?->format('d M Y, H:i') ?? 'Sesi ini' }}</span>
                <span class="text-xs text-slate-400 block">WIB</span>
            </x-card>
        </div>

        {{-- Area Fitur Modul Guru BK (Fase 4) --}}
        <x-card title="Daftar Laporan Masuk" subtitle="Fitur penerimaan, verifikasi, dan penanganan laporan akan aktif pada Fase 4">
            <x-empty-state 
                title="Modul Guru BK Segera Hadir" 
                description="Modul daftar laporan perundungan, verifikasi, balasan siswa, dan catatan internal akan diimplementasikan pada Fase 4."
            />
        </x-card>
    </div>
</x-layouts.app>
