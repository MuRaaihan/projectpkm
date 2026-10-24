<x-layouts.app title="Laporan Saya">
    <div 
        x-data="{
            activeTab: 'semua',
            reports: {{ $reports->count() }}
        }"
        class="px-4 py-5 sm:px-6 sm:py-6 flex flex-col gap-6 max-w-5xl w-full mx-auto lg:px-8 lg:py-8 animate-fade-in"
    >
        {{-- ── Page Title Header ──────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <a href="{{ route('siswa.dashboard') }}" class="text-xs sm:text-sm font-medium text-slate-500 hover:text-primary-700 dark:hover:text-[#5AE39D] transition-colors">
                        Dashboard Siswa
                    </a>
                    <span class="text-xs text-slate-400">/</span>
                    <span class="text-xs sm:text-sm font-semibold text-primary-700 dark:text-[#5AE39D]">Laporan Saya</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">
                    Laporan Saya
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-1">
                    Pantau tahapan tindak lanjut dan respon Guru BK atas aduan yang telah kamu ajukan.
                </p>
            </div>

            <a href="{{ route('siswa.reports.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white text-xs sm:text-sm font-bold shadow-xs card-hover transition-colors shrink-0">
                <svg class="w-4 h-4 text-[#B8E34B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>Buat Laporan Baru</span>
            </a>
        </div>

        {{-- ── Filter Tabs ──────────────────────────── --}}
        @php
            $tabList = [
                'semua' => 'Semua',
                'baru' => 'Baru',
                'diverifikasi' => 'Diverifikasi',
                'diproses' => 'Diproses',
                'selesai' => 'Selesai',
                'ditolak' => 'Ditolak',
            ];
        @endphp
        <div class="flex items-center gap-2 pb-2 overflow-x-auto scrollbar-hide border-b border-slate-200/80 dark:border-slate-800" role="tablist" aria-label="Filter status laporan">
            @foreach ($tabList as $key => $label)
                @php
                    $countForTab = $key === 'semua' 
                        ? $reports->total() 
                        : $reports->where('status', $key)->count();
                @endphp
                <button 
                    type="button"
                    role="tab"
                    @click="activeTab = '{{ $key }}'"
                    :class="activeTab === '{{ $key }}' 
                        ? 'bg-primary-600 text-white shadow-xs' 
                        : 'bg-slate-100 dark:bg-slate-800/80 text-slate-600 dark:text-slate-300 hover:bg-slate-200/80 dark:hover:bg-slate-700/80'"
                    class="shrink-0 flex items-center gap-2 px-4 py-2.5 min-h-[44px] rounded-xl text-xs font-bold whitespace-nowrap transition-all duration-150"
                >
                    <span x-show="activeTab === '{{ $key }}'" class="w-1.5 h-1.5 rounded-full bg-[#B8E34B]"></span>
                    <span>{{ $label }}</span>
                    @if ($countForTab > 0)
                        <span 
                            :class="activeTab === '{{ $key }}' ? 'bg-white/20 text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200'"
                            class="text-[10px] font-bold px-1.5 py-0.5 rounded-full leading-none">
                            {{ $countForTab }}
                        </span>
                    @endif
                </button>
            @endforeach
        </div>

        {{-- ── Report Cards List ──────────────────────────── --}}
        <div class="flex flex-col gap-3.5">
            @forelse ($reports as $report)
                <div 
                    x-show="activeTab === 'semua' || activeTab === '{{ $report->status }}'"
                    class="bg-surface-card dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-5 hover:border-primary-400 dark:hover:border-primary-600 hover:shadow-xs card-hover transition-all duration-150 flex flex-col sm:flex-row sm:items-center justify-between gap-4 group"
                >
                    <div class="flex-1 min-w-0">
                        {{-- Meta line: ID, Date, Privacy Badge --}}
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            <span class="text-xs font-mono font-bold text-slate-500 dark:text-slate-400">
                                #LAP-{{ str_pad($report->id, 4, '0', STR_PAD_LEFT) }}
                            </span>
                            <span class="text-slate-300 dark:text-slate-600">•</span>
                            <span class="inline-flex items-center gap-1 text-xs text-slate-500 dark:text-slate-400 font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $report->incident_date->format('d M Y') }}
                            </span>

                            <span class="text-slate-300 dark:text-slate-600">•</span>
                            <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full {{ $report->reporter_role === 'korban' ? 'bg-amber-100/70 dark:bg-amber-950/50 text-amber-900 dark:text-[#FAD46B]' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300' }}">
                                {{ $report->reporter_role === 'korban' ? 'Sebagai Korban' : 'Sebagai Saksi' }}
                            </span>

                            @if ($report->is_hidden_identity)
                                <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-primary-700 dark:text-[#5AE39D] bg-primary-50 dark:bg-primary-950/50 px-2 py-0.5 rounded-full border border-primary-200 dark:border-primary-900">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    Pelapor Rahasia
                                </span>
                            @endif
                        </div>

                        {{-- Category title --}}
                        <a href="{{ route('siswa.reports.show', $report) }}" class="block">
                            <h2 class="text-base font-extrabold text-slate-900 dark:text-slate-100 group-hover:text-primary-700 dark:group-hover:text-[#5AE39D] transition-colors truncate">
                                {{ $report->category->name }}
                            </h2>
                        </a>

                        {{-- Snippet --}}
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 line-clamp-2 leading-relaxed mt-1.5">
                            {{ $report->description }}
                        </p>

                        {{-- Location & Attachments count --}}
                        <div class="flex items-center gap-3 mt-2.5 text-[11px] text-slate-500 dark:text-slate-400">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $report->location }}
                            </span>
                            @if ($report->attachments->count() > 0)
                                <span class="flex items-center gap-1 text-primary-700 dark:text-[#5AE39D] font-medium">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                    {{ $report->attachments->count() }} Lampiran
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Status Badge & Action Button --}}
                    <div class="flex items-center justify-between sm:justify-end gap-3 shrink-0 pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-100 dark:border-slate-800">
                        <x-badge :variant="$report->status">
                            {{ $report->status_label }}
                        </x-badge>

                        <a href="{{ route('siswa.reports.show', $report) }}" 
                           class="w-11 h-11 min-w-[44px] min-h-[44px] rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-300 group-hover:bg-primary-600 group-hover:text-white inline-flex items-center justify-center transition-all duration-150"
                           aria-label="Buka detail laporan">
                            <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-surface-card dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-8 sm:p-12 text-center flex flex-col items-center justify-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-[#5AE39D] flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div class="max-w-md">
                        <h3 class="text-base font-bold text-slate-900 dark:text-slate-100">
                            Belum Ada Laporan yang Dibuat
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                            Semua laporan perundungan yang kamu kirimkan akan tercatat aman di sini. Jangan ragu melapor jika kamu mengalami atau melihat perundungan.
                        </p>
                    </div>
                    <a href="{{ route('siswa.reports.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white text-xs sm:text-sm font-bold shadow-xs card-hover transition">
                        <svg class="w-4 h-4 text-[#B8E34B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span>Buat Laporan Sekarang</span>
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($reports->hasPages())
            <div class="pt-4 border-t border-slate-200/80 dark:border-slate-800">
                {{ $reports->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>
