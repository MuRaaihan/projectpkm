<x-layouts.app title="Impor Akun dari Excel">
    <div class="max-w-4xl mx-auto space-y-6 animate-fade-in">
        {{-- Breadcrumb & Judul --}}
        <div>
            <div class="flex items-center gap-2 mb-1.5 text-xs">
                <a href="{{ route('master.dashboard') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 transition">Master</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <span class="font-semibold text-emerald-600 dark:text-emerald-400">Impor Excel</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100 flex items-center gap-2.5">
                <span>Impor Akun Massal dari Excel</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Tambah ratusan akun siswa atau konselor madrasah sekaligus dengan verifikasi data dua tahap yang aman.
            </p>
        </div>

        {{-- Langkah 1: Unduh Format Template --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs">
            <div class="flex items-center gap-3.5 pb-4 border-b border-slate-100 dark:border-slate-850">
                <div class="w-8 h-8 rounded-full bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 font-bold text-xs flex items-center justify-center shrink-0">
                    1
                </div>
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 dark:text-slate-100">Unduh Template Resmi Excel</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Gunakan format kolom yang telah disesuaikan agar data terbaca dengan tepat.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-5">
                <div class="p-4 sm:p-5 bg-emerald-50/60 dark:bg-emerald-950/20 rounded-2xl border border-emerald-100 dark:border-emerald-800/60 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-bold text-slate-900 dark:text-slate-100">Template Akun Siswa</p>
                        <p class="text-xs text-emerald-700 dark:text-emerald-400 mt-0.5">Kolom: NIS, Nama Siswa, Kelas, L/P</p>
                    </div>
                    <a href="{{ route('master.import.template.siswa') }}" class="min-h-[40px] inline-flex items-center justify-center gap-2 px-3.5 py-1.5 text-xs sm:text-sm font-semibold text-emerald-700 dark:text-emerald-300 bg-white dark:bg-slate-800 border border-emerald-200 dark:border-emerald-700 hover:bg-emerald-50 dark:hover:bg-slate-700 rounded-xl shadow-xs transition shrink-0 active:scale-[0.98]">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Unduh .XLSX
                    </a>
                </div>

                <div class="p-4 sm:p-5 bg-slate-50 dark:bg-slate-900/40 rounded-2xl border border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-bold text-slate-900 dark:text-slate-100">Template Guru BK</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Kolom: NIP/User, Nama, Nomor HP</p>
                    </div>
                    <a href="{{ route('master.import.template.bk') }}" class="min-h-[40px] inline-flex items-center justify-center gap-2 px-3.5 py-1.5 text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-xl shadow-xs transition shrink-0 active:scale-[0.98]">
                        <svg class="w-4 h-4 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Unduh .XLSX
                    </a>
                </div>
            </div>
        </div>

        {{-- Langkah 2: Unggah File Excel --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs">
            <div class="flex items-center gap-3.5 pb-4 border-b border-slate-100 dark:border-slate-850">
                <div class="w-8 h-8 rounded-full bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 font-bold text-xs flex items-center justify-center shrink-0">
                    2
                </div>
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 dark:text-slate-100">Unggah File Excel & Pratinjau Validasi</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Sistem akan memeriksa kelengkapan data dan mendeteksi NIS/NIP ganda sebelum disimpan.</p>
                </div>
            </div>

            <form action="{{ route('master.import.preview') }}" method="POST" enctype="multipart/form-data" class="space-y-5 mt-5">
                @csrf

                {{-- Tipe Impor --}}
                <div class="space-y-2">
                    <label class="text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 block">
                        Pilih Tipe Data yang Diimpor <span class="text-rose-500 font-semibold ml-0.5">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <label class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700/50 transition has-checked:border-emerald-500 has-checked:bg-emerald-50/50 dark:has-checked:bg-emerald-950/30 min-h-[42px]">
                            <input type="radio" name="type" value="siswa" checked class="text-emerald-600 focus:ring-emerald-500 w-4 h-4" />
                            <div>
                                <span class="text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100 block">Akun Siswa</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400">Impor rombel kelas peserta didik baru.</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700/50 transition has-checked:border-emerald-500 has-checked:bg-emerald-50/50 dark:has-checked:bg-emerald-950/30 min-h-[42px]">
                            <input type="radio" name="type" value="bk" class="text-emerald-600 focus:ring-emerald-500 w-4 h-4" />
                            <div>
                                <span class="text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100 block">Akun Guru BK</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400">Impor konselor penanggung jawab madrasah.</span>
                            </div>
                        </label>
                    </div>
                    @error('type')
                        <p class="text-xs text-rose-500 font-medium mt-0.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input File --}}
                <div class="space-y-2">
                    <label for="excel_file" class="text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 block">
                        Pilih Berkas Excel (.xlsx) <span class="text-rose-500 font-semibold ml-0.5">*</span>
                    </label>
                    <input 
                        type="file" 
                        name="file" 
                        id="excel_file" 
                        accept=".xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" 
                        required 
                        class="block w-full min-h-[42px] text-xs sm:text-sm text-slate-600 dark:text-slate-300 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 dark:file:bg-emerald-950/50 file:text-emerald-700 dark:file:text-emerald-400 hover:file:bg-emerald-100 border border-slate-200 dark:border-slate-700 rounded-xl cursor-pointer bg-white dark:bg-slate-800"
                    />
                    <p class="text-xs text-slate-400">Maksimal ukuran file 2 MB. Hanya format <code>.xlsx</code> resmi yang diizinkan.</p>
                    @error('file')
                        <p class="text-xs text-rose-500 font-medium mt-0.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Ketentuan Keamanan --}}
                <div class="p-4 sm:p-5 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 text-xs text-slate-600 dark:text-slate-400 space-y-2 leading-relaxed">
                    <p class="font-bold text-slate-900 dark:text-slate-200 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Protokol Keamanan & Perlindungan Akun:
                    </p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Seluruh rumus formula dievaluasi secara statis untuk mencegah injeksi formula Excel.</li>
                        <li>Kata sandi dibuat acak secara individual untuk tiap pengguna dan diwajibkan ganti pada saat masuk pertama kali.</li>
                        <li>Kredensial akun hanya dapat diunduh <strong>1 (satu) kali</strong> sesaat setelah data berhasil disimpan ke database.</li>
                    </ul>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex justify-end">
                    <x-button type="submit" variant="primary" size="lg">
                        Unggah & Tampilkan Pratinjau Validasi
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
