<x-layouts.app title="Tambah Guru BK">
    <div class="max-w-2xl mx-auto space-y-6 animate-fade-in">
        {{-- Breadcrumb & Judul --}}
        <div>
            <div class="flex items-center gap-2 mb-1.5 text-xs">
                <a href="{{ route('master.dashboard') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 transition">Master</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <a href="{{ route('master.bk-users.index') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 transition">Akun Guru BK</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <span class="font-semibold text-emerald-600 dark:text-emerald-400">Tambah Akun</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100">
                Tambah Akun Guru BK
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Daftarkan konselor madrasah baru yang berwenang menindaklanjuti laporan perundungan siswa.
            </p>
        </div>

        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xs">
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
                <div class="space-y-2">
                    <x-input 
                        name="password" 
                        type="password" 
                        label="Kata Sandi Awal" 
                        placeholder="Kosongkan jika ingin dibuatkan otomatis" 
                        hint="Minimal 8 karakter. Jika dikosongkan, sistem akan mengacak kata sandi aman otomatis."
                    />
                    <div class="p-3.5 bg-amber-50 dark:bg-amber-950/40 rounded-xl border border-amber-200 dark:border-amber-800 text-xs text-amber-800 dark:text-amber-300 flex items-start gap-2.5 leading-relaxed">
                        <svg class="w-4 h-4 text-amber-600 dark:text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>Guru BK wajib langsung mengganti kata sandi ini pada saat pertama kali masuk ke sistem.</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                    <a href="{{ route('master.bk-users.index') }}" class="min-h-[42px] inline-flex items-center justify-center px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-xl transition">
                        Batal
                    </a>
                    <x-button type="submit" variant="primary" size="md">
                        Simpan Akun Guru BK
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
