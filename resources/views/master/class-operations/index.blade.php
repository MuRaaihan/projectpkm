<x-layouts.app title="Operasi Massal Kelas">
    <div class="space-y-6">
        {{-- Header --}}
        <div class="pb-2 border-b border-slate-200">
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('master.dashboard') }}" class="text-xs text-slate-500 hover:text-slate-800">Master</a>
                <span class="text-xs text-slate-300">/</span>
                <span class="text-xs font-semibold text-purple-700">Operasi Massal Kelas</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                Operasi Massal Kelas
            </h1>
            <p class="text-xs sm:text-sm text-slate-500">
                Kenaikan kelas tahunan dan pengarsipan massal siswa alumni tanpa menghapus riwayat laporan perundungan.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Bagian 1: Kenaikan / Perpindahan Kelas Massal (FR-13) --}}
            <x-card class="h-full flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                        <div class="p-2.5 bg-purple-50 text-purple-700 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-slate-900">Kenaikan / Perpindahan Kelas Massal</h2>
                            <p class="text-xs text-slate-500">Pindahkan seluruh siswa dari satu rombel ke rombel tingkat selanjutnya.</p>
                        </div>
                    </div>

                    <form action="{{ route('master.class-operations.preview-promotion') }}" method="POST" class="space-y-4 mt-5">
                        @csrf

                        {{-- Kelas Asal --}}
                        <div>
                            <label for="from_class_id" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Kelas Asal (Sumber) <span class="text-rose-500">*</span>
                            </label>
                            <select name="from_class_id" id="from_class_id" required class="w-full text-xs rounded-lg border border-slate-300 py-2.5 pl-3 pr-8 bg-white focus:outline-none focus:ring-2 focus:ring-purple-500 @error('from_class_id') border-rose-400 @enderror">
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
                            <label for="to_class_id" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Kelas Tujuan (Sasaran Baru) <span class="text-rose-500">*</span>
                            </label>
                            <select name="to_class_id" id="to_class_id" required class="w-full text-xs rounded-lg border border-slate-300 py-2.5 pl-3 pr-8 bg-white focus:outline-none focus:ring-2 focus:ring-purple-500 @error('to_class_id') border-rose-400 @enderror">
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

                        <div class="p-3 bg-purple-50/60 rounded-xl border border-purple-100 text-xs text-purple-900 leading-relaxed">
                            <strong>Petunjuk:</strong> Sistem akan menampilkan pratinjau daftar siswa yang terdaftar di kelas asal terlebih dahulu sebelum memindahkan data.
                        </div>

                        <div class="pt-3">
                            <x-button type="submit" variant="primary" class="w-full justify-center">
                                Pratinjau Daftar Siswa yang Dipindahkan
                            </x-button>
                        </div>
                    </form>
                </div>
            </x-card>

            {{-- Bagian 2: Pengarsipan Siswa Massal per Kelas (FR-12) --}}
            <x-card class="h-full flex flex-col justify-between border-rose-200/80">
                <div>
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                        <div class="p-2.5 bg-rose-50 text-rose-700 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-slate-900">Arsipkan Siswa per Kelas (Alumni)</h2>
                            <p class="text-xs text-slate-500">Nonaktifkan akun satu angkatan yang lulus (misal kelas IX).</p>
                        </div>
                    </div>

                    <form action="{{ route('master.class-operations.archive-students') }}" method="POST" class="space-y-4 mt-5">
                        @csrf

                        {{-- Pilih Kelas --}}
                        <div>
                            <label for="archive_class_id" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Pilih Rombel Kelas yang Akan Diarsipkan <span class="text-rose-500">*</span>
                            </label>
                            <select name="class_id" id="archive_class_id" required class="w-full text-xs rounded-lg border border-slate-300 py-2.5 pl-3 pr-8 bg-white focus:outline-none focus:ring-2 focus:ring-rose-500 @error('class_id') border-rose-400 @enderror">
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

                        <div class="p-3 bg-amber-50 rounded-xl border border-amber-200 text-xs text-amber-900 leading-relaxed">
                            <strong>Perlindungan Data:</strong> Pengarsipan massal menggunakan <em>soft-delete</em>. Akun siswa dinonaktifkan dari login, tetapi <strong>seluruh riwayat laporan perundungan terdahulu tetap utuh</strong> demi kebutuhan rekam jejak madrasah.
                        </div>

                        <div class="pt-3">
                            <x-button type="submit" variant="danger" class="w-full justify-center" onclick="return confirm('Apakah Anda yakin ingin mengarsipkan seluruh akun siswa di kelas ini?');">
                                Arsipkan Seluruh Siswa di Kelas Ini
                            </x-button>
                        </div>
                    </form>
                </div>
            </x-card>
        </div>

        {{-- Ringkasan Jumlah Siswa per Kelas --}}
        <x-card class="p-0! overflow-hidden">
            <div class="p-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-800">Daftar Rombel & Jumlah Siswa Aktif</h3>
                <span class="text-xs text-slate-500">Total Rombel: {{ $classes->count() }}</span>
            </div>
            <x-table :headers="['Tingkat', 'Nama Kelas', 'Tahun Ajaran', 'Jumlah Siswa Aktif']">
                @forelse ($classes as $c)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="px-4 py-3 sm:px-6 text-xs font-semibold text-slate-700">
                            Kelas {{ $c->grade_level }}
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-xs font-bold text-slate-900">
                            {{ $c->name }}
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-xs text-slate-600">
                            {{ $c->academicYear?->name ?? '-' }}
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-xs font-semibold {{ $c->students_count > 0 ? 'text-purple-700 font-bold' : 'text-slate-400' }}">
                            {{ $c->students_count }} Siswa
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4">
                            <x-empty-state title="Belum ada kelas" description="Silakan buat data kelas terlebih dahulu di menu Data Kelas." />
                        </td>
                    </tr>
                @endforelse
            </x-table>
        </x-card>
    </div>
</x-layouts.app>
