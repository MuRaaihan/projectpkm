<x-layouts.app title="Ubah Data Siswa">
    <div class="max-w-2xl mx-auto space-y-6">
        {{-- Breadcrumb & Judul --}}
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('master.dashboard') }}" class="text-xs text-slate-500 hover:text-slate-800">Master</a>
                <span class="text-xs text-slate-300">/</span>
                <a href="{{ route('master.students.index') }}" class="text-xs text-slate-500 hover:text-slate-800">Akun Siswa</a>
                <span class="text-xs text-slate-300">/</span>
                <span class="text-xs font-semibold text-purple-700">Ubah Data</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                Ubah Data Siswa
            </h1>
            <p class="text-xs sm:text-sm text-slate-500">
                Perbarui informasi akun peserta didik.
            </p>
        </div>

        <x-card>
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
                    <div>
                        <label for="class_id" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Kelas Siswa <span class="text-rose-500">*</span>
                        </label>
                        <select name="class_id" id="class_id" required class="w-full text-xs rounded-lg border border-slate-300 py-2 pl-3 pr-8 bg-white focus:outline-none focus:ring-2 focus:ring-purple-500 @error('class_id') border-rose-400 @enderror">
                            <option value="">Pilih Kelas</option>
                            @foreach ($classes as $c)
                                <option value="{{ $c->id }}" {{ old('class_id', $student->class_id) == $c->id ? 'selected' : '' }}>
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
                            <option value="L" {{ old('gender', $student->gender) === 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                            <option value="P" {{ old('gender', $student->gender) === 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                        </select>
                        @error('gender')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="p-3 bg-slate-50 rounded-lg border border-slate-200 text-xs text-slate-600 space-y-1">
                    <p class="font-medium text-slate-700">Informasi Tambahan Akun:</p>
                    <ul class="list-disc list-inside space-y-0.5 text-slate-500">
                        <li>Status akun saat ini: <strong class="{{ $student->is_active ? 'text-emerald-700' : 'text-amber-700' }}">{{ $student->is_active ? 'Aktif' : 'Nonaktif' }}</strong></li>
                        <li>Login terakhir: {{ $student->last_login_at?->format('d/m/Y H:i') ?? 'Belum pernah login' }}</li>
                        <li>Perlu ganti kata sandi: {{ $student->must_change_password ? 'Ya (wajib saat login)' : 'Tidak' }}</li>
                    </ul>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('master.students.index', ['class_id' => $student->class_id]) }}" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition">
                        Batal
                    </a>
                    <x-button type="submit" variant="primary">
                        Perbarui Data Siswa
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.app>
