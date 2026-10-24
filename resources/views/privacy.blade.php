<x-layouts.public title="Kebijakan Privasi & Batas Kerahasiaan - SISPERKA">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16 space-y-8 animate-fade-in">
        {{-- Header Halaman --}}
        <div class="space-y-3 pb-6 border-b border-slate-200 dark:border-slate-800">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 text-xs sm:text-sm font-semibold">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Batas Kerahasiaan & Hak Perlindungan Pelapor
            </div>
            <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100">
                Kebijakan Privasi & Batas Kerahasiaan
            </h1>
            <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 leading-relaxed">
                Panduan resmi perlindungan data, independensi konseling, dan jaminan keamanan bagi peserta didik MTs Soebono Mantofani.
            </p>
        </div>

        {{-- Konten Utama Kebijakan --}}
        <div class="space-y-6 text-sm sm:text-base text-slate-700 dark:text-slate-300 leading-relaxed">
            {{-- Poin 1: Komitmen Utama --}}
            <div class="p-6 rounded-2xl bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 shadow-xs space-y-3">
                <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100 flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 text-sm font-mono font-bold flex items-center justify-center shrink-0">1</span>
                    Komitmen Perlindungan Peserta Didik
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    SISPERKA (Sistem Pelaporan Perundungan MTs Soebono Mantofani) dibangun semata-mata untuk mewujudkan lingkungan madrasah yang bebas dari kekerasan fisik, verbal, relasional, maupun siber (<em>cyberbullying</em>), mengacu pada <strong>Permendikbudristek No. 46 Tahun 2023</strong> tentang Pencegahan dan Penanganan Kekerasan di Lingkungan Satuan Pendidikan.
                </p>
            </div>

            {{-- Poin 2: Kerahasiaan Identitas --}}
            <div class="p-6 rounded-2xl bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 shadow-xs space-y-3">
                <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100 flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 text-sm font-mono font-bold flex items-center justify-center shrink-0">2</span>
                    Opsi "Sembunyikan Nama" (Pelapor Rahasia)
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    Setiap pelapor (baik yang melapor sebagai korban maupun saksi) memiliki hak penuh untuk menyembunyikan identitasnya. Jika opsi ini dicentang:
                </p>
                <ul class="list-disc list-inside space-y-2 text-xs sm:text-sm text-slate-600 dark:text-slate-400 pl-2">
                    <li>Namamu akan tampil sebagai <strong>"Pelapor Rahasia"</strong> di seluruh daftar laporan.</li>
                    <li>Bahkan di layar Guru BK, namamu tetap tertutup sampai Guru BK melakukan tindakan khusus "Lihat Identitas" jika sangat diperlukan demi keselamatanmu.</li>
                    <li>Setiap pembukaan identitas wajib memiliki alasan profesional dan <strong>tercatat permanen</strong> di log audit keamanan madrasah.</li>
                </ul>
            </div>

            {{-- Poin 3: Batas Kerahasiaan --}}
            <div class="p-6 rounded-2xl bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 shadow-xs space-y-3">
                <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100 flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 text-sm font-mono font-bold flex items-center justify-center shrink-0">3</span>
                    Kapan Kerahasiaan Perlu Dibuka? (Batas Kerahasiaan)
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    Sesuai etika profesi Bimbingan & Konseling dan asas hukum perlindungan anak, kerahasiaan identitas hanya dapat dibuka terbatas kepada pihak berwenang (Kepala Madrasah, Orang Tua/Wali, atau Tim Medis) dalam kondisi darurat terbatas:
                </p>
                <ul class="list-disc list-inside space-y-2 text-xs sm:text-sm text-slate-600 dark:text-slate-400 pl-2">
                    <li>Terdapat ancaman bahaya fisik serius yang mengancam keselamatan nyawa siswa atau orang lain.</li>
                    <li>Terdapat indikasi tindakan yang membutuhkan penanganan medis segera atau intervensi darurat khusus.</li>
                </ul>
                <p class="text-xs text-slate-500 italic mt-2">
                    Bahkan dalam kondisi darurat tersebut, pembukaan informasi dilakukan secara sangat terukur, bertahap, dan selalu mengutamakan pemulihan mental serta martabat siswa.
                </p>
            </div>

            {{-- Poin 4: Batasan Akses Master Administrator --}}
            <div class="p-6 rounded-2xl bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 shadow-xs space-y-3">
                <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100 flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 text-sm font-mono font-bold flex items-center justify-center shrink-0">4</span>
                    Batasan Akses Master Administrator (Admin Sekolah)
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    Sistem dirancang dengan pemisahan wewenang ketat (<em>Separation of Duties</em>):
                </p>
                <ul class="list-disc list-inside space-y-2 text-xs sm:text-sm text-slate-600 dark:text-slate-400 pl-2">
                    <li>Master Admin <strong>TIDAK BISA</strong> membaca kronologi peristiwa, catatan internal penanganan, maupun lampiran bukti apa pun.</li>
                    <li>Master Admin <strong>TIDAK BISA</strong> melihat nama siswa yang melapor maupun yang dilaporkan.</li>
                    <li>Master Admin hanya bertugas mengelola akun login pengguna dan melihat statistik jumlah laporan berupa grafik angka agregat.</li>
                </ul>
            </div>

            {{-- Poin 5: Enkripsi & Notifikasi Internal --}}
            <div class="p-6 rounded-2xl bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 shadow-xs space-y-3">
                <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100 flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 text-sm font-mono font-bold flex items-center justify-center shrink-0">5</span>
                    Keamanan Penyimpanan & Komunikasi Internal
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    Untuk memastikan tidak ada jejak digital yang bocor ke lingkungan luar:
                </p>
                <ul class="list-disc list-inside space-y-2 text-xs sm:text-sm text-slate-600 dark:text-slate-400 pl-2">
                    <li>Semua kolom sensitif di database disimpan dalam keadaan terenkripsi.</li>
                    <li>Seluruh pemberitahuan perkembangan laporan berlangsung <strong>hanya di dalam website ini</strong> melalui ikon lonceng. Sistem tidak mengirim pesan ke WhatsApp, SMS, atau email ke pihak luar.</li>
                    <li>File bukti dienkripsi dan disimpan di folder privat yang tidak dapat diakses bebas lewat internet.</li>
                </ul>
            </div>
        </div>

        {{-- Hubungi BK --}}
        <div class="p-6 rounded-2xl bg-slate-50 dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <p class="text-sm font-bold text-slate-900 dark:text-slate-100">Punya pertanyaan seputar keamanan dan privasi?</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Guru Bimbingan & Konseling MTs Soebono Mantofani siap menjawab keraguanmu di ruang BK madrasah.</p>
            </div>
            <a href="{{ route('home') }}" class="min-h-[44px] inline-flex items-center justify-center px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-xl transition active:scale-[0.98]">
                &larr; Kembali ke Beranda
            </a>
        </div>
                &larr; Kembali ke Beranda
            </a>
        </div>
    </div>
</x-layouts.public>
