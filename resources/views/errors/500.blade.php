<x-layouts.public title="500 - Terjadi Kendala Server - SISPERKA">
    <div class="min-h-[calc(100dvh-16rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 animate-fade-in">
        <div class="max-w-md w-full text-center space-y-6">
            <div class="mx-auto w-16 h-16 rounded-2xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-800 flex items-center justify-center font-bold shadow-xs">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <div class="space-y-2">
                <span class="text-xs font-bold text-rose-600 dark:text-rose-400 tracking-wider uppercase">Galat 500 &bull; Kendala Sistem</span>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100">
                    Terjadi Kendala Teknis
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                    Sistem sedang mengalami kendala sementara saat memproses permintaan Anda. Silakan coba kembali beberapa saat lagi.
                </p>
            </div>

            <div class="pt-2 flex flex-wrap items-center justify-center gap-3">
                <a href="{{ url('/') }}" class="min-h-[44px] inline-flex items-center justify-center px-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-200 bg-white dark:bg-[#16231D] hover:bg-slate-50 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-800 rounded-xl shadow-xs transition active:scale-[0.98]">
                    Kembali ke Beranda
                </a>

                @auth
                    <a href="{{ url('/dashboard') }}" class="min-h-[44px] inline-flex items-center justify-center px-5 py-2.5 text-xs sm:text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-xs transition active:scale-[0.98]">
                        Buka Dashboard Saya
                    </a>
                @endauth
            </div>
        </div>
    </div>
</x-layouts.public>
