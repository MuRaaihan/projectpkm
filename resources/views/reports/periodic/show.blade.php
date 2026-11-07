<x-layouts.app title="Rincian Rekap Laporan: {{ $summary->period_label }}">
    <div class="px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8 max-w-6xl w-full mx-auto space-y-6 animate-fade-in">
        {{-- Breadcrumb & Header --}}
        <div>
            <div class="flex items-center gap-2 mb-1.5 text-xs">
                <a href="{{ auth()->user()->isMaster() ? route('master.dashboard') : route('bk.dashboard') }}" 
                   class="text-slate-500 hover:text-primary-700 dark:hover:text-[#5AE39D] transition">
                    {{ auth()->user()->isMaster() ? 'Dashboard Utama' : 'Dashboard Guru BK' }}
                </a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <a href="{{ route('periodic-reports.index') }}" 
                   class="text-slate-500 hover:text-primary-700 dark:hover:text-[#5AE39D] transition">
                    Rekap Laporan Berkala
                </a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <span class="font-semibold text-primary-700 dark:text-[#5AE39D]">{{ $summary->period_label }}</span>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900 dark:text-slate-100 flex items-center gap-2.5">
                        <span>{{ $summary->period_label }}</span>
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-2 flex-wrap">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Rentang: {{ $summary->start_date->format('d F Y') }} – {{ $summary->end_date->format('d F Y') }}</span>
                        </span>
                        <span>&bull;</span>
                        <span class="flex items-center gap-1 font-mono text-[11px]">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Dihasilkan pada {{ $summary->generated_at->format('d/m/Y H:i') }} WIB</span>
                        </span>
                    </p>
                </div>
                <div class="flex items-center gap-2.5">
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider {{ $summary->period_type === 'monthly' ? 'bg-primary-50 text-primary-700 dark:bg-primary-950/60 dark:text-[#5AE39D] border border-primary-200 dark:border-primary-900' : 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-800' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $summary->period_type === 'monthly' ? 'bg-primary-600 dark:bg-[#5AE39D]' : 'bg-indigo-600 dark:bg-indigo-400' }}"></span>
                        <span>{{ $summary->period_type === 'monthly' ? 'Rekap Bulanan' : 'Rekap Semesteran' }}</span>
                    </span>
                    <button type="button" 
                            onclick="window.print()" 
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 text-xs font-semibold hover:bg-slate-50 dark:hover:bg-slate-800 transition shadow-2xs cursor-pointer">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>Cetak</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Kartu Metrik Utama Ringkas --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="p-5 rounded-2xl bg-surface-card dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 shadow-xs">
                <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider block">Total Kasus Masuk</span>
                <span class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-100 mt-1 block font-mono">{{ $summary->total_reports }}</span>
                <span class="text-xs text-slate-500 dark:text-slate-400 mt-1 block font-medium">Laporan terdaftar</span>
            </div>

            <div class="p-5 rounded-2xl border border-primary-200 dark:border-primary-900/60 bg-primary-50/50 dark:bg-[#1A3326]/40 shadow-xs">
                <span class="text-[10px] font-bold text-primary-700 dark:text-[#5AE39D] uppercase tracking-wider block">Penanganan Tuntas</span>
                <span class="text-2xl sm:text-3xl font-black text-primary-800 dark:text-[#5AE39D] mt-1 block font-mono">{{ $summary->resolved_reports }}</span>
                <span class="text-xs text-primary-700/80 dark:text-primary-300/80 mt-1 block font-medium">Kasus telah selesai</span>
            </div>

            <div class="p-5 rounded-2xl border border-amber-200 dark:border-amber-800/80 bg-amber-50/50 dark:bg-[#261A05] shadow-xs">
                <span class="text-[10px] font-bold text-amber-700 dark:text-[#FAD46B] uppercase tracking-wider block">Sedang Berjalan</span>
                <span class="text-2xl sm:text-3xl font-black text-amber-800 dark:text-[#FAD46B] mt-1 block font-mono">{{ $summary->in_process_reports }}</span>
                <span class="text-xs text-amber-700/80 dark:text-amber-300 mt-1 block font-medium">Proses konseling BK</span>
            </div>

            <div class="p-5 rounded-2xl border border-teal-200 dark:border-teal-800/80 bg-teal-50/50 dark:bg-teal-950/30 shadow-xs">
                <span class="text-[10px] font-bold text-teal-700 dark:text-teal-400 uppercase tracking-wider block">Kecepatan Respons</span>
                <span class="text-2xl sm:text-3xl font-black text-teal-800 dark:text-teal-300 mt-1 block font-mono">
                    {{ $summary->avg_resolution_days !== null ? $summary->avg_resolution_days : '0' }}
                </span>
                <span class="text-xs text-teal-700/80 dark:text-teal-400/80 mt-1 block font-medium">Hari rata-rata tuntas</span>
            </div>
        </div>

        {{-- Panel Sebaran Tingkat Urgensi Kasus --}}
        <div class="bg-surface-card dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-6 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                <h2 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-slate-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span>Sebaran Berdasarkan Tingkat Urgensi</span>
                </h2>
                <span class="text-xs text-slate-400 font-medium">Klasifikasi penanganan</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                <div class="p-4 rounded-xl bg-rose-50/70 dark:bg-rose-950/30 border border-rose-200/80 dark:border-rose-900/60 flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-rose-700 dark:text-rose-400 uppercase tracking-wider block">Tinggi / Kritis</span>
                        <span class="text-xs text-rose-600 dark:text-rose-400/90 mt-0.5 block">Kekerasan fisik / bahaya langsung</span>
                    </div>
                    <span class="text-2xl font-black text-rose-800 dark:text-rose-300 font-mono">{{ $summary->urgent_high_reports }}</span>
                </div>

                <div class="p-4 rounded-xl bg-amber-50/70 dark:bg-amber-950/30 border border-amber-200/80 dark:border-amber-800/60 flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-amber-700 dark:text-[#FAD46B] uppercase tracking-wider block">Sedang</span>
                        <span class="text-xs text-amber-600 dark:text-amber-400/90 mt-0.5 block">Verbal / intimidasi / ancaman</span>
                    </div>
                    <span class="text-2xl font-black text-amber-800 dark:text-[#FAD46B] font-mono">{{ $summary->urgent_medium_reports }}</span>
                </div>

                <div class="p-4 rounded-xl bg-slate-100/80 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider block">Rendah</span>
                        <span class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 block">Perselisihan sebaya ringan</span>
                    </div>
                    <span class="text-2xl font-black text-slate-900 dark:text-slate-100 font-mono">{{ $summary->urgent_low_reports }}</span>
                </div>
            </div>
        </div>

        {{-- Dua Kolom: Sebaran Kategori & Sebaran Kelas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Sebaran Kategori Kasus --}}
            <div class="bg-surface-card dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-6 shadow-xs space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                    <h2 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-slate-100 flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        <span>Sebaran Berdasarkan Kategori</span>
                    </h2>
                </div>

                @php
                    $categories = $summary->categories_breakdown ?? [];
                @endphp
                @if(count($categories) > 0)
                    <div class="space-y-3">
                        @foreach($categories as $catName => $count)
                            @php
                                $percent = $summary->total_reports > 0 ? round(($count / $summary->total_reports) * 100) : 0;
                            @endphp
                            <div class="space-y-1.5 p-3 rounded-xl bg-slate-50 dark:bg-slate-900/40 border border-slate-100 dark:border-slate-800/80">
                                <div class="flex items-center justify-between text-xs sm:text-sm">
                                    <span class="font-bold text-slate-800 dark:text-slate-200">{{ $catName }}</span>
                                    <span class="font-bold text-primary-700 dark:text-[#5AE39D] font-mono">
                                        {{ $count }} laporan ({{ $percent }}%)
                                    </span>
                                </div>
                                <div class="w-full bg-slate-200 dark:bg-slate-800 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-primary-600 dark:bg-[#5AE39D] h-full rounded-full" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-8 text-center text-xs text-slate-400 italic">
                        Tidak ada laporan yang terdaftar pada periode ini.
                    </div>
                @endif
            </div>

            {{-- Sebaran Kelas Siswa --}}
            <div class="bg-surface-card dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-6 shadow-xs space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                    <h2 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-slate-100 flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Sebaran Berdasarkan Kelas Siswa</span>
                    </h2>
                </div>

                @php
                    $classes = $summary->classes_breakdown ?? [];
                @endphp
                @if(count($classes) > 0)
                    <div class="space-y-3">
                        @foreach($classes as $className => $count)
                            @php
                                $percent = $summary->total_reports > 0 ? round(($count / $summary->total_reports) * 100) : 0;
                            @endphp
                            <div class="space-y-1.5 p-3 rounded-xl bg-slate-50 dark:bg-slate-900/40 border border-slate-100 dark:border-slate-800/80">
                                <div class="flex items-center justify-between text-xs sm:text-sm">
                                    <span class="font-bold text-slate-800 dark:text-slate-200">Kelas {{ $className }}</span>
                                    <span class="font-bold text-slate-700 dark:text-slate-300 font-mono">
                                        {{ $count }} laporan ({{ $percent }}%)
                                    </span>
                                </div>
                                <div class="w-full bg-slate-200 dark:bg-slate-800 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-indigo-600 dark:bg-indigo-400 h-full rounded-full" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-8 text-center text-xs text-slate-400 italic">
                        Tidak ada data kelas yang terdaftar pada periode ini.
                    </div>
                @endif
            </div>
        </div>

        {{-- Navigasi Kembali --}}
        <div class="pt-4 flex items-center justify-between">
            <a href="{{ route('periodic-reports.index') }}" 
               class="min-h-[44px] inline-flex items-center justify-center gap-2 px-5 py-2.5 text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition shadow-2xs cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Rekap Berkala</span>
            </a>
        </div>
    </div>
</x-layouts.app>
