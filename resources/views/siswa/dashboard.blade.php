<x-layouts.app title="Dashboard Siswa">
    <div class="space-y-6">
        {{-- Sambutan Ramah Anak --}}
        <div class="bg-gradient-to-r from-emerald-600 to-teal-700 rounded-2xl p-6 sm:p-8 text-white shadow-sm relative overflow-hidden">
            <div class="relative z-10 max-w-2xl">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-white/20 text-white backdrop-blur-xs mb-3">
                    Ruang Aman Peserta Didik
                </span>
                <h1 class="text-xl sm:text-3xl font-bold tracking-tight text-white mb-2">
                    Halo, {{ auth()->user()->name }}
                </h1>
                <p class="text-xs sm:text-sm text-emerald-50 leading-relaxed">
                    Jangan takut bersuara. Jika kamu atau temanmu mengalami atau melihat tindakan perundungan (bullying), ceritakan kepada kami di sini. Identitasmu dapat dirahasiakan dan selalu dilindungi.
                </p>
                <div class="mt-5 flex flex-wrap items-center gap-3">
                    <a href="{{ url('/siswa/buat-laporan') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-emerald-900 bg-white hover:bg-emerald-50 rounded-lg shadow-xs transition active:scale-[0.98]">
                        <svg class="w-4 h-4 mr-1.5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Buat Laporan Baru
                    </a>
                </div>
            </div>

            {{-- Dekorasi Latar Lembut --}}
            <div class="absolute -right-12 -bottom-12 w-64 h-64 rounded-full bg-white/10 pointer-events-none blur-2xl"></div>
        </div>

        {{-- Kartu Info Profil Siswa --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-card class="p-4!">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Nomor Induk Siswa (NIS)</span>
                <span class="text-xl font-bold text-slate-900 mt-1 block">{{ auth()->user()->login_id }}</span>
                <span class="text-xs text-slate-400 mt-1 block">ID Resmi Madrasah</span>
            </x-card>

            <x-card class="p-4!">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Kelas</span>
                <span class="text-xl font-bold text-slate-900 mt-1 block">{{ auth()->user()->schoolClass?->name ?? 'Belum Ditentukan' }}</span>
                <span class="text-xs text-slate-400 mt-1 block">MTs Soebono Mantofani</span>
            </x-card>

            <x-card class="p-4!">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Status Akun</span>
                <span class="text-xl font-bold text-emerald-600 mt-1 block">Aktif</span>
                <span class="text-xs text-slate-400 mt-1 block">Terdaftar resmi</span>
            </x-card>
        </div>

        {{-- Area Riwayat Laporan (Fase 3) --}}
        <x-card title="Riwayat Laporan Kamu" subtitle="Daftar laporan perundungan yang pernah kamu kirimkan">
            <x-empty-state 
                title="Belum ada laporan yang dikirim" 
                description="Ketika kamu mengirimkan laporan perundungan, riwayat dan balasan dari Guru BK akan tampil di halaman ini."
            >
                <div class="text-xs text-slate-400 italic">
                    *Fitur pengiriman laporan lengkap akan aktif pada Fase 3.
                </div>
            </x-empty-state>
        </x-card>
    </div>
</x-layouts.app>
