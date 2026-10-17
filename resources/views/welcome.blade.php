<x-layouts.public title="SISPERKA - Ruang Aman Pelaporan Perundungan MTs Soebono Mantofani">
    <div class="space-y-16 sm:space-y-24 py-8 sm:py-16">
        {{-- HERO SECTION (Asymmetric Split Layout) --}}
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
                {{-- Kolom Teks Kiri --}}
                <div class="lg:col-span-7 space-y-6">
                    {{-- Badge Status --}}
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-200/80 text-xs font-semibold text-emerald-800 shadow-2xs">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-600"></span>
                        </span>
                        <span>Ruang Aman & Rahasia Siswa MTs Soebono Mantofani</span>
                    </div>

                    {{-- Judul Utama --}}
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-slate-900 leading-[1.15]">
                        Setiap Anak Berhak Merasa <span class="text-emerald-700 underline decoration-emerald-300 decoration-wavy decoration-2 underline-offset-6">Aman & Dihargai</span> di Madrasah.
                    </h1>

                    {{-- Deskripsi Hangat --}}
                    <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl">
                        Jika kamu mengalami atau melihat perundungan (<em>bullying</em>), jangan ragu untuk bercerita. Laporanmu dijaga sepenuhnya secara rahasia dan langsung ditangani dengan penuh kasih oleh Guru Bimbingan & Konseling (BK).
                    </p>

                    {{-- Action CTA --}}
                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 text-sm font-bold text-white bg-emerald-700 hover:bg-emerald-800 rounded-xl shadow-sm transition duration-150 active:scale-[0.98]">
                                Buka Dashboard Saya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 text-sm font-bold text-white bg-emerald-700 hover:bg-emerald-800 rounded-xl shadow-sm transition duration-150 active:scale-[0.98]">
                                Masuk & Buat Laporan
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        @endauth

                        <a href="#tata-cara" class="inline-flex items-center justify-center gap-2 px-5 py-3.5 text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 rounded-xl transition duration-150 active:scale-[0.98]">
                            Pelajari Tata Cara
                        </a>
                    </div>

                    {{-- Pernyataan Privasi Ramah Anak --}}
                    <div class="flex items-center gap-2 text-xs text-slate-500 pt-1">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>Tersedia opsi <strong>"Sembunyikan Nama"</strong>. Kamu tidak akan dimarahi atau dipersalahkan.</span>
                    </div>
                </div>

                {{-- Kolom Visual Kanan (Bento Card Preview Keamanan) --}}
                <div class="lg:col-span-5">
                    <div class="relative">
                        {{-- Kartu Utama --}}
                        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-md p-6 sm:p-8 space-y-6 relative z-10">
                            {{-- Header Kartu --}}
                            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900">Perlindungan Kerahasiaan</p>
                                        <p class="text-[11px] text-slate-500">Standar Keamanan SISPERKA</p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    Aktif
                                </span>
                            </div>

                            {{-- Poin Keunggulan Keamanan --}}
                            <div class="space-y-3.5">
                                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 flex items-start gap-3">
                                    <div class="w-6 h-6 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">
                                        ✓
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-800">Identitas Terlindungi Penuh</h4>
                                        <p class="text-[11px] text-slate-500 leading-relaxed mt-0.5">
                                            Nama pelapor dapat disamarkan sebagai <strong>"Pelapor Rahasia"</strong>.
                                        </p>
                                    </div>
                                </div>

                                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 flex items-start gap-3">
                                    <div class="w-6 h-6 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">
                                        ✓
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-800">Hanya Diakses Guru BK</h4>
                                        <p class="text-[11px] text-slate-500 leading-relaxed mt-0.5">
                                            Bahkan akun Master tidak dapat membaca kronologi laporan maupun identitas pelapor.
                                        </p>
                                    </div>
                                </div>

                                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 flex items-start gap-3">
                                    <div class="w-6 h-6 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">
                                        ✓
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-800">Tombol Keluar Cepat</h4>
                                        <p class="text-[11px] text-slate-500 leading-relaxed mt-0.5">
                                            Klik tombol merah di header jika ada orang mendekat untuk langsung menutup sistem.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Kontak Ruang Konseling --}}
                            <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                                <span>Ruang BK MTs Soebono Mantofani</span>
                                <span class="font-semibold text-emerald-700">Layanan Aktif</span>
                            </div>
                        </div>

                        {{-- Dekorasi Latar Belakang Halus --}}
                        <div class="absolute -inset-2 bg-emerald-100/40 rounded-[2.5rem] -z-10 blur-xl transform rotate-1"></div>
                    </div>
                </div>
            </div>
        </section>

        {{-- SECTION 2: TATA CARA PELAPORAN (Asymmetric Timeline / Stepper) --}}
        <section id="tata-cara" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24">
            <div class="text-center max-w-2xl mx-auto mb-12 space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Langkah Mudah</span>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">
                    Bagaimana Cara Melaporkan?
                </h2>
                <p class="text-xs sm:text-sm text-slate-500">
                    Proses pelaporan dirancang singkat, jelas, dan tidak membebani peserta didik.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Langkah 1 --}}
                <div class="p-6 rounded-2xl bg-white border border-slate-200/80 shadow-xs space-y-3 relative">
                    <span class="font-mono text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md inline-block">
                        Langkah 01
                    </span>
                    <h3 class="text-sm font-bold text-slate-900">Masuk dengan NIS</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Gunakan Nomor Induk Siswa (NIS) dan kata sandi yang telah dibagikan pihak madrasah.
                    </p>
                </div>

                {{-- Langkah 2 --}}
                <div class="p-6 rounded-2xl bg-white border border-slate-200/80 shadow-xs space-y-3 relative">
                    <span class="font-mono text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md inline-block">
                        Langkah 02
                    </span>
                    <h3 class="text-sm font-bold text-slate-900">Ceritakan Peristiwa</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Tuliskan tempat, perkiraan waktu, dan apa yang terjadi. Kamu dapat melapor sebagai korban maupun saksi.
                    </p>
                </div>

                {{-- Langkah 3 --}}
                <div class="p-6 rounded-2xl bg-white border border-slate-200/80 shadow-xs space-y-3 relative">
                    <span class="font-mono text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md inline-block">
                        Langkah 03
                    </span>
                    <h3 class="text-sm font-bold text-slate-900">Pilih Opsi Rahasia</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Centang "Sembunyikan Nama Saya" bila ingin identitasmu hanya diketahui Guru BK saat penanganan khusus.
                    </p>
                </div>

                {{-- Langkah 4 --}}
                <div class="p-6 rounded-2xl bg-white border border-slate-200/80 shadow-xs space-y-3 relative">
                    <span class="font-mono text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md inline-block">
                        Langkah 04
                    </span>
                    <h3 class="text-sm font-bold text-slate-900">Pendampingan BK</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Guru BK membaca laporanmu, memberikan balasan tertutup di sistem, dan mengundangmu berbincang santai.
                    </p>
                </div>
            </div>
        </section>

        {{-- SECTION 3: BENTO KEPERCAYAAN & BATAS KERAHASIAAN --}}
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-slate-900 rounded-3xl p-8 sm:p-12 text-white space-y-8">
                <div class="max-w-2xl space-y-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-400">Jaminan Madrasah</span>
                    <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">
                        Komitmen Kami: Tempat Bercerita Tanpa Rasa Takut
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        MTs Soebono Mantofani menerapkan Permendikbudristek No. 46 Tahun 2023 untuk pencegahan dan penanganan kekerasan di lingkungan satuan pendidikan.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-6 rounded-2xl bg-slate-800/80 border border-slate-700/80 space-y-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-white">Data Terenkripsi</h3>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Kronologi kejadian, nama yang dilaporkan, dan catatan balasan disimpan dengan enkripsi militer di database.
                        </p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-800/80 border border-slate-700/80 space-y-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-white">Perlindungan Saksi & Korban</h3>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Madrasah menjamin tidak ada aksi balas dendam. Penyelesaian mengedepankan pembinaan edukatif dan restoratif.
                        </p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-800/80 border border-slate-700/80 space-y-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-white">Privat Tanpa Notifikasi Luar</h3>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Tidak ada pengiriman WhatsApp, SMS, atau email ke pihak luar. Seluruh komunikasi berlangsung di dalam website ini saja.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- SECTION 4: FAQ RINGKAS RAMAH SISWA --}}
        <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="text-center space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Tanya Jawab</span>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">
                    Pertanyaan yang Sering Diajukan
                </h2>
                <p class="text-xs sm:text-sm text-slate-500">
                    Hal-hal yang sering ditanyakan siswa sebelum menyampaikan laporan.
                </p>
            </div>

            <div class="space-y-4">
                <details class="group bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs open:border-emerald-300 transition">
                    <summary class="flex items-center justify-between font-bold text-sm text-slate-800 cursor-pointer list-none">
                        <span>Apakah orang yang merundung akan tahu bahwa aku yang melapor?</span>
                        <span class="transition group-open:rotate-180 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </span>
                    </summary>
                    <p class="mt-3 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Tidak. Guru BK tidak akan pernah memberitahukan siapa pelapornya kepada pihak terlapor. Kamu juga dapat memilih opsi "Sembunyikan Nama" agar namamu tidak terpampang di daftar umum penanganan.
                    </p>
                </details>

                <details class="group bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs open:border-emerald-300 transition">
                    <summary class="flex items-center justify-between font-bold text-sm text-slate-800 cursor-pointer list-none">
                        <span>Bagaimana kalau aku bukan korban, tapi hanya melihat temanku dirundung?</span>
                        <span class="transition group-open:rotate-180 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </span>
                    </summary>
                    <p class="mt-3 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Kamu sangat dianjurkan melapor sebagai <strong>Saksi</strong>. Membela teman yang membutuhkan pertolongan adalah perbuatan terpuji yang sangat dihargai oleh madrasah.
                    </p>
                </details>

                <details class="group bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs open:border-emerald-300 transition">
                    <summary class="flex items-center justify-between font-bold text-sm text-slate-800 cursor-pointer list-none">
                        <span>Bagaimana jika akun NIS atau kata sandi saya bermasalah?</span>
                        <span class="transition group-open:rotate-180 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </span>
                    </summary>
                    <p class="mt-3 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Kamu dapat langsung mendatangi Ruang BK atau meminta bantuan wali kelas untuk melakukan reset kata sandi melalui Master Administrator sistem madrasah.
                    </p>
                </details>
            </div>
        </section>

        {{-- CALL TO ACTION BAWAH --}}
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-emerald-700 to-teal-800 rounded-3xl p-8 sm:p-12 text-white text-center space-y-6">
                <div class="max-w-xl mx-auto space-y-3">
                    <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">
                        Kamu Berharga. Suaramu Penting.
                    </h2>
                    <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed">
                        Jangan simpan rasa takutmu sendirian. Ruang Bimbingan & Konseling MTs Soebono Mantofani siap membantumu setiap saat.
                    </p>
                </div>

                <div class="pt-2">
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 text-sm font-bold text-emerald-900 bg-white hover:bg-emerald-50 rounded-xl shadow-md transition duration-150 active:scale-[0.98]">
                        Masuk ke SISPERKA Sekarang
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-layouts.public>
