<x-layouts.app title="Dashboard Guru BK">
    <div class="px-4 py-5 sm:px-6 sm:py-6 flex flex-col gap-6 max-w-6xl w-full mx-auto lg:px-8 lg:py-8 animate-fade-in">
        {{-- ── Welcome Header ───────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200/80 dark:border-slate-800">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-100/80 dark:bg-primary-950/70 text-primary-800 dark:text-[#5AE39D] text-xs font-bold mb-2">
                    <span class="w-2 h-2 rounded-full bg-primary-600 dark:bg-[#5AE39D]"></span>
                    <span>Guru Bimbingan & Konseling</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">
                    Selamat datang, {{ auth()->user()->name }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-1">
                    Portal penanganan resmi, mediasi, dan pendampingan psikologis peserta didik MTs Soebono Mantofani.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('bk.reports.index') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white text-xs sm:text-sm font-bold shadow-xs card-hover transition shrink-0">
                    <svg class="w-4 h-4 text-[#B8E34B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Buka Semua Laporan</span>
                </a>
            </div>
        </div>

        {{-- ── Alert Banner: Laporan Baru Prioritas (FR-20 / Desain GBK) ── --}}
        @if (($new_reports ?? 0) > 0)
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-amber-50/90 dark:bg-[#261A05] border border-amber-300 dark:border-amber-800/80 rounded-2xl p-5 shadow-xs animate-slide-up">
                <div class="flex items-start gap-3.5">
                    <div class="w-11 h-11 rounded-xl bg-amber-100 dark:bg-amber-900/50 border border-amber-300 dark:border-amber-700 text-amber-800 dark:text-[#FAD46B] flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <p class="text-base font-extrabold text-amber-950 dark:text-[#FAD46B]">
                            {{ $new_reports }} Laporan Baru Memerlukan Verifikasi Segera
                        </p>
                        <p class="text-xs text-amber-900/80 dark:text-amber-200/90 mt-0.5 leading-relaxed">
                            Laporan masuk membutuhkan respon validasi awal dalam 1x24 jam kerja untuk menentukan pendampingan konseling yang tepat.
                        </p>
                    </div>
                </div>

                <a href="{{ route('bk.reports.index', ['status' => 'baru']) }}" 
                   class="px-5 py-2.5 rounded-xl bg-amber-800 hover:bg-amber-900 text-white text-xs font-bold transition-colors shrink-0 shadow-xs flex items-center justify-center gap-1.5">
                    <span>Tinjau Laporan</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        @endif

        {{-- ── Asymmetrical KPI Matrix ──────────────────────── --}}
        <section aria-labelledby="kpi-heading" class="animate-slide-up stagger-1">
            <div class="flex items-center justify-between mb-3.5">
                <h2 id="kpi-heading" class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    Statistik Kasus Sekolah
                </h2>
                <span class="text-xs font-semibold text-slate-600 dark:text-slate-300">
                    Total {{ $total_reports ?? 0 }} laporan tercatat
                </span>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Total Kasus --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs flex flex-col justify-between card-hover">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Kasus</span>
                        <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-100 block">{{ $total_reports ?? 0 }}</span>
                        <span class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 block">Seluruh kasus terdata</span>
                    </div>
                </div>

                {{-- Aduan Baru --}}
                <div class="bg-rose-50/60 dark:bg-[#251012] rounded-2xl border border-rose-200/80 dark:border-rose-900/60 p-5 shadow-xs flex flex-col justify-between card-hover">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-rose-800 dark:text-rose-300">Aduan Baru</span>
                        <div class="w-9 h-9 rounded-xl bg-rose-100 dark:bg-rose-900/50 text-rose-700 dark:text-rose-300 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-2xl sm:text-3xl font-black text-rose-950 dark:text-rose-200 block">{{ $new_reports ?? 0 }}</span>
                        <span class="text-[11px] text-rose-800/80 dark:text-rose-300/80 mt-0.5 block">Menunggu verifikasi BK</span>
                    </div>
                </div>

                {{-- Dalam Penanganan --}}
                <div class="bg-amber-50/60 dark:bg-[#261A05] rounded-2xl border border-amber-200/80 dark:border-amber-800/80 p-5 shadow-xs flex flex-col justify-between card-hover">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-800 dark:text-[#FAD46B]">Dalam Penanganan</span>
                        <div class="w-9 h-9 rounded-xl bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-[#FAD46B] flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-2xl sm:text-3xl font-black text-amber-950 dark:text-[#FAD46B] block">{{ $active_reports ?? 0 }}</span>
                        <span class="text-[11px] text-amber-800/80 dark:text-amber-200/80 mt-0.5 block">Verifikasi / mediasi aktif</span>
                    </div>
                </div>

                {{-- Selesai Ditangani --}}
                <div class="bg-emerald-50/60 dark:bg-[#153222] rounded-2xl border border-emerald-200/80 dark:border-emerald-800/80 p-5 shadow-xs flex flex-col justify-between card-hover">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 dark:text-[#5AE39D]">Selesai Ditangani</span>
                        <div class="w-9 h-9 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-[#5AE39D] flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-2xl sm:text-3xl font-black text-emerald-950 dark:text-[#5AE39D] block">{{ $resolved_reports ?? 0 }}</span>
                        <span class="text-[11px] text-emerald-800/80 dark:text-emerald-200/80 mt-0.5 block">Penanganan tuntas</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── Laporan Terbaru Masuk (Card & Table) ──────────── --}}
        <section aria-labelledby="recent-heading" class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 overflow-hidden shadow-xs">
            <div class="p-5 sm:p-6 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 id="recent-heading" class="text-base sm:text-lg font-black text-slate-900 dark:text-slate-100">
                        Laporan Terbaru Masuk
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Daftar laporan terkini yang dikirim oleh peserta didik.
                    </p>
                </div>

                <a href="{{ route('bk.reports.index') }}" class="text-xs font-bold text-primary-700 dark:text-[#5AE39D] hover:underline flex items-center gap-1 self-start sm:self-auto">
                    <span>Lihat Semua Laporan</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            @if(isset($recent_reports) && $recent_reports->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs sm:text-sm text-slate-900 dark:text-slate-100 border-collapse">
                        <thead class="bg-slate-50/80 dark:bg-slate-900/60 border-b border-slate-200/80 dark:border-slate-800 text-[11px] uppercase font-bold text-slate-500 dark:text-slate-400">
                            <tr>
                                <th class="px-5 py-3.5">ID & Waktu</th>
                                <th class="px-5 py-3.5">Pelapor</th>
                                <th class="px-5 py-3.5">Kelas</th>
                                <th class="px-5 py-3.5">Kategori</th>
                                <th class="px-5 py-3.5">Status</th>
                                <th class="px-5 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                            @foreach($recent_reports as $item)
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-900/40 transition">
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <span class="font-mono font-bold text-slate-900 dark:text-slate-100 block">
                                            #LAP-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                                        </span>
                                        <span class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 block">
                                            {{ $item->created_at->format('d M Y, H:i') }} WIB
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if($item->is_hidden_identity)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-primary-50 dark:bg-primary-950/50 text-primary-800 dark:text-[#5AE39D] border border-primary-200 dark:border-primary-900">
                                                <svg class="w-3.5 h-3.5 text-primary-600 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                                Pelapor Rahasia
                                            </span>
                                        @else
                                            <span class="font-bold text-slate-900 dark:text-slate-100">{{ $item->reporter_display_name }}</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-slate-600 dark:text-slate-300">
                                        {{ $item->reporter_class_name ?? '-' }}
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap font-bold text-slate-900 dark:text-slate-100">
                                        {{ $item->category->name ?? 'Lainnya' }}
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <x-badge :variant="$item->status">
                                            {{ $item->status_label }}
                                        </x-badge>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-right">
                                        <a href="{{ route('bk.reports.show', $item) }}" 
                                           class="inline-flex items-center gap-1.5 px-3.5 py-1.5 min-h-[36px] text-xs font-bold text-primary-700 dark:text-[#5AE39D] hover:bg-primary-50 dark:hover:bg-primary-950/50 rounded-xl transition">
                                            <span>Buka Laporan</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 sm:p-12 text-center flex flex-col items-center justify-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-slate-100">Belum Ada Laporan Masuk</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 max-w-sm">
                        Saat ini belum ada aduan baru yang membutuhkan penanganan Guru BK.
                    </p>
                </div>
            @endif
        </section>
    </div>
</x-layouts.app>
