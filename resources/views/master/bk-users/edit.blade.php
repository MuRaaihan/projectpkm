<x-layouts.app title="Ubah Data Guru BK">
    <div class="px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8 max-w-2xl w-full mx-auto space-y-6 animate-fade-in">
        {{-- Breadcrumb & Judul --}}
        <div>
            <div class="flex items-center gap-2 mb-1.5 text-xs">
                <a href="{{ route('master.dashboard') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 transition">Master</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <a href="{{ route('master.bk-users.index') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 transition">Akun Guru BK</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <span class="font-semibold text-emerald-600 dark:text-emerald-400">Ubah Data</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100">
                Ubah Data Guru BK
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Perbarui informasi akun konselor madrasah penanggung jawab.
            </p>
        </div>

        <div class="bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xs">
            <form action="{{ route('master.bk-users.update', $bkUser) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- NIP / Username --}}
                <x-input 
                    name="login_id" 
                    label="NIP / Username Login" 
                    placeholder="Contoh: 198501012010011001" 
                    value="{{ old('login_id', $bkUser->login_id) }}" 
                    required 
                    hint="Harus unik dan tidak boleh ada spasi."
                />

                {{-- Nama Lengkap --}}
                <x-input 
                    name="name" 
                    label="Nama Lengkap & Gelar" 
                    placeholder="Contoh: Dra. Hj. Siti Rahmawati, M.Pd" 
                    value="{{ old('name', $bkUser->name) }}" 
                    required 
                />

                {{-- No. HP / WhatsApp --}}
                <x-input 
                    name="phone" 
                    type="tel" 
                    label="Nomor Telepon / WhatsApp (Opsional)" 
                    placeholder="Contoh: 081234567890" 
                    value="{{ old('phone', $bkUser->phone) }}" 
                />

                <div class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 text-xs text-slate-600 dark:text-slate-400 space-y-1.5">
                    <p class="font-bold text-slate-900 dark:text-slate-200">Informasi Tambahan Akun:</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Status akun saat ini: <strong class="{{ $bkUser->is_active ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' }}">{{ $bkUser->is_active ? 'Aktif' : 'Nonaktif' }}</strong></li>
                        <li>Sesi masuk terakhir: {{ $bkUser->last_login_at?->format('d/m/Y H:i') ?? 'Belum pernah masuk' }}</li>
                        <li>Perlu ganti kata sandi: {{ $bkUser->must_change_password ? 'Ya (wajib saat masuk)' : 'Tidak' }}</li>
                    </ul>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                    <a href="{{ route('master.bk-users.index') }}" class="min-h-[44px] inline-flex items-center justify-center px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-xl transition">
                        Batal
                    </a>
                    <x-button type="submit" variant="primary" size="md">
                        Perbarui Data Guru BK
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
