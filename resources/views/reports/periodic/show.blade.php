<x-layouts.app title="Rincian Laporan Periodik: {{ $summary->period_label }}">
    <div class="max-w-5xl mx-auto space-y-6 animate-fade-in">
        {{-- Breadcrumb & Judul --}}
        <div>
            <div class="flex items-center gap-2 mb-1.5 text-xs">
                <a href="{{ route('periodic-reports.index') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 transition">Laporan Periodik</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $summary->period_label }}</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 border-b border-slate-200 dark:border-slate-800">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100 flex items-center gap-2.5">
                        <span>{{ $summary->period_label }}</span>
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                        Rentang: {{ $summary->start_date->format('d F Y') }} s/d {{ $summary->end_date->format('d F Y') }} &bull; Dibuat otomatis pada {{ $summary->generated_at->format('d/m/Y H:i') }} WIB
                    </p>
                </div>
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider {{ $summary->period_type === 'monthly' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-800' : 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-800' }}">
                        {{ $summary->period_type === 'monthly' ? 'Rekap Bulanan' : 'Rekap Semesteran' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Kartu Metrik Utama --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="p-4 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-800 shadow-xs">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Laporan</span>
                <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-slate-100 mt-1 block">{{ $summary->total_reports }}</span>
                <span class="text-xs text-slate-400 mt-0.5 block">Laporan masuk</span>
            </div>

            <div class="p-4 rounded-2xl border border-emerald-200 dark:border-emerald-800/80 bg-emerald-50/30 dark:bg-emerald-950/20 shadow-xs">
                <span class="text-[10px] font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider block">Selesai Ditangani</span>
                <span class="text-2xl sm:text-3xl font-extrabold text-emerald-800 dark:text-emerald-300 mt-1 block">{{ $summary->resolved_reports }}</span>
                <span class="text-xs text-emerald-600/80 dark:text-emerald-400/80 mt-0.5 block">Penanganan tuntas</span>
            </div>

            <div class="p-4 rounded-2xl border border-amber-200 dark:border-amber-800/80 bg-amber-50/30 dark:bg-amber-950/20 shadow-xs">
                <span class="text-[10px] font-bold text-amber-700 dark:text-amber-400 uppercase tracking-wider block">Sedang Proses</span>
                <span class="text-2xl sm:text-3xl font-extrabold text-amber-800 dark:text-amber-300 mt-1 block">{{ $summary->in_process_reports }}</span>
                <span class="text-xs text-amber-600/80 dark:text-amber-400/80 mt-0.5 block">Konseling & mediasi</span>
            </div>

            <div class="p-4 rounded-2xl border border-teal-200 dark:border-teal-800/80 bg-teal-50/30 dark:bg-teal-950/20 shadow-xs">
                <span class="text-[10px] font-bold text-teal-700 dark:text-teal-400 uppercase tracking-wider block">Rata-rata Waktu</span>
                <span class="text-2xl sm:text-3xl font-extrabold text-teal-800 dark:text-teal-300 mt-1 block">
                    {{ $summary->avg_resolution_days !== null ? $summary->avg_resolution_days : '0' }}
                </span>
                <span class="text-xs text-teal-600/80 dark:text-teal-400/80 mt-0.5 block">Hari penyelesaian</span>
            </div>
        </div>

        {{-- Rincian Tingkat Urgensi --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs space-y-4">
            <h2 class="text-sm sm:text-base font-bold text-slate-900 dark:text-slate-100 pb-3 border-b border-slate-100 dark:border-slate-850">
                Sebaran Tingkat Urgensi Kasus
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="p-4 rounded-2xl bg-rose-50/70 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-900/60 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-rose-700 dark:text-rose-400 uppercase tracking-wider block">Tinggi</span>
                        <span class="text-xs text-rose-600 dark:text-rose-400">Kekerasan fisik/bahaya</span>
                    </div>
                    <span class="text-2xl font-extrabold text-rose-800 dark:text-rose-300">{{ $summary->urgent_high_reports }}</span>
                </div>

                <div class="p-4 rounded-2xl bg-amber-50/70 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800/60 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-amber-700 dark:text-amber-400 uppercase tracking-wider block">Sedang</span>
                        <span class="text-xs text-amber-600 dark:text-amber-400">Verbal/pengucilan</span>
                    </div>
                    <span class="text-2xl font-extrabold text-amber-800 dark:text-amber-300">{{ $summary->urgent_medium_reports }}</span>
                </div>

                <div class="p-4 rounded-2xl bg-slate-100 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-700 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider block">Rendah</span>
                        <span class="text-xs text-slate-400">Perselisihan ringan</span>
                    </div>
                    <span class="text-2xl font-extrabold text-slate-900 dark:text-slate-100">{{ $summary->urgent_low_reports }}</span>
                </div>
            </div>
        </div>

        {{-- Dua Kolom: Sebaran Kategori & Sebaran Kelas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Kategori Kasus --}}
            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs space-y-3">
                <h2 class="text-sm sm:text-base font-bold text-slate-900 dark:text-slate-100 pb-3 border-b border-slate-100 dark:border-slate-850">
                    Sebaran Berdasarkan Kategori
                </h2>
                @php
                    $categories = $summary->categories_breakdown ?? [];
                @endphp
                @if(count($categories) > 0)
                    <div class="space-y-2">
                        @foreach($categories as $catName => $count)
                            <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900/40 rounded-xl border border-slate-100 dark:border-slate-700/60 text-xs sm:text-sm">
                                <span class="font-medium text-slate-800 dark:text-slate-200">{{ $catName }}</span>
                                <span class="font-bold text-emerald-600 dark:text-emerald-400 px-2.5 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-100 dark:border-emerald-800 text-xs">
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
            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs space-y-3">
                <h2 class="text-sm sm:text-base font-bold text-slate-900 dark:text-slate-100 pb-3 border-b border-slate-100 dark:border-slate-850">
                    Sebaran Berdasarkan Kelas Siswa
                </h2>
                @php
                    $classes = $summary->classes_breakdown ?? [];
                @endphp
                @if(count($classes) > 0)
                    <div class="space-y-2">
                        @foreach($classes as $className => $count)
                            <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900/40 rounded-xl border border-slate-100 dark:border-slate-700/60 text-xs sm:text-sm">
                                <span class="font-medium text-slate-800 dark:text-slate-200">Kelas {{ $className }}</span>
                                <span class="font-bold text-slate-600 dark:text-slate-400 px-2.5 py-0.5 rounded-full bg-slate-100 dark:bg-slate-700 text-xs">
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
            <a href="{{ route('periodic-reports.index') }}" class="min-h-[42px] inline-flex items-center justify-center px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-xl transition shadow-xs">
                &larr; Kembali ke Daftar Laporan Periodik
            </a>
        </div>
    </div>
</x-layouts.app>
