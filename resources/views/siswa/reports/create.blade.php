<x-layouts.app title="Buat Laporan Perundungan">
    <div 
        x-data="{
            step: {{ $errors->any() ? ($errors->has('attachments.*') || $errors->has('attachments') ? 1 : 0) : 0 }},
            reporter_role: '{{ old('reporter_role', 'korban') }}',
            category_id: '{{ old('category_id', '') }}',
            incident_date: '{{ old('incident_date', date('Y-m-d')) }}',
            location: '{{ addslashes(old('location', '')) }}',
            accused_name: '{{ addslashes(old('accused_name', '')) }}',
            description: '{{ addslashes(str_replace(["\r", "\n"], [' ', '\n'], old('description', ''))) }}',
            privacy: '{{ old('is_hidden_identity', '1') == '1' ? 'hidden' : 'shown' }}',
            fileNames: [],
            handleFiles(e) {
                this.fileNames = Array.from(e.target.files).map(f => f.name);
            },
            getCategoryLabel() {
                const sel = document.getElementById('category_id');
                if (!sel || !sel.selectedIndex || sel.selectedIndex === 0) return '-';
                return sel.options[sel.selectedIndex].text.trim();
            },
            getFormattedDate() {
                if (!this.incident_date) return '-';
                try {
                    const d = new Date(this.incident_date + 'T00:00:00');
                    return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                } catch(e) {
                    return this.incident_date;
                }
            }
        }"
        class="px-4 py-5 sm:px-6 sm:py-6 flex flex-col gap-6 max-w-3xl w-full mx-auto lg:px-8 lg:py-8 animate-fade-in"
    >
        {{-- Breadcrumb & Title --}}
        <div>
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('siswa.dashboard') }}" class="text-xs sm:text-sm font-medium text-slate-500 hover:text-primary-700 dark:hover:text-[#5AE39D] transition-colors">
                    Dashboard Siswa
                </a>
                <span class="text-xs text-slate-400">/</span>
                <span class="text-xs sm:text-sm font-semibold text-primary-700 dark:text-[#5AE39D]">Buat Laporan</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">
                        Buat Laporan Perundungan
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 mt-1">
                        Ceritakan apa yang terjadi dengan jujur dan tenang. Ruang ini aman, dan Guru BK siap mendampingimu.
                    </p>
                </div>
            </div>
        </div>

        {{-- Progress Steps (0: Detail, 1: Bukti & Privasi, 2: Konfirmasi) --}}
        <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-4 sm:p-5 shadow-xs">
            <div class="flex items-center justify-between max-w-xl mx-auto" role="list" aria-label="Langkah pengisian laporan">
                {{-- Step 1 --}}
                <div class="flex items-center flex-1">
                    <div class="flex flex-col items-center gap-1.5 flex-1">
                        <button type="button" @click="step = 0" class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition-all"
                            :class="step > 0 ? 'bg-primary-600 text-white' : (step === 0 ? 'bg-primary-600 text-white ring-4 ring-primary-100 dark:ring-primary-950/80' : 'bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400')">
                            <template x-if="step > 0">
                                <svg class="w-4 h-4 text-[#B8E34B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </template>
                            <template x-if="step <= 0">
                                <span>1</span>
                            </template>
                        </button>
                        <span class="text-[11px] font-semibold text-center" :class="step === 0 ? 'text-primary-700 dark:text-[#5AE39D]' : 'text-slate-500 dark:text-slate-400'">
                            Detail Kejadian
                        </span>
                    </div>
                    <div class="h-0.5 flex-1 mx-2" :class="step > 0 ? 'bg-primary-600' : 'bg-slate-200 dark:bg-slate-800'"></div>
                </div>

                {{-- Step 2 --}}
                <div class="flex items-center flex-1">
                    <div class="flex flex-col items-center gap-1.5 flex-1">
                        <button type="button" @click="if (step > 1 || (category_id && incident_date && location && description.length >= 20)) step = 1" class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition-all"
                            :class="step > 1 ? 'bg-primary-600 text-white' : (step === 1 ? 'bg-primary-600 text-white ring-4 ring-primary-100 dark:ring-primary-950/80' : 'bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400')">
                            <template x-if="step > 1">
                                <svg class="w-4 h-4 text-[#B8E34B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </template>
                            <template x-if="step <= 1">
                                <span>2</span>
                            </template>
                        </button>
                        <span class="text-[11px] font-semibold text-center" :class="step === 1 ? 'text-primary-700 dark:text-[#5AE39D]' : 'text-slate-500 dark:text-slate-400'">
                            Bukti & Privasi
                        </span>
                    </div>
                    <div class="h-0.5 flex-1 mx-2" :class="step > 1 ? 'bg-primary-600' : 'bg-slate-200 dark:bg-slate-800'"></div>
                </div>

                {{-- Step 3 --}}
                <div class="flex items-center">
                    <div class="flex flex-col items-center gap-1.5">
                        <button type="button" @click="if (category_id && incident_date && location && description.length >= 20) step = 2" class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition-all"
                            :class="step === 2 ? 'bg-primary-600 text-white ring-4 ring-primary-100 dark:ring-primary-950/80' : 'bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400'">
                            <span>3</span>
                        </button>
                        <span class="text-[11px] font-semibold text-center" :class="step === 2 ? 'text-primary-700 dark:text-[#5AE39D]' : 'text-slate-500 dark:text-slate-400'">
                            Konfirmasi
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Error Banner jika ada kegagalan validasi backend --}}
        @if ($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-900/60 flex items-start gap-3">
                <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="text-xs sm:text-sm text-rose-900 dark:text-rose-200">
                    <p class="font-bold">Mohon periksa kembali formulir:</p>
                    <ul class="list-disc list-inside mt-1 space-y-0.5">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Main Form Container --}}
        <form action="{{ route('siswa.reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="reportForm">
            @csrf

            {{-- ══════════════════════════════════════════════════════
                 STEP 0: DETAIL KEJADIAN
            ══════════════════════════════════════════════════════ --}}
            <div x-show="step === 0" class="flex flex-col gap-5 animate-slide-up">
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-7 shadow-xs space-y-6">
                    <div class="border-b border-slate-100 dark:border-slate-800/80 pb-4">
                        <h2 class="text-base sm:text-lg font-black text-slate-900 dark:text-slate-100">
                            1. Ceritakan apa yang terjadi
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-1">
                            Isi berdasarkan yang kamu ingat. Tidak perlu menggunakan bahasa formal.
                        </p>
                    </div>

                    {{-- Peran Pelapor --}}
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100 mb-2.5">
                            Dalam kejadian ini, posisi kamu sebagai apa? <span class="text-rose-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="relative flex items-start p-4 rounded-xl border cursor-pointer transition-all card-hover"
                                :class="reporter_role === 'korban' ? 'border-primary-500 bg-primary-50/60 dark:bg-primary-950/40 ring-1 ring-primary-500' : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/40'">
                                <input type="radio" name="reporter_role" value="korban" x-model="reporter_role" class="mt-1 w-4 h-4 text-primary-600 focus:ring-primary-600 border-slate-300">
                                <div class="ml-3">
                                    <span class="block text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100">Saya Korban</span>
                                    <span class="block text-[11px] sm:text-xs text-slate-500 dark:text-slate-400 mt-0.5">Saya sendiri yang mengalami perlakuan tidak menyenangkan ini.</span>
                                </div>
                            </label>

                            <label class="relative flex items-start p-4 rounded-xl border cursor-pointer transition-all card-hover"
                                :class="reporter_role === 'saksi' ? 'border-primary-500 bg-primary-50/60 dark:bg-primary-950/40 ring-1 ring-primary-500' : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/40'">
                                <input type="radio" name="reporter_role" value="saksi" x-model="reporter_role" class="mt-1 w-4 h-4 text-primary-600 focus:ring-primary-600 border-slate-300">
                                <div class="ml-3">
                                    <span class="block text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100">Saya Saksi</span>
                                    <span class="block text-[11px] sm:text-xs text-slate-500 dark:text-slate-400 mt-0.5">Saya melihat, mendengar, atau mengetahui kejadian yang menimpa teman saya.</span>
                                </div>
                            </label>
                        </div>
                        @error('reporter_role')
                            <p class="text-rose-600 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Kejadian / Kategori --}}
                    <div>
                        <label for="category_id" class="block text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100 mb-2">
                            Jenis / Kategori Kejadian <span class="text-rose-500">*</span>
                        </label>
                        <select name="category_id" id="category_id" x-model="category_id" required
                            class="w-full min-h-[44px] text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 py-2.5 px-3.5 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:border-primary-600 transition">
                            <option value="">-- Pilih Jenis Perundungan --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Pilih kategori yang paling sesuai dengan kejadian yang kamu alami atau saksikan.</p>
                        @error('category_id')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal & Tempat Kejadian --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="incident_date" class="block text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100 mb-1.5">
                                Kapan Terjadi? <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" name="incident_date" id="incident_date" x-model="incident_date" max="{{ date('Y-m-d') }}" required
                                class="w-full min-h-[44px] text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 py-2.5 px-3.5 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 transition">
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Tanggal perkiraan kejadian terjadi.</p>
                            @error('incident_date')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="location" class="block text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100 mb-1.5">
                                Di mana Terjadi? <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="location" id="location" x-model="location" required
                                placeholder="Contoh: Kantin, Ruang Kelas VII-A, Lapangan"
                                class="w-full min-h-[44px] text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 py-2.5 px-3.5 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-600 transition">
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Sebutkan tempat atau lokasi kejadian.</p>
                            @error('location')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Pihak yang Terlibat / Terlapor (Opsional) --}}
                    <div>
                        <label for="accused_name" class="block text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100 mb-1.5">
                            Pihak yang Terlibat / Terlapor <span class="text-slate-400 font-normal">(opsional)</span>
                        </label>
                        <input type="text" name="accused_name" id="accused_name" x-model="accused_name"
                            placeholder="Contoh: Nama siswa, kelas, atau ciri-cirinya"
                            class="w-full min-h-[44px] text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 py-2.5 px-3.5 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-600 transition">
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Jika belum yakin dengan nama lengkapnya, kamu boleh mengosongkan bagian ini.</p>
                        @error('accused_name')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kronologi Kejadian --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="description" class="block text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100">
                                Kronologi Kejadian <span class="text-rose-500">*</span>
                            </label>
                            <span class="text-[11px] font-mono text-slate-500 dark:text-slate-400" x-text="description.length + '/2000 karakter'"></span>
                        </div>
                        <textarea name="description" id="description" x-model="description" rows="5" required
                            placeholder="Ceritakan kejadian yang kamu alami atau saksikan dengan tenang..."
                            class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 py-3 px-3.5 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-600 transition leading-relaxed"></textarea>
                        <div class="flex items-center justify-between mt-1 text-[11px] text-slate-500 dark:text-slate-400">
                            <span>Minimal 20 karakter agar Guru BK mendapat gambaran yang utuh.</span>
                            <span x-show="description.length > 0 && description.length < 20" class="text-amber-600 dark:text-amber-400 font-semibold">
                                Kurang <span x-text="20 - description.length"></span> karakter lagi
                            </span>
                        </div>
                        @error('description')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Navigation Step 0 -> Step 1 --}}
                <div class="flex items-center justify-between gap-3 pt-2">
                    <a href="{{ route('siswa.dashboard') }}" class="min-h-[44px] px-5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                        Batal
                    </a>
                    <button type="button" 
                        @click="if (!category_id || !incident_date || !location.trim() || description.trim().length < 20) { alert('Mohon lengkapi jenis kejadian, tanggal, lokasi, dan kronologi (minimal 20 karakter).'); return; } step = 1; window.scrollTo({top: 0, behavior: 'smooth'});"
                        class="min-h-[44px] px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white text-xs sm:text-sm font-bold flex items-center gap-2 shadow-xs transition card-hover">
                        <span>Lanjut: Bukti & Privasi</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            {{-- ══════════════════════════════════════════════════════
                 STEP 1: BUKTI & PRIVASI
            ══════════════════════════════════════════════════════ --}}
            <div x-show="step === 1" class="flex flex-col gap-5 animate-slide-up" style="display: none;">
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-7 shadow-xs space-y-6">
                    <div class="border-b border-slate-100 dark:border-slate-800/80 pb-4">
                        <h2 class="text-base sm:text-lg font-black text-slate-900 dark:text-slate-100">
                            2. Bukti &amp; Pengaturan Privasi
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-1">
                            Lampiran bukti bersifat opsional. Kamu memiliki kendali penuh atas kerahasiaan identitasmu.
                        </p>
                    </div>

                    {{-- File Upload Card --}}
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100 mb-2">
                            Unggah Bukti Pendukung <span class="text-slate-400 font-normal">(opsional, maks 3 file)</span>
                        </label>
                        
                        <div class="relative border-2 border-dashed border-slate-300 dark:border-slate-700 hover:border-primary-500 dark:hover:border-primary-500 rounded-2xl p-6 text-center transition bg-slate-50/50 dark:bg-slate-900/30">
                            <input type="file" name="attachments[]" id="attachments" multiple accept=".jpg,.jpeg,.png,.pdf"
                                @change="handleFiles($event)"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            
                            <div class="flex flex-col items-center justify-center gap-2">
                                <div class="w-12 h-12 rounded-2xl bg-primary-100/70 dark:bg-primary-950/60 text-primary-600 dark:text-[#5AE39D] flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                </div>
                                <p class="text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100">
                                    Klik atau seret file ke sini untuk mengunggah
                                </p>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                    Format: <strong>JPG, PNG, atau PDF</strong> (Maks. 5 MB per berkas)
                                </p>
                            </div>
                        </div>

                        {{-- File List Preview --}}
                        <div x-show="fileNames.length > 0" class="mt-3 space-y-1.5" style="display: none;">
                            <p class="text-xs font-bold text-slate-700 dark:text-slate-300">File yang dipilih:</p>
                            <template x-for="(name, idx) in fileNames" :key="idx">
                                <div class="flex items-center gap-2 text-xs text-primary-700 dark:text-[#5AE39D] bg-primary-50 dark:bg-primary-950/40 px-3 py-1.5 rounded-lg border border-primary-200 dark:border-primary-900">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                    <span x-text="name" class="truncate font-medium"></span>
                                </div>
                            </template>
                        </div>
                        @error('attachments')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        @error('attachments.*')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Privacy Options (Hidden / Shown) --}}
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100 mb-2.5">
                            Pengaturan Privasi Identitas <span class="text-rose-500">*</span>
                        </label>

                        {{-- Hidden input for backend boolean --}}
                        <input type="hidden" name="is_hidden_identity" :value="privacy === 'hidden' ? '1' : '0'">

                        <div class="grid grid-cols-1 gap-3">
                            {{-- Option 1: Hidden (Pelapor Rahasia) --}}
                            <label class="relative flex items-start p-4 rounded-xl border cursor-pointer transition-all card-hover"
                                :class="privacy === 'hidden' ? 'border-primary-500 bg-primary-50/70 dark:bg-primary-950/40 ring-1 ring-primary-500' : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/40'">
                                <input type="radio" value="hidden" x-model="privacy" class="mt-1 w-4 h-4 text-primary-600 focus:ring-primary-600 border-slate-300">
                                <div class="ml-3.5 flex-1">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-primary-700 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        <span class="text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100">Rahasiakan Identitas Saya (Pelapor Rahasia - Disarankan)</span>
                                    </div>
                                    <p class="text-[11px] sm:text-xs text-slate-600 dark:text-slate-400 mt-1 leading-relaxed">
                                        Namamu disamarkan sebagai <strong>"Pelapor Rahasia"</strong>. Siswa lain dan pihak umum tidak akan mengetahui identitasmu. Guru BK memegang akses ini secara rahasia dan aman demi keselamatanmu.
                                    </p>
                                </div>
                            </label>

                            {{-- Option 2: Shown --}}
                            <label class="relative flex items-start p-4 rounded-xl border cursor-pointer transition-all card-hover"
                                :class="privacy === 'shown' ? 'border-primary-500 bg-primary-50/70 dark:bg-primary-950/40 ring-1 ring-primary-500' : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/40'">
                                <input type="radio" value="shown" x-model="privacy" class="mt-1 w-4 h-4 text-primary-600 focus:ring-primary-600 border-slate-300">
                                <div class="ml-3.5 flex-1">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span class="text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100">Tampilkan Nama Asli Saya</span>
                                    </div>
                                    <p class="text-[11px] sm:text-xs text-slate-600 dark:text-slate-400 mt-1 leading-relaxed">
                                        Namamu ({{ auth()->user()->name }}) akan tercantum pada berkas tindak lanjut Guru BK.
                                    </p>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Jaminan Perlindungan --}}
                    <div class="p-4 rounded-xl bg-amber-50/70 dark:bg-amber-950/30 border border-amber-200/80 dark:border-amber-900/60 flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-700 dark:text-[#FAD46B] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-xs text-amber-900 dark:text-[#FAD46B] leading-relaxed">
                            <strong>Perlindungan Pelapor:</strong> Madrasah berkomitmen melindungi setiap pelapor dari tindakan intimidasi atau aksi balasan apa pun.
                        </p>
                    </div>
                </div>

                {{-- Navigation Step 1 -> Back/Next --}}
                <div class="flex items-center justify-between gap-3 pt-2">
                    <button type="button" @click="step = 0; window.scrollTo({top: 0, behavior: 'smooth'});" class="min-h-[44px] px-5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                        Kembali ke Detail
                    </button>
                    <button type="button" @click="step = 2; window.scrollTo({top: 0, behavior: 'smooth'});" class="min-h-[44px] px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white text-xs sm:text-sm font-bold flex items-center gap-2 shadow-xs transition card-hover">
                        <span>Lanjut: Periksa Ringkasan</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            {{-- ══════════════════════════════════════════════════════
                 STEP 2: KONFIRMASI RINGKASAN & KIRIM
            ══════════════════════════════════════════════════════ --}}
            <div x-show="step === 2" class="flex flex-col gap-5 animate-slide-up" style="display: none;">
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 sm:p-7 shadow-xs space-y-6">
                    <div class="border-b border-slate-100 dark:border-slate-800/80 pb-4">
                        <h2 class="text-base sm:text-lg font-black text-slate-900 dark:text-slate-100">
                            3. Periksa Kembali Laporanmu
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-1">
                            Pastikan semua informasi sudah benar sebelum mengirimkan ke Guru BK.
                        </p>
                    </div>

                    {{-- Summary Table Card --}}
                    <div class="bg-slate-50/80 dark:bg-slate-900/60 rounded-xl border border-slate-200/80 dark:border-slate-800 p-4 sm:p-5 divide-y divide-slate-200/80 dark:divide-slate-800 text-xs sm:text-sm">
                        <div class="py-2.5 flex items-center justify-between gap-4">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Peran Pelapor</span>
                            <span class="font-bold text-slate-900 dark:text-slate-100 capitalize" x-text="reporter_role === 'korban' ? 'Saya Korban Langsung' : 'Saya Saksi'"></span>
                        </div>

                        <div class="py-2.5 flex items-center justify-between gap-4">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Jenis Kejadian</span>
                            <span class="font-bold text-primary-700 dark:text-[#5AE39D]" x-text="getCategoryLabel()"></span>
                        </div>

                        <div class="py-2.5 flex items-center justify-between gap-4">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Waktu Kejadian</span>
                            <span class="font-bold text-slate-900 dark:text-slate-100" x-text="getFormattedDate()"></span>
                        </div>

                        <div class="py-2.5 flex items-center justify-between gap-4">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Lokasi Kejadian</span>
                            <span class="font-bold text-slate-900 dark:text-slate-100" x-text="location || '-'"></span>
                        </div>

                        <div class="py-2.5 flex items-center justify-between gap-4">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Pihak Terlibat / Terlapor</span>
                            <span class="font-bold text-slate-900 dark:text-slate-100" x-text="accused_name || 'Tidak dicantumkan'"></span>
                        </div>

                        <div class="py-3 flex flex-col gap-1.5">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Kronologi Kejadian</span>
                            <p class="font-normal text-slate-800 dark:text-slate-200 whitespace-pre-wrap leading-relaxed bg-white dark:bg-slate-900 p-3 rounded-lg border border-slate-200 dark:border-slate-800" x-text="description || '-'"></p>
                        </div>

                        <div class="py-2.5 flex items-center justify-between gap-4">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Lampiran Bukti</span>
                            <span class="font-bold text-slate-900 dark:text-slate-100" x-text="fileNames.length > 0 ? (fileNames.length + ' file dipilih') : 'Tidak ada berkas'"></span>
                        </div>

                        <div class="py-2.5 flex items-center justify-between gap-4">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Status Privasi</span>
                            <span class="inline-flex items-center gap-1.5 font-bold" :class="privacy === 'hidden' ? 'text-primary-700 dark:text-[#5AE39D]' : 'text-slate-800 dark:text-slate-200'">
                                <template x-if="privacy === 'hidden'">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        Pelapor Rahasia (Nama Disamarkan)
                                    </span>
                                </template>
                                <template x-if="privacy !== 'hidden'">
                                    <span>Nama Asli Ditampilkan</span>
                                </template>
                            </span>
                        </div>
                    </div>

                    <div class="p-4 rounded-xl bg-primary-50/70 dark:bg-primary-950/30 border border-primary-200/80 dark:border-primary-900/60 flex items-start gap-3">
                        <svg class="w-5 h-5 text-primary-700 dark:text-[#5AE39D] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <p class="text-xs text-primary-900 dark:text-primary-200 leading-relaxed">
                            Dengan mengirimkan laporan ini, kamu mengonfirmasi bahwa data yang diberikan adalah benar sesuai ingatanmu. Guru BK akan merespon melalui sistem SIPERKA secara berkala.
                        </p>
                    </div>
                </div>

                {{-- Action Submit --}}
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2">
                    <button type="button" @click="step = 1; window.scrollTo({top: 0, behavior: 'smooth'});" class="w-full sm:w-auto min-h-[44px] px-5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                        Ubah Bukti / Privasi
                    </button>

                    <button type="submit" class="w-full sm:w-auto min-h-[48px] px-8 py-3 rounded-xl bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white text-sm sm:text-base font-extrabold flex items-center justify-center gap-3 shadow-md hover:shadow-lg transition card-hover">
                        <svg class="w-5 h-5 text-[#B8E34B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        <span>Kirimkan Laporan Ini</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>
