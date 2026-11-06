<x-layouts.app title="Statistik Penanganan Laporan">
    <div class="px-4 py-5 sm:px-6 sm:py-6 flex flex-col gap-6 max-w-6xl w-full mx-auto lg:px-8 lg:py-8 animate-fade-in">
        {{-- ── Header Halaman ───────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200/80 dark:border-slate-800">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <a href="{{ route('bk.dashboard') }}" class="text-xs sm:text-sm font-medium text-slate-500 hover:text-primary-700 dark:hover:text-[#5AE39D] transition-colors">
                        Dashboard Guru BK
                    </a>
                    <span class="text-xs text-slate-400">/</span>
                    <span class="text-xs sm:text-sm font-semibold text-primary-700 dark:text-[#5AE39D]">Statistik</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">
                    Statistik Penanganan Laporan
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-1">
                    Analisis agregat tren kasus, sebaran kategori, dan efektivitas tindak lanjut konseling peserta didik.
                </p>
            </div>

            <div class="flex items-center gap-3 self-start sm:self-auto">
                <a href="{{ route('bk.reports.download.view') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white text-xs sm:text-sm font-bold shadow-xs card-hover transition">
                    <svg class="w-4 h-4 text-[#B8E34B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Unduh Rekap Laporan</span>
                </a>
            </div>
        </div>

        {{-- ── Filter Periode Kasus ─────────────────────────── --}}
        <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-4 sm:p-5 shadow-xs">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary-50 dark:bg-[#1A3326] border border-primary-200/60 dark:border-[#289E70]/40 text-primary-700 dark:text-[#5AE39D] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100">
                            Filter Periode Analisis
                        </h2>
                        <p class="text-[11px] sm:text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                            @php
                                $monthNames = [1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'];
                                $availableYears = \App\Models\Report::whereNotNull('created_at')
                                    ->pluck('created_at')
                                    ->filter()
                                    ->map(function ($date) {
                                        return $date instanceof \Carbon\Carbon ? $date->format('Y') : \Carbon\Carbon::parse($date)->format('Y');
                                    })
                                    ->unique()
                                    ->sortDesc()
                                    ->values();
                            @endphp
                            @if($selectedYear && $selectedMonth)
                                Menampilkan data: <strong class="text-primary-700 dark:text-[#5AE39D]">{{ $monthNames[$selectedMonth] ?? '' }} {{ $selectedYear }}</strong>
                            @elseif($selectedYear)
                                Menampilkan data sepanjang tahun: <strong class="text-primary-700 dark:text-[#5AE39D]">{{ $selectedYear }}</strong>
                            @elseif($selectedMonth)
                                Menampilkan data bulan: <strong class="text-primary-700 dark:text-[#5AE39D]">{{ $monthNames[$selectedMonth] ?? '' }}</strong> (semua tahun)
                            @else
                                Menampilkan seluruh data aduan yang tersimpan
                            @endif
                        </p>
                    </div>
                </div>

                <form method="GET" action="{{ route('bk.statistics.index') }}" class="flex flex-wrap sm:flex-nowrap items-center gap-2.5">
                    {{-- Dropdown Tahun --}}
                    <div class="relative flex-1 sm:w-40 min-w-[130px]">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <select id="year" name="year" 
                            class="w-full appearance-none pl-9 pr-8 py-2 text-xs sm:text-sm font-semibold rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 transition shadow-2xs cursor-pointer">
                            <option value="">Semua Tahun</option>
                            @foreach($availableYears as $y)
                                <option value="{{ $y }}" {{ (string)$selectedYear === (string)$y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>

                    {{-- Dropdown Bulan --}}
                    <div class="relative flex-1 sm:w-44 min-w-[140px]">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <select id="month" name="month" 
                            class="w-full appearance-none pl-9 pr-8 py-2 text-xs sm:text-sm font-semibold rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 transition shadow-2xs cursor-pointer">
                            <option value="">Semua Bulan</option>
                            @foreach($monthNames as $num => $namaBulan)
                                <option value="{{ $num }}" {{ $selectedMonth == $num ? 'selected' : '' }}>{{ $namaBulan }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>

                    {{-- Tombol Terapkan & Reset --}}
                    <div class="flex items-center gap-1.5 shrink-0">
                        <button type="submit" 
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white font-bold text-xs sm:text-sm rounded-xl transition shadow-xs cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <span>Terapkan</span>
                        </button>
                        @if($selectedYear || $selectedMonth)
                            <a href="{{ route('bk.statistics.index') }}" 
                               class="inline-flex items-center justify-center gap-1 px-3 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold text-xs sm:text-sm rounded-xl transition cursor-pointer"
                               title="Reset filter periode">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                <span>Reset</span>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- ── Kartu Ringkasan Metrik (KPI Matrix Sesuai Frontend) ── --}}
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- 1. Total Laporan --}}
            <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs flex flex-col justify-between card-hover">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Kasus</span>
                    <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                </div>
                <div>
                    <span class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-100 tabular-nums block">{{ $stats['total_reports'] }}</span>
                    <span class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 block">Seluruh aduan masuk</span>
                </div>
            </div>

            {{-- 2. Aduan Baru --}}
            <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-rose-200/80 dark:border-rose-900/50 p-5 shadow-xs flex flex-col justify-between card-hover">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-rose-800 dark:text-rose-400">Aduan Baru</span>
                    <div class="w-8 h-8 rounded-lg bg-rose-50 dark:bg-rose-950/60 text-rose-700 dark:text-rose-400 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    </div>
                </div>
                <div>
                    <span class="text-2xl sm:text-3xl font-black text-rose-900 dark:text-rose-300 tabular-nums block">{{ $stats['new_reports'] }}</span>
                    <span class="text-[11px] text-rose-700 dark:text-rose-400 mt-1 block">Perlu verifikasi awal</span>
                </div>
            </div>

            {{-- 3. Dalam Penanganan --}}
            <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-amber-200/80 dark:border-amber-900/50 p-5 shadow-xs flex flex-col justify-between card-hover">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-800 dark:text-[#FAD46B]">Dalam Penanganan</span>
                    <div class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-[#FAD46B] flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div>
                    <span class="text-2xl sm:text-3xl font-black text-amber-900 dark:text-[#FAD46B] tabular-nums block">{{ $stats['active_reports'] }}</span>
                    <span class="text-[11px] text-amber-700 dark:text-amber-300 mt-1 block">Proses konseling aktif</span>
                </div>
            </div>

            {{-- 4. Tuntas Diselesaikan --}}
            <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-emerald-200/80 dark:border-emerald-900/50 p-5 shadow-xs flex flex-col justify-between card-hover">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 dark:text-[#5AE39D]">Tuntas Selesai</span>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-[#5AE39D] flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div>
                    <span class="text-2xl sm:text-3xl font-black text-emerald-900 dark:text-[#5AE39D] tabular-nums block">{{ $stats['resolved_reports'] }}</span>
                    <span class="text-[11px] text-emerald-700 dark:text-emerald-300 mt-1 block">Kasus tuntas diselesaikan</span>
                </div>
            </div>
        </div>

        {{-- ── Grid Grafik Interaktif (Chart.js) ─────────────── --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Grafik 1: Tren Bulanan --}}
            <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-6 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800 mb-4">
                        <div>
                            <h2 class="text-sm sm:text-base font-black text-slate-900 dark:text-slate-100">
                                Tren Laporan (6 Bulan Terakhir)
                            </h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                Frekuensi aduan perundungan peserta didik per bulan
                            </p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-primary-50 dark:bg-primary-950/60 text-primary-700 dark:text-[#5AE39D] border border-primary-200/80 dark:border-primary-800">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary-600 dark:bg-[#5AE39D]"></span>
                            Historis
                        </span>
                    </div>

                    <div class="relative h-64 sm:h-72 w-full">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-[11px] text-slate-500 dark:text-slate-400">
                    <span>Garis menunjukkan kurva pertumbuhan laporan masuk</span>
                    <span class="font-semibold text-primary-700 dark:text-[#5AE39D]">1x24 jam respon</span>
                </div>
            </div>

            {{-- Grafik 2: Sebaran Kategori --}}
            <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-6 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800 mb-4">
                        <div>
                            <h2 class="text-sm sm:text-base font-black text-slate-900 dark:text-slate-100">
                                Sebaran Berdasarkan Kategori
                            </h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                Proporsi jenis perundungan yang dilaporkan
                            </p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 dark:bg-amber-950/60 text-amber-800 dark:text-[#FAD46B] border border-amber-200/80 dark:border-amber-800">
                            Persentase
                        </span>
                    </div>

                    <div class="relative h-64 sm:h-72 w-full flex items-center justify-center">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-[11px] text-slate-500 dark:text-slate-400">
                    <span>Arahkan kursor pada diagram untuk melihat detail persentase</span>
                    <span class="font-semibold text-slate-700 dark:text-slate-300">{{ count($stats['category_distribution']) }} Kategori</span>
                </div>
            </div>

            {{-- Grafik 3: Status Laporan --}}
            <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-6 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800 mb-4">
                        <div>
                            <h2 class="text-sm sm:text-base font-black text-slate-900 dark:text-slate-100">
                                Distribusi Status Penanganan
                            </h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                Tahapan proses tindak lanjut yang sedang berjalan
                            </p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                            Status Alur
                        </span>
                    </div>

                    <div class="relative h-64 sm:h-72 w-full">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-[11px] text-slate-500 dark:text-slate-400">
                    <span>5 tahapan eskalasi penanganan terdata</span>
                    <span class="font-semibold text-emerald-700 dark:text-[#5AE39D]">{{ $stats['resolved_reports'] }} Selesai</span>
                </div>
            </div>

            {{-- Grafik 4: Sebaran Tingkat Kelas --}}
            <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-6 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800 mb-4">
                        <div>
                            <h2 class="text-sm sm:text-base font-black text-slate-900 dark:text-slate-100">
                                Sebaran Berdasarkan Jenjang Kelas
                            </h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                Jumlah kasus menurut tingkat madrasah (Kelas 7, 8, dan 9)
                            </p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-primary-50 dark:bg-primary-950/60 text-primary-700 dark:text-[#5AE39D] border border-primary-200/80 dark:border-primary-800">
                            Tingkat Kelas
                        </span>
                    </div>

                    <div class="relative h-64 sm:h-72 w-full">
                        <canvas id="gradeChart"></canvas>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-[11px] text-slate-500 dark:text-slate-400">
                    <span>Data digunakan untuk prioritas penyuluhan bimbingan</span>
                    <span class="font-semibold text-slate-700 dark:text-slate-300">Jenjang MTs</span>
                </div>
            </div>
        </div>

        {{-- ── Disclaimer Keamanan Data Statistik (Sesuai Frontend) ── --}}
        <div class="bg-surface-card dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl p-4 sm:p-5 flex items-start gap-3.5 shadow-2xs">
            <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-[#261A05] border border-amber-200 dark:border-amber-800 text-amber-700 dark:text-[#FAD46B] flex items-center justify-center shrink-0 mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h3 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100">
                    Integritas &amp; Kerahasiaan Data Statistik
                </h3>
                <p class="text-[11px] sm:text-xs text-slate-600 dark:text-slate-400 mt-0.5 leading-relaxed">
                    Data statistik disajikan secara agregat murni tanpa menampilkan identitas siswa, nama pihak terlibat, maupun isi kronologi sensitif. Data ini digunakan secara eksklusif untuk evaluasi program madrasah aman dan tidak untuk konsumsi publik umum.
                </p>
            </div>
        </div>
    </div>

    {{-- ── Script Inisialisasi & Reaktivitas Chart.js ───────────── --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Chart === 'undefined') {
                return;
            }

            Chart.defaults.font.family = '"Inter", ui-sans-serif, system-ui, -apple-system, sans-serif';

            let trendChart, categoryChart, statusChart, gradeChart;

            function getThemeConfig() {
                const isDark = document.documentElement.classList.contains('dark');
                return {
                    isDark: isDark,
                    textColor: isDark ? '#9EB3A8' : '#69736C',
                    headingColor: isDark ? '#F2F7F4' : '#18241E',
                    gridColor: isDark ? 'rgba(34, 52, 42, 0.6)' : 'rgba(226, 225, 217, 0.7)',
                    doughnutBorder: isDark ? '#16231D' : '#FFFFFF',
                    primaryColor: isDark ? '#5AE39D' : '#176B4D',
                    pointBg: isDark ? '#16231D' : '#FFFFFF',
                    tooltipBg: isDark ? '#14201A' : '#FFFFFF',
                    tooltipText: isDark ? '#F2F7F4' : '#18241E',
                    tooltipBorder: isDark ? '#22342A' : '#E2E1D9',
                };
            }

            function createOrUpdateCharts() {
                const theme = getThemeConfig();

                // 1. Trend Chart
                const trendCanvas = document.getElementById('trendChart');
                if (trendCanvas) {
                    const ctx = trendCanvas.getContext('2d');
                    const gradient = ctx.createLinearGradient(0, 0, 0, 240);
                    gradient.addColorStop(0, theme.isDark ? 'rgba(90, 227, 157, 0.25)' : 'rgba(23, 107, 77, 0.22)');
                    gradient.addColorStop(1, 'rgba(23, 107, 77, 0.0)');

                    if (trendChart) {
                        trendChart.data.datasets[0].borderColor = theme.primaryColor;
                        trendChart.data.datasets[0].backgroundColor = gradient;
                        trendChart.data.datasets[0].pointBorderColor = theme.primaryColor;
                        trendChart.data.datasets[0].pointBackgroundColor = theme.pointBg;
                        trendChart.options.scales.x.ticks.color = theme.textColor;
                        trendChart.options.scales.x.grid.color = theme.gridColor;
                        trendChart.options.scales.y.ticks.color = theme.textColor;
                        trendChart.options.scales.y.grid.color = theme.gridColor;
                        trendChart.update();
                    } else {
                        trendChart = new Chart(trendCanvas, {
                            type: 'line',
                            data: {
                                labels: {!! json_encode(array_column($stats['monthly_trend'], 'label')) !!},
                                datasets: [{
                                    label: 'Jumlah Laporan Masuk',
                                    data: {!! json_encode(array_column($stats['monthly_trend'], 'count')) !!},
                                    borderColor: theme.primaryColor,
                                    backgroundColor: gradient,
                                    borderWidth: 2.5,
                                    fill: true,
                                    tension: 0.35,
                                    pointBackgroundColor: theme.pointBg,
                                    pointBorderColor: theme.primaryColor,
                                    pointBorderWidth: 2,
                                    pointRadius: 4.5,
                                    pointHoverRadius: 6.5,
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        backgroundColor: theme.tooltipBg,
                                        titleColor: theme.tooltipText,
                                        bodyColor: theme.tooltipText,
                                        borderColor: theme.tooltipBorder,
                                        borderWidth: 1,
                                        padding: 10,
                                        usePointStyle: true,
                                        callbacks: {
                                            label: function(context) {
                                                return ' ' + context.parsed.y + ' laporan';
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        ticks: { color: theme.textColor, font: { size: 11, weight: '500' } },
                                        grid: { color: theme.gridColor }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        ticks: { precision: 0, color: theme.textColor, font: { size: 11, weight: '500' } },
                                        grid: { color: theme.gridColor }
                                    }
                                }
                            }
                        });
                    }
                }

                // 2. Category Chart
                const catCanvas = document.getElementById('categoryChart');
                if (catCanvas) {
                    if (categoryChart) {
                        categoryChart.data.datasets[0].borderColor = theme.doughnutBorder;
                        categoryChart.options.plugins.legend.labels.color = theme.headingColor;
                        categoryChart.update();
                    } else {
                        categoryChart = new Chart(catCanvas, {
                            type: 'doughnut',
                            data: {
                                labels: {!! json_encode(array_column($stats['category_distribution'], 'label')) !!},
                                datasets: [{
                                    data: {!! json_encode(array_column($stats['category_distribution'], 'count')) !!},
                                    backgroundColor: [
                                        '#176B4D',
                                        '#289E70',
                                        '#B8E34B',
                                        '#FAD46B',
                                        '#0284C7',
                                        '#8B5CF6',
                                        '#F43F5E',
                                        '#94A3B8'
                                    ],
                                    borderWidth: 2,
                                    borderColor: theme.doughnutBorder
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                cutout: '68%',
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            boxWidth: 10,
                                            boxHeight: 10,
                                            borderRadius: 3,
                                            font: { size: 11, weight: '500' },
                                            color: theme.headingColor,
                                            padding: 12
                                        }
                                    },
                                    tooltip: {
                                        backgroundColor: theme.tooltipBg,
                                        titleColor: theme.tooltipText,
                                        bodyColor: theme.tooltipText,
                                        borderColor: theme.tooltipBorder,
                                        borderWidth: 1,
                                        padding: 10,
                                        callbacks: {
                                            label: function(context) {
                                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                                const val = context.parsed;
                                                const pct = total > 0 ? Math.round((val / total) * 100) : 0;
                                                return ` ${context.label}: ${val} kasus (${pct}%)`;
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }
                }

                // 3. Status Chart
                const statusCanvas = document.getElementById('statusChart');
                if (statusCanvas) {
                    if (statusChart) {
                        statusChart.options.scales.x.ticks.color = theme.textColor;
                        statusChart.options.scales.x.grid.color = theme.gridColor;
                        statusChart.options.scales.y.ticks.color = theme.textColor;
                        statusChart.options.scales.y.grid.color = theme.gridColor;
                        statusChart.update();
                    } else {
                        statusChart = new Chart(statusCanvas, {
                            type: 'bar',
                            data: {
                                labels: {!! json_encode(array_column($stats['status_distribution'], 'label')) !!},
                                datasets: [{
                                    label: 'Laporan',
                                    data: {!! json_encode(array_column($stats['status_distribution'], 'count')) !!},
                                    backgroundColor: [
                                        '#0284C7', // Baru / Sky
                                        '#469A79', // Diverifikasi / Mint
                                        '#F59E0B', // Dalam Penanganan / Amber
                                        '#176B4D', // Selesai / Dark Emerald
                                        '#E11D48'  // Ditolak / Rose
                                    ],
                                    borderRadius: 8,
                                    borderSkipped: false
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        backgroundColor: theme.tooltipBg,
                                        titleColor: theme.tooltipText,
                                        bodyColor: theme.tooltipText,
                                        borderColor: theme.tooltipBorder,
                                        borderWidth: 1,
                                        padding: 10
                                    }
                                },
                                scales: {
                                    x: {
                                        ticks: { color: theme.textColor, font: { size: 10.5, weight: '500' } },
                                        grid: { display: false }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        ticks: { precision: 0, color: theme.textColor, font: { size: 11, weight: '500' } },
                                        grid: { color: theme.gridColor }
                                    }
                                }
                            }
                        });
                    }
                }

                // 4. Grade Chart
                const gradeCanvas = document.getElementById('gradeChart');
                if (gradeCanvas) {
                    if (gradeChart) {
                        gradeChart.data.datasets[0].backgroundColor = theme.primaryColor;
                        gradeChart.options.scales.x.ticks.color = theme.textColor;
                        gradeChart.options.scales.x.grid.color = theme.gridColor;
                        gradeChart.options.scales.y.ticks.color = theme.textColor;
                        gradeChart.options.scales.y.grid.color = theme.gridColor;
                        gradeChart.update();
                    } else {
                        gradeChart = new Chart(gradeCanvas, {
                            type: 'bar',
                            data: {
                                labels: {!! json_encode(array_column($stats['grade_distribution'], 'label')) !!},
                                datasets: [{
                                    label: 'Jumlah Kasus',
                                    data: {!! json_encode(array_column($stats['grade_distribution'], 'count')) !!},
                                    backgroundColor: theme.primaryColor,
                                    borderRadius: 8,
                                    borderSkipped: false,
                                    maxBarThickness: 48
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        backgroundColor: theme.tooltipBg,
                                        titleColor: theme.tooltipText,
                                        bodyColor: theme.tooltipText,
                                        borderColor: theme.tooltipBorder,
                                        borderWidth: 1,
                                        padding: 10
                                    }
                                },
                                scales: {
                                    x: {
                                        ticks: { color: theme.textColor, font: { size: 11, weight: '600' } },
                                        grid: { display: false }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        ticks: { precision: 0, color: theme.textColor, font: { size: 11, weight: '500' } },
                                        grid: { color: theme.gridColor }
                                    }
                                }
                            }
                        });
                    }
                }
            }

            // Inisialisasi awal
            createOrUpdateCharts();

            // Observer agar chart selalu adaptif secara realtime saat mode gelap / terang diubah
            const observer = new MutationObserver(function (mutations) {
                mutations.forEach(function (mutation) {
                    if (mutation.attributeName === 'class') {
                        createOrUpdateCharts();
                    }
                });
            });
            observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
        });
    </script>
</x-layouts.app>