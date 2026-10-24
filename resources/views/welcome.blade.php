<x-layouts.public title="SISPERKA - Ruang Aman Pelaporan Perundungan MTs Soebono Mantofani">
    <div class="space-y-16 sm:space-y-24 py-8 sm:py-16 animate-fade-in">
        {{-- 1. HERO SECTION --}}
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                {{-- Kolom Teks Kiri --}}
                <div class="lg:col-span-7 space-y-6 animate-slide-up">
                    {{-- Badge Status Ruang Aman --}}
                    <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-primary-100/90 dark:bg-primary-950/70 border border-primary-300/80 dark:border-primary-800/80 text-xs sm:text-sm font-bold text-primary-800 dark:text-primary-300 shadow-2xs">
                        <span class="w-2.5 h-2.5 rounded-full bg-primary-600 dark:bg-[#5AE39D]" aria-hidden="true"></span>
                        <span>Ruang Aman & Rahasia Siswa MTs Soebono Mantofani</span>
                    </div>

                    {{-- Judul Utama --}}
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-slate-900 dark:text-slate-100 leading-[1.18]">
                        {{ \App\Models\Setting::get('hero_title', 'Kamu tidak sendirian. Ceritakan di sini, dengan aman.') }}
                    </h1>

                    {{-- Deskripsi Hangat (>=16px) --}}
                    <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed max-w-2xl font-normal">
                        {{ \App\Models\Setting::get('hero_subtitle', 'Jika kamu mengalami atau melihat perundungan (bullying) di sekolah, jangan ragu untuk bercerita. Laporanmu dijaga sepenuhnya secara rahasia dan langsung didampingi dengan tulus oleh Guru Bimbingan & Konseling (BK).') }}
                    </p>

                    {{-- Action CTA --}}
                    <div class="flex flex-wrap items-center gap-3.5 pt-2">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="min-h-[44px] inline-flex items-center justify-center gap-2 px-6 py-3 text-base font-bold text-white bg-primary-600 hover:bg-primary-700 active:bg-primary-800 rounded-xl shadow-xs transition duration-150 card-hover focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2">
                                <span>Buka Dashboard Saya</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="min-h-[44px] inline-flex items-center justify-center gap-2 px-6 py-3 text-base font-bold text-white bg-primary-600 hover:bg-primary-700 active:bg-primary-800 rounded-xl shadow-xs transition duration-150 card-hover focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2">
                                <span>Masuk & Buat Laporan</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        @endauth

                        <a href="#tata-cara" class="min-h-[44px] inline-flex items-center justify-center gap-2 px-5 py-3 text-base font-semibold text-slate-700 dark:text-slate-200 bg-white dark:bg-[#16231D] hover:bg-slate-50 dark:hover:bg-slate-800 border border-slate-300/80 dark:border-slate-700 rounded-xl transition duration-150 card-hover focus:outline-none focus:ring-2 focus:ring-slate-400">
                            Pelajari Tata Cara
                        </a>
                    </div>

                    {{-- Pernyataan Privasi Ramah Anak --}}
                    <div class="flex items-center gap-2.5 text-sm text-slate-600 dark:text-slate-400 pt-2 border-t border-slate-200/80 dark:border-slate-800/80">
                        <svg class="w-5 h-5 text-primary-600 dark:text-[#5AE39D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>Tersedia opsi <strong>"Sembunyikan Nama"</strong>. Kamu tidak akan dimarahi atau dipersalahkan.</span>
                    </div>
                </div>

                {{-- Kolom Visual Kanan: Ilustrasi Hero & Kartu Proteksi --}}
                <div class="lg:col-span-5 animate-slide-up stagger-1">
                    <div class="relative flex items-center justify-center">
                        {{-- Lingkaran Latar Belakang Lembut --}}
                        <div class="absolute w-[300px] h-[300px] sm:w-[400px] sm:h-[400px] rounded-full bg-primary-100/60 dark:bg-primary-950/40 border border-primary-200/50 dark:border-primary-800/30 -z-10 blur-xs"></div>

                        {{-- Titik Aksen Dekoratif --}}
                        <div class="absolute top-4 right-4 w-3.5 h-3.5 rounded-full bg-[#B8E34B] shadow-xs"></div>
                        <div class="absolute bottom-10 left-4 w-3 h-3 rounded-full bg-[#F2C94C] shadow-xs"></div>

                        {{-- Gambar Hero --}}
                        <div class="relative z-10 w-full max-w-[460px] p-2">
                            <img src="{{ asset('images/siperka-hero-v3.png') }}" 
                                 alt="Siswa melaporkan perundungan kepada Guru BK melalui SISPERKA" 
                                 class="w-full h-auto object-contain drop-shadow-md rounded-2xl" />
                        </div>
                    </div>

                    {{-- Kartu Jaminan Keamanan Mini --}}
                    <div class="mt-6 bg-white dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs p-5 space-y-3 card-hover">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-950 text-primary-700 dark:text-[#5AE39D] flex items-center justify-center font-bold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900 dark:text-slate-100">Perlindungan Kerahasiaan</p>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Standar Keamanan SISPERKA</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                Aktif
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            Identitas disamarkan sebagai <strong>"Pelapor Rahasia"</strong>. Bahkan Master Admin tidak memiliki akses melihat isi cerita laporan.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- 2. APA ITU SISPERKA & NILAI UTAMA --}}
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="p-8 sm:p-12 rounded-3xl bg-gradient-to-br from-white via-white to-slate-50 dark:from-[#16231D] dark:via-[#16231D] dark:to-[#13211B] border border-slate-200/90 dark:border-slate-800 shadow-xs space-y-8">
                <div class="max-w-3xl space-y-3">
                    <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-primary-700 dark:text-[#5AE39D]">Mengenal SISPERKA</span>
                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900 dark:text-slate-100">
                        Wadah Pelaporan Resmi yang Menjaga Keselamatan & Hak Siswa
                    </h2>
                    <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed">
                        {{ \App\Models\Setting::get('about_text', 'SISPERKA (Sistem Pelaporan Perundungan MTs Soebono Mantofani) hadir sebagai ruang terpercaya bagi seluruh peserta didik madrasah untuk menyampaikan kejadian perundungan, kekerasan verbal, fisik, maupun siber, baik yang dialami sendiri maupun disaksikan pada teman sebaya.') }}
                    </p>
                    <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 leading-relaxed">
                        Kami menjamin setiap cerita ditangani secara profesional, penuh empati, dan bebas dari penghakiman, selaras dengan amanat <strong>Permendikbudristek No. 46 Tahun 2023</strong> tentang Pencegahan dan Penanganan Kekerasan di Lingkungan Satuan Pendidikan.
                    </p>
                </div>

                {{-- 3 Kartu Nilai Utama --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
                    <div class="p-6 rounded-2xl bg-white dark:bg-[#14201A] border border-slate-200 dark:border-slate-800 shadow-xs space-y-2.5 card-hover">
                        <div class="w-10 h-10 rounded-xl bg-primary-100 dark:bg-primary-950/70 text-primary-700 dark:text-[#5AE39D] flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-slate-100">Kerahasiaan Tingkat Tinggi</h3>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                            Opsi menyembunyikan identitas memastikan namamu tidak diketahui oleh teman sebaya maupun pihak yang dilaporkan.
                        </p>
                    </div>

                    <div class="p-6 rounded-2xl bg-white dark:bg-[#14201A] border border-slate-200 dark:border-slate-800 shadow-xs space-y-2.5 card-hover">
                        <div class="w-10 h-10 rounded-xl bg-primary-100 dark:bg-primary-950/70 text-primary-700 dark:text-[#5AE39D] flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-slate-100">Ditangani Langsung Guru BK</h3>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                            Laporan hanya diterima dan diproses langsung oleh Guru Bimbingan dan Konseling berpengalaman di madrasah.
                        </p>
                    </div>

                    <div class="p-6 rounded-2xl bg-white dark:bg-[#14201A] border border-slate-200 dark:border-slate-800 shadow-xs space-y-2.5 card-hover">
                        <div class="w-10 h-10 rounded-xl bg-primary-100 dark:bg-primary-950/70 text-primary-700 dark:text-[#5AE39D] flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-slate-100">Tanpa Rasa Takut & Menghakimi</h3>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                            Setiap siswa berhak atas perlindungan dan rasa damai. Kamu akan disambut dengan empati, bukan tuduhan.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- 3. TATA CARA MENGGUNAKAN (4 LANGKAH BERIKON) --}}
        <section id="tata-cara" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24">
            <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
                <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-primary-700 dark:text-[#5AE39D]">Langkah Mudah</span>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900 dark:text-slate-100">
                    Bagaimana Cara Menggunakan SISPERKA?
                </h2>
                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400">
                    Proses pelaporan dirancang singkat, jelas, dan tidak membebani peserta didik.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Langkah 1 --}}
                <div class="p-6 rounded-2xl bg-white dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 shadow-xs space-y-3 card-hover">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-primary-800 dark:text-primary-300 bg-primary-50 dark:bg-primary-950/60 border border-primary-200 dark:border-primary-800 px-3 py-1 rounded-md">
                            Langkah 01
                        </span>
                        <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-primary-700 dark:text-[#5AE39D] flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                        </div>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-slate-100">Masuk dengan Akun NIS</h3>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        Gunakan Nomor Induk Siswa (NIS) dan kata sandi madrasah yang telah dibagikan untuk masuk ke sistem.
                    </p>
                </div>

                {{-- Langkah 2 --}}
                <div class="p-6 rounded-2xl bg-white dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 shadow-xs space-y-3 card-hover">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-primary-800 dark:text-primary-300 bg-primary-50 dark:bg-primary-950/60 border border-primary-200 dark:border-primary-800 px-3 py-1 rounded-md">
                            Langkah 02
                        </span>
                        <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-primary-700 dark:text-[#5AE39D] flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </div>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-slate-100">Ceritakan Kejadian</h3>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        Tuliskan waktu, tempat, dan apa yang dialami atau disaksikan. Kamu boleh melapor sebagai korban maupun saksi.
                    </p>
                </div>

                {{-- Langkah 3 --}}
                <div class="p-6 rounded-2xl bg-white dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 shadow-xs space-y-3 card-hover">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-primary-800 dark:text-primary-300 bg-primary-50 dark:bg-primary-950/60 border border-primary-200 dark:border-primary-800 px-3 py-1 rounded-md">
                            Langkah 03
                        </span>
                        <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-primary-700 dark:text-[#5AE39D] flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-slate-100">Pilih Opsi Rahasia</h3>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        Centang "Sembunyikan Nama Saya" agar identitasmu tersamarkan sebagai <em>Pelapor Rahasia</em> dari pihak luar.
                    </p>
                </div>

                {{-- Langkah 4 --}}
                <div class="p-6 rounded-2xl bg-white dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 shadow-xs space-y-3 card-hover">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-primary-800 dark:text-primary-300 bg-primary-50 dark:bg-primary-950/60 border border-primary-200 dark:border-primary-800 px-3 py-1 rounded-md">
                            Langkah 04
                        </span>
                        <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-primary-700 dark:text-[#5AE39D] flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-slate-100">Pendampingan Guru BK</h3>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        Pantau perubahan status di website. Guru BK akan menindaklanjuti dan mengundangmu berbincang santai.
                    </p>
                </div>
            </div>
        </section>

        {{-- 4. JAMINAN KERAHASIAAN (BATAS AKSES DATA) --}}
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-[#18241E] dark:bg-[#13211B] rounded-3xl p-8 sm:p-12 text-white space-y-8 border border-slate-800 shadow-sm">
                <div class="max-w-2xl space-y-2">
                    <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-[#B8E34B]">Transparansi & Kejujuran</span>
                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                        Siapa yang Dapat Melihat Laporanmu?
                    </h2>
                    <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                        Kerahasiaan adalah fondasi rasa aman. Berikut adalah batasan akses yang diterapkan secara tegas oleh sistem SISPERKA:
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Guru BK --}}
                    <div class="p-6 rounded-2xl bg-[#1E3027] border border-[#2B4237] space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-primary-600/30 text-[#5AE39D] flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-white">Guru Bimbingan & Konseling</h3>
                                <span class="text-xs font-semibold text-[#5AE39D]">Akses Terbatas Konseling</span>
                            </div>
                        </div>
                        <ul class="space-y-2.5 text-xs sm:text-sm text-slate-200">
                            <li class="flex items-start gap-2">
                                <span class="text-[#5AE39D] font-bold">✓</span>
                                <span>Membaca kronologi, tanggal, dan bukti untuk keperluan penanganan.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#5AE39D] font-bold">✓</span>
                                <span>Nama disamarkan sebagai "Pelapor Rahasia" bila opsi centang diaktifkan.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#5AE39D] font-bold">✓</span>
                                <span>Pembukaan nama hanya bila darurat & wajib tercatat di log audit.</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Master Administrator --}}
                    <div class="p-6 rounded-2xl bg-[#1E3027] border border-[#2B4237] space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-800 text-slate-300 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-white">Master Admin Madrasah</h3>
                                <span class="text-xs font-semibold text-slate-400">Hanya Statistik Angka</span>
                            </div>
                        </div>
                        <ul class="space-y-2.5 text-xs sm:text-sm text-slate-200">
                            <li class="flex items-start gap-2">
                                <span class="text-red-400 font-bold">✕</span>
                                <span><strong>TIDAK BISA</strong> membaca isi cerita atau kronologi kejadian.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-red-400 font-bold">✕</span>
                                <span><strong>TIDAK BISA</strong> melihat nama siswa pelapor maupun terlapor.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#5AE39D] font-bold">✓</span>
                                <span>Hanya mengelola akun login dan melihat grafik statistik aggregate.</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Pihak Luar / Terlapor --}}
                    <div class="p-6 rounded-2xl bg-[#1E3027] border border-[#2B4237] space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-red-950/40 text-red-400 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-white">Pihak Luar / Terlapor</h3>
                                <span class="text-xs font-semibold text-red-400">Tertutup Sepenuhnya</span>
                            </div>
                        </div>
                        <ul class="space-y-2.5 text-xs sm:text-sm text-slate-200">
                            <li class="flex items-start gap-2">
                                <span class="text-red-400 font-bold">✕</span>
                                <span>Sama sekali <strong>TIDAK TAHU</strong> ada laporan yang masuk.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-red-400 font-bold">✕</span>
                                <span>Guru BK tidak akan membocorkan identitas pelapor kepada siapa pun.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#5AE39D] font-bold">✓</span>
                                <span>Perlindungan mutlak terhadap potensi aksi balas dendam.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        {{-- 5. ALUR PENANGANAN LAPORAN --}}
        <section id="alur-penanganan" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24">
            <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
                <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-primary-700 dark:text-[#5AE39D]">Alur Responsif</span>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900 dark:text-slate-100">
                    Alur Penanganan Laporan & Perkiraan Waktu
                </h2>
                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400">
                    Setiap laporan yang masuk ditangani secara terstruktur dan terukur oleh tim BK madrasah.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Alur 1 --}}
                <div class="p-6 rounded-2xl bg-white dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 shadow-xs space-y-3 card-hover">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                        <span class="text-xs font-bold text-primary-800 dark:text-primary-300 uppercase tracking-wider">Tahap 1</span>
                        <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-primary-50 dark:bg-primary-950 text-primary-800 dark:text-primary-300 border border-primary-200 dark:border-primary-800">
                            Maks. 1×24 Jam
                        </span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-slate-100">Verifikasi Awal</h3>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        Guru BK menerima notifikasi di sistem, membaca kronologi, dan memvalidasi keabsahan informasi laporan.
                    </p>
                </div>

                {{-- Alur 2 --}}
                <div class="p-6 rounded-2xl bg-white dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 shadow-xs space-y-3 card-hover">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                        <span class="text-xs font-bold text-primary-800 dark:text-primary-300 uppercase tracking-wider">Tahap 2</span>
                        <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-amber-50 dark:bg-amber-950 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                            1 – 2 Hari Kerja
                        </span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-slate-100">Klarifikasi Tertutup</h3>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        Guru BK mengundang pelapor secara personal dan tenang ke ruang konseling untuk mendengarkan cerita lebih dalam.
                    </p>
                </div>

                {{-- Alur 3 --}}
                <div class="p-6 rounded-2xl bg-white dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 shadow-xs space-y-3 card-hover">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                        <span class="text-xs font-bold text-primary-800 dark:text-primary-300 uppercase tracking-wider">Tahap 3</span>
                        <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-indigo-50 dark:bg-indigo-950 text-indigo-800 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                            Sesuai Kebutuhan
                        </span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-slate-100">Tindakan Solutif & Pemulihan</h3>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        Pendampingan psikologis korban, mediasi damai bila memungkinkan, dan pembinaan edukatif bagi pihak terkait.
                    </p>
                </div>

                {{-- Alur 4 --}}
                <div class="p-6 rounded-2xl bg-white dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 shadow-xs space-y-3 card-hover">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                        <span class="text-xs font-bold text-primary-800 dark:text-primary-300 uppercase tracking-wider">Tahap 4</span>
                        <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                            Berkala
                        </span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-slate-100">Pemantauan Lanjutan</h3>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        Guru BK memantau kondisi siswa pasca-penanganan untuk memastikan rasa aman telah pulih seutuhnya di madrasah.
                    </p>
                </div>
            </div>
        </section>

        {{-- 6. FAQ RINGKAS RAMAH SISWA --}}
        <section id="faq" class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 scroll-mt-24">
            <div class="text-center space-y-2">
                <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-primary-700 dark:text-[#5AE39D]">Tanya Jawab</span>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900 dark:text-slate-100">
                    Pertanyaan yang Sering Diajukan (FAQ)
                </h2>
                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400">
                    Ketahui jawaban atas pertanyaan yang sering diajukan sebelum kamu melapor.
                </p>
            </div>

            <div class="space-y-3.5">
                <details class="group bg-white dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-2xs open:border-primary-600 transition card-hover">
                    <summary class="flex items-center justify-between font-bold text-sm sm:text-base text-slate-900 dark:text-slate-100 cursor-pointer list-none min-h-[44px]">
                        <span>Apakah orang yang merundung akan tahu bahwa aku yang melapor?</span>
                        <span class="transition group-open:rotate-180 text-slate-400 ml-4 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-slate-800 pt-3">
                        Tidak. Guru BK tidak akan pernah memberitahukan siapa pelapornya kepada pihak terlapor. Kamu juga dapat memilih opsi <strong>"Sembunyikan Nama"</strong> saat mengisi form agar namamu tertutup sebagai "Pelapor Rahasia" di daftar umum penanganan.
                    </p>
                </details>

                <details class="group bg-white dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-2xs open:border-primary-600 transition card-hover">
                    <summary class="flex items-center justify-between font-bold text-sm sm:text-base text-slate-900 dark:text-slate-100 cursor-pointer list-none min-h-[44px]">
                        <span>Bagaimana kalau aku bukan korban, tapi hanya melihat temanku dirundung?</span>
                        <span class="transition group-open:rotate-180 text-slate-400 ml-4 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-slate-800 pt-3">
                        Kamu sangat dianjurkan melapor sebagai <strong>Saksi</strong>. Membela teman yang membutuhkan pertolongan adalah perbuatan mulia yang sangat dihargai dan dilindungi oleh madrasah.
                    </p>
                </details>

                <details class="group bg-white dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-2xs open:border-primary-600 transition card-hover">
                    <summary class="flex items-center justify-between font-bold text-sm sm:text-base text-slate-900 dark:text-slate-100 cursor-pointer list-none min-h-[44px]">
                        <span>Apakah aku akan dimarahi oleh guru atau orang tua bila melapor?</span>
                        <span class="transition group-open:rotate-180 text-slate-400 ml-4 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-slate-800 pt-3">
                        Sama sekali tidak. Guru BK hadir untuk mendampingi, mengayomi, dan mencarikan solusi terbaik bagimu. Menyampaikan perundungan adalah hak setiap anak dan madrasah berkomitmen penuh melindungimu.
                    </p>
                </details>

                <details class="group bg-white dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-2xs open:border-primary-600 transition card-hover">
                    <summary class="flex items-center justify-between font-bold text-sm sm:text-base text-slate-900 dark:text-slate-100 cursor-pointer list-none min-h-[44px]">
                        <span>Bagaimana jika akun NIS atau kata sandi saya bermasalah?</span>
                        <span class="transition group-open:rotate-180 text-slate-400 ml-4 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-slate-800 pt-3">
                        Kamu dapat langsung mendatangi Ruang BK atau meminta bantuan wali kelas untuk melakukan reset kata sandi akunmu melalui staf Master Administrator madrasah.
                    </p>
                </details>
            </div>
        </section>

        {{-- 7. CALL TO ACTION PENUTUP --}}
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-primary-700 via-primary-600 to-primary-800 rounded-3xl p-8 sm:p-12 text-white text-center space-y-6 shadow-md border border-primary-800">
                <div class="max-w-xl mx-auto space-y-3">
                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight">
                        Kamu Berharga. Suaramu Berarti.
                    </h2>
                    <p class="text-sm sm:text-base text-emerald-100 leading-relaxed">
                        Jangan memendam rasa takut atau sedih sendirian. Ruang Bimbingan & Konseling MTs Soebono Mantofani siap mendengar dan membantumu setiap saat.
                    </p>
                </div>

                <div class="pt-2">
                    <a href="{{ route('login') }}" class="min-h-[44px] inline-flex items-center justify-center gap-2 px-8 py-3.5 text-base font-bold text-primary-800 bg-white hover:bg-emerald-50 rounded-xl shadow-md transition duration-150 card-hover focus:outline-none focus:ring-2 focus:ring-white">
                        Masuk ke SISPERKA Sekarang
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-layouts.public>
