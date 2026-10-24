<x-layouts.public title="SISPERKA - Ruang Aman Pelaporan Perundungan MTs Soebono Mantofani">
    <div class="space-y-16 sm:space-y-24 animate-fade-in pb-16">
        {{-- ===================================================
            1. HERO SECTION (Sesuai Desain frontend/src/app/page.tsx)
            =================================================== --}}
        <section class="relative overflow-hidden pt-10 pb-16 sm:pt-14 sm:pb-20 lg:pt-16 lg:pb-24 bg-[#EDECEA] dark:bg-[#0E1713] border-b border-slate-300 dark:border-slate-800 -mt-px">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-10 items-center">
                    {{-- Hero Copy --}}
                    <div class="flex flex-col items-start text-left max-w-2xl animate-slide-up">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-primary-100/90 dark:bg-primary-950/70 text-primary-800 dark:text-primary-300 text-xs font-bold mb-5 border border-primary-300/80 dark:border-primary-800/80 shadow-2xs">
                            <span class="w-2 h-2 rounded-full bg-primary-600 dark:bg-[#5AE39D]"></span>
                            <span>Ruang Konseling Digital Siswa & Guru BK</span>
                        </div>

                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 dark:text-slate-100 tracking-tight leading-[1.14] mb-5">
                            Berani Bersuara, <br class="hidden sm:inline" />
                            <span class="text-primary-600 dark:text-[#5AE39D] underline decoration-[#B8E34B] decoration-4 underline-offset-8">
                                Ciptakan Sekolah Bebas Perundungan.
                            </span>
                        </h1>

                        <p class="text-base sm:text-lg text-slate-700 dark:text-slate-300 leading-relaxed mb-6 max-w-xl font-normal">
                            <span class="font-semibold text-slate-900 dark:text-slate-100">{{ \App\Models\Setting::get('hero_title', 'Kamu tidak sendirian. Ceritakan di sini, dengan aman.') }}</span>
                            {{ \App\Models\Setting::get('hero_subtitle', 'SIPERKA adalah Sistem Informasi Pelaporan Kasus Perundungan yang menghubungkan siswa langsung dengan Guru BK secara aman, rahasia, dan terstruktur. Suaramu dilindungi dan didengar tanpa rasa takut.') }}
                        </p>

                        <div class="flex flex-wrap gap-2.5 mb-8">
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-200 shadow-2xs">
                                <svg class="w-3.5 h-3.5 text-primary-600 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <span>Opsi 100% Anonim</span>
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-200 shadow-2xs">
                                <svg class="w-3.5 h-3.5 text-[#8C6708] dark:text-[#FAD46B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Respon Cepat Guru BK</span>
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-200 shadow-2xs">
                                <svg class="w-3.5 h-3.5 text-[#3F570E] dark:text-[#D2F365]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <span>Pendampingan Objektif</span>
                            </span>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="min-h-[44px] inline-flex items-center justify-center gap-2.5 px-7 py-3 text-base font-bold text-white bg-primary-600 hover:bg-primary-700 active:bg-primary-800 rounded-xl shadow-xs transition duration-150 card-hover focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2">
                                    <span>Buka Dashboard Saya</span>
                                    <svg class="w-4 h-4 text-[#B8E34B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="min-h-[44px] inline-flex items-center justify-center gap-2.5 px-7 py-3 text-base font-bold text-white bg-primary-600 hover:bg-primary-700 active:bg-primary-800 rounded-xl shadow-xs transition duration-150 card-hover focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2">
                                    <span>Mulai Menggunakan SIPERKA</span>
                                    <svg class="w-4 h-4 text-[#B8E34B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            @endauth

                            <a href="#cara-kerja" class="min-h-[44px] inline-flex items-center justify-center px-7 py-3 text-base font-semibold text-slate-700 dark:text-slate-200 bg-white dark:bg-[#16231D] hover:bg-slate-50 dark:hover:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl transition duration-150 card-hover focus:outline-none focus:ring-2 focus:ring-slate-400">
                                Pelajari Cara Kerja
                            </a>
                        </div>
                    </div>

                    {{-- Character Illustration (Sesuai frontend ReportingIllustration) --}}
                    <div class="relative flex items-center justify-center min-h-[360px] lg:min-h-[460px] animate-slide-up stagger-1">
                        {{-- Background shape --}}
                        <div class="absolute w-[300px] h-[300px] sm:w-[400px] sm:h-[400px] rounded-full bg-primary-100/70 dark:bg-primary-950/40 border border-primary-200/60 dark:border-primary-800/40"></div>

                        {{-- Decorative accents --}}
                        <div class="absolute top-8 right-6 w-3.5 h-3.5 rounded-full bg-[#B8E34B] shadow-xs"></div>
                        <div class="absolute bottom-12 left-6 w-3 h-3 rounded-full bg-[#F2C94C] shadow-xs"></div>
                        <div class="absolute top-20 left-4 w-4 h-4 rounded-full border-2 border-primary-400/80"></div>

                        {{-- Gambar Hero SIPERKA --}}
                        <div class="relative z-10 w-full max-w-[480px]">
                            <img src="{{ asset('images/siperka-hero-v3.png') }}" 
                                 alt="Siswa melaporkan perundungan kepada Guru BK melalui SIPERKA" 
                                 class="w-full h-auto object-contain drop-shadow-md rounded-2xl" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===================================================
            2. APA ITU SIPERKA (Sesuai Desain frontend #tentang)
            =================================================== --}}
        <section id="tentang" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24 text-center">
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-primary-50 dark:bg-primary-950/40 text-primary-700 dark:text-primary-300 border border-primary-200/60 dark:border-primary-800 text-xs font-bold mb-4">
                TENTANG SISTEM
            </span>

            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white mb-4 tracking-tight">
                Apa itu SIPERKA?
            </h2>

            <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 max-w-3xl mx-auto mb-14 leading-relaxed">
                {{ \App\Models\Setting::get('about_text', 'SIPERKA adalah sistem informasi berbasis web yang membantu siswa menyampaikan laporan terkait perundungan secara lebih terstruktur serta membantu Guru BK dalam mengelola, memverifikasi, memantau, dan mencatat tindak lanjut laporan.') }}
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                {{-- Langkah 1 --}}
                <div class="flex flex-col items-center text-center p-7 rounded-2xl border transition-all hover:-translate-y-1 hover:shadow-sm bg-[#f0f7f3] dark:bg-[#12231b] border-emerald-200/80 dark:border-emerald-800">
                    <div class="w-13 h-13 rounded-xl bg-white dark:bg-slate-800 shadow-2xs border border-slate-200/90 dark:border-slate-700 flex items-center justify-center mb-4 p-3">
                        <svg class="w-6 h-6 text-[#176B4D] dark:text-[#86efac]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    </div>
                    <span class="text-[11px] font-bold uppercase tracking-wider mb-1 text-[#176B4D] dark:text-[#86efac]">
                        Langkah 1
                    </span>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-2">
                        Sampaikan
                    </h3>
                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                        Laporkan kejadian yang kamu alami atau saksikan dengan aman dan terlindungi.
                    </p>
                </div>

                {{-- Langkah 2 --}}
                <div class="flex flex-col items-center text-center p-7 rounded-2xl border transition-all hover:-translate-y-1 hover:shadow-sm bg-[#fef9eb] dark:bg-[#261f0a] border-amber-200/80 dark:border-amber-800">
                    <div class="w-13 h-13 rounded-xl bg-white dark:bg-slate-800 shadow-2xs border border-slate-200/90 dark:border-slate-700 flex items-center justify-center mb-4 p-3">
                        <svg class="w-6 h-6 text-[#966b09] dark:text-[#fde68a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <span class="text-[11px] font-bold uppercase tracking-wider mb-1 text-[#8c6708] dark:text-[#fde68a]">
                        Langkah 2
                    </span>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-2">
                        Pantau
                    </h3>
                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                        Lihat perkembangan laporan secara transparan melalui nomor tiket unik.
                    </p>
                </div>

                {{-- Langkah 3 --}}
                <div class="flex flex-col items-center text-center p-7 rounded-2xl border transition-all hover:-translate-y-1 hover:shadow-sm bg-[#f7faeb] dark:bg-[#1a230c] border-lime-200/80 dark:border-lime-900/40">
                    <div class="w-13 h-13 rounded-xl bg-white dark:bg-slate-800 shadow-2xs border border-slate-200/90 dark:border-slate-700 flex items-center justify-center mb-4 p-3">
                        <svg class="w-6 h-6 text-[#4d6614] dark:text-[#c4e84a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-[11px] font-bold uppercase tracking-wider mb-1 text-[#4d6614] dark:text-[#c4e84a]">
                        Langkah 3
                    </span>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-2">
                        Tindak Lanjut
                    </h3>
                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                        Guru BK mendampingi dan mencatat proses penanganan sampai tuntas.
                    </p>
                </div>
            </div>
        </section>

        {{-- ===================================================
            3. CARA MENGGUNAKAN SIPERKA DENGAN 6 PHONE MOCKUPS (Sesuai frontend #cara-kerja)
            =================================================== --}}
        <section id="cara-kerja" class="py-16 sm:py-20 lg:py-24 bg-[#F8FAF9] dark:bg-[#0E1713] border-y border-slate-300 dark:border-slate-800 scroll-mt-20">
            <div id="tata-cara" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24">
                {{-- Heading --}}
                <div class="text-center max-w-2xl mx-auto mb-14">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-primary-100 dark:bg-primary-950/60 text-primary-800 dark:text-primary-300 border border-primary-200/80 dark:border-primary-800 text-xs font-bold mb-4">
                        PANDUAN ALUR
                    </span>

                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                        Bagaimana Cara Menggunakan SISPERKA?
                    </h2>

                    <p class="mt-4 text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed">
                        Enam langkah sederhana untuk menyampaikan laporan dan memantau proses penanganannya secara terstruktur.
                    </p>
                </div>

                {{-- 6 Phone Mockups Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-10 gap-y-16 items-start">
                    {{-- ── Step 01: Masuk ke SIPERKA ── --}}
                    <div class="text-center">
                        <div class="flex justify-center mb-5">
                            <div class="relative">
                                {{-- Phone Frame --}}
                                <div class="relative w-[215px] sm:w-[225px] lg:w-[230px] mx-auto select-none">
                                    <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-[160px] h-6 rounded-full bg-black/15 dark:bg-black/40 blur-lg pointer-events-none"></div>
                                    <div class="relative rounded-[2.8rem] bg-[#141A17] p-[5px] shadow-[0_16px_40px_rgba(20,26,23,0.35)] border border-[#2C3831]">
                                        <div class="absolute -left-[4px] top-24 w-[3.5px] h-8 rounded-l-md bg-[#2C3831]"></div>
                                        <div class="absolute -left-[4px] top-36 w-[3.5px] h-12 rounded-l-md bg-[#2C3831]"></div>
                                        <div class="absolute -right-[4px] top-32 w-[3.5px] h-16 rounded-r-md bg-[#2C3831]"></div>

                                        {{-- Screen Content --}}
                                        <div class="relative overflow-hidden rounded-[2.5rem] bg-[#F8FAF9] aspect-[9/19.2] flex flex-col">
                                            <div class="absolute z-50 top-[9px] left-1/2 -translate-x-1/2 pointer-events-none">
                                                <div class="w-[68px] h-[19px] rounded-full bg-black flex items-center justify-end pr-2">
                                                    <div class="w-[4.5px] h-[4.5px] rounded-full bg-[#1F2C24]"></div>
                                                </div>
                                            </div>
                                            <div class="h-9 shrink-0 z-40 flex items-center justify-between px-5 pt-2 text-[8.5px] font-semibold text-slate-800">
                                                <span>08:24</span>
                                                <div class="flex items-center gap-1 text-[7px]"><span>LTE</span><span>100%</span></div>
                                            </div>

                                            <div class="flex-1 flex flex-col justify-center bg-[#EDECEA] px-3.5 pb-3 text-center">
                                                <div class="flex justify-center mb-1">
                                                    <div class="w-8 h-8 rounded-xl bg-white border border-slate-300 flex items-center justify-center shadow-xs p-1">
                                                        <img src="{{ asset('images/logo-sekolah.png') }}" alt="Logo" class="w-full h-full object-contain" />
                                                    </div>
                                                </div>
                                                <p class="text-[10px] font-black text-slate-900 tracking-tight leading-tight">SIPERKA</p>
                                                <p class="text-[5px] font-bold text-slate-500 uppercase tracking-widest mt-0.5">Sistem Pelaporan Sekolah</p>

                                                <div class="mt-2 bg-white border border-slate-200/90 rounded-2xl p-2.5 text-left shadow-xs">
                                                    <p class="text-[7.5px] font-extrabold text-slate-900 leading-tight">Masuk ke Akun</p>
                                                    <p class="text-[5px] text-slate-500 mt-0.5 leading-tight">Gunakan identitas resmi terdaftar.</p>

                                                    <label class="block text-[5px] font-bold text-slate-700 mt-2">ID Pengguna (NIS / NIP)</label>
                                                    <div class="h-6 mt-0.5 border border-slate-200 rounded-lg px-2 flex items-center bg-slate-50/80">
                                                        <span class="text-[5.5px] text-slate-600">12345 (NIS Siswa)</span>
                                                    </div>

                                                    <label class="block text-[5px] font-bold text-slate-700 mt-1.5">Kata Sandi</label>
                                                    <div class="h-6 mt-0.5 border border-slate-200 rounded-lg px-2 flex items-center justify-between bg-slate-50/80">
                                                        <span class="text-[5.5px] text-slate-400">••••••••</span>
                                                        <span class="text-[6px] text-slate-400">👁</span>
                                                    </div>

                                                    <div class="w-full h-6.5 mt-2.5 rounded-xl bg-primary-600 flex items-center justify-center text-white text-[6.5px] font-bold shadow-xs">
                                                        Masuk Sekarang
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute -top-3 -left-3 w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-xs font-bold shadow-md ring-2 ring-white dark:ring-slate-900 font-mono">
                                    01
                                </div>
                            </div>
                        </div>

                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                            Masuk dengan Akun NIS
                        </h3>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400 max-w-xs mx-auto leading-relaxed">
                            Login menggunakan akun terdaftar madrasah untuk mengakses seluruh layanan perlindungan.
                        </p>
                    </div>

                    {{-- ── Step 02: Buka Dashboard ── --}}
                    <div class="text-center">
                        <div class="flex justify-center mb-5">
                            <div class="relative">
                                {{-- Phone Frame --}}
                                <div class="relative w-[215px] sm:w-[225px] lg:w-[230px] mx-auto select-none">
                                    <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-[160px] h-6 rounded-full bg-black/15 dark:bg-black/40 blur-lg pointer-events-none"></div>
                                    <div class="relative rounded-[2.8rem] bg-[#141A17] p-[5px] shadow-[0_16px_40px_rgba(20,26,23,0.35)] border border-[#2C3831]">
                                        <div class="absolute -left-[4px] top-24 w-[3.5px] h-8 rounded-l-md bg-[#2C3831]"></div>
                                        <div class="absolute -left-[4px] top-36 w-[3.5px] h-12 rounded-l-md bg-[#2C3831]"></div>
                                        <div class="absolute -right-[4px] top-32 w-[3.5px] h-16 rounded-r-md bg-[#2C3831]"></div>

                                        {{-- Screen Content --}}
                                        <div class="relative overflow-hidden rounded-[2.5rem] bg-[#F8FAF9] aspect-[9/19.2] flex flex-col text-left">
                                            <div class="absolute z-50 top-[9px] left-1/2 -translate-x-1/2 pointer-events-none">
                                                <div class="w-[68px] h-[19px] rounded-full bg-black flex items-center justify-end pr-2">
                                                    <div class="w-[4.5px] h-[4.5px] rounded-full bg-[#1F2C24]"></div>
                                                </div>
                                            </div>
                                            <div class="h-9 shrink-0 z-40 flex items-center justify-between px-5 pt-2 text-[8.5px] font-semibold text-slate-800">
                                                <span>08:24</span>
                                                <div class="flex items-center gap-1 text-[7px]"><span>LTE</span><span>100%</span></div>
                                            </div>

                                            {{-- App Header --}}
                                            <div class="h-[36px] shrink-0 bg-white border-b border-slate-200/90 flex items-center justify-between px-3">
                                                <div class="flex items-center gap-1.5">
                                                    <img src="{{ asset('images/logo-sekolah.png') }}" alt="Logo" class="w-4 h-4 object-contain" />
                                                    <div>
                                                        <p class="text-[7.5px] font-black text-slate-900 leading-tight">SIPERKA</p>
                                                        <p class="text-[4.5px] text-slate-400 leading-tight">Ruang Aman Siswa</p>
                                                    </div>
                                                </div>
                                                <div class="w-5 h-5 rounded-full bg-primary-600 text-white text-[6px] font-bold flex items-center justify-center">
                                                    AF
                                                </div>
                                            </div>

                                            {{-- Main Content --}}
                                            <div class="flex-1 overflow-hidden px-3 pt-2 flex flex-col gap-2">
                                                {{-- Greeting Banner --}}
                                                <div class="bg-gradient-to-br from-[#EAF5EE] to-[#F0EFE8] border border-primary-200/70 rounded-xl p-2.5">
                                                    <div class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full bg-white/90 text-primary-800 text-[4.5px] font-bold">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-primary-600"></span>
                                                        Ruang Aman Siswa
                                                    </div>
                                                    <p class="text-[8.5px] font-black text-slate-900 mt-1 leading-tight">Halo, Ahmad Fauzi 👋</p>
                                                    <p class="text-[5px] text-slate-600 leading-tight mt-0.5">Suaramu sangat berarti untuk sekolah aman.</p>

                                                    <div class="mt-2 bg-primary-600 rounded-lg p-1.5 text-white flex items-center justify-between shadow-2xs">
                                                        <div class="flex items-center gap-1.5">
                                                            <div class="w-5 h-5 rounded-md bg-[#B8E34B] text-[#176B4D] flex items-center justify-center font-bold text-[7px]">
                                                                +
                                                            </div>
                                                            <div>
                                                                <p class="text-[6.5px] font-extrabold leading-tight">Buat Laporan Baru</p>
                                                                <p class="text-[4.5px] text-emerald-100">Bisa opsi anonim</p>
                                                            </div>
                                                        </div>
                                                        <span class="text-emerald-200 text-[8px]">›</span>
                                                    </div>
                                                </div>

                                                {{-- KPI Metrics --}}
                                                <div class="grid grid-cols-3 gap-1.5">
                                                    <div class="bg-white border border-slate-200 rounded-lg p-1.5 text-center shadow-2xs">
                                                        <p class="text-[9px] font-black text-primary-700">4</p>
                                                        <p class="text-[4.5px] text-slate-500 font-semibold">Total</p>
                                                    </div>
                                                    <div class="bg-white border border-slate-200 rounded-lg p-1.5 text-center shadow-2xs">
                                                        <p class="text-[9px] font-black text-amber-600">2</p>
                                                        <p class="text-[4.5px] text-slate-500 font-semibold">Diproses</p>
                                                    </div>
                                                    <div class="bg-white border border-slate-200 rounded-lg p-1.5 text-center shadow-2xs">
                                                        <p class="text-[9px] font-black text-emerald-600">1</p>
                                                        <p class="text-[4.5px] text-slate-500 font-semibold">Selesai</p>
                                                    </div>
                                                </div>

                                                {{-- Recent Report --}}
                                                <div class="bg-white border border-slate-200 rounded-xl p-2 shadow-2xs">
                                                    <div class="flex items-center justify-between mb-1">
                                                        <span class="text-[5px] font-bold text-slate-400 uppercase tracking-wider">Laporan Terkini</span>
                                                        <span class="text-[4.5px] font-semibold text-primary-600">Lihat Semua</span>
                                                    </div>
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <p class="text-[6.5px] font-extrabold text-slate-900 leading-tight">Perundungan Verbal</p>
                                                            <p class="text-[5px] font-mono text-slate-500 mt-0.5">SPK-2026-001</p>
                                                        </div>
                                                        <span class="text-[4.5px] font-bold text-primary-700 bg-primary-50 border border-primary-200 px-1.5 py-0.5 rounded-full">
                                                            Diverifikasi
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Bottom Nav --}}
                                            <div class="h-[34px] shrink-0 bg-white border-t border-slate-200 flex items-center justify-around text-center">
                                                <div class="text-primary-600 text-[5px] font-bold">🏠 Beranda</div>
                                                <div class="text-slate-400 text-[5px]">📄 Laporan</div>
                                                <div class="text-slate-400 text-[5px]">👤 Profil</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute -top-3 -left-3 w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-xs font-bold shadow-md ring-2 ring-white dark:ring-slate-900 font-mono">
                                    02
                                </div>
                            </div>
                        </div>

                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                            Buka Dashboard
                        </h3>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400 max-w-xs mx-auto leading-relaxed">
                            Pilih menu Buat Laporan untuk mulai menyampaikan kejadian yang dialami dengan mudah.
                        </p>
                    </div>

                    {{-- ── Step 03: Ceritakan Kejadian (Buat Laporan) ── --}}
                    <div class="text-center">
                        <div class="flex justify-center mb-5">
                            <div class="relative">
                                {{-- Phone Frame --}}
                                <div class="relative w-[215px] sm:w-[225px] lg:w-[230px] mx-auto select-none">
                                    <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-[160px] h-6 rounded-full bg-black/15 dark:bg-black/40 blur-lg pointer-events-none"></div>
                                    <div class="relative rounded-[2.8rem] bg-[#141A17] p-[5px] shadow-[0_16px_40px_rgba(20,26,23,0.35)] border border-[#2C3831]">
                                        <div class="absolute -left-[4px] top-24 w-[3.5px] h-8 rounded-l-md bg-[#2C3831]"></div>
                                        <div class="absolute -left-[4px] top-36 w-[3.5px] h-12 rounded-l-md bg-[#2C3831]"></div>
                                        <div class="absolute -right-[4px] top-32 w-[3.5px] h-16 rounded-r-md bg-[#2C3831]"></div>

                                        {{-- Screen Content --}}
                                        <div class="relative overflow-hidden rounded-[2.5rem] bg-[#F8FAF9] aspect-[9/19.2] flex flex-col text-left">
                                            <div class="absolute z-50 top-[9px] left-1/2 -translate-x-1/2 pointer-events-none">
                                                <div class="w-[68px] h-[19px] rounded-full bg-black flex items-center justify-end pr-2">
                                                    <div class="w-[4.5px] h-[4.5px] rounded-full bg-[#1F2C24]"></div>
                                                </div>
                                            </div>
                                            <div class="h-9 shrink-0 z-40 flex items-center justify-between px-5 pt-2 text-[8.5px] font-semibold text-slate-800">
                                                <span>08:24</span>
                                                <div class="flex items-center gap-1 text-[7px]"><span>LTE</span><span>100%</span></div>
                                            </div>

                                            <div class="h-[36px] shrink-0 bg-white border-b border-slate-200 px-3 flex items-center justify-between">
                                                <span class="text-[7.5px] font-bold text-slate-900">← Buat Laporan</span>
                                                <span class="text-[5px] font-bold text-primary-700 bg-primary-50 border border-primary-200 px-1.5 py-0.5 rounded-full">Langkah 1/2</span>
                                            </div>

                                            <div class="flex-1 overflow-hidden px-3 pt-2 flex flex-col gap-1.5">
                                                <div>
                                                    <span class="text-[5px] font-bold text-slate-700">Kategori Perundungan</span>
                                                    <div class="h-5.5 mt-0.5 bg-white border border-slate-200 rounded-md px-1.5 flex items-center justify-between text-[5.5px] text-slate-800 font-medium">
                                                        <span>Perundungan Verbal</span>
                                                        <span class="text-slate-400 text-[6px]">⌄</span>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-2 gap-1.5">
                                                    <div>
                                                        <span class="text-[5px] font-bold text-slate-700">Tanggal</span>
                                                        <div class="h-5.5 mt-0.5 bg-white border border-slate-200 rounded-md px-1.5 flex items-center gap-1 text-[5px] text-slate-700">
                                                            <span>📅 12 Sep 2026</span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <span class="text-[5px] font-bold text-slate-700">Lokasi</span>
                                                        <div class="h-5.5 mt-0.5 bg-white border border-slate-200 rounded-md px-1.5 flex items-center gap-1 text-[5px] text-slate-700">
                                                            <span>📍 Lapangan</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="flex justify-between text-[5px] font-bold text-slate-700">
                                                        <span>Kronologi Kejadian</span>
                                                        <span class="text-slate-400 font-normal">184/1000</span>
                                                    </div>
                                                    <div class="h-12 mt-0.5 bg-white border border-slate-200 rounded-md p-1.5 text-[5px] text-slate-700 leading-tight">
                                                        Teman sekelas sering mengejek nama dan memanggil sebutan tidak pantas...
                                                    </div>
                                                </div>

                                                <div>
                                                    <span class="text-[5px] font-bold text-slate-700">Pihak Terlibat (Opsional)</span>
                                                    <div class="h-5 mt-0.5 bg-white border border-slate-200 rounded-md px-1.5 flex items-center text-[5px] text-slate-400">
                                                        Siswa kelas 8-B
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="h-[36px] shrink-0 bg-white border-t border-slate-200 px-3 flex items-center gap-1.5">
                                                <div class="flex-1 h-6 rounded-lg border border-slate-200 text-[5px] font-bold text-slate-600 flex items-center justify-center">Batal</div>
                                                <div class="flex-1 h-6 rounded-lg bg-primary-600 text-[5px] font-bold text-white flex items-center justify-center shadow-xs">Lanjutkan →</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute -top-3 -left-3 w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-xs font-bold shadow-md ring-2 ring-white dark:ring-slate-900 font-mono">
                                    03
                                </div>
                            </div>
                        </div>

                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                            Ceritakan Kejadian
                        </h3>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400 max-w-xs mx-auto leading-relaxed">
                            Ceritakan kronologi, tentukan kategori, dan lengkapi rincian kejadian dengan jujur dan tenang.
                        </p>
                    </div>

                    {{-- ── Step 04: Periksa Detail & Opsi Rahasia ── --}}
                    <div class="text-center">
                        <div class="flex justify-center mb-5">
                            <div class="relative">
                                {{-- Phone Frame --}}
                                <div class="relative w-[215px] sm:w-[225px] lg:w-[230px] mx-auto select-none">
                                    <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-[160px] h-6 rounded-full bg-black/15 dark:bg-black/40 blur-lg pointer-events-none"></div>
                                    <div class="relative rounded-[2.8rem] bg-[#141A17] p-[5px] shadow-[0_16px_40px_rgba(20,26,23,0.35)] border border-[#2C3831]">
                                        <div class="absolute -left-[4px] top-24 w-[3.5px] h-8 rounded-l-md bg-[#2C3831]"></div>
                                        <div class="absolute -left-[4px] top-36 w-[3.5px] h-12 rounded-l-md bg-[#2C3831]"></div>
                                        <div class="absolute -right-[4px] top-32 w-[3.5px] h-16 rounded-r-md bg-[#2C3831]"></div>

                                        {{-- Screen Content --}}
                                        <div class="relative overflow-hidden rounded-[2.5rem] bg-[#F8FAF9] aspect-[9/19.2] flex flex-col text-left">
                                            <div class="absolute z-50 top-[9px] left-1/2 -translate-x-1/2 pointer-events-none">
                                                <div class="w-[68px] h-[19px] rounded-full bg-black flex items-center justify-end pr-2">
                                                    <div class="w-[4.5px] h-[4.5px] rounded-full bg-[#1F2C24]"></div>
                                                </div>
                                            </div>
                                            <div class="h-9 shrink-0 z-40 flex items-center justify-between px-5 pt-2 text-[8.5px] font-semibold text-slate-800">
                                                <span>08:24</span>
                                                <div class="flex items-center gap-1 text-[7px]"><span>LTE</span><span>100%</span></div>
                                            </div>

                                            <div class="h-[36px] shrink-0 bg-white border-b border-slate-200 px-3 flex items-center justify-between">
                                                <span class="text-[7.5px] font-bold text-slate-900">← Ringkasan Laporan</span>
                                                <span class="text-[5px] font-bold text-primary-700 bg-primary-50 border border-primary-200 px-1.5 py-0.5 rounded-full">Langkah 2/2</span>
                                            </div>

                                            <div class="flex-1 overflow-hidden px-3 pt-2 flex flex-col gap-2">
                                                <div class="bg-white border border-slate-200 rounded-xl p-2 shadow-2xs">
                                                    <p class="text-[6.5px] font-extrabold text-slate-900 leading-tight">Ringkasan Detail Kasus</p>
                                                    <p class="text-[4.5px] text-slate-500 mb-1.5">Pastikan detail sudah sesuai sebelum dikirim.</p>

                                                    <div class="bg-slate-50 border border-slate-200/80 rounded-lg divide-y divide-slate-200/60 text-[5px]">
                                                        <div class="p-1 flex justify-between"><span class="text-slate-500">Kategori:</span><span class="font-bold text-slate-800">Perundungan Verbal</span></div>
                                                        <div class="p-1 flex justify-between"><span class="text-slate-500">Tanggal:</span><span class="font-semibold text-slate-800">12 Sep 2026</span></div>
                                                        <div class="p-1 flex justify-between"><span class="text-slate-500">Lokasi:</span><span class="font-semibold text-slate-800">Lapangan Olahraga</span></div>
                                                    </div>
                                                </div>

                                                {{-- Privacy Option Card --}}
                                                <div class="bg-primary-50/70 border border-primary-200/80 rounded-xl p-2 shadow-2xs">
                                                    <div class="flex items-center gap-1.5 mb-1">
                                                        <span class="text-[6px]">🔒</span>
                                                        <span class="text-[5.5px] font-bold text-primary-900">Opsi Privasi Pelapor</span>
                                                    </div>
                                                    <div class="bg-white rounded-lg p-1.5 border border-primary-200 flex items-start gap-1.5">
                                                        <div class="w-2.5 h-2.5 rounded-full bg-primary-600 text-white flex items-center justify-center text-[4px] font-bold shrink-0 mt-0.5">✓</div>
                                                        <div>
                                                            <p class="text-[5px] font-bold text-slate-900">Sembunyikan Identitas (Anonim)</p>
                                                            <p class="text-[4px] text-slate-500 leading-tight mt-0.5">Identitasmu dirahasiakan dan hanya ditangani Guru BK.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="h-[36px] shrink-0 bg-white border-t border-slate-200 px-3 flex items-center gap-1.5">
                                                <div class="flex-1 h-6 rounded-lg border border-slate-200 text-[5px] font-bold text-slate-600 flex items-center justify-center">Kembali</div>
                                                <div class="flex-1 h-6 rounded-lg bg-primary-600 text-[5px] font-bold text-white flex items-center justify-center shadow-xs">Kirim Laporan</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute -top-3 -left-3 w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-xs font-bold shadow-md ring-2 ring-white dark:ring-slate-900 font-mono">
                                    04
                                </div>
                            </div>
                        </div>

                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                            Pilih Opsi Rahasia
                        </h3>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400 max-w-xs mx-auto leading-relaxed">
                            Tinjau kembali ringkasan laporan serta aktifkan opsi anonim untuk jaminan kerahasiaan penuh.
                        </p>
                    </div>

                    {{-- ── Step 05: Laporan Dikirim ── --}}
                    <div class="text-center">
                        <div class="flex justify-center mb-5">
                            <div class="relative">
                                {{-- Phone Frame --}}
                                <div class="relative w-[215px] sm:w-[225px] lg:w-[230px] mx-auto select-none">
                                    <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-[160px] h-6 rounded-full bg-black/15 dark:bg-black/40 blur-lg pointer-events-none"></div>
                                    <div class="relative rounded-[2.8rem] bg-[#141A17] p-[5px] shadow-[0_16px_40px_rgba(20,26,23,0.35)] border border-[#2C3831]">
                                        <div class="absolute -left-[4px] top-24 w-[3.5px] h-8 rounded-l-md bg-[#2C3831]"></div>
                                        <div class="absolute -left-[4px] top-36 w-[3.5px] h-12 rounded-l-md bg-[#2C3831]"></div>
                                        <div class="absolute -right-[4px] top-32 w-[3.5px] h-16 rounded-r-md bg-[#2C3831]"></div>

                                        {{-- Screen Content --}}
                                        <div class="relative overflow-hidden rounded-[2.5rem] bg-[#F8FAF9] aspect-[9/19.2] flex flex-col text-center px-3.5 justify-center">
                                            <div class="absolute z-50 top-[9px] left-1/2 -translate-x-1/2 pointer-events-none">
                                                <div class="w-[68px] h-[19px] rounded-full bg-black flex items-center justify-end pr-2">
                                                    <div class="w-[4.5px] h-[4.5px] rounded-full bg-[#1F2C24]"></div>
                                                </div>
                                            </div>
                                            <div class="h-9 shrink-0 z-40 flex items-center justify-between px-5 pt-2 text-[8.5px] font-semibold text-slate-800">
                                                <span>08:24</span>
                                                <div class="flex items-center gap-1 text-[7px]"><span>LTE</span><span>100%</span></div>
                                            </div>

                                            <div class="w-10 h-10 mx-auto rounded-full bg-primary-100 border-2 border-primary-200 text-primary-600 flex items-center justify-center shadow-xs">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            </div>

                                            <p class="text-[9px] font-black text-slate-900 mt-2">Laporan Berhasil Dikirim!</p>
                                            <p class="text-[5px] text-slate-500 mt-0.5 leading-tight max-w-[150px] mx-auto">
                                                Laporanmu telah diterima sistem dan segera ditindaklanjuti Guru BK.
                                            </p>

                                            <div class="mt-2.5 bg-white border border-slate-200 rounded-xl px-3 py-2 w-full max-w-[150px] mx-auto shadow-2xs text-center">
                                                <p class="text-[4.5px] font-bold text-slate-400 uppercase tracking-wider">Nomor Registrasi Laporan</p>
                                                <p class="text-[8px] font-extrabold font-mono text-primary-700 tracking-wider mt-0.5">SPK-2026-004</p>
                                                <p class="text-[4px] text-slate-400 mt-0.5">Simpan nomor ini untuk memantau status</p>
                                            </div>

                                            <div class="mt-2.5 w-full max-w-[150px] mx-auto h-6 rounded-lg bg-primary-600 text-white text-[5.5px] font-bold flex items-center justify-center shadow-xs">
                                                Pantau Status Laporan →
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute -top-3 -left-3 w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-xs font-bold shadow-md ring-2 ring-white dark:ring-slate-900 font-mono">
                                    05
                                </div>
                            </div>
                        </div>

                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                            Laporan Dikirim
                        </h3>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400 max-w-xs mx-auto leading-relaxed">
                            Dapatkan nomor registrasi tiket laporan untuk memantau tahapan proses penanganan secara berkala.
                        </p>
                    </div>

                    {{-- ── Step 06: Pantau Penanganan ── --}}
                    <div class="text-center">
                        <div class="flex justify-center mb-5">
                            <div class="relative">
                                {{-- Phone Frame --}}
                                <div class="relative w-[215px] sm:w-[225px] lg:w-[230px] mx-auto select-none">
                                    <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-[160px] h-6 rounded-full bg-black/15 dark:bg-black/40 blur-lg pointer-events-none"></div>
                                    <div class="relative rounded-[2.8rem] bg-[#141A17] p-[5px] shadow-[0_16px_40px_rgba(20,26,23,0.35)] border border-[#2C3831]">
                                        <div class="absolute -left-[4px] top-24 w-[3.5px] h-8 rounded-l-md bg-[#2C3831]"></div>
                                        <div class="absolute -left-[4px] top-36 w-[3.5px] h-12 rounded-l-md bg-[#2C3831]"></div>
                                        <div class="absolute -right-[4px] top-32 w-[3.5px] h-16 rounded-r-md bg-[#2C3831]"></div>

                                        {{-- Screen Content --}}
                                        <div class="relative overflow-hidden rounded-[2.5rem] bg-[#F8FAF9] aspect-[9/19.2] flex flex-col text-left">
                                            <div class="absolute z-50 top-[9px] left-1/2 -translate-x-1/2 pointer-events-none">
                                                <div class="w-[68px] h-[19px] rounded-full bg-black flex items-center justify-end pr-2">
                                                    <div class="w-[4.5px] h-[4.5px] rounded-full bg-[#1F2C24]"></div>
                                                </div>
                                            </div>
                                            <div class="h-9 shrink-0 z-40 flex items-center justify-between px-5 pt-2 text-[8.5px] font-semibold text-slate-800">
                                                <span>08:24</span>
                                                <div class="flex items-center gap-1 text-[7px]"><span>LTE</span><span>100%</span></div>
                                            </div>

                                            <div class="h-[36px] shrink-0 bg-white border-b border-slate-200 px-3 flex items-center justify-between">
                                                <span class="text-[7.5px] font-bold text-slate-900">← Detail Laporan</span>
                                                <span class="text-[5px] font-bold text-amber-700 bg-amber-50 border border-amber-200 px-1.5 py-0.5 rounded-full">Proses</span>
                                            </div>

                                            <div class="flex-1 overflow-hidden px-3 pt-2 flex flex-col gap-1.5">
                                                <div class="bg-white border border-slate-200 rounded-xl p-2 shadow-2xs">
                                                    <p class="text-[4.5px] font-mono text-slate-400">SPK-2026-004</p>
                                                    <p class="text-[6.5px] font-black text-slate-900 leading-tight">Perundungan Verbal</p>
                                                </div>

                                                {{-- Timeline Card --}}
                                                <div class="bg-white border border-slate-200 rounded-xl p-2 shadow-2xs space-y-1">
                                                    <p class="text-[5px] font-bold uppercase tracking-wider text-slate-500">Tahapan Penanganan</p>
                                                    <div class="flex items-start gap-1">
                                                        <div class="w-3 h-3 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[4px] font-bold">✓</div>
                                                        <div><p class="text-[5px] font-bold text-slate-900">Laporan Diterima</p><p class="text-[4px] text-slate-400">12 Sep 2026</p></div>
                                                    </div>
                                                    <div class="flex items-start gap-1">
                                                        <div class="w-3 h-3 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[4px] font-bold">✓</div>
                                                        <div><p class="text-[5px] font-bold text-slate-900">Verifikasi Guru BK</p><p class="text-[4px] text-slate-400">13 Sep 2026</p></div>
                                                    </div>
                                                    <div class="flex items-start gap-1">
                                                        <div class="w-3 h-3 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center text-[4px] font-bold">⏳</div>
                                                        <div><p class="text-[5px] font-bold text-slate-900">Tindak Lanjut & Konseling</p><p class="text-[4px] text-amber-700 font-medium">Sedang Berlangsung</p></div>
                                                    </div>
                                                </div>

                                                {{-- Counselor Note --}}
                                                <div class="bg-[#EAF5EE] border border-primary-200/80 rounded-xl p-1.5">
                                                    <p class="text-[5px] font-bold text-primary-800">Catatan Guru BK:</p>
                                                    <p class="text-[4.5px] text-slate-700 mt-0.5 leading-tight">Jadwal pendampingan telah dikoordinasikan. Siswa dijadwalkan sesi konseling tertutup.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute -top-3 -left-3 w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-xs font-bold shadow-md ring-2 ring-white dark:ring-slate-900 font-mono">
                                    06
                                </div>
                            </div>
                        </div>

                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                            Pantau Penanganan
                        </h3>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400 max-w-xs mx-auto leading-relaxed">
                            Ikuti riwayat tahapan verifikasi hingga tindak lanjut Guru BK selesai secara transparan.
                        </p>
                    </div>
                </div>

                {{-- Bottom Note --}}
                <div class="mt-16 max-w-3xl mx-auto border-t border-slate-300 dark:border-slate-800 pt-8 text-center">
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                        Tampilan pada ilustrasi merupakan representasi alur penggunaan antarmuka SIPERKA dan disesuaikan dengan fitur sistem yang tersedia.
                    </p>
                </div>
            </div>
        </section>

        {{-- ===================================================
            4. SIAPA YANG MENGGUNAKAN SIPERKA (Sesuai frontend #pengguna)
            =================================================== --}}
        <section id="pengguna" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24">
            <div class="text-center mb-14">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-primary-50 dark:bg-primary-950/40 text-primary-700 dark:text-primary-300 border border-primary-200/60 dark:border-primary-800 text-xs font-bold mb-4">
                    EKOSISTEM PENGGUNA
                </span>

                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white mb-4 tracking-tight">
                    Siapa yang Menggunakan SIPERKA?
                </h2>

                <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 max-w-2xl mx-auto">
                    Dirancang spesifik untuk mendukung tiga peran utama warga sekolah dengan hak akses yang teratur.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Siswa --}}
                <div class="bg-white dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-6 shadow-2xs hover:shadow-xs transition-shadow">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg font-bold text-xs mb-5 border bg-primary-50 text-primary-800 border-primary-200/70 dark:bg-primary-950/60 dark:text-primary-300 dark:border-primary-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>SISWA / I</span>
                    </div>

                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-sm text-slate-700 dark:text-slate-300">
                            <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Membuat laporan kejadian perundungan</span>
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-700 dark:text-slate-300">
                            <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Melihat riwayat laporan pribadi</span>
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-700 dark:text-slate-300">
                            <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Memantau status penanganan secara langsung</span>
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-700 dark:text-slate-300">
                            <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Opsi kerahasiaan identitas (Pelapor Rahasia)</span>
                        </li>
                    </ul>
                </div>

                {{-- Guru BK --}}
                <div class="bg-white dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-6 shadow-2xs hover:shadow-xs transition-shadow">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg font-bold text-xs mb-5 border bg-amber-50 text-amber-800 border-amber-200/70 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>GURU BK</span>
                    </div>

                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-sm text-slate-700 dark:text-slate-300">
                            <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Menerima notifikasi laporan masuk</span>
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-700 dark:text-slate-300">
                            <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Memverifikasi keabsahan laporan & bukti</span>
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-700 dark:text-slate-300">
                            <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Memperbarui status penanganan & urgensi</span>
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-700 dark:text-slate-300">
                            <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Mencatat tindak lanjut dan konseling tertutup</span>
                        </li>
                    </ul>
                </div>

                {{-- Administrator --}}
                <div class="bg-white dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-6 shadow-2xs hover:shadow-xs transition-shadow">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg font-bold text-xs mb-5 border bg-slate-100 text-slate-800 border-slate-200/90 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>ADMINISTRATOR</span>
                    </div>

                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-sm text-slate-700 dark:text-slate-300">
                            <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Manajemen akun siswa & staf madrasah</span>
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-700 dark:text-slate-300">
                            <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Pemantauan operasional & log keamanan sistem</span>
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-700 dark:text-slate-300">
                            <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Analitik dan statistik agregat sekolah</span>
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-700 dark:text-slate-300">
                            <svg class="w-4 h-4 text-primary-600 dark:text-[#5AE39D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Pengaturan kategori & konfigurasi madrasah</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- ===================================================
            5. PRIVASI & SEBELUM MEMBUAT LAPORAN (Sesuai frontend)
            =================================================== --}}
        <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Privacy Card --}}
            <div class="bg-white dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-8 flex flex-col items-start shadow-2xs card-hover">
                <div class="w-12 h-12 bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 rounded-xl flex items-center justify-center mb-6 border border-amber-200/60 dark:border-amber-800/60">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>

                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">
                    Identitas Dirahasiakan
                </h3>

                <p class="text-slate-600 dark:text-slate-300 leading-relaxed text-sm">
                    Informasi pelapor hanya dapat diakses oleh pihak Guru BK yang berwenang untuk keperluan pendampingan dan penyelesaian kasus. Kamu berhak memilih opsi anonim saat mengirimkan laporan.
                </p>
            </div>

            {{-- Before Report Guide --}}
            <div class="bg-white dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-8 shadow-2xs card-hover">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">
                    Sebelum Membuat Laporan
                </h3>

                <ul class="space-y-2.5 mb-6 text-sm text-slate-700 dark:text-slate-300">
                    <li class="flex items-start gap-2.5">
                        <span class="text-primary-600 dark:text-[#5AE39D] font-bold mt-0.5">•</span>
                        <span>Ceritakan kejadian secara objektif dan jujur</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="text-primary-600 dark:text-[#5AE39D] font-bold mt-0.5">•</span>
                        <span>Sertakan waktu dan lokasi kejadian jika diketahui</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="text-primary-600 dark:text-[#5AE39D] font-bold mt-0.5">•</span>
                        <span>Gunakan bahasa yang jelas dan mudah dipahami</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="text-primary-600 dark:text-[#5AE39D] font-bold mt-0.5">•</span>
                        <span>Lampirkan bukti pendukung (jika tersedia)</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="text-primary-600 dark:text-[#5AE39D] font-bold mt-0.5">•</span>
                        <span>Periksa kembali rincian sebelum menekan kirim</span>
                    </li>
                </ul>

                <div class="rounded-xl border border-primary-200/80 bg-primary-50/70 dark:border-primary-900/60 dark:bg-primary-950/30 p-4">
                    <p class="text-xs leading-relaxed text-primary-900 dark:text-primary-200">
                        <span class="font-bold">Catatan Etika:</span> SIPERKA adalah wadah pendampingan dan pembinaan, bukan untuk mencari kesalahan secara sepihak. Laporan diproses secara profesional oleh Guru BK.
                    </p>
                </div>
            </div>
        </section>

        {{-- ===================================================
            6. FINAL CALL TO ACTION (Sesuai Desain frontend)
            =================================================== --}}
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-16 sm:py-20 bg-primary-600 dark:bg-[#123F28] relative text-white rounded-3xl p-8 sm:p-12 text-center shadow-lg border border-primary-700">
                <div class="max-w-3xl mx-auto space-y-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-[#B8E34B] text-primary-950 text-xs font-bold shadow-xs">
                        MULAI SEKARANG
                    </span>

                    <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">
                        Siap Mewujudkan Sekolah Bebas Perundungan?
                    </h2>

                    <p class="text-base sm:text-lg text-white/90 max-w-2xl mx-auto leading-relaxed">
                        Sampaikan aspirasi dan laporanmu melalui sistem yang aman, terpercaya, dan langsung terhubung dengan Guru BK.
                    </p>

                    <div class="pt-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-white text-primary-800 hover:bg-emerald-50 rounded-xl font-bold text-base shadow-md hover:shadow-lg transition-all card-hover">
                                <span>Buka Dashboard</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-white text-primary-800 hover:bg-emerald-50 rounded-xl font-bold text-base shadow-md hover:shadow-lg transition-all card-hover">
                                <span>Lapor Sekarang</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-layouts.public>
