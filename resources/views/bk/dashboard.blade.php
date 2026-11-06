<x-layouts.app title="Portal Konseling Guru BK">
    @php
        $verified_count = \App\Models\Report::where('status', 'diverifikasi')->count();
        $processing_count = \App\Models\Report::where('status', 'diproses')->count();
        $categories = \App\Models\Category::withCount('reports')->get();
        $categoryBarColors = [
            'bg-primary-600 dark:bg-[#5AE39D]',
            'bg-amber-500 dark:bg-[#FAD46B]',
            'bg-[#3F570E] dark:bg-[#D2F365]',
            'bg-sky-600 dark:bg-sky-400',
            'bg-red-500 dark:bg-red-400',
        ];
    @endphp

    <div class="px-4 sm:px-6 lg:px-8 py-6 flex flex-col gap-6 max-w-6xl w-full mx-auto animate-fade-in" x-data="{ filterMode: 'all' }">
        {{-- ── Mobile Page Title (Sesuai GBKDashboardPage) ── --}}
        <div class="lg:hidden">
            <h1 class="text-xl font-black text-slate-900 dark:text-slate-100">
                Portal Guru BK
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                Monitoring penanganan aduan siswa & konseling
            </p>
        </div>

        {{-- ── Alert Banner: Laporan Baru Prioritas (Sesuai GBKDashboardPage:88-112) ── --}}
        @if (($new_reports ?? 0) > 0)
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-amber-50/90 dark:bg-[#261A05] border border-amber-300 dark:border-amber-800/80 rounded-2xl p-5 shadow-xs animate-slide-up">
                <div class="flex items-start gap-4">
                    <div class="w-11 h-11 rounded-xl bg-amber-100 dark:bg-amber-900/50 border border-amber-300 dark:border-amber-700 text-amber-800 dark:text-[#FAD46B] flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <p class="text-base font-extrabold text-amber-950 dark:text-[#FAD46B]">
                            {{ $new_reports }} Laporan Baru Memerlukan Verifikasi Segera
                        </p>
                        <p class="text-xs text-amber-800 dark:text-amber-200/90 mt-1 leading-relaxed">
                            Laporan masuk membutuhkan validasi kronologi dalam 1x24 jam kerja untuk menentukan pendampingan konseling yang tepat.
                        </p>
                    </div>
                </div>

                <a href="{{ route('bk.reports.index', ['status' => 'baru']) }}" 
                   class="px-5 py-2.5 rounded-xl bg-amber-800 hover:bg-amber-900 text-white text-xs font-bold transition-colors shrink-0 shadow-xs flex items-center justify-center gap-1.5 cursor-pointer">
                    <span>Tinjau Laporan</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        @endif

        {{-- ── Asymmetrical KPI Matrix (5 KPI Cards Sesuai Frontend) ── --}}
        <section aria-labelledby="kpi-heading" class="animate-slide-up stagger-1">
            <div class="flex items-center justify-between mb-3.5">
                <h2 id="kpi-heading" class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    Statistik Kasus Sekolah
                </h2>
                <span class="text-xs font-semibold text-slate-600 dark:text-slate-300">
                    Total {{ $total_reports ?? 0 }} laporan tercatat
                </span>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5">
                {{-- 1. Total Kasus --}}
                <div class="bg-surface-card dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl p-4.5 shadow-xs flex flex-col justify-between card-hover">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Kasus</span>
                        <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-slate-900 dark:text-slate-100 tabular-nums">{{ $total_reports ?? 0 }}</p>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Seluruh kasus terdata</p>
                    </div>
                </div>

                {{-- 2. Aduan Baru --}}
                <div class="bg-surface-card dark:bg-[#16231D] border border-rose-200/80 dark:border-rose-900/50 rounded-2xl p-4.5 shadow-xs flex flex-col justify-between card-hover">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-rose-800 dark:text-rose-400">Aduan Baru</span>
                        <div class="w-8 h-8 rounded-lg bg-rose-50 dark:bg-rose-950/60 text-rose-700 dark:text-rose-400 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-rose-900 dark:text-rose-300 tabular-nums">{{ $new_reports ?? 0 }}</p>
                        <p class="text-[11px] text-rose-700 dark:text-rose-400 mt-0.5">Perlu ditinjau</p>
                    </div>
                </div>

                {{-- 3. Validasi --}}
                <div class="bg-surface-card dark:bg-[#16231D] border border-amber-200/80 dark:border-amber-900/50 rounded-2xl p-4.5 shadow-xs flex flex-col justify-between card-hover">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-800 dark:text-[#FAD46B]">Validasi</span>
                        <div class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-[#FAD46B] flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-amber-900 dark:text-[#FAD46B] tabular-nums">{{ $verified_count }}</p>
                        <p class="text-[11px] text-amber-700 dark:text-amber-300 mt-0.5">Tahap verifikasi</p>
                    </div>
                </div>

                {{-- 4. Konseling --}}
                <div class="bg-surface-card dark:bg-[#16231D] border border-amber-200/80 dark:border-amber-900/50 rounded-2xl p-4.5 shadow-xs flex flex-col justify-between card-hover">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-800 dark:text-amber-400">Konseling</span>
                        <div class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-[#FAD46B] flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-amber-900 dark:text-[#FAD46B] tabular-nums">{{ $processing_count }}</p>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Proses pendampingan</p>
                    </div>
                </div>

                {{-- 5. Tuntas --}}
                <div class="bg-surface-card dark:bg-[#16231D] border border-emerald-200/80 dark:border-emerald-900/50 rounded-2xl p-4.5 shadow-xs flex flex-col justify-between card-hover col-span-2 sm:col-span-1">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 dark:text-[#5AE39D]">Tuntas</span>
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-[#5AE39D] flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-emerald-900 dark:text-[#5AE39D] tabular-nums">{{ $resolved_reports ?? 0 }}</p>
                        <p class="text-[11px] text-emerald-700 dark:text-emerald-300 mt-0.5">Kasus diselesaikan</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── Case Queue (3/5) + Category Distribution (2/5) Sesuai Frontend ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 animate-slide-up stagger-2">
            {{-- Kolom Kiri: Antrean Laporan (3/5) --}}
            <section aria-labelledby="recent-heading" class="lg:col-span-3 min-w-0 flex flex-col justify-between">
                <div>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 mb-3.5">
                        <div>
                            <h2 id="recent-heading" class="text-sm font-bold text-slate-900 dark:text-slate-100">
                                Antrean Tindak Lanjut Kasus
                            </h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                Pilih filter untuk mempersempit prioritas penanganan
                            </p>
                        </div>

                        {{-- Quick filter pills (Sesuai Frontend GBKDashboardPage) --}}
                        <div class="flex items-center gap-1.5 p-1 bg-slate-100 dark:bg-slate-800 rounded-xl">
                            <button type="button"
                                    @click="filterMode = 'all'"
                                    :class="filterMode === 'all' ? 'bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 shadow-2xs font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900'"
                                    class="px-2.5 py-1 text-xs font-semibold rounded-lg transition-all cursor-pointer">
                                Semua
                            </button>
                            <button type="button"
                                    @click="filterMode = 'urgent'"
                                    :class="filterMode === 'urgent' ? 'bg-white dark:bg-slate-700 text-amber-700 dark:text-[#FAD46B] shadow-2xs font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900'"
                                    class="px-2.5 py-1 text-xs font-semibold rounded-lg transition-all cursor-pointer">
                                Mendesak
                            </button>
                            <button type="button"
                                    @click="filterMode = 'progress'"
                                    :class="filterMode === 'progress' ? 'bg-white dark:bg-slate-700 text-primary-700 dark:text-[#5AE39D] shadow-2xs font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900'"
                                    class="px-2.5 py-1 text-xs font-semibold rounded-lg transition-all cursor-pointer">
                                Konseling
                            </button>
                            <button type="button"
                                    @click="filterMode = 'done'"
                                    :class="filterMode === 'done' ? 'bg-white dark:bg-slate-700 text-emerald-700 dark:text-emerald-400 shadow-2xs font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900'"
                                    class="px-2.5 py-1 text-xs font-semibold rounded-lg transition-all cursor-pointer">
                                Selesai
                            </button>
                        </div>
                    </div>

                    {{-- Desktop Table --}}
                    <div class="hidden md:block bg-surface-card dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-xs">
                        <table class="w-full text-sm">
                            <thead class="border-b border-slate-200 dark:border-slate-800 bg-slate-50/80 dark:bg-slate-800/60">
                                <tr>
                                    <th class="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                        No Tiket
                                    </th>
                                    <th class="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                        Kategori Kasus
                                    </th>
                                    <th class="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                        Tanggal Masuk
                                    </th>
                                    <th class="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                        Status
                                    </th>
                                    <th class="px-4 py-3 text-right"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse($recent_reports as $report)
                                    @php
                                        $statusClass = match($report->status) {
                                            'baru' => 'urgent',
                                            'diverifikasi' => 'urgent',
                                            'diproses' => 'progress',
                                            'selesai' => 'done',
                                            default => 'other',
                                        };
                                        $badgeVariant = match($report->status) {
                                            'baru' => 'bg-rose-50 text-rose-800 dark:bg-rose-950/60 dark:text-rose-300',
                                            'diverifikasi' => 'bg-emerald-50 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300',
                                            'diproses' => 'bg-amber-50 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300',
                                            'selesai' => 'bg-emerald-50 text-emerald-800 dark:bg-emerald-950/60 dark:text-[#5AE39D]',
                                            default => 'bg-slate-100 text-slate-800',
                                        };
                                    @endphp
                                    <tr x-show="filterMode === 'all' || (filterMode === 'urgent' && '{{ $statusClass }}' === 'urgent') || (filterMode === 'progress' && '{{ $statusClass }}' === 'progress') || (filterMode === 'done' && '{{ $statusClass }}' === 'done')"
                                        class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors cursor-pointer group">
                                        <td class="px-4 py-3.5 font-mono text-xs font-bold text-slate-700 dark:text-slate-300">
                                            #{{ substr($report->id, 0, 8) }}
                                        </td>
                                        <td class="px-4 py-3.5 text-sm font-bold text-slate-900 dark:text-slate-100">
                                            {{ $report->category->name ?? 'Laporan Perundungan' }}
                                        </td>
                                        <td class="px-4 py-3.5 text-xs text-slate-500 dark:text-slate-400">
                                            {{ $report->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-4 py-3.5">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $badgeVariant }}">
                                                {{ $report->status_label ?? ucfirst($report->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3.5 text-right">
                                            <a href="{{ route('bk.reports.show', $report) }}" 
                                               class="text-xs text-primary-600 dark:text-[#5AE39D] font-bold inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                                                <span>Kelola</span>
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-500 dark:text-slate-400">
                                            Belum ada laporan masuk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Card Footer Desktop --}}
                        <div class="px-5 py-3.5 bg-slate-50/70 dark:bg-slate-800/40 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                            <span class="text-slate-500 dark:text-slate-400">
                                Menampilkan antrean laporan masuk terbaru
                            </span>
                            <a href="{{ route('bk.reports.index') }}" 
                               class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl font-bold text-xs text-primary-700 dark:text-[#5AE39D] bg-primary-50 dark:bg-primary-950/60 hover:bg-primary-100 dark:hover:bg-primary-900/60 border border-primary-200/80 dark:border-primary-800/60 transition-all shadow-2xs group cursor-pointer active:scale-95">
                                <span>Buka Seluruh Daftar Kasus</span>
                                <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>

                    {{-- Mobile List Cards --}}
                    <div class="md:hidden bg-surface-card dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden divide-y divide-slate-100 dark:divide-slate-800 shadow-xs">
                        @forelse($recent_reports as $report)
                            @php
                                $statusClass = match($report->status) {
                                    'baru' => 'urgent',
                                    'diverifikasi' => 'urgent',
                                    'diproses' => 'progress',
                                    'selesai' => 'done',
                                    default => 'other',
                                };
                            @endphp
                            <a href="{{ route('bk.reports.show', $report) }}"
                               x-show="filterMode === 'all' || (filterMode === 'urgent' && '{{ $statusClass }}' === 'urgent') || (filterMode === 'progress' && '{{ $statusClass }}' === 'progress') || (filterMode === 'done' && '{{ $statusClass }}' === 'done')"
                               class="w-full text-left px-4 py-4 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors flex items-center justify-between gap-3 block">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1.5">
                                        <span class="font-mono text-xs font-bold text-slate-600 dark:text-slate-300">
                                            #{{ substr($report->id, 0, 8) }}
                                        </span>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-primary-100 dark:bg-primary-950 text-primary-700 dark:text-[#5AE39D]">
                                            {{ $report->status_label ?? ucfirst($report->status) }}
                                        </span>
                                    </div>
                                    <p class="text-sm font-bold text-slate-900 dark:text-slate-100 truncate">
                                        {{ $report->category->name ?? 'Laporan Perundungan' }}
                                    </p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                        {{ $report->created_at->format('d M Y, H:i') }} WIB
                                    </p>
                                </div>
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @empty
                            <div class="px-4 py-8 text-center text-sm text-slate-500 dark:text-slate-400">
                                Belum ada laporan masuk.
                            </div>
                        @endforelse

                        {{-- Card Footer Mobile --}}
                        <div class="p-3.5 bg-slate-50/70 dark:bg-slate-800/40 flex justify-center">
                            <a href="{{ route('bk.reports.index') }}" 
                               class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl font-bold text-xs text-primary-700 dark:text-[#5AE39D] bg-primary-50 dark:bg-primary-950/60 hover:bg-primary-100 dark:hover:bg-primary-900/60 border border-primary-200/80 dark:border-primary-800/60 transition-all shadow-2xs group cursor-pointer active:scale-95">
                                <span>Buka Seluruh Daftar Kasus</span>
                                <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Kolom Kanan: Distribusi Kategori (2/5) --}}
            <section aria-labelledby="category-heading" class="lg:col-span-2">
                <div class="flex items-center justify-between mb-3.5">
                    <h2 id="category-heading" class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        Distribusi Kategori
                    </h2>
                    <a href="{{ route('bk.statistics.index') }}" 
                       class="flex items-center gap-1 text-xs text-primary-600 dark:text-[#5AE39D] font-bold hover:underline cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <span>Analitik</span>
                    </a>
                </div>

                <div class="bg-surface-card dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-xs flex flex-col gap-4">
                    @php $totalReportsCount = max(1, $total_reports ?? 1); @endphp
                    @forelse($categories as $idx => $cat)
                        @php
                            $cnt = $cat->reports_count ?? 0;
                            $pct = round(($cnt / $totalReportsCount) * 100);
                            $barColor = $categoryBarColors[$idx % count($categoryBarColors)];
                        @endphp
                        <div class="flex flex-col gap-1.5">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-slate-800 dark:text-slate-200 truncate">
                                    {{ $cat->name }}
                                </span>
                                <span class="font-extrabold tabular-nums text-slate-900 dark:text-slate-100">
                                    {{ $cnt }} ({{ $pct }}%)
                                </span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2.5 overflow-hidden">
                                <div class="h-2.5 rounded-full transition-all duration-500 {{ $barColor }}"
                                     style="width: {{ $pct }}%;"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-4">Belum ada kategori kasus.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-layouts.app>