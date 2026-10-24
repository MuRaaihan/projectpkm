<x-layouts.app title="Bantuan & Kontak Darurat">
    <div class="px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8 max-w-4xl w-full mx-auto space-y-8 animate-fade-in">
        {{-- Header Bantuan --}}
        <div class="pb-6 border-b border-slate-200 dark:border-slate-800 space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800 text-xs font-semibold">
                <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                Saluran Bantuan & Keselamatan Siswa
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100">
                Pusat Bantuan & Kontak Darurat
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                Jika kamu atau temanmu sedang menghadapi bahaya, ancaman fisik, atau membutuhkan pertolongan mendesak, kamu tidak perlu takut. Bantuan selalu tersedia untukmu.
            </p>
        </div>

        {{-- LANGKAH CEPAT JIKA DALAM BAHAYA FISIK --}}
        <div class="p-6 rounded-2xl bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800/80 text-amber-900 dark:text-amber-200 space-y-4">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-300 flex items-center justify-center shrink-0 font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-amber-950 dark:text-amber-100">
                        Apa yang harus dilakukan jika kamu merasa terancam sekarang?
                    </h2>
                    <p class="text-xs sm:text-sm text-amber-800 dark:text-amber-300 mt-1 leading-relaxed">
                        Keselamatan fisikmu adalah hal yang paling utama. Jangan ragu melakukan langkah-langkah di bawah ini:
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 pt-2">
                <div class="p-4 rounded-xl bg-white/90 dark:bg-[#16231D]/90 border border-amber-200/60 dark:border-amber-800/50 space-y-1">
                    <span class="text-xs font-bold text-amber-800 dark:text-amber-300 uppercase tracking-wider block">1. Menjauh & Cari Keramaian</span>
                    <p class="text-xs text-amber-900 dark:text-slate-300 leading-relaxed">Segera tinggalkan tempat sepi dan pergilah ke area ramai, seperti ruang guru, perpustakaan, atau pos piket.</p>
                </div>
                <div class="p-4 rounded-xl bg-white/90 dark:bg-[#16231D]/90 border border-amber-200/60 dark:border-amber-800/50 space-y-1">
                    <span class="text-xs font-bold text-amber-800 dark:text-amber-300 uppercase tracking-wider block">2. Dekati Guru Terdekat</span>
                    <p class="text-xs text-amber-900 dark:text-slate-300 leading-relaxed">Langsung beri tahu guru piket, wali kelas, atau satpam madrasah bahwa kamu membutuhkan perlindungan saat itu juga.</p>
                </div>
                <div class="p-4 rounded-xl bg-white/90 dark:bg-[#16231D]/90 border border-amber-200/60 dark:border-amber-800/50 space-y-1">
                    <span class="text-xs font-bold text-amber-800 dark:text-amber-300 uppercase tracking-wider block">3. Datangi Ruang BK</span>
                    <p class="text-xs text-amber-900 dark:text-slate-300 leading-relaxed">Ruang Bimbingan & Konseling adalah zona aman. Kamu berhak berlindung di sana kapan pun kamu merasa cemas.</p>
                </div>
            </div>
        </div>

        {{-- KONTAK RESMI BK MADRASAH --}}
        <div class="bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs space-y-6">
            <div class="flex items-center gap-3 pb-4 border-b border-slate-100 dark:border-slate-800">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-slate-100">Ruang Bimbingan & Konseling {{ $schoolContacts['school_name'] }}</h2>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Konselor madrasah selalu siap mendengar keluh kesahmu tanpa menghakimi.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm">
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-800">
                    <span class="text-xs font-semibold text-slate-400 block mb-1">Lokasi Ruang Layanan</span>
                    <p class="font-bold text-slate-900 dark:text-slate-100">{{ $schoolContacts['counseling_location'] }}</p>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-800">
                    <span class="text-xs font-semibold text-slate-400 block mb-1">Waktu Pelayanan</span>
                    <p class="font-bold text-slate-900 dark:text-slate-100">{{ $schoolContacts['counseling_hours'] }}</p>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-800">
                    <span class="text-xs font-semibold text-slate-400 block mb-1">Telepon Madrasah</span>
                    <p class="font-bold text-slate-900 dark:text-slate-100 font-mono">{{ $schoolContacts['school_phone'] }}</p>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-800">
                    <span class="text-xs font-semibold text-slate-400 block mb-1">Email Layanan Konseling</span>
                    <p class="font-bold text-slate-900 dark:text-slate-100">{{ $schoolContacts['school_email'] }}</p>
                </div>
            </div>
        </div>

        {{-- HOTLINE RESMI DARURAT NASIONAL PERLINDUNGAN ANAK --}}
        <div class="space-y-4">
            <div class="space-y-1">
                <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-slate-100">Layanan Darurat & Pengaduan Nasional</h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Layanan telepon gratis yang disediakan oleh lembaga negara resmi untuk perlindungan anak di luar lingkungan sekolah.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($nationalHotlines as $hotline)
                    <div class="p-5 rounded-2xl bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 shadow-xs flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <span class="text-[10px] font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-100 dark:border-emerald-800 px-2.5 py-1 rounded-md inline-block">
                                {{ $hotline['provider'] }}
                            </span>
                            <h3 class="text-sm sm:text-base font-bold text-slate-900 dark:text-slate-100">{{ $hotline['name'] }}</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">{{ $hotline['description'] }}</p>
                        </div>

                        <div class="pt-3 border-t border-slate-100 dark:border-slate-800 space-y-1.5">
                            <div class="flex items-center justify-between text-xs sm:text-sm">
                                <span class="text-xs font-medium text-slate-400">Bebas Pulsa:</span>
                                <span class="font-mono font-bold text-rose-600 dark:text-rose-400 text-sm sm:text-base">{{ $hotline['hotline'] }}</span>
                            </div>
                            @if($hotline['whatsapp'] !== '-')
                                <div class="flex items-center justify-between text-xs sm:text-sm">
                                    <span class="text-xs font-medium text-slate-400">WhatsApp:</span>
                                    <span class="font-mono font-bold text-emerald-600 dark:text-emerald-400 text-xs sm:text-sm">{{ $hotline['whatsapp'] }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- KEMBALI KE DASHBOARD --}}
        <div class="pt-4 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
            <a href="{{ route('siswa.dashboard') }}" class="min-h-[44px] inline-flex items-center justify-center gap-2 px-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition">
                &larr; Kembali ke Dashboard Saya
            </a>
            <a href="{{ route('siswa.reports.create') }}" class="min-h-[44px] inline-flex items-center justify-center gap-2 px-4 py-2.5 text-xs sm:text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-xs transition">
                Buat Laporan Sekarang
            </a>
        </div>
    </div>
</x-layouts.app>
