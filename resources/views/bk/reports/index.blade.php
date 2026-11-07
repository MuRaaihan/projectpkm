<x-layouts.app title="Daftar Laporan Siswa">
    @php
        $statusCounts = \App\Models\Report::selectRaw('status, count(*) as count')->groupBy('status')->pluck('count', 'status');
        $totalReportsAll = \App\Models\Report::count();
        $currentStatus = request('status', '');
        $statusTabs = [
            '' => 'Semua',
            'baru' => 'Diterima',
            'diverifikasi' => 'Diverifikasi',
            'diproses' => 'Dalam Penanganan',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
        ];
        $statusColors = [
            '' => 'bg-slate-400',
            'baru' => 'bg-rose-500',
            'diverifikasi' => 'bg-sky-500',
            'diproses' => 'bg-amber-500',
            'selesai' => 'bg-emerald-500',
            'ditolak' => 'bg-slate-400',
        ];
    @endphp

    <div class="px-4 py-5 sm:px-6 sm:py-6 flex flex-col gap-6 max-w-6xl w-full mx-auto lg:px-8 lg:py-8 animate-fade-in">
        {{-- ── Header Halaman ───────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200/80 dark:border-slate-800">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <a href="{{ route('bk.dashboard') }}" class="text-xs sm:text-sm font-medium text-slate-500 hover:text-primary-700 dark:hover:text-[#5AE39D] transition-colors">
                        Dashboard Guru BK
                    </a>
                    <span class="text-xs text-slate-400">/</span>
                    <span class="text-xs sm:text-sm font-semibold text-primary-700 dark:text-[#5AE39D]">Laporan Masuk</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">
                    Daftar Laporan Siswa
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-1">
                    Pemeriksaan kronologi, verifikasi bukti, dan penetapan tindak lanjut konseling peserta didik.
                </p>
            </div>

            <div class="flex items-center gap-3 self-start sm:self-auto">
                <span class="text-xs font-bold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-900 px-3.5 py-2 border border-slate-300/80 dark:border-slate-700 rounded-xl shadow-2xs">
                    Total: <span class="text-primary-700 dark:text-[#5AE39D] font-mono">{{ $reports->total() }}</span> laporan
                </span>
            </div>
        </div>

        {{-- ── Panel Filter & Status Laporan Terpadu ─────────── --}}
        <div class="bg-white dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs overflow-hidden">
            {{-- 1. Bar Tab Status Laporan (Clean Segmented Tabs) --}}
            <div class="p-2 sm:p-2.5 bg-slate-50/80 dark:bg-slate-900/60 border-b border-slate-200/80 dark:border-slate-800">
                <div class="flex items-center gap-1.5 overflow-x-auto scrollbar-hide py-0.5">
                    @foreach($statusTabs as $val => $label)
                        @php
                            $isActive = ($val === '' && !request()->filled('status')) || (request('status') === $val);
                            $tabUrl = request()->fullUrlWithQuery(['status' => $val ?: null, 'page' => null]);
                            $tabCount = $val === '' ? $totalReportsAll : ($statusCounts[$val] ?? 0);
                        @endphp
                        <a href="{{ $tabUrl }}"
                           class="shrink-0 inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-150 {{ $isActive ? 'bg-primary-600 text-white font-bold shadow-xs' : 'bg-white dark:bg-slate-800/90 text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-700/70 border border-slate-200/70 dark:border-slate-700/60' }}">
                            <span class="w-2 h-2 rounded-full shrink-0 {{ $isActive ? 'bg-white' : ($statusColors[$val] ?? 'bg-slate-400') }}"></span>
                            <span>{{ $label }}</span>
                            <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-[11px] font-bold font-mono {{ $isActive ? 'bg-white/20 text-white' : ($tabCount > 0 ? 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300' : 'bg-slate-100 dark:bg-slate-700 text-slate-400') }}">
                                {{ $tabCount }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- 2. Formulir Filter & Pencarian Lanjutan --}}
            <form method="GET" action="{{ route('bk.reports.index') }}" class="p-4 sm:p-5 space-y-4">
                {{-- Pertahankan tab status jika sedang aktif --}}
                @if(request()->filled('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif

                {{-- Baris 1: Search & Filter Utama (12 Grid) --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-3.5">
                    {{-- Pencarian --}}
                    <div class="md:col-span-5">
                        <label for="q" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                            Cari ID Tiket / Lokasi / Pelapor
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" id="q" name="q" value="{{ request('q') }}" placeholder="Ketik nomor tiket #LAP-..., lokasi, dsb..."
                                class="w-full pl-10 pr-4 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D] transition min-h-[42px]">
                        </div>
                    </div>

                    {{-- Filter Kategori --}}
                    <div class="md:col-span-3">
                        <label for="category_id" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                            Kategori Kasus
                        </label>
                        <div class="relative">
                            <select id="category_id" name="category_id" 
                                class="w-full appearance-none pl-3.5 pr-8 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D] transition min-h-[42px] cursor-pointer font-medium">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Filter Urgensi --}}
                    <div class="md:col-span-2">
                        <label for="urgency" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                            Tingkat Urgensi
                        </label>
                        <div class="relative">
                            <select id="urgency" name="urgency" 
                                class="w-full appearance-none pl-3.5 pr-8 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D] transition min-h-[42px] cursor-pointer font-medium">
                                <option value="">Semua</option>
                                <option value="tinggi" {{ request('urgency') === 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                <option value="sedang" {{ request('urgency') === 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="rendah" {{ request('urgency') === 'rendah' ? 'selected' : '' }}>Rendah</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Filter Kelas --}}
                    <div class="md:col-span-2">
                        <label for="class_name" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                            Rombel / Kelas
                        </label>
                        <div class="relative">
                            <select id="class_name" name="class_name" 
                                class="w-full appearance-none pl-3.5 pr-8 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D] transition min-h-[42px] cursor-pointer font-medium">
                                <option value="">Semua Kelas</option>
                                @foreach($classes as $c)
                                    <option value="{{ $c->name }}" {{ request('class_name') === $c->name ? 'selected' : '' }}>
                                        {{ $c->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Baris 2: Rentang Tanggal, Urutkan & Tombol Aksi --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-3 border-t border-slate-100 dark:border-slate-800 text-xs">
                    <div class="flex flex-wrap items-center gap-2 text-slate-600 dark:text-slate-400">
                        <span class="font-bold flex items-center gap-1.5 text-slate-700 dark:text-slate-300">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Tanggal:</span>
                        </span>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" 
                            class="px-3 py-1.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D] transition min-h-[38px]">
                        <span class="text-slate-400 font-medium">s/d</span>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" 
                            class="px-3 py-1.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D] transition min-h-[38px]">

                        <div class="relative ml-0 sm:ml-2">
                            <select id="sort" name="sort" onchange="this.form.submit()" 
                                class="appearance-none pl-3 pr-8 py-1.5 text-xs font-semibold rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D] transition min-h-[38px] cursor-pointer">
                                <option value="" {{ !request('sort') ? 'selected' : '' }}>Urut: Terbaru Masuk</option>
                                <option value="urgency_desc" {{ request('sort') === 'urgency_desc' ? 'selected' : '' }}>Urut: Urgensi Tertinggi</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 self-end sm:self-auto shrink-0">
                        @if(request()->hasAny(['q', 'status', 'urgency', 'sort', 'category_id', 'class_name', 'date_from', 'date_to']))
                            <a href="{{ route('bk.reports.index') }}" 
                               class="px-3.5 py-2 min-h-[38px] inline-flex items-center justify-center bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold rounded-xl text-xs transition cursor-pointer">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                <span>Reset</span>
                            </a>
                        @endif
                        <button type="submit" 
                                class="px-4 py-2 min-h-[38px] bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white font-bold rounded-xl text-xs transition shadow-xs flex items-center gap-1.5 cursor-pointer active:scale-[0.98]">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <span>Terapkan Filter</span>
                        </button>
                    </div>
                </div>
            </form>
        {{-- ── Daftar Laporan (Desktop Table + Mobile Cards Sesuai Frontend Prototype) ── --}}
        <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 overflow-hidden shadow-xs">
            @if($reports->count() > 0)
                {{-- 1. Desktop Table --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left text-xs sm:text-sm text-slate-900 dark:text-slate-100 border-collapse">
                        <thead class="bg-slate-50/80 dark:bg-slate-900/60 border-b border-slate-200/80 dark:border-slate-800 text-[11px] uppercase font-bold text-slate-500 dark:text-slate-400">
                            <tr>
                                <th class="px-5 py-3.5">ID &amp; Waktu</th>
                                <th class="px-5 py-3.5">Urgensi</th>
                                <th class="px-5 py-3.5">Pelapor</th>
                                <th class="px-5 py-3.5">Peran</th>
                                <th class="px-5 py-3.5">Kelas</th>
                                <th class="px-5 py-3.5">Kategori</th>
                                <th class="px-5 py-3.5">Status</th>
                                <th class="px-5 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                            @foreach($reports as $report)
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-900/40 transition group">
                                    <td class="px-5 py-3.5 whitespace-nowrap">
                                        <div class="font-mono font-bold text-slate-900 dark:text-slate-100">
                                            #LAP-{{ str_pad($report->id, 4, '0', STR_PAD_LEFT) }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">
                                            {{ $report->created_at->format('d M Y, H:i') }} WIB
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap">
                                        @if($report->urgency === 'tinggi')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 dark:bg-rose-950/50 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-900">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-600 animate-pulse"></span>
                                                Tinggi
                                            </span>
                                        @elseif($report->urgency === 'sedang')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-950/50 text-amber-700 dark:text-[#FAD46B] border border-amber-200 dark:border-amber-900">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                Sedang
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                Rendah
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap">
                                        @if($report->is_hidden_identity)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-primary-50 dark:bg-primary-950/50 text-primary-800 dark:text-[#5AE39D] border border-primary-200 dark:border-primary-900">
                                                <svg class="w-3.5 h-3.5 text-primary-600 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                                Pelapor Rahasia
                                            </span>
                                        @else
                                            <span class="font-bold text-slate-900 dark:text-slate-100">{{ $report->reporter_display_name }}</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap text-xs">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full font-bold {{ $report->reporter_role === 'korban' ? 'bg-amber-100/70 dark:bg-amber-950/50 text-amber-900 dark:text-[#FAD46B]' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300' }}">
                                            {{ $report->reporter_role === 'korban' ? 'Korban' : 'Saksi' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap text-slate-600 dark:text-slate-300 font-medium">
                                        {{ $report->reporter_class_name ?? '-' }}
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap font-bold text-slate-900 dark:text-slate-100">
                                        {{ $report->category->name ?? 'Lainnya' }}
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap">
                                        <x-badge :variant="$report->status">
                                            {{ $report->status_label }}
                                        </x-badge>
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap text-right">
                                        <a href="{{ route('bk.reports.show', $report) }}" 
                                           class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold text-primary-700 dark:text-[#5AE39D] hover:bg-primary-50 dark:hover:bg-primary-950/60 rounded-xl transition group-hover:translate-x-0.5">
                                            <span>Buka Kasus</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- 2. Mobile Card List (Sesuai Frontend Prototype guru-bk/laporan/page.tsx:233-263) --}}
                <div class="md:hidden divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($reports as $report)
                        <a href="{{ route('bk.reports.show', $report) }}" 
                           class="flex items-start justify-between gap-3 p-4 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors block">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-mono text-xs font-bold text-slate-600 dark:text-slate-400">
                                        #LAP-{{ str_pad($report->id, 4, '0', STR_PAD_LEFT) }}
                                    </span>
                                    @if($report->is_hidden_identity)
                                        <span class="inline-flex items-center gap-1 text-[11px] text-primary-700 dark:text-[#5AE39D] font-bold">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                            Anonim
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm font-bold text-slate-900 dark:text-slate-100 truncate">
                                    {{ $report->category->name ?? 'Laporan Perundungan' }}
                                </p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                    {{ $report->created_at->format('d M Y') }} &bull; {{ $report->reporter_class_name ?? 'Kelas -' }} &bull; {{ $report->location }}
                                </p>
                            </div>
                            <div class="shrink-0 flex flex-col items-end gap-1.5">
                                <x-badge :variant="$report->status">
                                    {{ $report->status_label }}
                                </x-badge>
                                @if($report->urgency === 'tinggi')
                                    <span class="text-[10px] font-bold text-rose-600 dark:text-rose-400">Urgensi Tinggi</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>

                @if($reports->hasPages())
                    <div class="px-5 py-4 border-t border-slate-200/80 dark:border-slate-800">
                        {{ $reports->links() }}
                    </div>
                @endif
            @else
                <div class="p-8 sm:p-12 text-center flex flex-col items-center justify-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-slate-100">Tidak Ada Laporan Ditemukan</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 max-w-sm">
                        Tidak ada laporan perundungan yang cocok dengan kriteria filter atau pencarian Anda.
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
