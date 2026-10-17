<x-layouts.app title="Ubah Data Guru BK">
    <div class="max-w-2xl mx-auto space-y-6">
        {{-- Breadcrumb & Judul --}}
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('master.dashboard') }}" class="text-xs text-slate-500 hover:text-slate-800">Master</a>
                <span class="text-xs text-slate-300">/</span>
                <a href="{{ route('master.bk-users.index') }}" class="text-xs text-slate-500 hover:text-slate-800">Akun Guru BK</a>
                <span class="text-xs text-slate-300">/</span>
                <span class="text-xs font-semibold text-purple-700">Ubah Data</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                Ubah Data Guru BK
            </h1>
            <p class="text-xs sm:text-sm text-slate-500">
                Perbarui informasi akun konselor madrasah penanggung jawab.
            </p>
        </div>

        <x-card>
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

                <div class="p-3 bg-slate-50 rounded-lg border border-slate-200 text-xs text-slate-600 space-y-1">
                    <p class="font-medium text-slate-700">Informasi Tambahan Akun:</p>
                    <ul class="list-disc list-inside space-y-0.5 text-slate-500">
                        <li>Status akun saat ini: <strong class="{{ $bkUser->is_active ? 'text-emerald-700' : 'text-amber-700' }}">{{ $bkUser->is_active ? 'Aktif' : 'Nonaktif' }}</strong></li>
                        <li>Login terakhir: {{ $bkUser->last_login_at?->format('d/m/Y H:i') ?? 'Belum pernah login' }}</li>
                        <li>Perlu ganti kata sandi: {{ $bkUser->must_change_password ? 'Ya (wajib saat login)' : 'Tidak' }}</li>
                    </ul>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('master.bk-users.index') }}" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition">
                        Batal
                    </a>
                    <x-button type="submit" variant="primary">
                        Perbarui Data Guru BK
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.app>
