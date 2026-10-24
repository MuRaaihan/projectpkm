<x-layouts.app title="Dashboard Siswa">
    <div class="px-4 py-5 sm:px-6 sm:py-6 flex flex-col gap-6 max-w-5xl w-full mx-auto lg:px-8 lg:py-8 animate-fade-in">
        {{-- ── Greeting & Action Banner ─────────────────────── --}}
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
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 mt-2 leading-relaxed">
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

                    {{-- Banner CTA button --}}
                    <div class="shrink-0 flex flex-col gap-2.5">
                        <a href="{{ route('siswa.reports.create') }}" 
                           class="bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white rounded-2xl px-6 py-4 flex items-center justify-between gap-5 shadow-sm hover:shadow-md card-hover group transition-all border border-primary-700/60">
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

        {{-- ── Summary & Status Overview (KPI Cards) ─────────── --}}
        <section aria-labelledby="summary-heading" class="animate-slide-up stagger-1">
            <div class="flex items-center justify-between mb-4">
                <h2 id="summary-heading" class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    Ringkasan Aduan Kamu
                </h2>
                @if ($total_reports > 0)
                    <a href="{{ route('siswa.reports.index') }}" class="text-xs font-bold text-primary-700 dark:text-[#5AE39D] hover:underline flex items-center gap-1">
                        <span>Semua Laporan ({{ $total_reports }})</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                {{-- Total --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs flex items-center justify-between card-hover">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 block">Total Laporan</span>
                        <span class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-100 mt-1 block">{{ $total_reports }}</span>
                        <span class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 block">Semua laporan terkirim</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                </div>

                {{-- Sedang Ditangani --}}
                <div class="bg-amber-50/60 dark:bg-[#261A05] rounded-2xl border border-amber-200/80 dark:border-amber-800/80 p-5 shadow-xs flex items-center justify-between card-hover">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-800 dark:text-[#FAD46B] block">Sedang Ditangani</span>
                        <span class="text-2xl sm:text-3xl font-black text-amber-950 dark:text-[#FAD46B] mt-1 block">{{ $active_reports }}</span>
                        <span class="text-[11px] text-amber-800 dark:text-amber-200/80 mt-0.5 block">Baru atau proses konseling</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-[#FAD46B] flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>

                {{-- Selesai --}}
                <div class="bg-emerald-50/60 dark:bg-[#153222] rounded-2xl border border-emerald-200/80 dark:border-emerald-800/80 p-5 shadow-xs flex items-center justify-between card-hover">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 dark:text-[#5AE39D] block">Selesai Ditangani</span>
                        <span class="text-2xl sm:text-3xl font-black text-emerald-950 dark:text-[#5AE39D] mt-1 block">{{ $resolved_reports }}</span>
                        <span class="text-[11px] text-emerald-800 dark:text-emerald-200/80 mt-0.5 block">Penanganan tuntas</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-[#5AE39D] flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── Banner Bantuan & Kontak Darurat ──────────────── --}}
        <section class="bg-surface-card dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 card-hover animate-slide-up stagger-2">
            <div class="flex items-start gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-primary-50 dark:bg-primary-950 text-primary-700 dark:text-[#5AE39D] border border-primary-200 dark:border-primary-800 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 dark:text-slate-100">Butuh bicara langsung atau bantuan darurat?</h3>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">
                        Guru BK siap mendengarkan di Ruang Konseling setiap hari sekolah. Kamu juga dapat mengakses kontak darurat nasional 24 jam.
                    </p>
                </div>
            </div>
            <a href="{{ route('siswa.help') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs sm:text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 rounded-xl shadow-xs transition shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <span>Kontak & Bantuan</span>
            </a>
        </section>

        {{-- ── Area Riwayat Laporan Terbaru ─────────────────── --}}
        <section aria-labelledby="reports-heading" class="animate-slide-up stagger-3">
            <div class="flex items-center justify-between mb-4">
                <h2 id="reports-heading" class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    Laporan Terbaru Kamu
                </h2>
                @if ($recent_reports->count() > 0)
                    <a href="{{ route('siswa.reports.index') }}" class="text-xs font-bold text-primary-700 dark:text-[#5AE39D] hover:underline">
                        Lihat Semua Riwayat &rarr;
                    </a>
                @endif
            </div>

            @if ($recent_reports->count() > 0)
                <div class="flex flex-col gap-3">
                    @foreach ($recent_reports as $report)
                        @php
                            $badgeVariant = match ($report->status) {
                                'baru' => 'baru',
                                'diverifikasi' => 'diverifikasi',
                                'diproses' => 'diproses',
                                'selesai' => 'selesai',
                                'ditolak' => 'ditolak',
                                default => 'default',
                            };
                            $statusLabel = match ($report->status) {
                                'baru' => 'Baru',
                                'diverifikasi' => 'Sudah dibaca',
                                'diproses' => 'Sedang ditangani',
                                'selesai' => 'Selesai',
                                'ditolak' => 'Tidak dapat diproses',
                                default => ucfirst($report->status),
                            };
                        @endphp
                        <a href="{{ route('siswa.reports.show', $report) }}" 
                           class="block p-5 bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs hover:border-primary-400 dark:hover:border-primary-600 transition card-hover group">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="space-y-1.5 flex-1 min-w-0">
                                    <div class="flex items-center gap-2.5">
                                        <span class="text-xs font-mono font-bold text-slate-400 dark:text-slate-500">
                                            #{{ substr($report->id, 0, 8) }}
                                        </span>
                                        <x-badge :variant="$badgeVariant" size="sm">
                                            {{ $statusLabel }}
                                        </x-badge>
                                        @if ($report->is_hidden_identity)
                                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-full">
                                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                                Rahasia
                                            </span>
                                        @endif
                                    </div>
                                    <h3 class="text-base font-bold text-slate-900 dark:text-slate-100 group-hover:text-primary-700 dark:group-hover:text-[#5AE39D] transition-colors truncate">
                                        {{ $report->category->name ?? 'Laporan Perundungan' }}
                                    </h3>
                                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500 dark:text-slate-400">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            {{ $report->incident_date?->translatedFormat('d M Y') ?? '-' }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ $report->location }}
                                        </span>
                                    </div>
                                </div>
                                <div class="shrink-0 flex items-center gap-2 text-primary-700 dark:text-[#5AE39D] text-xs font-bold">
                                    <span>Lihat Tanggapan</span>
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="bg-surface-card dark:bg-[#16231D] rounded-3xl border border-dashed border-slate-300 dark:border-slate-800 p-8 text-center space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-primary-600 dark:text-[#5AE39D] flex items-center justify-center mx-auto">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div class="max-w-sm mx-auto space-y-1">
                        <h3 class="text-base font-bold text-slate-900 dark:text-slate-100">Belum ada laporan</h3>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                            Kalau ada hal yang mengganggumu atau temanmu di sekolah, kamu bisa bercerita kapan saja dengan aman di sini.
                        </p>
                    </div>
                    <a href="{{ route('siswa.reports.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white text-xs sm:text-sm font-bold shadow-xs transition card-hover">
                        <svg class="w-4 h-4 text-[#B8E34B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Mulai Buat Laporan</span>
                    </a>
                </div>
            @endif
        </section>
    </div>
</x-layouts.app>
