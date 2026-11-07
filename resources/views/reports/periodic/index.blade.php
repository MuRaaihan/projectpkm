<x-layouts.app title="Rekap Laporan Berkala">
    <div class="px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8 max-w-7xl w-full mx-auto space-y-6 animate-fade-in">
        {{-- Header & Breadcrumb --}}
        <div>
            <div class="flex items-center gap-2 mb-1.5 text-xs">
                <a href="{{ auth()->user()->isMaster() ? route('master.dashboard') : route('bk.dashboard') }}" 
                   class="text-slate-500 hover:text-primary-700 dark:hover:text-[#5AE39D] transition">
                    {{ auth()->user()->isMaster() ? 'Dashboard Utama' : 'Dashboard Guru BK' }}
                </a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <span class="font-semibold text-primary-700 dark:text-[#5AE39D]">Rekap Laporan Berkala</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 border-b border-slate-200 dark:border-slate-800">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900 dark:text-slate-100 flex items-center gap-2.5">
                        <span>Rekap Laporan Berkala</span>
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                        Ringkasan analitik dan statistik tren kasus perundungan per bulan dan per semester tanpa memuat data identitas privat peserta didik.
                    </p>
                </div>
            </div>
        </div>

        {{-- Panel Kontrol & Generate Rekapitulasi --}}
        <div class="bg-gradient-to-br from-white to-slate-50/80 dark:from-[#16231D] dark:to-[#121c17] rounded-2xl border border-slate-200/90 dark:border-slate-800/90 p-5 sm:p-6 shadow-xs">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                {{-- Info Box Kiri --}}
                <div class="flex items-start gap-4 max-w-xl">
                    <div class="w-11 h-11 rounded-2xl bg-primary-100 dark:bg-primary-950/70 border border-primary-200 dark:border-primary-900 flex items-center justify-center shrink-0 text-primary-700 dark:text-[#5AE39D]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-slate-100">
                            Pembaruan Rekapitulasi Berkala
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                            Sistem secara otomatis menghitung rekapitulasi data setiap awal bulan. Anda juga dapat memperbarui atau menghitung ulang rekap secara manual kapan saja di bawah ini.
                        </p>
                    </div>
                </div>

                {{-- Form Kontrol Kanan --}}
                <form method="POST" action="{{ route('periodic-reports.generate') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 w-full lg:w-auto shrink-0">
                    @csrf
                    <div class="relative flex-1 sm:w-44">
                        <select name="period" 
                                aria-label="Pilih Periode Rekapitulasi"
                                class="w-full appearance-none pl-3.5 pr-8 py-2.5 text-xs sm:text-sm font-semibold border border-slate-300 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D] min-h-[44px] bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 cursor-pointer shadow-2xs">
                            <option value="monthly">Periode Bulan Ini</option>
                            <option value="semester">Periode Semester Ini</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>

                    <button type="submit" 
                            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white text-xs sm:text-sm font-bold rounded-xl transition min-h-[44px] shadow-xs active:scale-[0.98] cursor-pointer shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span>Perbarui Rekap</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- Navigasi Filter Tab Segmented --}}
        <div class="flex items-center justify-between gap-4 flex-wrap">
            <div class="inline-flex items-center p-1 bg-slate-100 dark:bg-slate-800/80 rounded-xl border border-slate-200/80 dark:border-slate-700/80 text-xs sm:text-sm font-semibold">
                <a href="{{ route('periodic-reports.index') }}" 
                   class="px-3.5 py-1.5 rounded-lg transition duration-150 {{ !request('type') ? 'bg-white dark:bg-[#16231D] text-primary-700 dark:text-[#5AE39D] shadow-2xs font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200' }}">
                    Semua Periode
                </a>
                <a href="{{ route('periodic-reports.index', ['type' => 'monthly']) }}" 
                   class="px-3.5 py-1.5 rounded-lg transition duration-150 {{ request('type') === 'monthly' ? 'bg-white dark:bg-[#16231D] text-primary-700 dark:text-[#5AE39D] shadow-2xs font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200' }}">
                    Bulanan
                </a>
                <a href="{{ route('periodic-reports.index', ['type' => 'semester']) }}" 
                   class="px-3.5 py-1.5 rounded-lg transition duration-150 {{ request('type') === 'semester' ? 'bg-white dark:bg-[#16231D] text-primary-700 dark:text-[#5AE39D] shadow-2xs font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200' }}">
                    Semesteran
                </a>
            </div>

            <div class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                Total Tersedia: <span class="font-bold text-slate-900 dark:text-slate-100">{{ $summaries->total() }}</span> ringkasan
            </div>
        </div>

        {{-- Grid Daftar Ringkasan Rekapitulasi --}}
        @if($summaries->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($summaries as $summary)
                    @php
                        $resolvedRate = $summary->total_reports > 0 
                            ? round(($summary->resolved_reports / $summary->total_reports) * 100) 
                            : 0;
                    @endphp
                    <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs hover:border-primary-500/70 dark:hover:border-primary-500/50 hover:shadow-sm transition-all duration-200 flex flex-col justify-between group">
                        <div class="space-y-4">
                            {{-- Header Kartu: Tipe & Waktu Generate --}}
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full {{ $summary->period_type === 'monthly' ? 'bg-primary-50 text-primary-700 dark:bg-primary-950/60 dark:text-[#5AE39D] border border-primary-200 dark:border-primary-900' : 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-800' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $summary->period_type === 'monthly' ? 'bg-primary-600 dark:bg-[#5AE39D]' : 'bg-indigo-600 dark:bg-indigo-400' }}"></span>
                                    <span>{{ $summary->period_type === 'monthly' ? 'Rekap Bulanan' : 'Rekap Semester' }}</span>
                                </span>
                                <span class="text-[11px] text-slate-400 flex items-center gap-1 font-mono">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>{{ $summary->generated_at->format('d/m/Y H:i') }}</span>
                                </span>
                            </div>

                            {{-- Judul & Periode Waktu --}}
                            <div>
                                <h3 class="text-lg font-extrabold text-slate-900 dark:text-slate-100 group-hover:text-primary-700 dark:group-hover:text-[#5AE39D] transition-colors leading-snug">
                                    {{ $summary->period_label }}
                                </h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>{{ $summary->start_date->format('d M Y') }} – {{ $summary->end_date->format('d M Y') }}</span>
                                </p>
                            </div>

                            {{-- Progress Bar Penanganan Kasus --}}
                            <div class="space-y-1.5 bg-slate-50/80 dark:bg-slate-900/50 p-3 rounded-xl border border-slate-100 dark:border-slate-800">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-slate-500 dark:text-slate-400 font-semibold">Tingkat Penanganan</span>
                                    <span class="font-extrabold text-primary-700 dark:text-[#5AE39D]">{{ $resolvedRate }}% Selesai</span>
                                </div>
                                <div class="w-full bg-slate-200 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                    <div class="bg-primary-600 dark:bg-[#5AE39D] h-full rounded-full transition-all duration-300" style="width: {{ $resolvedRate }}%"></div>
                                </div>
                            </div>

                            {{-- 4 Kotak Metrik Ringkas --}}
                            <div class="grid grid-cols-2 gap-2 text-center text-xs">
                                <div class="p-2.5 bg-slate-50 dark:bg-slate-900/40 rounded-xl border border-slate-100 dark:border-slate-800/80">
                                    <span class="text-slate-400 dark:text-slate-500 block text-[10px] font-semibold uppercase tracking-wider">Total Kasus</span>
                                    <span class="text-lg font-black text-slate-900 dark:text-slate-100 font-mono mt-0.5 block">{{ $summary->total_reports }}</span>
                                </div>
                                <div class="p-2.5 bg-primary-50/70 dark:bg-primary-950/30 rounded-xl border border-primary-100 dark:border-primary-900/60">
                                    <span class="text-primary-700 dark:text-[#5AE39D] block text-[10px] font-semibold uppercase tracking-wider">Tuntas</span>
                                    <span class="text-lg font-black text-primary-800 dark:text-[#5AE39D] font-mono mt-0.5 block">{{ $summary->resolved_reports }}</span>
                                </div>
                                <div class="p-2.5 bg-rose-50/70 dark:bg-rose-950/30 rounded-xl border border-rose-100 dark:border-rose-900/60">
                                    <span class="text-rose-700 dark:text-rose-400 block text-[10px] font-semibold uppercase tracking-wider">Urgensi Tinggi</span>
                                    <span class="text-lg font-black text-rose-800 dark:text-rose-300 font-mono mt-0.5 block">{{ $summary->urgent_high_reports }}</span>
                                </div>
                                <div class="p-2.5 bg-teal-50/70 dark:bg-teal-950/30 rounded-xl border border-teal-100 dark:border-teal-900/60">
                                    <span class="text-teal-700 dark:text-teal-400 block text-[10px] font-semibold uppercase tracking-wider">Rata-rata Waktu</span>
                                    <span class="text-lg font-black text-teal-800 dark:text-teal-300 font-mono mt-0.5 block">
                                        {{ $summary->avg_resolution_days !== null ? $summary->avg_resolution_days.'h' : '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Footer Kartu: Tombol Aksi --}}
                        <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800">
                            <a href="{{ route('periodic-reports.show', $summary) }}" 
                               class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-xs sm:text-sm font-bold text-primary-700 dark:text-[#5AE39D] bg-primary-50/70 dark:bg-primary-950/40 hover:bg-primary-100 dark:hover:bg-primary-900/50 border border-primary-200/80 dark:border-primary-900 rounded-xl transition-all duration-150 min-h-[42px] cursor-pointer group-hover:bg-primary-600 group-hover:text-white dark:group-hover:bg-primary-600 dark:group-hover:text-white">
                                <span>Lihat Rincian Analisis</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($summaries->hasPages())
                <div class="pt-4 flex justify-center">
                    {{ $summaries->links() }}
                </div>
            @endif
        @else
            {{-- Tampilan Kosong Ramah Pengguna (Empty State) --}}
            <div class="bg-surface-card dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-3xl p-8 sm:p-12 text-center shadow-xs max-w-2xl mx-auto space-y-5">
                <div class="w-16 h-16 rounded-3xl bg-primary-50 dark:bg-primary-950/60 border border-primary-200 dark:border-primary-900/60 flex items-center justify-center mx-auto text-primary-600 dark:text-[#5AE39D] shadow-xs">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                
                <div class="space-y-1.5">
                    <h3 class="text-base sm:text-lg font-black text-slate-900 dark:text-slate-100">
                        Belum Ada Rekap Laporan Berkala
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 max-w-md mx-auto leading-relaxed">
                        Sistem belum mendeteksi rekapitulasi data. Anda dapat langsung membuat rekapitulasi statistik periode bulan ini dengan menekan tombol di bawah.
                    </p>
                </div>

                <form method="POST" action="{{ route('periodic-reports.generate') }}" class="inline-block">
                    @csrf
                    <input type="hidden" name="period" value="monthly">
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white text-xs sm:text-sm font-bold rounded-xl transition shadow-xs active:scale-[0.98] cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Buat Rekapitulasi Bulan Ini Sekarang</span>
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-layouts.app>
