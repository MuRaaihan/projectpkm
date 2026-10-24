<x-layouts.public title="Verifikasi Dua Faktor (2FA) - SISPERKA">
    <div class="min-h-[80vh] flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8 animate-fade-in">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            {{-- Logo dan Judul --}}
            <div class="text-center space-y-2">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-600 text-white font-bold text-xl shadow-xs mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100">
                    Verifikasi Dua Langkah
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 max-w-sm mx-auto">
                    Akun staf dilindungi oleh lapisan keamanan tambahan (2FA).
                </p>
            </div>

            {{-- Kartu Formulir --}}
            <div class="mt-8 bg-white dark:bg-[#16231D] py-8 px-5 shadow-xs border border-slate-200 dark:border-slate-800 rounded-2xl sm:px-10"
                 x-data="{ useRecovery: false }">
                
                {{-- Flash Message Error --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-xs sm:text-sm text-rose-800 dark:text-rose-300 space-y-1">
                        @foreach ($errors->all() as $error)
                            <p class="flex items-center gap-1.5 font-medium">
                                <svg class="w-4 h-4 shrink-0 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>{{ $error }}</span>
                            </p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('two-factor.verify') }}" class="space-y-5">
                    @csrf

                    {{-- Mode 1: Kode 6-Digit TOTP --}}
                    <div x-show="!useRecovery" class="space-y-2">
                        <label for="code" class="block text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200">
                            Kode Autentikasi (6 Digit)
                        </label>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                            Buka aplikasi authenticator (Google Authenticator atau Microsoft Authenticator) dan masukkan kode yang tampil.
                        </p>
                        <input type="text" 
                               inputmode="numeric" 
                               pattern="[0-9]*"
                               maxlength="6"
                               autocomplete="one-time-code"
                               id="code" 
                               name="code" 
                               placeholder="Contoh: 123456" 
                               class="w-full text-center tracking-widest text-2xl font-mono px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 min-h-[48px]"
                               :required="!useRecovery" />
                    </div>

                    {{-- Mode 2: Kode Pemulihan Darurat (Recovery Code) --}}
                    <div x-show="useRecovery" style="display: none;" class="space-y-2">
                        <label for="recovery_code" class="block text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200">
                            Kode Pemulihan Darurat (Recovery Code)
                        </label>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                            Masukkan salah satu kode pemulihan cadangan yang kamu simpan saat mengaktifkan 2FA.
                        </p>
                        <input type="text" 
                               id="recovery_code" 
                               name="recovery_code" 
                               placeholder="Contoh: ABCDE-12345" 
                               class="w-full text-center font-mono text-base px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 min-h-[48px] uppercase"
                               :required="useRecovery" />
                    </div>

                    {{-- Tombol Verifikasi --}}
                    <div>
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 text-xs sm:text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-xs transition duration-150 active:scale-[0.98] min-h-[44px]">
                            <span>Verifikasi & Masuk</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>

                    {{-- Toggle antara Kode TOTP dan Recovery Code --}}
                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800 text-center">
                        <button type="button" 
                                @click="useRecovery = !useRecovery" 
                                class="text-xs sm:text-sm font-semibold text-emerald-600 dark:text-emerald-400 hover:underline min-h-[40px] inline-flex items-center">
                            <span x-text="useRecovery ? 'Gunakan Kode Aplikasi Authenticator' : 'Tidak bisa mengakses aplikasi? Gunakan kode pemulihan'"></span>
                        </button>
                    </div>
                </form>

                {{-- Batal dan Kembali ke Login --}}
                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}" class="text-xs text-slate-500 hover:text-slate-900 dark:hover:text-slate-300 inline-flex items-center gap-1 min-h-[40px]">
                        &larr; Batalkan dan kembali ke halaman masuk
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
