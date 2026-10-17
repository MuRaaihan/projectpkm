<x-layouts.public title="Masuk ke SISPERKA - MTs Soebono Mantofani">
    <div class="min-h-[calc(100dvh-10rem)] flex items-center justify-center py-10 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-6">
            {{-- Header Form --}}
            <div class="text-center space-y-2">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200/80 shadow-2xs mb-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Masuk ke SISPERKA
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 max-w-xs mx-auto leading-relaxed">
                    Satu portal terpadu untuk Siswa, Guru BK, dan Master Admin MTs Soebono Mantofani.
                </p>
            </div>

            {{-- Kartu Login --}}
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-8 space-y-5">
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    {{-- ID Pengguna --}}
                    <div>
                        <x-input 
                            name="login_id" 
                            label="ID Pengguna (NIS / NIP / Username)"
                            placeholder="Contoh: 12345 (Siswa) atau NIP Guru BK"
                            required
                            autofocus
                            helper="Siswa masukkan nomor NIS, Guru BK masukkan NIP/username."
                        />
                    </div>

                    {{-- Kata Sandi --}}
                    <div>
                        <x-input 
                            name="password" 
                            type="password"
                            label="Kata Sandi"
                            placeholder="Masukkan kata sandi akunmu"
                            required
                        />
                    </div>

                    {{-- Ingat Saya --}}
                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none text-slate-600">
                            <input type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-700 focus:ring-emerald-500 w-4 h-4" />
                            <span>Ingat akun saya di perangkat ini</span>
                        </label>
                    </div>

                    {{-- Tombol Masuk --}}
                    <div class="pt-2">
                        <x-button type="submit" variant="primary" size="lg" class="w-full font-bold shadow-xs">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Masuk Sekarang
                        </x-button>
                    </div>
                </form>

                {{-- Catatan Bantuan Akun --}}
                <div class="pt-4 border-t border-slate-100 text-center">
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Lupa kata sandi atau belum memiliki akun? Hubungi Guru BK di ruang konseling atau staf tata usaha madrasah.
                    </p>
                </div>
            </div>

            {{-- Jaminan Kerahasiaan Ringkas --}}
            <div class="text-center text-xs text-slate-500 flex items-center justify-center gap-1.5">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span>Sistem Pelaporan Resmi & Rahasia MTs Soebono Mantofani</span>
            </div>
        </div>
    </div>
</x-layouts.public>
