<x-layouts.app title="Dashboard Siswa">
    <div class="px-4 py-5 sm:px-6 sm:py-6 flex flex-col gap-6 max-w-5xl w-full mx-auto lg:px-8 lg:py-8 animate-fade-in">
        {{-- ── Greeting & Action Banner (Sesuai Dashboard Screen 02) ── --}}
        <section aria-labelledby="greeting-heading" class="animate-slide-up">
            <div class="relative overflow-hidden bg-gradient-to-br from-[#EAF5EE] via-white to-[#F0EFE8] dark:from-[#13241C] dark:via-[#16231D] dark:to-[#0E1713] border border-slate-300/80 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xs">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="max-w-xl">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-primary-100/90 dark:bg-primary-950/70 text-primary-800 dark:text-primary-300 text-xs font-bold mb-3.5 border border-primary-300/80 dark:border-primary-800/80 shadow-2xs">
                            <span class="w-2 h-2 rounded-full bg-primary-600 dark:bg-[#5AE39D]"></span>
                            <span>Ruang Aman Siswa SIPERKA</span>
                        </div>
                        <h1 id="greeting-heading" class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">
                            Halo, {{ auth()->user()->name }}
                        </h1>
                        <p class="text-sm text-slate-600 dark:text-slate-300 mt-2 leading-relaxed">
                            Kamu tidak sendirian. Suaramu sangat berarti untuk menciptakan lingkungan sekolah yang aman dan saling menghargai. Setiap aduan ditangani langsung oleh Guru BK secara rahasia.
                        </p>

                        <div class="flex flex-wrap items-center gap-4 mt-4 pt-4 border-t border-slate-200/80 dark:border-slate-800/80 text-xs text-slate-500 dark:text-slate-400">
                            <span class="flex items-center gap-1.5 font-medium">
                                <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                Kerahasiaan Identitas & Data Pribadi Terjamin
                            </span>
                            <span class="flex items-center gap-1.5 font-medium">
                                <svg class="w-3.5 h-3.5 text-primary-600 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                Tersedia Opsi Pengirim Anonim
                            </span>
                        </div>
                    </div>

                    {{-- Desktop banner CTA button --}}
                    <div class="shrink-0 flex flex-col gap-2.5">
                        <a href="{{ route('siswa.reports.create') }}" 
                           class="bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white rounded-2xl px-6 py-4 flex items-center justify-between gap-5 shadow-sm hover:shadow-md card-hover group cursor-pointer transition-all border border-primary-700/60">
                            <div class="flex items-center gap-3.5">
                                <div class="w-11 h-11 rounded-xl bg-[#B8E34B] text-[#176B4D] flex items-center justify-center font-bold shadow-xs group-hover:scale-105 transition-transform">
                                    <svg class="w-6 h-6 text-[#176B4D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-base font-extrabold text-white leading-tight">Buat Laporan Baru</p>
                                    <p class="text-xs text-emerald-100 font-medium mt-0.5">Bisa pilih opsi anonim</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-emerald-200 group-hover:translate-x-1.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        <p class="text-[11px] text-center text-slate-500 dark:text-slate-400">
                            Guru BK merespon laporan dalam 1x24 jam kerja
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── Summary & Status Overview (Asymmetrical Composition Sesuai Frontend) ── --}}
        <section aria-labelledby="summary-heading" class="animate-slide-up stagger-1">
            <div class="flex items-center justify-between mb-4">
                <h2 id="summary-heading" class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    Ringkasan Status Kasus
                </h2>
                <span class="text-xs text-primary-600 dark:text-[#5AE39D] font-bold">
                    Terhubung dengan Ruang BK
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                {{-- Main Total Card - 5 cols --}}
                <div class="md:col-span-5 bg-surface-card dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                Total Laporan Diajukan
                            </span>
                            <div class="w-10 h-10 rounded-xl bg-primary-50 dark:bg-primary-950/60 border border-primary-200/60 dark:border-primary-800/60 text-primary-700 dark:text-primary-300 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                        </div>
                        <p class="text-4xl font-black text-slate-900 dark:text-slate-100 tabular-nums">
                            {{ $total_reports }}
                        </p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">
                            Seluruh aduan yang tersimpan aman dalam akun Anda
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                        <span>Terakhir diperbarui</span>
                        <span class="font-semibold text-slate-700 dark:text-slate-300">Hari ini</span>
                    </div>
                </div>

                {{-- Split Status Breakdown - 7 cols --}}
                <div class="md:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Dalam Penanganan --}}
                    <div class="bg-surface-card dark:bg-[#16231D] border border-amber-200/80 dark:border-amber-900/50 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-bold uppercase tracking-wider text-amber-800 dark:text-amber-400">
                                    Dalam Penanganan
                                </span>
                                <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800 text-amber-700 dark:text-[#FAD46B] flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                            </div>
                            <p class="text-3xl font-extrabold text-amber-900 dark:text-[#FAD46B] tabular-nums">
                                {{ $active_reports }}
                            </p>
                            <p class="text-xs text-slate-600 dark:text-slate-400 mt-2">
                                Laporan sedang ditelaah & didampingi Guru BK
                            </p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-amber-100 dark:border-amber-900/40">
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-amber-700 dark:text-amber-300">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                Tahap penanganan aktif
                            </span>
                        </div>
                    </div>

                    {{-- Tuntas Diselesaikan --}}
                    <div class="bg-surface-card dark:bg-[#16231D] border border-emerald-200/80 dark:border-emerald-900/50 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 dark:text-emerald-400">
                                    Tuntas Diselesaikan
                                </span>
                                <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-[#5AE39D] flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                            </div>
                            <p class="text-3xl font-extrabold text-emerald-900 dark:text-[#5AE39D] tabular-nums">
                                {{ $resolved_reports }}
                            </p>
                            <p class="text-xs text-slate-600 dark:text-slate-400 mt-2">
                                Kasus telah selesai dimediasi & ditutup
                            </p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-emerald-100 dark:border-emerald-900/40">
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-emerald-700 dark:text-emerald-300">
                                <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Pendampingan berhasil
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── Recent Report + Counselor Info Card ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-slide-up stagger-2">
            {{-- Recent Report (2 cols on lg) --}}
            <section aria-labelledby="recent-heading" class="lg:col-span-2 bg-surface-card dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4 border-b border-slate-200 dark:border-slate-800 pb-3.5">
                        <div>
                            <h2 id="recent-heading" class="text-sm font-bold text-slate-900 dark:text-slate-100">
                                Laporan Terbaru
                            </h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                Aktivitas tindak lanjut terakhir dari konselor
                            </p>
                        </div>
                        <a href="{{ route('siswa.reports.index') }}" 
                           class="text-xs text-primary-600 dark:text-[#5AE39D] font-bold hover:underline flex items-center gap-1 cursor-pointer">
                            <span>Lihat semua riwayat</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>

                    @if ($recent_reports->count() > 0)
                        @php
                            $latestReport = $recent_reports->first();
                            $statusStyle = match ($latestReport->status) {
                                'baru' => 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-200',
                                'diverifikasi' => 'bg-emerald-50 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300',
                                'diproses' => 'bg-amber-50 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300',
                                'selesai' => 'bg-emerald-100 text-emerald-900 dark:bg-emerald-900/50 dark:text-emerald-200',
                                'ditolak' => 'bg-red-50 text-red-800 dark:bg-red-950/60 dark:text-red-300',
                                default => 'bg-slate-100 text-slate-800',
                            };
                            $statusLabel = match ($latestReport->status) {
                                'baru' => 'Diterima',
                                'diverifikasi' => 'Diverifikasi',
                                'diproses' => 'Dalam Penanganan',
                                'selesai' => 'Selesai',
                                'ditolak' => 'Ditolak',
                                default => ucfirst($latestReport->status),
                            };
                        @endphp
                        <a href="{{ route('siswa.reports.show', $latestReport) }}" 
                           class="w-full text-left bg-slate-50/80 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/80 p-5
                             hover:bg-[#EAF5EE]/60 dark:hover:bg-[#163628]/50 hover:border-primary-400 dark:hover:border-primary-500
                             transition-all duration-150 cursor-pointer group rounded-2xl card-hover block">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2.5 mb-2.5">
                                        <span class="text-xs font-mono font-bold px-2.5 py-0.5 rounded-md bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-slate-200">
                                            #{{ substr($latestReport->id, 0, 8) }}
                                        </span>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusStyle }}">
                                            {{ $statusLabel }}
                                        </span>
                                        @if ($latestReport->is_hidden_identity)
                                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-500 dark:text-slate-400 bg-slate-200/60 dark:bg-slate-700/60 px-2 py-0.5 rounded-md">
                                                Anonim
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-base font-extrabold text-slate-900 dark:text-slate-100 mb-2 truncate">
                                        {{ $latestReport->category->name ?? 'Laporan Perundungan' }}
                                    </p>
                                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500 dark:text-slate-400">
                                        <span class="inline-flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            {{ $latestReport->incident_date?->translatedFormat('d M Y') ?? '-' }}
                                        </span>
                                        @if ($latestReport->location)
                                            <span class="inline-flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                {{ $latestReport->location }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="w-9 h-9 rounded-xl bg-white dark:bg-slate-700 flex items-center justify-center shrink-0 border border-slate-200 dark:border-slate-600 group-hover:bg-primary-600 group-hover:text-white transition-colors shadow-2xs">
                                    <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </div>
                            </div>
                        </a>
                    @else
                        <div class="text-center py-8 text-sm text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-800/40 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700">
                            Belum ada laporan yang diajukan.
                        </div>
                    @endif
                </div>

                <div class="mt-5 pt-3.5 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-primary-600 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        Respon Guru BK rata-rata 1x24 jam kerja
                    </span>
                </div>
            </section>

            {{-- Counselor Info Card (1 col on lg - Sesuai Frontend) --}}
            <section aria-label="Informasi keamanan dan konseling" class="flex flex-col">
                <div class="bg-[#EAF5EE] dark:bg-[#16291F] border border-[#c9e6d8] dark:border-emerald-800/70 rounded-2xl p-6 shadow-xs flex-1 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-[#176B4D] text-[#B8E34B] rounded-2xl flex items-center justify-center shrink-0 shadow-xs mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-[#176B4D] dark:text-[#5AE39D]">
                            Identitas Kamu Terlindungi Penuh
                        </h3>
                        <p class="text-xs text-slate-700 dark:text-slate-300 mt-2.5 leading-relaxed">
                            Kamu bisa memilih opsi anonim saat mengirimkan laporan. Guru BK menangani setiap aduan secara objektif, aman, dan tanpa diskriminasi.
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-[#c9e6d8]/80 dark:border-emerald-800/50">
                        <p class="text-xs font-semibold text-[#176B4D] dark:text-[#5AE39D]">
                            Butuh bantuan langsung? Kunjungi Ruang BK di lantai 2 gedung utama saat jam sekolah.
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-layouts.app>