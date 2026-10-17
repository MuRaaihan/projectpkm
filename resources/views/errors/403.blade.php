<x-layouts.public title="403 - Akses Dibatasi - SISPERKA">
    <div class="min-h-[calc(100dvh-16rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full text-center space-y-5">
            <div class="mx-auto w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <div>
                <span class="text-xs font-bold text-amber-700 tracking-wider uppercase">Galat 403 &bull; Akses Dibatasi</span>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 mt-1 sm:text-3xl">
                    Halaman Tidak Dapat Diakses
                </h1>
                <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                    Maaf, kamu tidak memiliki hak akses atau izin untuk membuka halaman ini. Demi keamanan dan kerahasiaan madrasah, akses ke setiap menu dibatasi sesuai peran masing-masing.
                </p>
            </div>

            <div class="pt-2 flex items-center justify-center gap-3">
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 rounded-lg shadow-xs transition">
                    Kembali ke Beranda
                </a>

                @auth
                    <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-xs transition">
                        Buka Dashboard Saya
                    </a>
                @endauth
            </div>
        </div>
    </div>
</x-layouts.public>
