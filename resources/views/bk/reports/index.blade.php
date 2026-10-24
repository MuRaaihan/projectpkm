<x-layouts.app title="Daftar Laporan Siswa">
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
                <span class="text-xs font-bold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-900 px-3.5 py-1.5 border border-slate-300/80 dark:border-slate-700 rounded-xl shadow-2xs">
                    Total: <span class="text-primary-700 dark:text-[#5AE39D] font-mono">{{ $reports->total() }}</span> laporan
                </span>
            </div>
        </div>

        {{-- ── Status Quick Filter Tabs ──────────────────────── --}}
        @php
            $currentStatus = request('status', '');
            $statusTabs = [
                '' => 'Semua',
                'baru' => 'Baru',
                'diverifikasi' => 'Diverifikasi',
                'diproses' => 'Dalam Penanganan',
                'selesai' => 'Selesai',
                'ditolak' => 'Ditolak',
            ];
        @endphp
        <div class="flex items-center gap-2 pb-1 overflow-x-auto scrollbar-hide border-b border-slate-200/80 dark:border-slate-800">
            @foreach($statusTabs as $val => $label)
                @php
                    $isActive = ($val === '' && !request()->filled('status')) || (request('status') === $val);
                    $tabUrl = request()->fullUrlWithQuery(['status' => $val ?: null, 'page' => null]);
                @endphp
                <a href="{{ $tabUrl }}"
                   class="shrink-0 flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all duration-150 {{ $isActive ? 'bg-primary-600 text-white shadow-xs' : 'bg-slate-100 dark:bg-slate-800/80 text-slate-600 dark:text-slate-300 hover:bg-slate-200/80 dark:hover:bg-slate-700' }}">
                    @if($isActive)
                        <span class="w-1.5 h-1.5 rounded-full bg-[#B8E34B]"></span>
                    @endif
                    <span>{{ $label }}</span>
                </a>
            @endforeach
        </div>

        {{-- ── Filter & Pencarian Toolbar ────────────────────── --}}
        <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-4 sm:p-5 shadow-xs">
            <form method="GET" action="{{ route('bk.reports.index') }}" class="space-y-4">
                {{-- Pertahankan tab status jika sedang aktif --}}
                @if(request()->filled('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                    {{-- Pencarian --}}
                    <div class="lg:col-span-2">
                        <label for="q" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Cari ID Tiket / Lokasi / Kelas</label>
                        <div class="relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" id="q" name="q" value="{{ request('q') }}" placeholder="Ketik kata kunci..."
                                class="w-full pl-10 pr-4 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 transition min-h-[42px]">
                        </div>
                    </div>

                    {{-- Filter Kategori --}}
                    <div>
                        <label for="category_id" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Kategori</label>
                        <select id="category_id" name="category_id" 
                            class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 transition min-h-[42px]">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Urgensi (FR-27) --}}
                    <div>
                        <label for="urgency" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Tingkat Urgensi</label>
                        <select id="urgency" name="urgency" 
                            class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 transition min-h-[42px]">
                            <option value="">Semua Urgensi</option>
                            <option value="tinggi" {{ request('urgency') === 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                            <option value="sedang" {{ request('urgency') === 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="rendah" {{ request('urgency') === 'rendah' ? 'selected' : '' }}>Rendah</option>
                        </select>
                    </div>

                    {{-- Filter Kelas --}}
                    <div>
                        <label for="class_name" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Rombel / Kelas</label>
                        <select id="class_name" name="class_name" 
                            class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 transition min-h-[42px]">
                            <option value="">Semua Kelas</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->name }}" {{ request('class_name') === $c->name ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Baris Bawah: Rentang Tanggal & Tombol Submit/Reset --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-3 border-t border-slate-100 dark:border-slate-800 text-xs text-slate-600 dark:text-slate-400">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="font-bold">Tanggal:</span>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-2.5 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100">
                        <span>s/d</span>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="px-2.5 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100">

                        <div class="ml-2 flex items-center gap-1.5">
                            <label for="sort" class="font-bold">Urutkan:</label>
                            <select id="sort" name="sort" onchange="this.form.submit()" class="px-2.5 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100">
                                <option value="" {{ !request('sort') ? 'selected' : '' }}>Terbaru Masuk</option>
                                <option value="urgency_desc" {{ request('sort') === 'urgency_desc' ? 'selected' : '' }}>Urgensi Tertinggi Dahulu</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl text-xs transition shadow-xs flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            <span>Terapkan Filter</span>
                        </button>
                        @if(request()->hasAny(['q', 'status', 'urgency', 'sort', 'category_id', 'class_name', 'date_from', 'date_to']))
                            <a href="{{ route('bk.reports.index') }}" class="px-3 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold rounded-xl text-xs transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        {{-- ── Daftar Tabel Laporan ──────────────────────────── --}}
        <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 overflow-hidden shadow-xs">
            @if($reports->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs sm:text-sm text-slate-900 dark:text-slate-100 border-collapse">
                        <thead class="bg-slate-50/80 dark:bg-slate-900/60 border-b border-slate-200/80 dark:border-slate-800 text-[11px] uppercase font-bold text-slate-500 dark:text-slate-400">
                            <tr>
                                <th class="px-5 py-3.5">ID & Waktu</th>
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
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-900/40 transition">
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="font-mono font-bold text-slate-900 dark:text-slate-100">
                                            #LAP-{{ str_pad($report->id, 4, '0', STR_PAD_LEFT) }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">
                                            {{ $report->created_at->format('d M Y, H:i') }} WIB
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if($report->urgency === 'tinggi')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 dark:bg-rose-950/50 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-900">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>
                                                Tinggi
                                            </span>
                                        @elseif($report->urgency === 'sedang')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-950/50 text-amber-700 dark:text-[#FAD46B] border border-amber-200 dark:border-amber-900">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                Sedang
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                Rendah
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if($report->is_hidden_identity)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-primary-50 dark:bg-primary-950/50 text-primary-800 dark:text-[#5AE39D] border border-primary-200 dark:border-primary-900">
                                                <svg class="w-3.5 h-3.5 text-primary-600 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                                Pelapor Rahasia
                                            </span>
                                        @else
                                            <span class="font-bold text-slate-900 dark:text-slate-100">{{ $report->reporter_display_name }}</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-xs">
                                        <span class="inline-block px-2 py-0.5 rounded-full font-bold {{ $report->reporter_role === 'korban' ? 'bg-amber-100/70 dark:bg-amber-950/50 text-amber-900 dark:text-[#FAD46B]' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300' }}">
                                            {{ $report->reporter_role === 'korban' ? 'Korban' : 'Saksi' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-slate-600 dark:text-slate-300 font-medium">
                                        {{ $report->reporter_class_name ?? '-' }}
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap font-bold text-slate-900 dark:text-slate-100">
                                        {{ $report->category->name ?? 'Lainnya' }}
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <x-badge :variant="$report->status">
                                            {{ $report->status_label }}
                                        </x-badge>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-right">
                                        <a href="{{ route('bk.reports.show', $report) }}" 
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
