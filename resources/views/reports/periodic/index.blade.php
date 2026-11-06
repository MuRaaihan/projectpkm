<x-layouts.app title="Laporan Periodik Otomatis">
    <div class="px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8 max-w-6xl w-full mx-auto space-y-6 animate-fade-in">
        {{-- Header Halaman --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900 dark:text-slate-100 flex items-center gap-2.5">
                    <span>Laporan Periodik Otomatis</span>
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Rekapitulasi tren penanganan kasus perundungan per bulan dan per semester tanpa memuat data identitas privat peserta didik.
                </p>
            </div>

            {{-- Form Cepat Generate --}}
            <form method="POST" action="{{ route('periodic-reports.generate') }}" class="flex items-center gap-2.5 shrink-0">
                @csrf
                <div class="relative">
                    <select name="period" 
                        class="appearance-none pl-3.5 pr-8 py-2 text-xs sm:text-sm font-semibold border border-slate-300 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D] min-h-[42px] bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 cursor-pointer">
                        <option value="monthly">Bulan Ini</option>
                        <option value="semester">Semester Ini</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
                <button type="submit" 
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white text-xs sm:text-sm font-bold rounded-xl transition min-h-[42px] shadow-xs active:scale-[0.98] cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span>Perbarui Rekap</span>
                </button>
            </form>
        </div>

        {{-- Filter Tab --}}
        <div class="flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-2 text-xs sm:text-sm font-semibold">
            <a href="{{ route('periodic-reports.index') }}" 
               class="px-3.5 py-2 rounded-xl transition min-h-[40px] inline-flex items-center {{ !request('type') ? 'bg-primary-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                Semua Periode
            </a>
            <a href="{{ route('periodic-reports.index', ['type' => 'monthly']) }}" 
               class="px-3.5 py-2 rounded-xl transition min-h-[40px] inline-flex items-center {{ request('type') === 'monthly' ? 'bg-primary-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                Bulanan
            </a>
            <a href="{{ route('periodic-reports.index', ['type' => 'semester']) }}" 
               class="px-3.5 py-2 rounded-xl transition min-h-[40px] inline-flex items-center {{ request('type') === 'semester' ? 'bg-primary-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                Semesteran
            </a>
        </div>

        {{-- Grid Daftar Ringkasan --}}
        @if($summaries->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($summaries as $summary)
                    <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs hover:border-primary-500/70 dark:hover:border-primary-500/50 transition space-y-4 flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full {{ $summary->period_type === 'monthly' ? 'bg-primary-50 text-primary-700 dark:bg-primary-950/60 dark:text-[#5AE39D] border border-primary-200 dark:border-primary-900' : 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-800' }}">
                                    {{ $summary->period_type === 'monthly' ? 'Bulanan' : 'Semester' }}
                                </span>
                                <span class="text-[11px] font-mono text-slate-400">
                                    {{ $summary->generated_at->format('d/m/Y H:i') }}
                                </span>
                            </div>

                            <h3 class="text-base font-bold text-slate-900 dark:text-slate-100">
                                {{ $summary->period_label }}
                            </h3>
                            <p class="text-xs text-slate-400">
                                Rentang: {{ $summary->start_date->format('d M Y') }} – {{ $summary->end_date->format('d M Y') }}
                            </p>

                            <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-100 dark:border-slate-800 text-center text-xs">
                                <div class="p-2 bg-slate-50 dark:bg-slate-900/40 rounded-xl">
                                    <span class="text-slate-400 block text-[10px]">Total Laporan</span>
                                    <span class="text-base font-bold text-slate-900 dark:text-slate-100">{{ $summary->total_reports }}</span>
                                </div>
                                <div class="p-2 bg-primary-50/60 dark:bg-primary-950/30 rounded-xl">
                                    <span class="text-primary-700 dark:text-[#5AE39D] block text-[10px]">Selesai</span>
                                    <span class="text-base font-bold text-primary-800 dark:text-[#5AE39D]">{{ $summary->resolved_reports }}</span>
                                </div>
                                <div class="p-2 bg-rose-50/60 dark:bg-rose-950/30 rounded-xl">
                                    <span class="text-rose-700 dark:text-rose-400 block text-[10px]">Urgensi Tinggi</span>
                                    <span class="text-base font-bold text-rose-800 dark:text-rose-300">{{ $summary->urgent_high_reports }}</span>
                                </div>
                                <div class="p-2 bg-teal-50/60 dark:bg-teal-950/30 rounded-xl">
                                    <span class="text-teal-700 dark:text-teal-400 block text-[10px]">Rata-rata Selesai</span>
                                    <span class="text-base font-bold text-teal-800 dark:text-teal-300">
                                        {{ $summary->avg_resolution_days !== null ? $summary->avg_resolution_days.' hari' : '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-100 dark:border-slate-800">
                            <a href="{{ route('periodic-reports.show', $summary) }}" 
                               class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2.5 text-xs sm:text-sm font-bold text-primary-700 dark:text-[#5AE39D] hover:bg-primary-50 dark:hover:bg-primary-950/60 border border-primary-200 dark:border-primary-900 rounded-xl transition min-h-[42px] cursor-pointer">
                                <span>Lihat Rincian Analisis</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($summaries->hasPages())
                <div class="pt-4">
                    {{ $summaries->links() }}
                </div>
            @endif
        @else
            <div class="p-8 text-center bg-surface-card dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl">
                <x-empty-state 
                    title="Belum Ada Laporan Periodik" 
                    description="Klik tombol 'Perbarui Rekap' di pojok kanan atas untuk menghasilkan ringkasan periodik otomatis."
                />
            </div>
        @endif
    </div>
</x-layouts.app>
