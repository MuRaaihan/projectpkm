<x-layouts.public title="Kebijakan Privasi & Batas Kerahasiaan - SISPERKA">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16 space-y-8">
        {{-- Header Halaman --}}
        <div class="space-y-3 pb-6 border-b border-slate-200">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-semibold">
                Batas Kerahasiaan & Hak Pelapor
            </div>
            <h1 class="text-2xl sm:text-4xl font-bold tracking-tight text-slate-900">
                Kebijakan Privasi & Batas Kerahasiaan
            </h1>
            <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                Panduan resmi perlindungan data dan jaminan keamanan bagi peserta didik MTs Soebono Mantofani.
            </p>
        </div>

        {{-- Konten Utama Kebijakan --}}
        <div class="prose prose-slate max-w-none space-y-6 text-sm text-slate-700 leading-relaxed">
            {{-- Poin 1: Komitmen Utama --}}
            <div class="p-6 rounded-2xl bg-white border border-slate-200/80 shadow-xs space-y-3">
                <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-800 text-xs font-mono font-bold flex items-center justify-center shrink-0">1</span>
                    Komitmen Perlindungan Anak
                </h2>
                <p>
                    SISPERKA (Sistem Pelaporan Perundungan MTs Soebono Mantofani) dibangun semata-mata untuk mewujudkan lingkungan madrasah yang bebas dari kekerasan fisik, verbal, relasional, maupun siber (<em>cyberbullying</em>), mengacu pada <strong>Permendikbudristek No. 46 Tahun 2023</strong>.
                </p>
            </div>

            {{-- Poin 2: Kerahasiaan Identitas --}}
            <div class="p-6 rounded-2xl bg-white border border-slate-200/80 shadow-xs space-y-3">
                <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-800 text-xs font-mono font-bold flex items-center justify-center shrink-0">2</span>
                    Opsi "Sembunyikan Nama" (Pelapor Rahasia)
                </h2>
                <p>
                    Setiap pelapor (baik sebagai korban maupun saksi) memiliki hak untuk menyembunyikan identitasnya. Jika opsi ini dipilih:
                </p>
                <ul class="list-disc list-inside space-y-1.5 text-slate-600 pl-2">
                    <li>Namamu akan tampil sebagai <strong>"Pelapor Rahasia"</strong> di sistem.</li>
                    <li>Bahkan di layar Guru BK, namamu tetap tertutup sampai Guru BK melakukan aksi khusus "Lihat Identitas" jika sangat diperlukan untuk keselamatanmu.</li>
                    <li>Setiap pembukaan identitas wajib memiliki alasan resmi dan <strong>tercatat secara permanen</strong> di log audit keamanan madrasah.</li>
                </ul>
            </div>

            {{-- Poin 3: Batas Kerahasiaan --}}
            <div class="p-6 rounded-2xl bg-white border border-slate-200/80 shadow-xs space-y-3">
                <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-800 text-xs font-mono font-bold flex items-center justify-center shrink-0">3</span>
                    Kapan Kerahasiaan Perlu Dibuka? (Batas Kerahasiaan)
                </h2>
                <p>
                    Sesuai etika profesi Bimbingan & Konseling dan keselamatan hukum perlindungan anak, kerahasiaan identitas hanya dapat dibuka terbatas kepada pihak berwenang (Kepala Madrasah / Orang Tua / Pihak Medis) dalam kondisi darurat:
                </p>
                <ul class="list-disc list-inside space-y-1.5 text-slate-600 pl-2">
                    <li>Terdapat ancaman bahaya fisik serius yang mengancam nyawa siswa atau orang lain.</li>
                    <li>Terdapat indikasi tindakan yang membutuhkan penanganan medis segera atau intervensi darurat.</li>
                </ul>
                <p class="text-xs text-slate-500 italic mt-2">
                    Bahkan dalam kondisi tersebut, pembukaan informasi dilakukan secara bertahap, profesional, dan dengan mengutamakan keselamatan mental siswa.
                </p>
            </div>

            {{-- Poin 4: Tombol Keluar Cepat --}}
            <div class="p-6 rounded-2xl bg-white border border-slate-200/80 shadow-xs space-y-3">
                <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-800 text-xs font-mono font-bold flex items-center justify-center shrink-0">4</span>
                    Fasilitas Tombol "Keluar Cepat"
                </h2>
                <p>
                    Untuk melindungi privasimu saat sedang membuka sistem di lingkungan umum atau sekolah, tombol merah <strong>"Keluar Cepat"</strong> di pojok kanan atas selalu tersedia di seluruh halaman. Menekan tombol ini akan seketika menutup sesi pelaporan dan mengalihkan browser ke halaman netral (Google).
                </p>
            </div>
        </div>

        {{-- Hubungi BK --}}
        <div class="p-6 rounded-2xl bg-slate-100 border border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <p class="text-sm font-bold text-slate-900">Punya pertanyaan seputar keamanan dan privasi?</p>
                <p class="text-xs text-slate-500">Guru Bimbingan & Konseling MTs Soebono Mantofani siap menjawab keraguanmu.</p>
            </div>
            <a href="{{ route('home') }}" class="px-4 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition active:scale-[0.98]">
                &larr; Kembali ke Beranda
            </a>
        </div>
    </div>
</x-layouts.public>
