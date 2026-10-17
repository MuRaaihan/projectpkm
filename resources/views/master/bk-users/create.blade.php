<x-layouts.app title="Tambah Guru BK">
    <div class="max-w-2xl mx-auto space-y-6">
        {{-- Breadcrumb & Judul --}}
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('master.dashboard') }}" class="text-xs text-slate-500 hover:text-slate-800">Master</a>
                <span class="text-xs text-slate-300">/</span>
                <a href="{{ route('master.bk-users.index') }}" class="text-xs text-slate-500 hover:text-slate-800">Akun Guru BK</a>
                <span class="text-xs text-slate-300">/</span>
                <span class="text-xs font-semibold text-purple-700">Tambah Akun</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                Tambah Akun Guru BK
            </h1>
            <p class="text-xs sm:text-sm text-slate-500">
                Daftarkan konselor madrasah baru yang berwenang menindaklanjuti laporan perundungan siswa.
            </p>
        </div>

        <x-card>
            <form action="{{ route('master.bk-users.store') }}" method="POST" class="space-y-5">
                @csrf

                {{-- NIP / Username --}}
                <x-input 
                    name="login_id" 
                    label="NIP / Username Login" 
                    placeholder="Contoh: 198501012010011001 atau bk_budi" 
                    value="{{ old('login_id') }}" 
                    required 
                    hint="Digunakan untuk masuk ke sistem. Harus unik dan tidak boleh ada spasi."
                />

                {{-- Nama Lengkap --}}
                <x-input 
                    name="name" 
                    label="Nama Lengkap & Gelar" 
                    placeholder="Contoh: Dra. Hj. Siti Rahmawati, M.Pd" 
                    value="{{ old('name') }}" 
                    required 
                />

                {{-- No. HP / WhatsApp --}}
                <x-input 
                    name="phone" 
                    type="tel" 
                    label="Nomor Telepon / WhatsApp (Opsional)" 
                    placeholder="Contoh: 081234567890" 
                    value="{{ old('phone') }}" 
                    hint="Nomor kontak internal madrasah untuk koordinasi."
                />

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
                        <span>Guru BK wajib langsung mengganti kata sandi ini pada saat pertama kali login ke sistem.</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('master.bk-users.index') }}" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition">
                        Batal
                    </a>
                    <x-button type="submit" variant="primary">
                        Simpan Akun Guru BK
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.app>
