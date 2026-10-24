<x-layouts.app title="Operasi Massal Kelas">
    <div class="space-y-6 animate-fade-in">
        {{-- Header --}}
        <div class="pb-4 border-b border-slate-200 dark:border-slate-800">
            <div class="flex items-center gap-2 mb-1.5 text-xs">
                <a href="{{ route('master.dashboard') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 transition">Master</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <span class="font-semibold text-emerald-600 dark:text-emerald-400">Operasi Massal Kelas</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100 flex items-center gap-2.5">
                <span>Operasi Massal Kelas</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Kenaikan kelas tahunan dan pengarsipan massal siswa alumni tanpa menghapus riwayat laporan perundungan.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Bagian 1: Kenaikan / Perpindahan Kelas Massal (FR-13) --}}
            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 pb-4 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-slate-100">Kenaikan / Perpindahan Kelas Massal</h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Pindahkan seluruh siswa dari satu rombel ke rombel tingkat selanjutnya.</p>
                        </div>
                    </div>

                    <form action="{{ route('master.class-operations.preview-promotion') }}" method="POST" class="space-y-4 mt-5">
                        @csrf

                        {{-- Kelas Asal --}}
                        <div>
                            <label for="from_class_id" class="block text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1">
                                Kelas Asal (Sumber) <span class="text-rose-500 font-semibold ml-0.5">*</span>
                            </label>
                            <select name="from_class_id" id="from_class_id" required class="w-full min-h-[42px] text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 py-2.5 pl-3 pr-8 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('from_class_id') border-rose-400 @enderror">
                                <option value="">-- Pilih Kelas Asal --</option>
                                @foreach ($classes as $c)
                                    <option value="{{ $c->id }}" {{ old('from_class_id') == $c->id ? 'selected' : '' }}>
                                        Kelas {{ $c->name }} ({{ $c->academicYear?->name ?? '-' }}) — {{ $c->students_count }} Siswa Aktif
                                    </option>
                                @endforeach
                            </select>
                            @error('from_class_id')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kelas Tujuan --}}
                        <div>
                            <label for="to_class_id" class="block text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1">
                                Kelas Tujuan (Sasaran Baru) <span class="text-rose-500 font-semibold ml-0.5">*</span>
                            </label>
                            <select name="to_class_id" id="to_class_id" required class="w-full min-h-[42px] text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 py-2.5 pl-3 pr-8 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 @error('to_class_id') border-rose-400 @enderror">
                                <option value="">-- Pilih Kelas Tujuan --</option>
                                @foreach ($classes as $c)
                                    <option value="{{ $c->id }}" {{ old('to_class_id') == $c->id ? 'selected' : '' }}>
                                        Kelas {{ $c->name }} ({{ $c->academicYear?->name ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('to_class_id')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="p-3.5 bg-emerald-50 dark:bg-emerald-950/40 rounded-xl border border-emerald-200 dark:border-emerald-800 text-xs text-emerald-800 dark:text-emerald-300 leading-relaxed">
                            <strong>Petunjuk:</strong> Sistem akan menampilkan pratinjau daftar siswa yang terdaftar di kelas asal terlebih dahulu sebelum memindahkan data.
                        </div>

                        <div class="pt-2">
                            <x-button type="submit" variant="primary" class="w-full justify-center min-h-[42px]">
                                Pratinjau Daftar Siswa yang Dipindahkan
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Bagian 2: Pengarsipan Siswa Massal per Kelas (FR-12) --}}
            <div class="bg-white dark:bg-slate-800 border border-rose-200 dark:border-rose-900/60 rounded-2xl p-6 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 pb-4 border-b border-slate-100 dark:border-slate-800">
                        <div class="w-10 h-10 bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-400 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-slate-100">Arsipkan Siswa per Kelas (Alumni)</h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Nonaktifkan akun satu angkatan yang lulus (misal kelas IX).</p>
                        </div>
                    </div>

                    <form action="{{ route('master.class-operations.archive-students') }}" method="POST" class="space-y-4 mt-5">
                        @csrf

                        {{-- Pilih Kelas --}}
                        <div>
                            <label for="archive_class_id" class="block text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1">
                                Pilih Rombel Kelas yang Akan Diarsipkan <span class="text-rose-500 font-semibold ml-0.5">*</span>
                            </label>
                            <select name="class_id" id="archive_class_id" required class="w-full min-h-[42px] text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 py-2.5 pl-3 pr-8 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-rose-500 @error('class_id') border-rose-400 @enderror">
                                <option value="">-- Pilih Kelas Alumni --</option>
                                @foreach ($classes as $c)
                                    <option value="{{ $c->id }}" {{ old('class_id') == $c->id ? 'selected' : '' }}>
                                        Kelas {{ $c->name }} ({{ $c->academicYear?->name ?? '-' }}) — {{ $c->students_count }} Siswa Aktif
                                    </option>
                                @endforeach
                            </select>
                            @error('class_id')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kata Sandi Master --}}
                        <div>
                            <x-input 
                                type="password" 
                                name="master_password" 
                                label="Konfirmasi Kata Sandi Master Anda" 
                                placeholder="Masukkan kata sandi akun Master" 
                                required 
                                hint="Verifikasi keamanan wajib untuk mencegah pengarsipan massal tidak disengaja."
                            />
                        </div>

                        <div class="p-3.5 bg-amber-50 dark:bg-amber-950/40 rounded-xl border border-amber-200 dark:border-amber-800 text-xs text-amber-900 dark:text-amber-200 leading-relaxed">
                            <strong>Perlindungan Data:</strong> Pengarsipan massal menggunakan <em>soft-delete</em>. Akun siswa dinonaktifkan dari login, tetapi <strong>seluruh riwayat laporan perundungan terdahulu tetap utuh</strong> demi kebutuhan rekam jejak madrasah.
                        </div>

                        <div class="pt-2">
                            <x-button type="submit" variant="danger" class="w-full justify-center min-h-[42px]" onclick="return confirm('Apakah Anda yakin ingin mengarsipkan seluruh akun siswa di kelas ini?');">
                                Arsipkan Seluruh Siswa di Kelas Ini
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Ringkasan Jumlah Siswa per Kelas --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-xs">
            <div class="p-4 sm:p-5 bg-slate-50/70 dark:bg-slate-850 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <h3 class="text-sm sm:text-base font-bold text-slate-900 dark:text-slate-100">Daftar Rombel & Jumlah Siswa Aktif</h3>
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Total Rombel: {{ $classes->count() }}</span>
            </div>
            <x-table :headers="['Tingkat', 'Nama Kelas', 'Tahun Ajaran', 'Jumlah Siswa Aktif']">
                @forelse ($classes as $c)
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition">
                        <td class="px-4 py-3 sm:px-6 text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300">
                            Kelas {{ $c->grade_level }}
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100">
                            {{ $c->name }}
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                            {{ $c->academicYear?->name ?? '-' }}
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-xs sm:text-sm font-semibold {{ $c->students_count > 0 ? 'text-emerald-600 dark:text-emerald-400 font-bold' : 'text-slate-400' }}">
                            {{ $c->students_count }} Siswa
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-8">
                            <x-empty-state title="Belum ada kelas" description="Silakan buat data kelas terlebih dahulu di menu Data Kelas." />
                        </td>
                    </tr>
                @endforelse
            </x-table>
        </div>
    </div>
</x-layouts.app>
