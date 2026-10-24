<x-layouts.public title="Masuk ke SISPERKA - MTs Soebono Mantofani">
    <div class="min-h-[calc(100dvh-12rem)] flex flex-col items-center justify-center py-10 px-4 sm:px-6 lg:px-8 animate-fade-in">
        <div class="w-full max-w-md">
            {{-- Branding Header --}}
            <div class="flex flex-col items-center gap-3 mb-8 text-center animate-slide-up">
                <div class="w-16 h-16 rounded-2xl bg-white dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 flex items-center justify-center shadow-xs p-2.5">
                    <img src="{{ asset('images/logo-sekolah.png') }}" 
                         alt="Logo Sekolah" 
                         class="w-full h-full object-contain" />
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight">
                        Masuk ke SISPERKA
                    </h1>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mt-1">
                        MTs Soebono Mantofani
                    </p>
                </div>
            </div>

            {{-- Kartu Form Login --}}
            <div class="bg-white dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-3xl shadow-sm p-7 sm:p-9 w-full animate-slide-up stagger-1">
                <div class="mb-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-100/90 dark:bg-primary-950/70 text-primary-800 dark:text-primary-300 text-xs font-bold mb-3 border border-primary-200 dark:border-primary-800 shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-primary-600 dark:bg-[#5AE39D]"></span>
                        Portal Masuk Universal
                    </div>
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-slate-100 tracking-tight">
                        Masuk ke Akun
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-1 leading-relaxed">
                        Satu portal terpadu untuk Siswa, Guru BK, dan Master Admin.
                    </p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4.5 space-y-4" novalidate>
                    @csrf

                    {{-- ID Pengguna --}}
                    <div>
                        <x-input 
                            name="login_id" 
                            label="ID Pengguna (NIS / NIP / Username)"
                            placeholder="Contoh: 12345 (Siswa) atau NIP Guru BK"
                            required
                            autofocus
                            helper="Siswa masukkan nomor NIS, Guru BK masukkan NIP atau username."
                        />
                    </div>

                    {{-- Kata Sandi --}}
                    <div>
                        <x-input 
                            name="password" 
                            type="password"
                            label="Kata Sandi"
                            placeholder="Masukkan kata sandi akun Anda"
                            required
                        />
                    </div>

                    {{-- Ingat Saya --}}
                    <div class="flex items-center justify-between text-sm pt-1">
                        <label class="flex items-center gap-2.5 cursor-pointer select-none text-slate-700 dark:text-slate-300 min-h-[44px]">
                            <input type="checkbox" name="remember" class="rounded-md border-slate-300 dark:border-slate-700 text-primary-600 focus:ring-primary-500 w-4 h-4 bg-white dark:bg-slate-800" />
                            <span class="text-xs sm:text-sm font-medium">Ingat akun saya di perangkat ini</span>
                        </label>
                    </div>

                    {{-- Tombol Masuk --}}
                    <div class="pt-2">
                        <x-button type="submit" variant="primary" size="lg" class="w-full font-bold shadow-xs">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Masuk Sekarang
                        </x-button>
                    </div>
                </form>

                {{-- Catatan Bantuan Akun --}}
                <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-800 text-center">
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                        Lupa kata sandi atau belum memiliki akun? Hubungi Guru BK di ruang konseling atau staf tata usaha madrasah.
                    </p>
                </div>
            </div>

            {{-- Jaminan Kerahasiaan Ringkas --}}
            <div class="text-center text-xs text-slate-500 dark:text-slate-400 flex items-center justify-center gap-1.5 mt-6">
                <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span>Sistem Pelaporan Resmi & Rahasia MTs Soebono Mantofani</span>
            </div>
        </div>
    </div>
</x-layouts.public>
