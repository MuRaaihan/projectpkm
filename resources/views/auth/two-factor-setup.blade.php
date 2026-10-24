<x-layouts.app title="Pengaturan Autentikasi Dua Faktor (2FA)">
    <div class="px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8 max-w-4xl w-full mx-auto space-y-6 animate-fade-in">
        {{-- Header Halaman --}}
        <div>
            <div class="flex items-center gap-2 mb-1.5 text-xs">
                <a href="{{ auth()->user()->isMaster() ? route('master.dashboard') : route('bk.dashboard') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 transition">
                    {{ auth()->user()->isMaster() ? 'Master' : 'Guru BK' }}
                </a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <span class="font-semibold text-emerald-600 dark:text-emerald-400">Keamanan 2FA</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 border-b border-slate-200 dark:border-slate-800">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100 flex items-center gap-2.5">
                        <span>Autentikasi Dua Faktor (2FA)</span>
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                        Lapisan keamanan ekstra standar industri (TOTP) untuk melindungi akun pengelola madrasah (FR-08).
                    </p>
                </div>
                <div>
                    @if ($isEnabled)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            2FA Aktif Terlindungi
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            2FA Belum Aktif
                        </span>
                    @endif
                </div>
            </div>
        </div>

        @if (!$isEnabled)
            {{-- KONDISI 1: 2FA BELUM DIAKTIFKAN (FORM AKTIVASI) --}}
            <div class="bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 space-y-6 shadow-xs">
                <div class="border-b border-slate-100 dark:border-slate-800 pb-4">
                    <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-slate-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Aktifkan Autentikasi Dua Faktor
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Ikuti dua langkah mudah berikut untuk menghubungkan akunmu dengan aplikasi Authenticator.
                    </p>
                </div>

                {{-- Langkah 1: Kunci Penyiapan --}}
                <div class="space-y-3">
                    <div class="flex items-center gap-2 font-bold text-xs sm:text-sm text-slate-900 dark:text-slate-100">
                        <span class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs shrink-0">1</span>
                        <span>Tambahkan Akun ke Aplikasi Authenticator</span>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 pl-8 leading-relaxed">
                        Buka aplikasi <strong>Google Authenticator</strong> atau <strong>Microsoft Authenticator</strong> di ponselmu, pilih <em>"Tambahkan Akun"</em> &rarr; <em>"Masukkan Kunci Penyiapan / Enter Setup Key"</em>:
                    </p>

                    <div class="pl-8 space-y-3">
                        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 space-y-2 max-w-lg">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Kunci Penyiapan Rahasia (Secret Key):</span>
                            <div class="flex items-center justify-between gap-3">
                                <code id="secret-key" class="text-base sm:text-lg font-mono font-bold tracking-wider text-emerald-600 dark:text-emerald-400 select-all">
                                    {{ $secret }}
                                </code>
                                <button type="button" 
                                        onclick="navigator.clipboard.writeText('{{ $secret }}'); alert('Kunci rahasia berhasil disalin ke clipboard!');" 
                                        class="px-3.5 py-2 bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl text-xs font-semibold text-slate-800 dark:text-slate-200 transition shrink-0 min-h-[44px]">
                                    Salin Kunci
                                </button>
                            </div>
                        </div>

                        <div>
                            <a href="{{ $otpAuthUri }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:underline min-h-[36px]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                <span>Buka langsung di aplikasi Authenticator ponsel ini</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Langkah 2: Konfirmasi Kode --}}
                <div class="space-y-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2 font-bold text-xs sm:text-sm text-slate-900 dark:text-slate-100">
                        <span class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs shrink-0">2</span>
                        <span>Verifikasi & Aktifkan</span>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 pl-8 leading-relaxed">
                        Masukkan kode 6-digit yang muncul di aplikasi Authenticator untuk mengonfirmasi bahwa penyiapan telah berhasil:
                    </p>

                    <form method="POST" action="{{ route('two-factor.confirm') }}" class="pl-8 max-w-sm space-y-4">
                        @csrf
                        <div>
                            <label for="code" class="sr-only">Kode Verifikasi 6 Digit</label>
                            <input type="text" 
                                   inputmode="numeric" 
                                   pattern="[0-9]*" 
                                   maxlength="6" 
                                   id="code" 
                                   name="code" 
                                   required 
                                   placeholder="Contoh: 123456" 
                                   class="w-full text-center tracking-widest text-xl font-mono px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 min-h-[44px]" />
                            @error('code')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 text-xs sm:text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-xs transition min-h-[44px]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Konfirmasi & Aktifkan 2FA</span>
                        </button>
                    </form>
                </div>
            </div>
        @else
            {{-- KONDISI 2: 2FA SUDAH AKTIF --}}
            {{-- Kartu Status & Kode Pemulihan --}}
            <div class="bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 space-y-6 shadow-xs">
                <div class="border-b border-slate-100 dark:border-slate-800 pb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-slate-100 flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Kode Pemulihan Darurat (Recovery Codes)
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                            Simpan kode-kode ini di tempat yang aman. Setiap kode hanya dapat digunakan sekali bila kamu kehilangan akses ke aplikasi authenticator.
                        </p>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-lg shrink-0">
                        Sisa: {{ count($recoveryCodes) }} kode
                    </span>
                </div>

                @if(count($recoveryCodes) > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 p-4 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700">
                        @foreach($recoveryCodes as $code)
                            <div class="p-2.5 bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-lg text-center font-mono text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100 select-all">
                                {{ $code }}
                            </div>
                        @endforeach
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="button" 
                                onclick="navigator.clipboard.writeText('{{ implode("\n", $recoveryCodes) }}'); alert('Semua kode pemulihan telah disalin ke clipboard!');" 
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl text-xs font-semibold text-slate-800 dark:text-slate-200 transition min-h-[44px]">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                            <span>Salin Semua Kode</span>
                        </button>
                    </div>
                @else
                    <div class="p-4 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800 text-xs text-amber-900 dark:text-amber-200">
                        Kamu telah menggunakan semua kode pemulihan cadangan. Sangat disarankan membuat kode pemulihan baru di bawah ini.
                    </div>
                @endif

                {{-- Buat Ulang Kode Pemulihan --}}
                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 space-y-3">
                    <h3 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100">Buat Ulang Kode Pemulihan</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Jika kamu merasa kode sebelumnya telah diketahui pihak lain atau hampir habis, kamu dapat membuat 8 kode baru.</p>
                    
                    <form method="POST" action="{{ route('two-factor.regenerate-recovery-codes') }}" class="flex flex-col sm:flex-row items-start sm:items-center gap-3 max-w-lg">
                        @csrf
                        <div class="flex-1 w-full">
                            <label for="regen_password" class="sr-only">Kata Sandi Saat Ini</label>
                            <input type="password" 
                                   id="regen_password" 
                                   name="password" 
                                   required 
                                   placeholder="Masukkan kata sandi akunmu..." 
                                   class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500 min-h-[44px]" />
                        </div>
                        <button type="submit" 
                                class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-800 dark:text-slate-200 text-xs sm:text-sm font-semibold rounded-xl transition min-h-[44px] shrink-0">
                            <span>Buat Ulang Kode</span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Kartu Nonaktifkan 2FA --}}
            <div class="border border-rose-200 dark:border-rose-900/60 p-6 sm:p-8 space-y-4 bg-rose-50/20 dark:bg-rose-950/20 rounded-2xl">
                <div class="border-b border-rose-200 dark:border-rose-900/40 pb-3">
                    <h2 class="text-sm sm:text-base font-bold text-rose-900 dark:text-rose-200 flex items-center gap-2">
                        <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        Nonaktifkan Autentikasi Dua Faktor
                    </h2>
                    <p class="text-xs text-rose-700 dark:text-rose-300 mt-0.5">
                        Menonaktifkan 2FA akan menurunkan perlindungan keamanan akunmu. Kamu hanya akan memerlukan login ID dan kata sandi untuk masuk.
                    </p>
                </div>

                <form method="POST" action="{{ route('two-factor.disable') }}" 
                      onsubmit="return confirm('Apakah Anda yakin ingin menonaktifkan Autentikasi Dua Faktor? Akun Anda tidak lagi terlindungi lapisan kedua.');"
                      class="flex flex-col sm:flex-row items-start sm:items-center gap-3 max-w-lg">
                    @csrf
                    <div class="flex-1 w-full">
                        <label for="disable_password" class="sr-only">Kata Sandi Saat Ini</label>
                        <input type="password" 
                               id="disable_password" 
                               name="password" 
                               required 
                               placeholder="Konfirmasi kata sandimu..." 
                               class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-rose-300 dark:border-rose-800 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-rose-500 min-h-[44px]" />
                    </div>
                    <button type="submit" 
                            class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs sm:text-sm font-semibold rounded-xl transition min-h-[44px] shrink-0">
                        <span>Nonaktifkan 2FA</span>
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-layouts.app>
