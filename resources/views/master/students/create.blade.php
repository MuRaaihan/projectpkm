<x-layouts.app title="Tambah Siswa">
    <div class="max-w-2xl mx-auto space-y-6">
        {{-- Breadcrumb & Judul --}}
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('master.dashboard') }}" class="text-xs text-slate-500 hover:text-slate-800">Master</a>
                <span class="text-xs text-slate-300">/</span>
                <a href="{{ route('master.students.index') }}" class="text-xs text-slate-500 hover:text-slate-800">Akun Siswa</a>
                <span class="text-xs text-slate-300">/</span>
                <span class="text-xs font-semibold text-purple-700">Tambah Akun</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                Tambah Akun Siswa
            </h1>
            <p class="text-xs sm:text-sm text-slate-500">
                Daftarkan akun peserta didik baru untuk akses pelaporan perundungan.
            </p>
        </div>

        <x-card>
            <form action="{{ route('master.students.store') }}" method="POST" class="space-y-5">
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
                    <div>
                        <label for="class_id" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Kelas Siswa <span class="text-rose-500">*</span>
                        </label>
                        <select name="class_id" id="class_id" required class="w-full text-xs rounded-lg border border-slate-300 py-2 pl-3 pr-8 bg-white focus:outline-none focus:ring-2 focus:ring-purple-500 @error('class_id') border-rose-400 @enderror">
                            <option value="">Pilih Kelas</option>
                            @foreach ($classes as $c)
                                <option value="{{ $c->id }}" {{ old('class_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }} (Tingkat {{ $c->grade_level }})
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label for="gender" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Jenis Kelamin <span class="text-rose-500">*</span>
                        </label>
                        <select name="gender" id="gender" required class="w-full text-xs rounded-lg border border-slate-300 py-2 pl-3 pr-8 bg-white focus:outline-none focus:ring-2 focus:ring-purple-500 @error('gender') border-rose-400 @enderror">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('gender') === 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                            <option value="P" {{ old('gender') === 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                        </select>
                        @error('gender')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Kata Sandi Awal --}}
                <div class="space-y-1">
                    <x-input 
                        name="password" 
                        type="password" 
                        label="Kata Sandi Awal (Opsional)" 
                        placeholder="Kosongkan jika ingin dibuatkan otomatis" 
                        hint="Minimal 8 karakter. Jika dikosongkan, sistem akan mengacak kata sandi aman otomatis."
                    />
                    <div class="p-3 bg-amber-50 rounded-lg border border-amber-200 text-xs text-amber-800 flex items-start gap-2 mt-2">
                        <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>Siswa wajib langsung mengganti kata sandi ini saat login pertama kali.</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('master.students.index') }}" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition">
                        Batal
                    </a>
                    <x-button type="submit" variant="primary">
                        Simpan Akun Siswa
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.app>
