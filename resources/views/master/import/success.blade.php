<x-layouts.app title="Impor Akun Berhasil">
    <div class="max-w-2xl mx-auto space-y-6">
        <x-card class="text-center p-8! space-y-6">
            {{-- Icon Sukses --}}
            <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Impor {{ $count }} Akun Berhasil Disimpan!
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-2">
                    Seluruh akun {{ $type === 'siswa' ? 'siswa' : 'Guru BK' }} telah berhasil didaftarkan ke sistem SISPERKA dengan kata sandi unik.
                </p>
            </div>

            {{-- Peringatan Keamanan Unduh Kredensial Sekali Pakai --}}
            <div class="p-4 bg-amber-50 rounded-xl border border-amber-200 text-left space-y-2">
                <div class="flex items-center gap-2 text-amber-900 font-bold text-xs">
                    <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>PERINGATAN KEAMANAN PENTING:</span>
                </div>
                <p class="text-xs text-amber-800 leading-relaxed">
                    Demi melindungi kerahasiaan anak didik dan mencegah kebocoran data, berkas berisi daftar kata sandi awal akun ini <strong>HANYA DAPAT DIUNDUH 1 (SATU) KALI</strong>. Tautan akan otomatis hangus setelah diunduh atau saat Anda meninggalkan halaman ini.
                </p>
            </div>

            {{-- Tombol Unduh Kredensial --}}
            <div class="pt-2">
                <a href="{{ route('master.import.download-credentials', ['token' => $downloadToken]) }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-md transition active:scale-[0.98]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Unduh Berkas Kredensial Akun (.XLSX) Sekarang
                </a>
            </div>

            {{-- Link Kembali --}}
            <div class="pt-4 border-t border-slate-100 flex items-center justify-center gap-4 text-xs">
                @if ($type === 'siswa')
                    <a href="{{ route('master.students.index') }}" class="font-semibold text-purple-700 hover:text-purple-900">
                        Buka Daftar Siswa &rarr;
                    </a>
                @else
                    <a href="{{ route('master.bk-users.index') }}" class="font-semibold text-purple-700 hover:text-purple-900">
                        Buka Daftar Guru BK &rarr;
                    </a>
                @endif
                <span class="text-slate-300">|</span>
                <a href="{{ route('master.dashboard') }}" class="text-slate-500 hover:text-slate-700">
                    Kembali ke Dashboard Master
                </a>
            </div>
        </x-card>
    </div>
</x-layouts.app>
