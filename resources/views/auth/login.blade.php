<x-layouts.public title="Masuk ke SIPERKA - MTs Soebono Mantofani" :hide-header="true" :hide-footer="true">
    <div class="relative min-h-screen bg-[#EDECEA] dark:bg-[#0E1713] flex flex-col items-center justify-center px-4 py-12 transition-theme" x-data="{ showPassword: false }">
        {{-- Top Utility Bar (Sesuai Frontend login/page.tsx:49-52) --}}
        <div class="absolute top-4 right-4 sm:top-6 sm:right-6 flex items-center gap-2 z-10">
            <a href="{{ url('/') }}" 
               class="w-9 h-9 flex items-center justify-center rounded-xl bg-white dark:bg-[#16231D] border border-slate-300 dark:border-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors shadow-2xs" 
               title="Kembali ke Beranda" 
               aria-label="Kembali ke Beranda">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <button type="button" 
                    onclick="try { const isDark = document.documentElement.classList.toggle('dark'); localStorage.setItem('ui-theme', isDark ? 'dark' : 'light'); } catch(_) {}"
                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-white dark:bg-[#16231D] border border-slate-300 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors shadow-2xs"
                    aria-label="Mode Terang/Gelap"
                    title="Ganti Tema">
                <svg class="w-4 h-4 hidden dark:block text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                <svg class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
            </button>
        </div>

        <div class="w-full max-w-md">
            {{-- Branding Header (Sesuai Frontend login/page.tsx:55-67) --}}
            <div class="flex flex-col items-center gap-3 mb-8 text-center animate-fade-in">
                <div class="w-16 h-16 rounded-2xl bg-white dark:bg-[#16231D] border border-slate-300 dark:border-slate-800 flex items-center justify-center shadow-xs p-3">
                    <img src="{{ asset('images/logo-sekolah.png') }}" 
                         alt="Logo MTs Soebono Mantofani" 
                         class="w-full h-full object-contain" />
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight">
                        SIPERKA
                    </h1>
                    <p class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-widest mt-1">
                        Sistem Informasi Pelaporan Kasus Perundungan
                    </p>
                </div>
            </div>

            {{-- Kartu Form Login (Sesuai Frontend login/page.tsx:70-170) --}}
            <div class="bg-white dark:bg-[#16231D] border border-slate-300 dark:border-slate-800 rounded-3xl shadow-sm p-7 sm:p-9 w-full animate-slide-up">
                <div class="mb-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-100/80 dark:bg-primary-950/70 text-primary-800 dark:text-primary-300 text-xs font-bold mb-3 border border-primary-300/80 dark:border-primary-800/80 shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-primary-600 dark:bg-[#5AE39D]"></span>
                        <span>Portal Masuk Universal</span>
                    </div>
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-slate-100 tracking-tight">
                        Masuk ke Akun
                    </h2>
                    <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">
                        Gunakan email atau identitas resmi sekolah terdaftar (NIS / NIP).
                    </p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4.5" novalidate>
                    @csrf

                    {{-- ID Pengguna / Email --}}
                    <div>
                        <label for="login_id" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                            Email / Identitas (NIS / NIP)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <input 
                                type="text"
                                id="login_id"
                                name="login_id" 
                                value="{{ old('login_id') }}"
                                placeholder="contoh: siswa@sekolah.sch.id atau NIS"
                                required
                                autofocus
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-[#111A15] text-slate-900 dark:text-slate-100 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 focus:border-transparent transition"
                            />
                        </div>
                        @error('login_id')
                            <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kata Sandi dengan Eye Toggle --}}
                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <input 
                                type="password"
                                :type="showPassword ? 'text' : 'password'"
                                id="password"
                                name="password" 
                                placeholder="Masukkan kata sandi"
                                required
                                class="w-full pl-10 pr-11 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-[#111A15] text-slate-900 dark:text-slate-100 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 focus:border-transparent transition"
                            />
                            <button type="button" 
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition"
                                    aria-label="Lihat kata sandi">
                                <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-600 dark:text-red-400 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol Masuk --}}
                    <div class="pt-2">
                        <button type="submit" class="w-full py-3 px-4 flex items-center justify-center gap-2 font-bold text-white bg-primary-600 hover:bg-primary-700 active:bg-primary-800 rounded-xl shadow-xs transition duration-150 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 text-base">
                            <span>Masuk ke SIPERKA</span>
                        </button>
                    </div>
                </form>

                {{-- Bantuan & Enkripsi Info --}}
                <div class="mt-6 pt-5 border-t border-slate-200 dark:border-slate-800 flex flex-col gap-3 text-center">
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                        Akun resmi diberikan oleh madrasah. Jika terkendala, hubungi Guru BK.
                    </p>

                    <div class="flex items-center justify-center gap-1.5 text-[11px] text-slate-500 dark:text-slate-400 mt-1">
                        <svg class="w-3.5 h-3.5 text-primary-600 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>Kerahasiaan akun dilindungi sistem enkripsi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Hilangkan ikon mata bawaan browser (Edge/IE) agar tidak ganda dengan tombol mata custom --}}
    <style>
        input::-ms-reveal,
        input::-ms-clear {
            display: none !important;
        }
    </style>

    <script>
        try { sessionStorage.removeItem('siperka_logged_out'); } catch (_) {}
    </script>
</x-layouts.public>
