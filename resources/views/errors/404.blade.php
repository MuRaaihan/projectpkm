<x-layouts.public title="404 - Halaman Tidak Ditemukan - SISPERKA">
    <div class="min-h-[calc(100dvh-16rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 animate-fade-in">
        <div class="max-w-md w-full text-center space-y-6">
            <div class="mx-auto w-16 h-16 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 flex items-center justify-center font-bold shadow-xs">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <div class="space-y-2">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400 tracking-wider uppercase">Galat 404 &bull; Tidak Ditemukan</span>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100">
                    Halaman Tidak Ditemukan
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                    Halaman yang Anda tuju mungkin telah dipindahkan, dihapus, atau tautan yang Anda masukkan salah.
                </p>
            </div>

            <div class="pt-2 flex flex-wrap items-center justify-center gap-3">
                <a href="{{ url('/') }}" class="min-h-[42px] inline-flex items-center justify-center px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xs transition active:scale-[0.98]">
                    Kembali ke Beranda
                </a>

                @auth
                    <a href="{{ url('/dashboard') }}" class="min-h-[42px] inline-flex items-center justify-center px-5 py-2 text-xs sm:text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-xs transition active:scale-[0.98]">
                        Buka Dashboard Saya
                    </a>
                @endauth
            </div>
        </div>
    </div>
</x-layouts.public>
