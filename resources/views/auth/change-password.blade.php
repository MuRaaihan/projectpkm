<x-layouts.app title="Ganti Kata Sandi">
    <div class="max-w-xl mx-auto py-6">
        {{-- Kartu Ganti Kata Sandi --}}
        <x-card class="shadow-sm border-slate-200">
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-slate-900 tracking-tight">
                            {{ $isMandatory ? 'Wajib Ganti Kata Sandi' : 'Ganti Kata Sandi Akun' }}
                        </h1>
                        <p class="text-xs text-slate-500">
                            {{ $isMandatory 
                                ? 'Ini adalah langkah pengamanan wajib saat pertama kali masuk atau setelah reset.' 
                                : 'Perbarui kata sandi akunmu secara berkala agar tetap aman.' }}
                        </p>
                    </div>
                </div>
            </x-slot:header>

            @if ($isMandatory)
                <div class="mb-5 p-3.5 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-900 leading-relaxed flex items-start gap-2.5">
                    <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <strong class="font-semibold block mb-0.5">Penting untuk diperhatikan:</strong>
                        Semua menu dan fitur lain dinonaktifkan sementara sampai kamu berhasil menentukan kata sandi baru milikmu sendiri.
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                @method('PUT')

                @if (! $isMandatory)
                    <div>
                        <x-input 
                            name="current_password" 
                            type="password"
                            label="Kata Sandi Saat Ini"
                            placeholder="Masukkan kata sandi lama kamu"
                            required
                        />
                    </div>
                @endif

                <div>
                    <x-input 
                        name="password" 
                        type="password"
                        label="Kata Sandi Baru"
                        placeholder="Minimal 8 karakter"
                        required
                        helper="Minimal 8 karakter dan tidak boleh sama dengan ID Pengguna / NIS kamu."
                    />
                </div>

                <div>
                    <x-input 
                        name="password_confirmation" 
                        type="password"
                        label="Konfirmasi Kata Sandi Baru"
                        placeholder="Ulangi kata sandi baru"
                        required
                    />
                </div>

                <div class="pt-3 flex items-center justify-between gap-3">
                    @if (! $isMandatory)
                        <a href="{{ url()->previous() }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">
                            Batal
                        </a>
                    @else
                        <div></div>
                    @endif

                    <x-button type="submit" variant="primary" size="md">
                        Simpan Kata Sandi Baru
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.app>
