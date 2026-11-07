<x-layouts.app title="Tambah Siswa">
    <div class="px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8 max-w-2xl w-full mx-auto space-y-6 animate-fade-in">
        {{-- Breadcrumb & Judul --}}
        <div>
            <div class="flex items-center gap-2 mb-1.5 text-xs">
                <a href="{{ route('master.dashboard') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 transition">Master</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <a href="{{ route('master.students.index') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 transition">Akun Siswa</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <span class="font-semibold text-emerald-600 dark:text-emerald-400">Tambah Akun</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100">
                Tambah Akun Siswa
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Daftarkan akun peserta didik baru untuk akses pelaporan perundungan.
            </p>
        </div>

        <div class="bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xs">
            <form id="form-create-student" action="{{ route('master.students.store') }}" method="POST" autocomplete="off" class="space-y-5">
                @csrf

                {{-- NIS / Login ID --}}
                <x-input 
                    name="login_id" 
                    label="Nomor Induk Siswa (NIS)" 
                    placeholder="Contoh: 20260012" 
                    value="{{ old('login_id') }}" 
                    required 
                    hint="Digunakan siswa untuk login ke sistem. Wajib berupa nomor unik."
                />

                {{-- Nama Lengkap Siswa --}}
                <x-input 
                    name="name" 
                    label="Nama Lengkap Siswa" 
                    placeholder="Contoh: Ahmad Fauzan" 
                    value="{{ old('name') }}" 
                    required 
                />

                {{-- Kelas & Jenis Kelamin --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Kelas --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="class_id" class="text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200">
                            Kelas Siswa <span class="text-rose-500 font-semibold ml-0.5">*</span>
                        </label>
                        <div class="relative">
                            <select name="class_id" id="class_id" required class="w-full min-h-[44px] appearance-none cursor-pointer text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 py-2.5 pl-3.5 pr-10 bg-white dark:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 text-slate-900 dark:text-slate-100 transition font-medium @error('class_id') border-rose-500 bg-rose-50/30 @enderror">
                                <option value="">Pilih Kelas</option>
                                @foreach ($classes as $c)
                                    <option value="{{ $c->id }}" {{ old('class_id') == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }} (Tingkat {{ $c->grade_level }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 dark:text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                        @error('class_id')
                            <p class="text-xs text-rose-500 font-medium mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="gender" class="text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200">
                            Jenis Kelamin <span class="text-rose-500 font-semibold ml-0.5">*</span>
                        </label>
                        <div class="relative">
                            <select name="gender" id="gender" required class="w-full min-h-[44px] appearance-none cursor-pointer text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 py-2.5 pl-3.5 pr-10 bg-white dark:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 text-slate-900 dark:text-slate-100 transition font-medium @error('gender') border-rose-500 bg-rose-50/30 @enderror">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('gender') === 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                                <option value="P" {{ old('gender') === 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 dark:text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                        @error('gender')
                            <p class="text-xs text-rose-500 font-medium mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Kata Sandi Awal --}}
                <div class="space-y-2">
                    <x-input 
                        name="password" 
                        type="password" 
                        label="Kata Sandi Awal" 
                        placeholder="Kosongkan jika ingin dibuatkan otomatis" 
                        hint="Minimal 8 karakter. Jika dikosongkan, sistem otomatis menggunakan kata sandi default SiswaMTS!."
                    />
                    <div class="p-3.5 bg-amber-50 dark:bg-amber-950/40 rounded-xl border border-amber-200 dark:border-amber-800 text-xs text-amber-800 dark:text-amber-300 flex items-start gap-2.5 leading-relaxed">
                        <svg class="w-4 h-4 text-amber-600 dark:text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>Siswa wajib langsung mengganti kata sandi ini saat masuk pertama kali.</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                    <a href="{{ route('master.students.index') }}" class="min-h-[44px] inline-flex items-center justify-center px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-xl transition">
                        Batal
                    </a>
                    <x-button type="submit" variant="primary" size="md">
                        Simpan Akun Siswa
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
