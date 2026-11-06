<x-layouts.app title="Rincian Laporan Periodik: {{ $summary->period_label }}">
    <div class="px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8 max-w-5xl w-full mx-auto space-y-6 animate-fade-in">
        {{-- Breadcrumb & Judul --}}
        <div>
            <div class="flex items-center gap-2 mb-1.5 text-xs">
                <a href="{{ route('periodic-reports.index') }}" class="text-slate-500 hover:text-primary-700 dark:hover:text-[#5AE39D] transition">Laporan Periodik</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <span class="font-semibold text-primary-700 dark:text-[#5AE39D]">{{ $summary->period_label }}</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 border-b border-slate-200 dark:border-slate-800">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900 dark:text-slate-100 flex items-center gap-2.5">
                        <span>{{ $summary->period_label }}</span>
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                        Rentang: {{ $summary->start_date->format('d F Y') }} s/d {{ $summary->end_date->format('d F Y') }} &bull; Dibuat otomatis pada {{ $summary->generated_at->format('d/m/Y H:i') }} WIB
                    </p>
                </div>
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider {{ $summary->period_type === 'monthly' ? 'bg-primary-50 text-primary-700 dark:bg-primary-950/60 dark:text-[#5AE39D] border border-primary-200 dark:border-primary-900' : 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-800' }}">
                        {{ $summary->period_type === 'monthly' ? 'Rekap Bulanan' : 'Rekap Semesteran' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Kartu Metrik Utama --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="p-4.5 rounded-2xl bg-surface-card dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 shadow-xs">
                <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider block">Total Kasus</span>
                <span class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-100 mt-1 block font-mono">{{ $summary->total_reports }}</span>
                <span class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 block">Laporan masuk</span>
            </div>

            <div class="p-4.5 rounded-2xl border border-primary-200 dark:border-primary-900/60 bg-primary-50/40 dark:bg-[#1A3326]/40 shadow-xs">
                <span class="text-[10px] font-bold text-primary-700 dark:text-[#5AE39D] uppercase tracking-wider block">Selesai Ditangani</span>
                <span class="text-2xl sm:text-3xl font-black text-primary-800 dark:text-[#5AE39D] mt-1 block font-mono">{{ $summary->resolved_reports }}</span>
                <span class="text-xs text-primary-700/80 dark:text-primary-300/80 mt-0.5 block">Penanganan tuntas</span>
            </div>

            <div class="p-4.5 rounded-2xl border border-amber-200 dark:border-amber-800/80 bg-amber-50/40 dark:bg-[#261A05] shadow-xs">
                <span class="text-[10px] font-bold text-amber-700 dark:text-[#FAD46B] uppercase tracking-wider block">Sedang Proses</span>
                <span class="text-2xl sm:text-3xl font-black text-amber-800 dark:text-[#FAD46B] mt-1 block font-mono">{{ $summary->in_process_reports }}</span>
                <span class="text-xs text-amber-700/80 dark:text-amber-300 mt-0.5 block">Konseling &amp; mediasi</span>
            </div>

            <div class="p-4.5 rounded-2xl border border-teal-200 dark:border-teal-800/80 bg-teal-50/40 dark:bg-teal-950/30 shadow-xs">
                <span class="text-[10px] font-bold text-teal-700 dark:text-teal-400 uppercase tracking-wider block">Rata-rata Waktu</span>
                <span class="text-2xl sm:text-3xl font-black text-teal-800 dark:text-teal-300 mt-1 block font-mono">
                    {{ $summary->avg_resolution_days !== null ? $summary->avg_resolution_days : '0' }}
                </span>
                <span class="text-xs text-teal-700/80 dark:text-teal-400/80 mt-0.5 block">Hari penyelesaian</span>
            </div>
        </div>

        {{-- Rincian Tingkat Urgensi --}}
        <div class="bg-surface-card dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-6 shadow-xs space-y-4">
            <h2 class="text-sm sm:text-base font-bold text-slate-900 dark:text-slate-100 pb-3 border-b border-slate-100 dark:border-slate-800">
                Sebaran Tingkat Urgensi Kasus
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="p-4 rounded-xl bg-rose-50/70 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-900/60 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-rose-700 dark:text-rose-400 uppercase tracking-wider block">Tinggi</span>
                        <span class="text-xs text-rose-600 dark:text-rose-400">Kekerasan fisik/bahaya</span>
                    </div>
                    <span class="text-2xl font-black text-rose-800 dark:text-rose-300 font-mono">{{ $summary->urgent_high_reports }}</span>
                </div>

                <div class="p-4 rounded-xl bg-amber-50/70 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800/60 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-amber-700 dark:text-[#FAD46B] uppercase tracking-wider block">Sedang</span>
                        <span class="text-xs text-amber-600 dark:text-amber-400">Verbal / intimidasi</span>
                    </div>
                    <span class="text-2xl font-black text-amber-800 dark:text-[#FAD46B] font-mono">{{ $summary->urgent_medium_reports }}</span>
                </div>

                <div class="p-4 rounded-xl bg-slate-100 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider block">Rendah</span>
                        <span class="text-xs text-slate-500 dark:text-slate-400">Perselisihan ringan</span>
                    </div>
                    <span class="text-2xl font-black text-slate-900 dark:text-slate-100 font-mono">{{ $summary->urgent_low_reports }}</span>
                </div>
            </div>
        </div>

        {{-- Dua Kolom: Sebaran Kategori & Sebaran Kelas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Kategori Kasus --}}
            <div class="bg-surface-card dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-6 shadow-xs space-y-3">
                <h2 class="text-sm sm:text-base font-bold text-slate-900 dark:text-slate-100 pb-3 border-b border-slate-100 dark:border-slate-800">
                    Sebaran Berdasarkan Kategori
                </h2>
                @php
                    $categories = $summary->categories_breakdown ?? [];
                @endphp
                @if(count($categories) > 0)
                    <div class="space-y-2">
                        @foreach($categories as $catName => $count)
                            <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900/40 rounded-xl border border-slate-100 dark:border-slate-800 text-xs sm:text-sm">
                                <span class="font-medium text-slate-800 dark:text-slate-200">{{ $catName }}</span>
                                <span class="font-bold text-primary-700 dark:text-[#5AE39D] px-2.5 py-0.5 rounded-full bg-primary-50 dark:bg-primary-950/40 border border-primary-200 dark:border-primary-900 text-xs">
                                    {{ $count }} laporan
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-slate-400 italic py-4 text-center">Tidak ada laporan pada periode ini.</p>
                @endif
            </div>

            {{-- Kelas Siswa --}}
            <div class="bg-surface-card dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-6 shadow-xs space-y-3">
                <h2 class="text-sm sm:text-base font-bold text-slate-900 dark:text-slate-100 pb-3 border-b border-slate-100 dark:border-slate-800">
                    Sebaran Berdasarkan Kelas Siswa
                </h2>
                @php
                    $classes = $summary->classes_breakdown ?? [];
                @endphp
                @if(count($classes) > 0)
                    <div class="space-y-2">
                        @foreach($classes as $className => $count)
                            <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900/40 rounded-xl border border-slate-100 dark:border-slate-800 text-xs sm:text-sm">
                                <span class="font-medium text-slate-800 dark:text-slate-200">Kelas {{ $className }}</span>
                                <span class="font-bold text-slate-700 dark:text-slate-300 px-2.5 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-xs">
                                    {{ $count }} laporan
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-slate-400 italic py-4 text-center">Tidak ada data kelas pada periode ini.</p>
                @endif
            </div>
        </div>

        {{-- Navigasi Kembali --}}
        <div class="pt-2">
            <a href="{{ route('periodic-reports.index') }}" 
               class="min-h-[42px] inline-flex items-center justify-center gap-1.5 px-4 py-2 text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition shadow-xs cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Daftar Laporan Periodik</span>
            </a>
        </div>
    </div>
</x-layouts.app>
