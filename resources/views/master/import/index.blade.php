<x-layouts.app title="Impor Akun dari Excel">
    <div class="max-w-4xl mx-auto space-y-6">
        {{-- Breadcrumb & Judul --}}
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('master.dashboard') }}" class="text-xs text-slate-500 hover:text-slate-800">Master</a>
                <span class="text-xs text-slate-300">/</span>
                <span class="text-xs font-semibold text-purple-700">Impor Excel</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                Impor Akun Massal dari Excel
            </h1>
            <p class="text-xs sm:text-sm text-slate-500">
                Tambah ratusan akun siswa atau konselor madrasah sekaligus dengan verifikasi data dua tahap yang aman.
            </p>
        </div>

        {{-- Langkah 1: Unduh Format Template --}}
        <x-card>
            <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                <div class="w-7 h-7 rounded-full bg-purple-100 text-purple-800 font-bold text-xs flex items-center justify-center shrink-0">
                    1
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-900">Unduh Template Resmi Excel</h2>
                    <p class="text-xs text-slate-500">Gunakan format kolom yang telah disesuaikan agar data terbaca dengan tepat.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                <div class="p-4 bg-purple-50/60 rounded-xl border border-purple-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-purple-950">Template Akun Siswa</p>
                        <p class="text-[11px] text-purple-700">Kolom: NIS, Nama Siswa, Kelas, Jenis Kelamin (L/P)</p>
                    </div>
                    <a href="{{ route('master.import.template.siswa') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-purple-900 bg-white border border-purple-200 hover:bg-purple-100/50 rounded-lg shadow-xs transition">
                        <svg class="w-4 h-4 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Unduh .XLSX
                    </a>
                </div>

                <div class="p-4 bg-emerald-50/60 rounded-xl border border-emerald-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-emerald-950">Template Guru BK</p>
                        <p class="text-[11px] text-emerald-700">Kolom: NIP/Username, Nama Lengkap, Nomor HP</p>
                    </div>
                    <a href="{{ route('master.import.template.bk') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-emerald-900 bg-white border border-emerald-200 hover:bg-emerald-100/50 rounded-lg shadow-xs transition">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Unduh .XLSX
                    </a>
                </div>
            </div>
        </x-card>

        {{-- Langkah 2: Unggah File Excel --}}
        <x-card>
            <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                <div class="w-7 h-7 rounded-full bg-purple-100 text-purple-800 font-bold text-xs flex items-center justify-center shrink-0">
                    2
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-900">Unggah File Excel & Pratinjau Validasi</h2>
                    <p class="text-xs text-slate-500">Sistem akan memeriksa kelengkapan data dan mendeteksi NIS/NIP ganda sebelum disimpan.</p>
                </div>
            </div>

            <form action="{{ route('master.import.preview') }}" method="POST" enctype="multipart/form-data" class="space-y-5 mt-5">
                @csrf

                {{-- Tipe Impor --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-2">
                        Pilih Tipe Data yang Diimpor <span class="text-rose-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition has-checked:border-purple-600 has-checked:bg-purple-50/50">
                            <input type="radio" name="type" value="siswa" checked class="text-purple-600 focus:ring-purple-500" />
                            <div>
                                <span class="text-xs font-bold text-slate-900 block">Akun Siswa</span>
                                <span class="text-[11px] text-slate-500">Impor rombel kelas peserta didik baru.</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition has-checked:border-purple-600 has-checked:bg-purple-50/50">
                            <input type="radio" name="type" value="bk" class="text-purple-600 focus:ring-purple-500" />
                            <div>
                                <span class="text-xs font-bold text-slate-900 block">Akun Guru BK</span>
                                <span class="text-[11px] text-slate-500">Impor konselor penanggung jawab madrasah.</span>
                            </div>
                        </label>
                    </div>
                    @error('type')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input File --}}
                <div>
                    <label for="excel_file" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Pilih Berkas Excel (.xlsx) <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="file" 
                        name="file" 
                        id="excel_file" 
                        accept=".xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" 
                        required 
                        class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 border border-slate-300 rounded-lg cursor-pointer bg-white"
                    />
                    <p class="text-[11px] text-slate-500 mt-1">Maksimal ukuran file 2 MB. Hanya format <code>.xlsx</code> resmi yang diizinkan.</p>
                    @error('file')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Ketentuan Keamanan --}}
                <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 text-xs text-slate-600 space-y-1.5 leading-relaxed">
                    <p class="font-bold text-slate-800 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Protokol Keamanan & Perlindungan Akun:
                    </p>
                    <ul class="list-disc list-inside space-y-1 text-slate-500 text-[11px]">
                        <li>Seluruh rumus formula dievaluasi secara statis untuk mencegah injeksi formula Excel.</li>
                        <li>Kata sandi dibuat acak secara individual untuk tiap pengguna dan diwajibkan ganti pada login pertama.</li>
                        <li>Kredensial login hanya dapat diunduh <strong>1 (satu) kali</strong> sesaat setelah data berhasil disimpan ke database.</li>
                    </ul>
                </div>

                <div class="pt-2 flex justify-end">
                    <x-button type="submit" variant="primary">
                        Unggah & Tampilkan Pratinjau Validasi
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.app>
