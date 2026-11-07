<x-layouts.app title="Pengaturan Sekolah & Konten Beranda">
    <div class="px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8 max-w-6xl w-full mx-auto space-y-6 animate-fade-in">
        {{-- Header Halaman --}}
        <div>
            <div class="flex items-center gap-2 mb-1.5 text-xs">
                <a href="{{ route('master.dashboard') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 transition">Master</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <span class="font-semibold text-emerald-600 dark:text-emerald-400">Pengaturan Website</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 border-b border-slate-200 dark:border-slate-800">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100 flex items-center gap-2.5">
                        <span>Pengaturan Informasi Madrasah & Beranda</span>
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                        Kelola data resmi madrasah pada footer dan teks pengantar pada halaman beranda publik (FR-17).
                    </p>
                </div>
            </div>
        </div>

        {{-- Form Pengaturan --}}
        <form method="POST" action="{{ route('master.settings.update') }}" 
              data-confirm="Simpan seluruh perubahan informasi madrasah dan konfigurasi sistem?"
              data-confirm-title="Konfirmasi Simpan Pengaturan"
              data-confirm-button="Ya, Simpan Perubahan"
              data-confirm-color="#10B981"
              data-confirm-icon="question"
              class="space-y-6">
            @csrf
            @method('PUT')

            {{-- KARTU 1: INFORMASI MADRASAH & FOOTER --}}
            <div class="bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs space-y-6">
                <div class="border-b border-slate-100 dark:border-slate-800 pb-4">
                    <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-slate-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Informasi Madrasah & Footer Publik
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Informasi kontak dan operasional madrasah yang tampil di seluruh footer halaman publik.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="school_name" class="block text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1.5">Nama Madrasah <span class="text-rose-500">*</span></label>
                        <input type="text" id="school_name" name="school_name" value="{{ old('school_name', $settings['school_name']) }}" required class="w-full min-h-[44px] px-3.5 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500" />
                        @error('school_name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="school_phone" class="block text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1.5">Nomor Telepon Madrasah</label>
                        <input type="text" id="school_phone" name="school_phone" value="{{ old('school_phone', $settings['school_phone']) }}" class="w-full min-h-[44px] px-3.5 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500" />
                        @error('school_phone') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="school_address" class="block text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1.5">Alamat Lengkap Madrasah <span class="text-rose-500">*</span></label>
                        <textarea id="school_address" name="school_address" rows="2" required class="w-full px-3.5 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500">{{ old('school_address', $settings['school_address']) }}</textarea>
                        @error('school_address') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="counseling_location" class="block text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1.5">Lokasi Ruang Layanan BK <span class="text-rose-500">*</span></label>
                        <input type="text" id="counseling_location" name="counseling_location" value="{{ old('counseling_location', $settings['counseling_location']) }}" required class="w-full min-h-[44px] px-3.5 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500" />
                        @error('counseling_location') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="counseling_hours" class="block text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1.5">Jam Layanan Konseling BK <span class="text-rose-500">*</span></label>
                        <input type="text" id="counseling_hours" name="counseling_hours" value="{{ old('counseling_hours', $settings['counseling_hours']) }}" required class="w-full min-h-[44px] px-3.5 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500" />
                        @error('counseling_hours') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="school_email" class="block text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1.5">Email Resmi BK / Madrasah</label>
                        <input type="email" id="school_email" name="school_email" value="{{ old('school_email', $settings['school_email']) }}" class="w-full min-h-[44px] px-3.5 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500" />
                        @error('school_email') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="emergency_contact" class="block text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1.5">Petunjuk Kontak Darurat Singkat</label>
                        <input type="text" id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact', $settings['emergency_contact']) }}" class="w-full min-h-[44px] px-3.5 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500" />
                        @error('emergency_contact') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- KARTU 2: KONTEN BERANDA PUBLIK --}}
            <div class="bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs space-y-6">
                <div class="border-b border-slate-100 dark:border-slate-800 pb-4">
                    <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-slate-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Konten Pengantar Beranda (Hero & Tentang)
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Teks sapaan ramah anak yang tampil pada bagian atas beranda SISPERKA.</p>
                </div>

                <div class="space-y-5">
                    <div>
                        <label for="hero_title" class="block text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1.5">Judul Utama Beranda (Hero Headline) <span class="text-rose-500">*</span></label>
                        <input type="text" id="hero_title" name="hero_title" value="{{ old('hero_title', $settings['hero_title']) }}" required class="w-full min-h-[44px] px-3.5 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500" />
                        @error('hero_title') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="hero_subtitle" class="block text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1.5">Penjelasan Utama Beranda (Hero Subtitle) <span class="text-rose-500">*</span></label>
                        <textarea id="hero_subtitle" name="hero_subtitle" rows="3" required class="w-full px-3.5 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500">{{ old('hero_subtitle', $settings['hero_subtitle']) }}</textarea>
                        @error('hero_subtitle') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="about_text" class="block text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1.5">Teks Pengantar Bagian "Mengenal SISPERKA" <span class="text-rose-500">*</span></label>
                        <textarea id="about_text" name="about_text" rows="4" required class="w-full px-3.5 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500">{{ old('about_text', $settings['about_text']) }}</textarea>
                        @error('about_text') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- KARTU 3: KEBIJAKAN RETENSI DATA & EVALUASI TAHUNAN --}}
            <div class="bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs space-y-6">
                <div class="border-b border-slate-100 dark:border-slate-800 pb-4">
                    <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-slate-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Kebijakan Retensi Data & Evaluasi Tahunan (P2)
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Aturan penyimpanan arsip laporan demi privasi jangka panjang peserta didik madrasah.</p>
                </div>

                <div class="space-y-4">
                    <div class="p-4 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Status Audit Retensi Saat Ini</span>
                            <div class="text-xs sm:text-sm text-slate-900 dark:text-slate-100 font-medium">
                                Laporan selesai / ditolak melewati ambang batas retensi:
                                <span class="font-bold font-mono px-2 py-0.5 rounded-md {{ $expiredReportsCount > 0 ? 'bg-amber-100 text-amber-800 dark:bg-amber-950/50 dark:text-amber-300' : 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/50 dark:text-emerald-300' }}">
                                    {{ $expiredReportsCount }} laporan
                                </span>
                            </div>
                            <p class="text-xs text-slate-400">Perintah konsol otomatis: <code class="bg-white dark:bg-slate-800 px-1.5 py-0.5 rounded border border-slate-200 dark:border-slate-700 font-mono text-[11px]">php artisan reports:audit-retention</code></p>
                        </div>

                        <div class="text-xs text-slate-500 dark:text-slate-400 max-w-xs">
                            Data laporan yang telah diarsipkan lebih dari batas retensi tetap terlindungi tanpa membocorkan identitas siswa ke publik.
                        </div>
                    </div>

                    <div class="max-w-xs">
                        <label for="data_retention_years" class="block text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1.5">
                            Masa Retensi Arsip Laporan (Tahun) <span class="text-rose-500">*</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="number" 
                                   id="data_retention_years" 
                                   name="data_retention_years" 
                                   min="1" 
                                   max="20" 
                                   value="{{ old('data_retention_years', $settings['data_retention_years']) }}" 
                                   required 
                                   class="w-32 min-h-[44px] px-3.5 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500" />
                            <span class="text-xs sm:text-sm font-medium text-slate-600 dark:text-slate-400">Tahun</span>
                        </div>
                        @error('data_retention_years') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-slate-400 mt-1">Standar madrasah: 5 tahun setelah kasus dinyatakan selesai atau ditolak.</p>
                    </div>
                </div>
            </div>

            {{-- Tombol Simpan --}}
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('master.dashboard') }}" class="min-h-[44px] inline-flex items-center justify-center px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="min-h-[44px] inline-flex items-center justify-center gap-2 px-5 py-2 text-xs sm:text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-xs transition active:scale-[0.98]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Perubahan Pengaturan
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
