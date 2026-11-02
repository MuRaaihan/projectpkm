<x-layouts.app title="Ubah Data Siswa">
    <div class="px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8 max-w-2xl w-full mx-auto space-y-6 animate-fade-in">
        {{-- Breadcrumb & Judul --}}
        <div>
            <div class="flex items-center gap-2 mb-1.5 text-xs">
                <a href="{{ route('master.dashboard') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 transition">Master</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <a href="{{ route('master.students.index') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 transition">Akun Siswa</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <span class="font-semibold text-emerald-600 dark:text-emerald-400">Ubah Data</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100">
                Ubah Data Siswa
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Perbarui informasi akun peserta didik.
            </p>
        </div>

        <div class="bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xs">
            <form action="{{ route('master.students.update', $student) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- NIS / Login ID --}}
                <x-input 
                    name="login_id" 
                    label="Nomor Induk Siswa (NIS)" 
                    placeholder="Contoh: 20260012" 
                    value="{{ old('login_id', $student->login_id) }}" 
                    required 
                    hint="Harus unik di seluruh sistem."
                />

                {{-- Nama Lengkap Siswa --}}
                <x-input 
                    name="name" 
                    label="Nama Lengkap Siswa" 
                    placeholder="Contoh: Ahmad Fauzan" 
                    value="{{ old('name', $student->name) }}" 
                    required 
                />

                {{-- Kelas & Jenis Kelamin --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Kelas --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="class_id" class="text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200">
                            Kelas Siswa <span class="text-rose-500 font-semibold ml-0.5">*</span>
                        </label>
                        <select name="class_id" id="class_id" required class="w-full min-h-[44px] text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 py-2.5 px-3.5 bg-white dark:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 text-slate-900 dark:text-slate-100 @error('class_id') border-rose-500 bg-rose-50/30 @enderror">
                            <option value="">Pilih Kelas</option>
                            @foreach ($classes as $c)
                                <option value="{{ $c->id }}" {{ old('class_id', $student->class_id) == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }} (Tingkat {{ $c->grade_level }})
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <p class="text-xs text-rose-500 font-medium mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="gender" class="text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200">
                            Jenis Kelamin <span class="text-rose-500 font-semibold ml-0.5">*</span>
                        </label>
                        <select name="gender" id="gender" required class="w-full min-h-[44px] text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 py-2.5 px-3.5 bg-white dark:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 text-slate-900 dark:text-slate-100 @error('gender') border-rose-500 bg-rose-50/30 @enderror">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('gender', $student->gender) === 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                            <option value="P" {{ old('gender', $student->gender) === 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                        </select>
                        @error('gender')
                            <p class="text-xs text-rose-500 font-medium mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 text-xs text-slate-600 dark:text-slate-400 space-y-2">
                    <p class="font-bold text-slate-900 dark:text-slate-200">Informasi Tambahan Akun:</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Status akun saat ini: <strong class="{{ $student->is_active ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' }}">{{ $student->is_active ? 'Aktif' : 'Nonaktif' }}</strong></li>
                        <li>Sesi masuk terakhir: {{ $student->last_login_at?->format('d/m/Y H:i') ?? 'Belum pernah masuk' }}</li>
                        <li>Perlu ganti kata sandi: {{ $student->must_change_password ? 'Ya (wajib saat masuk)' : 'Tidak' }}</li>
                    </ul>
                    <div class="pt-2 border-t border-slate-200/80 dark:border-slate-800 flex items-center justify-between">
                        <span class="text-slate-500">Lupa kata sandi siswa?</span>
                        <button type="submit" form="form-reset-password" class="font-semibold text-amber-600 dark:text-amber-400 hover:underline">
                            Reset Kata Sandi Siswa
                        </button>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                    <a href="{{ route('master.students.index', ['class_id' => $student->class_id]) }}" class="min-h-[44px] inline-flex items-center justify-center px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-xl transition">
                        Batal
                    </a>
                    <x-button type="submit" variant="primary" size="md">
                        Perbarui Data Siswa
                    </x-button>
                </div>
            </form>

            <form id="form-reset-password" method="POST" action="{{ route('master.students.reset-password', $student) }}" 
                  data-confirm="Reset kata sandi siswa {{ $student->name }} (NIS: {{ $student->login_id }})? Sistem akan membuat kata sandi acak sementara baru dan mewajibkan siswa langsung menggantinya saat masuk."
                  data-confirm-title="Konfirmasi Reset Kata Sandi"
                  data-confirm-button="Ya, Reset Sandi"
                  data-confirm-color="#D97706"
                  class="hidden">
                @csrf
            </form>
        </div>
    </div>
</x-layouts.app>
