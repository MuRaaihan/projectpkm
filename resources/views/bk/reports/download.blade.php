<x-layouts.app title="Unduh Rekapitulasi Laporan">
    <div class="px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8 max-w-3xl w-full mx-auto space-y-6 animate-fade-in">
        {{-- Header Halaman --}}
        <div class="pb-4 border-b border-slate-200 dark:border-slate-800">
            <div class="flex items-center gap-2 mb-1.5 text-xs">
                <a href="{{ route('bk.reports.index') }}" class="text-slate-500 hover:text-primary-700 dark:hover:text-[#5AE39D] transition">Laporan Masuk</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <span class="font-semibold text-primary-700 dark:text-[#5AE39D]">Unduh Rekap</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900 dark:text-slate-100">
                Unduh Rekapitulasi Laporan
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Ekspor rekapitulasi data penanganan laporan perundungan ke format dokumen resmi (PDF atau Excel).
            </p>
        </div>

        {{-- Peringatan Kerahasiaan Dokumen --}}
        <div class="p-4 bg-amber-50/90 dark:bg-[#261A05] border border-amber-300 dark:border-amber-800/80 rounded-2xl text-xs sm:text-sm text-amber-900 dark:text-[#FAD46B] flex items-start gap-3.5 shadow-2xs">
            <div class="w-9 h-9 rounded-xl bg-amber-100 dark:bg-amber-900/60 text-amber-800 dark:text-[#FAD46B] flex items-center justify-center shrink-0 mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <span class="font-bold block text-amber-950 dark:text-[#FAD46B] text-sm">Klasifikasi Dokumen Rahasia</span>
                <p class="mt-0.5 leading-relaxed text-xs text-amber-800 dark:text-amber-200/90">
                    Dokumen hasil unduhan memuat data penanganan sensitif dan berstatus <strong>RAHASIA</strong>. Setiap aktivitas pengunduhan dicatat secara otomatis ke dalam audit keamanan madrasah.
                </p>
            </div>
        </div>

        {{-- Form Filter dan Pilihan Format --}}
        <div class="bg-surface-card dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-6 shadow-xs space-y-5">
            <div>
                <h2 class="text-base sm:text-lg font-black text-slate-900 dark:text-slate-100">Filter Data Laporan yang Akan Diunduh</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Tentukan kriteria penanganan laporan yang ingin Anda sertakan ke dalam berkas rekap</p>
            </div>

            <form method="POST" id="downloadForm" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Status --}}
                    <div>
                        <label for="status" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Status Penanganan</label>
                        <div class="relative">
                            <select id="status" 
                                    name="status" 
                                    class="w-full appearance-none pl-3.5 pr-8 py-2.5 text-xs sm:text-sm font-semibold rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D] min-h-[42px] cursor-pointer">
                                <option value="">Semua Status</option>
                                <option value="baru">Baru</option>
                                <option value="diverifikasi">Sudah dibaca (Diverifikasi)</option>
                                <option value="diproses">Sedang ditangani (Diproses)</option>
                                <option value="selesai">Selesai</option>
                                <option value="ditolak">Tidak dapat diproses (Ditolak)</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label for="category_id" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Kategori Perundungan</label>
                        <div class="relative">
                            <select id="category_id" 
                                    name="category_id" 
                                    class="w-full appearance-none pl-3.5 pr-8 py-2.5 text-xs sm:text-sm font-semibold rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D] min-h-[42px] cursor-pointer">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Kelas --}}
                    <div>
                        <label for="class_name" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Rombel / Kelas Siswa</label>
                        <div class="relative">
                            <select id="class_name" 
                                    name="class_name" 
                                    class="w-full appearance-none pl-3.5 pr-8 py-2.5 text-xs sm:text-sm font-semibold rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D] min-h-[42px] cursor-pointer">
                                <option value="">Semua Kelas</option>
                                @foreach($classes as $c)
                                    <option value="{{ $c->name }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Rentang Tanggal Kejadian --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">Rentang Tanggal Kejadian</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="date" 
                                   name="date_from" 
                                   placeholder="Mulai" 
                                   class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D] min-h-[42px]">
                            <input type="date" 
                                   name="date_to" 
                                   placeholder="Sampai" 
                                   class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D] min-h-[42px]">
                        </div>
                    </div>
                </div>

                {{-- Pilihan Format Tombol Unduh --}}
                <div class="pt-5 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-end gap-3">
                    <button type="submit" 
                            formaction="{{ route('bk.reports.download.pdf') }}" 
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 min-h-[42px] bg-rose-600 hover:bg-rose-700 active:bg-rose-800 text-white font-bold text-xs sm:text-sm rounded-xl shadow-xs transition active:scale-[0.98] cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        <span>Unduh Dokumen PDF (Cetak Resmi)</span>
                    </button>

                    <button type="submit" 
                            formaction="{{ route('bk.reports.download.excel') }}" 
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 min-h-[42px] bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white font-bold text-xs sm:text-sm rounded-xl shadow-xs transition active:scale-[0.98] cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Unduh Berkas Excel (.xlsx)</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
