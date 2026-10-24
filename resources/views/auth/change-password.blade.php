<x-layouts.app title="Ganti Kata Sandi">
    <div class="px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8 max-w-xl w-full mx-auto space-y-6 animate-fade-in">
        {{-- Kartu Ganti Kata Sandi --}}
        <div class="bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xs space-y-6">
            <div class="flex items-center gap-3.5 pb-4 border-b border-slate-100 dark:border-slate-800">
                <div class="w-11 h-11 rounded-xl bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800 flex items-center justify-center font-bold shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-slate-100 tracking-tight">
                        {{ $isMandatory ? 'Wajib Ganti Kata Sandi' : 'Ganti Kata Sandi Akun' }}
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                        {{ $isMandatory 
                            ? 'Ini adalah langkah pengamanan wajib saat pertama kali masuk atau setelah kata sandi diatur ulang.' 
                            : 'Perbarui kata sandi akun Anda secara berkala agar tetap aman.' }}
                    </p>
                </div>
            </div>

            @if ($isMandatory)
                <div class="p-4 bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800/80 rounded-xl text-xs sm:text-sm text-amber-900 dark:text-amber-200 leading-relaxed flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <strong class="font-semibold block mb-0.5 text-amber-950 dark:text-amber-100">Penting untuk diperhatikan:</strong>
                        Semua menu dan fitur lain dinonaktifkan sementara sampai Anda berhasil menentukan kata sandi baru milik Anda sendiri.
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
                            placeholder="Masukkan kata sandi lama Anda"
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
                        helper="Minimal 8 karakter dan tidak boleh sama dengan ID Pengguna / NIS Anda."
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

                <div class="pt-4 flex items-center justify-between gap-3 border-t border-slate-100 dark:border-slate-800">
                    @if (! $isMandatory)
                        <a href="{{ url()->previous() }}" class="min-h-[44px] inline-flex items-center text-xs sm:text-sm font-semibold text-slate-500 hover:text-slate-900 dark:hover:text-slate-300 px-2 transition">
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
        </div>
    </div>
</x-layouts.app>
