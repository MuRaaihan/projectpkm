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

        {{-- ── Filter Periode ───────────────────────────────── --}}
        <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-4 sm:p-5 shadow-xs">
            <form method="GET" action="{{ route('bk.statistics.index') }}" class="flex flex-wrap items-center gap-3">
                <div>
                    <label for="year" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Tahun</label>
                    <select id="year" name="year" 
                        class="px-3.5 py-2 text-xs sm:text-sm border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 min-h-[40px]">
                        <option value="">Semua Tahun</option>
                        @for($y = date('Y'); $y >= date('Y') - 4; $y--)
                            <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label for="month" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Bulan</label>
                    <select id="month" name="month" 
                        class="px-3.5 py-2 text-xs sm:text-sm border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 min-h-[40px]">
                        <option value="">Semua Bulan</option>
                        @foreach([1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'] as $num => $namaBulan)
                            <option value="{{ $num }}" {{ $selectedMonth == $num ? 'selected' : '' }}>{{ $namaBulan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2 pt-5">
                    <button type="submit" 
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-bold text-xs sm:text-sm rounded-xl min-h-[40px] transition shadow-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        <span>Filter</span>
                    </button>
                    @if($selectedYear || $selectedMonth)
                        <a href="{{ route('bk.statistics.index') }}" 
                           class="inline-flex items-center justify-center px-3.5 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold text-xs sm:text-sm rounded-xl min-h-[40px] transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- ── Kartu Ringkasan Metrik ───────────────────────── --}}
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs flex flex-col justify-between card-hover">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 block">Total Laporan</span>
                <span class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-100 mt-2 block">{{ $stats['total_reports'] }}</span>
                <span class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 block">Seluruh laporan tercatat</span>
            </div>

            <div class="bg-emerald-50/60 dark:bg-[#153222] rounded-2xl border border-emerald-200/80 dark:border-emerald-800/80 p-5 shadow-xs flex flex-col justify-between card-hover">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 dark:text-[#5AE39D] block">Selesai Ditangani</span>
                <span class="text-2xl sm:text-3xl font-black text-emerald-950 dark:text-[#5AE39D] mt-2 block">{{ $stats['resolved_reports'] }}</span>
                <span class="text-[11px] text-emerald-800/80 dark:text-emerald-200/80 mt-0.5 block">Kasus tuntas diselesaikan</span>
            </div>

            <div class="bg-amber-50/60 dark:bg-[#261A05] rounded-2xl border border-amber-200/80 dark:border-amber-800/80 p-5 shadow-xs flex flex-col justify-between card-hover">
                <span class="text-xs font-bold uppercase tracking-wider text-amber-800 dark:text-[#FAD46B] block">Sedang Ditangani</span>
                <span class="text-2xl sm:text-3xl font-black text-amber-950 dark:text-[#FAD46B] mt-2 block">{{ $stats['active_reports'] }}</span>
                <span class="text-[11px] text-amber-800/80 dark:text-amber-200/80 mt-0.5 block">Proses mediasi & tindak lanjut</span>
            </div>

            <div class="bg-rose-50/60 dark:bg-[#251012] rounded-2xl border border-rose-200/80 dark:border-rose-900/60 p-5 shadow-xs flex flex-col justify-between card-hover">
                <span class="text-xs font-bold uppercase tracking-wider text-rose-800 dark:text-rose-300 block">Laporan Baru</span>
                <span class="text-2xl sm:text-3xl font-black text-rose-950 dark:text-rose-200 mt-2 block">{{ $stats['new_reports'] }}</span>
                <span class="text-[11px] text-rose-800/80 dark:text-rose-300/80 mt-0.5 block">Menunggu verifikasi awal</span>
            </div>
        </div>

        {{-- ── Grid Grafik Chart.js ─────────────────────────── --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Grafik 1: Tren Bulanan --}}
            <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-6 shadow-xs">
                <div class="pb-3 border-b border-slate-100 dark:border-slate-800 mb-4">
                    <h2 class="text-base font-black text-slate-900 dark:text-slate-100">
                        Tren Laporan (6 Bulan Terakhir)
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Frekuensi aduan perundungan peserta didik per bulan
                    </p>
                </div>
                <div class="relative h-64 sm:h-72 w-full">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            {{-- Grafik 2: Sebaran Kategori --}}
            <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-6 shadow-xs">
                <div class="pb-3 border-b border-slate-100 dark:border-slate-800 mb-4">
                    <h2 class="text-base font-black text-slate-900 dark:text-slate-100">
                        Sebaran Berdasarkan Kategori
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Proporsi tipe perundungan yang dilaporkan
                    </p>
                </div>
                <div class="relative h-64 sm:h-72 w-full flex items-center justify-center">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>

            {{-- Grafik 3: Status Laporan --}}
            <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-6 shadow-xs">
                <div class="pb-3 border-b border-slate-100 dark:border-slate-800 mb-4">
                    <h2 class="text-base font-black text-slate-900 dark:text-slate-100">
                        Distribusi Status Penanganan
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Tahapan proses aduan yang tercatat
                    </p>
                </div>
                <div class="relative h-64 sm:h-72 w-full">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            {{-- Grafik 4: Sebaran Tingkat Kelas --}}
            <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-6 shadow-xs">
                <div class="pb-3 border-b border-slate-100 dark:border-slate-800 mb-4">
                    <h2 class="text-base font-black text-slate-900 dark:text-slate-100">
                        Sebaran Berdasarkan Tingkat Kelas
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Jumlah laporan per jenjang kelas (7, 8, dan 9)
                    </p>
                </div>
                <div class="relative h-64 sm:h-72 w-full">
                    <canvas id="gradeChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Script Inisialisasi Chart.js --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Chart === 'undefined') {
                return;
            }

            // 1. Tren Chart (Line)
            const trendCtx = document.getElementById('trendChart');
            if (trendCtx) {
                new Chart(trendCtx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode(array_column($stats['monthly_trend'], 'label')) !!},
                        datasets: [{
                            label: 'Jumlah Laporan',
                            data: {!! json_encode(array_column($stats['monthly_trend'], 'count')) !!},
                            borderColor: '#176B4D',
                            backgroundColor: 'rgba(23, 107, 77, 0.1)',
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.3,
                            pointBackgroundColor: '#176B4D',
                            pointRadius: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0 }
                            }
                        }
                    }
                });
            }

            // 2. Kategori Chart (Doughnut)
            const catCtx = document.getElementById('categoryChart');
            if (catCtx) {
                new Chart(catCtx, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode(array_column($stats['category_distribution'], 'label')) !!},
                        datasets: [{
                            data: {!! json_encode(array_column($stats['category_distribution'], 'count')) !!},
                            backgroundColor: [
                                '#176B4D',
                                '#B8E34B',
                                '#F59E0B',
                                '#0284C7',
                                '#8B5CF6',
                                '#EC4899',
                                '#94A3B8'
                            ],
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { boxWidth: 12, font: { size: 11 } }
                            }
                        }
                    }
                });
            }

            // 3. Status Chart (Bar)
            const statusCtx = document.getElementById('statusChart');
            if (statusCtx) {
                new Chart(statusCtx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode(array_column($stats['status_distribution'], 'label')) !!},
                        datasets: [{
                            label: 'Laporan',
                            data: {!! json_encode(array_column($stats['status_distribution'], 'count')) !!},
                            backgroundColor: [
                                'rgba(225, 29, 72, 0.85)',
                                'rgba(14, 165, 233, 0.85)',
                                'rgba(245, 158, 11, 0.85)',
                                'rgba(23, 107, 77, 0.85)',
                                'rgba(100, 116, 139, 0.85)'
                            ],
                            borderRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0 }
                            }
                        }
                    }
                });
            }

            // 4. Grade Chart (Bar)
            const gradeCtx = document.getElementById('gradeChart');
            if (gradeCtx) {
                new Chart(gradeCtx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode(array_column($stats['grade_distribution'], 'label')) !!},
                        datasets: [{
                            label: 'Jumlah Kasus',
                            data: {!! json_encode(array_column($stats['grade_distribution'], 'count')) !!},
                            backgroundColor: '#176B4D',
                            borderRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0 }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-layouts.app>
