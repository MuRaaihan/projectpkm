<x-layouts.app title="Impor Akun Berhasil">
    <div class="px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8 max-w-2xl w-full mx-auto space-y-6 animate-fade-in">
        <div class="bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl p-8 text-center space-y-6 shadow-xs">
            {{-- Icon Sukses --}}
            <div class="w-16 h-16 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 rounded-full flex items-center justify-center mx-auto shadow-xs">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100">
                    Impor {{ $count }} Akun Berhasil Disimpan!
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-2">
                    Seluruh akun {{ $type === 'siswa' ? 'siswa' : 'Guru BK' }} telah berhasil didaftarkan ke sistem SISPERKA dengan kata sandi acak yang aman.
                </p>
            </div>

            {{-- Peringatan Keamanan Unduh Kredensial Sekali Pakai --}}
            <div class="p-4 bg-amber-50 dark:bg-amber-950/30 rounded-2xl border border-amber-200 dark:border-amber-800/80 text-left space-y-2">
                <div class="flex items-center gap-2 text-amber-900 dark:text-amber-200 font-bold text-xs sm:text-sm">
                    <svg class="w-4 h-4 text-amber-600 dark:text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>PERINGATAN KEAMANAN PENTING</span>
                </div>
                <p class="text-xs text-amber-800 dark:text-amber-300 leading-relaxed">
                    Demi melindungi kerahasiaan anak didik dan mencegah kebocoran data, berkas berisi daftar kata sandi awal akun ini <strong>HANYA DAPAT DIUNDUH 1 (SATU) KALI</strong>. Tautan akan otomatis kedaluwarsa setelah diunduh atau saat Anda meninggalkan halaman ini.
                </p>
            </div>

            {{-- Tombol Unduh Kredensial --}}
            <div class="pt-2">
                <a href="{{ route('master.import.download-credentials', ['token' => $downloadToken]) }}" class="min-h-[44px] inline-flex items-center justify-center gap-2 px-6 py-2.5 text-xs sm:text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-xs transition active:scale-[0.98]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Unduh Berkas Kredensial Akun (.XLSX) Sekarang
                </a>
            </div>

            {{-- Link Kembali --}}
            <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-center gap-4 text-xs sm:text-sm">
                @if ($type === 'siswa')
                    <a href="{{ route('master.students.index') }}" class="font-semibold text-emerald-600 dark:text-emerald-400 hover:underline">
                        Buka Daftar Siswa &rarr;
                    </a>
                @else
                    <a href="{{ route('master.bk-users.index') }}" class="font-semibold text-emerald-600 dark:text-emerald-400 hover:underline">
                        Buka Daftar Guru BK &rarr;
                    </a>
                @endif
                <span class="text-slate-300 dark:text-slate-600">|</span>
                <a href="{{ route('master.dashboard') }}" class="text-slate-500 hover:text-slate-800 dark:hover:text-slate-300 transition">
                    Kembali ke Dashboard Master
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
