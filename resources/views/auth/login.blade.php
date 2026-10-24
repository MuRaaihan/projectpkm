<x-layouts.public title="Masuk ke SISPERKA - MTs Soebono Mantofani" :hide-footer="true">
    <div class="min-h-[calc(100dvh-5rem)] flex flex-col items-center justify-center py-8 px-4 sm:px-6 lg:px-8 animate-fade-in">
        <div class="w-full max-w-md">
            {{-- Branding Header --}}
            <div class="flex flex-col items-center gap-3 mb-6 text-center animate-slide-up">
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
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-slate-100 tracking-tight">
                        Masuk ke Akun
                    </h2>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-4" novalidate>
                    @csrf

                    {{-- ID Pengguna --}}
                    <div>
                        <x-input 
                            name="login_id" 
                            label="ID Pengguna (NIS / NIP / Username)"
                            placeholder="Masukkan ID Pengguna Anda"
                            required
                            autofocus
                        />
                    </div>

                    {{-- Kata Sandi --}}
                    <div>
                        <x-input 
                            name="password" 
                            type="password"
                            label="Kata Sandi"
                            placeholder="Masukkan kata sandi Anda"
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
            </div>
        </div>
    </div>
</x-layouts.public>
