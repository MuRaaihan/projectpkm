<x-layouts.app title="Buat Laporan Perundungan">
    <div 
        x-data="{
            step: {{ $errors->any() ? ($errors->has('attachments.*') || $errors->has('attachments') ? 1 : 0) : 0 }},
            reporter_role: {{ json_encode(old('reporter_role', 'korban')) }},
            category_id: {{ json_encode((string) old('category_id', '')) }},
            categoriesMap: {{ json_encode($categories->pluck('name', 'id')) }},
            incident_date: {{ json_encode(old('incident_date', date('Y-m-d'))) }},
            location: {{ json_encode(old('location', '')) }},
            accused_name: {{ json_encode(old('accused_name', '')) }},
            description: {{ json_encode(old('description', '')) }},
            privacy: '{{ old('is_hidden_identity', '1') == '1' ? 'hidden' : 'shown' }}',
            filePreviews: [],
            stepErrors: [],
            isStep0Valid() {
                const cat = (this.category_id || '').toString().trim();
                const date = (this.incident_date || '').toString().trim();
                const loc = (this.location || '').toString().trim();
                const desc = (this.description || '').toString().trim();
                return Boolean(cat && date && loc && desc.length >= 10);
            },
            validateStep0() {
                this.stepErrors = [];
                const cat = (this.category_id || '').toString().trim();
                const date = (this.incident_date || '').toString().trim();
                const loc = (this.location || '').toString().trim();
                const desc = (this.description || '').toString().trim();

                if (!cat) {
                    this.stepErrors.push('Pilih jenis / kategori kejadian terlebih dahulu.');
                }
                if (!date) {
                    this.stepErrors.push('Isi tanggal perkiraan kejadian.');
                }
                if (!loc) {
                    this.stepErrors.push('Isi tempat / lokasi kejadian (contoh: Kantin, Kelas, Lapangan).');
                }
                if (!desc) {
                    this.stepErrors.push('Ceritakan kronologi kejadian yang kamu alami atau ketahui.');
                } else if (desc.length < 10) {
                    this.stepErrors.push('Cerita kronologi kejadian minimal 10 karakter (saat ini ' + desc.length + ' karakter).');
                }

                if (this.stepErrors.length > 0) {
                    const banner = document.getElementById('step0ErrorBanner');
                    if (banner) {
                        banner.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    return false;
                }
                return true;
            },
            nextToStep1() {
                if (!this.validateStep0()) {
                    return;
                }
                this.stepErrors = [];
                this.step = 1;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            },
            goToStep(targetStep) {
                if (targetStep === 0) {
                    this.step = 0;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    return;
                }
                if (targetStep >= 1 && !this.validateStep0()) {
                    return;
                }
                this.stepErrors = [];
                this.step = targetStep;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            },
            handleFiles(e) {
                const files = Array.from(e.target.files).slice(0, 3);
                this.filePreviews = files.map(file => {
                    const isImg = file.type.startsWith('image/');
                    const sizeStr = file.size >= 1048576 
                        ? (file.size / 1048576).toFixed(1) + ' MB'
                        : (file.size / 1024).toFixed(0) + ' KB';
                    return {
                        name: file.name,
                        size: sizeStr,
                        isImage: isImg,
                        url: isImg ? URL.createObjectURL(file) : null
                    };
                });
            },
            resetFiles() {
                const input = document.getElementById('attachments');
                if (input) input.value = '';
                this.filePreviews = [];
            },
            getCategoryLabel() {
                if (this.category_id && this.categoriesMap && this.categoriesMap[this.category_id]) {
                    return this.categoriesMap[this.category_id];
                }
                const sel = document.getElementById('category_id');
                if (sel && sel.selectedIndex > 0 && sel.options[sel.selectedIndex]) {
                    return sel.options[sel.selectedIndex].text.trim();
                }
                return '-';
            },
            getFormattedDate() {
                if (!this.incident_date) return '-';
                try {
                    const parts = this.incident_date.split('-');
                    if (parts.length === 3) {
                        const d = new Date(parseInt(parts[0], 10), parseInt(parts[1], 10) - 1, parseInt(parts[2], 10));
                        return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                    }
                    return this.incident_date;
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
                        <button type="button" @click="goToStep(0)" class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition-all"
                            :class="step > 0 ? 'bg-primary-600 text-white' : (step === 0 ? 'bg-primary-600 text-white ring-4 ring-primary-100 dark:ring-[#1A3326]' : 'bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400')">
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
                        <button type="button" @click="goToStep(1)" class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition-all"
                            :class="step > 1 ? 'bg-primary-600 text-white' : (step === 1 ? 'bg-primary-600 text-white ring-4 ring-primary-100 dark:ring-[#1A3326]' : 'bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400')">
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
                        <button type="button" @click="goToStep(2)" class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition-all"
                            :class="step === 2 ? 'bg-primary-600 text-white ring-4 ring-primary-100 dark:ring-[#1A3326]' : 'bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400'">
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
                {{-- Banner Error Step 0 jika validasi gagal --}}
                <div id="step0ErrorBanner" x-show="stepErrors.length > 0" class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-900/60 flex items-start gap-3" style="display: none;">
                    <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="text-xs sm:text-sm text-rose-900 dark:text-rose-200">
                        <p class="font-bold">Mohon lengkapi bagian berikut sebelum melanjutkan ke Bukti &amp; Privasi:</p>
                        <ul class="list-disc list-inside mt-1.5 space-y-1">
                            <template x-for="(err, idx) in stepErrors" :key="idx">
                                <li x-text="err"></li>
                            </template>
                        </ul>
                    </div>
                </div>

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
                                :class="reporter_role === 'korban' ? 'border-primary-500 dark:border-[#289E70] bg-primary-50/80 dark:bg-[#1A3326] ring-1 ring-primary-500 dark:ring-[#289E70]' : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-[#16231D]'">
                                <input type="radio" name="reporter_role" value="korban" x-model="reporter_role" class="mt-1 w-4 h-4 text-primary-600 focus:ring-primary-600 border-slate-300 dark:border-slate-700 dark:bg-slate-900">
                                <div class="ml-3">
                                    <span class="block text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100">Saya Korban</span>
                                    <span class="block text-[11px] sm:text-xs text-slate-500 dark:text-slate-400 mt-0.5">Saya sendiri yang mengalami perlakuan tidak menyenangkan ini.</span>
                                </div>
                            </label>

                            <label class="relative flex items-start p-4 rounded-xl border cursor-pointer transition-all card-hover"
                                :class="reporter_role === 'saksi' ? 'border-primary-500 dark:border-[#289E70] bg-primary-50/80 dark:bg-[#1A3326] ring-1 ring-primary-500 dark:ring-[#289E70]' : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-[#16231D]'">
                                <input type="radio" name="reporter_role" value="saksi" x-model="reporter_role" class="mt-1 w-4 h-4 text-primary-600 focus:ring-primary-600 border-slate-300 dark:border-slate-700 dark:bg-slate-900">
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
                            <span class="text-[11px] font-mono text-slate-500 dark:text-slate-400" x-text="((description || '').length) + '/2000 karakter'"></span>
                        </div>
                        <textarea name="description" id="description" x-model="description" rows="5"
                            placeholder="Ceritakan kejadian yang kamu alami atau saksikan dengan tenang..."
                            class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 py-3 px-3.5 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-600 transition leading-relaxed"></textarea>
                        <div class="flex items-center justify-between mt-1 text-[11px] text-slate-500 dark:text-slate-400">
                            <span>Minimal 10 karakter agar Guru BK mendapat gambaran yang utuh.</span>
                            <span x-show="(description || '').length > 0 && (description || '').length < 10" class="text-amber-600 dark:text-amber-400 font-semibold" style="display: none;">
                                Kurang <span x-text="10 - (description || '').length"></span> karakter lagi
                            </span>
                        </div>
                        <div class="mt-3 p-3 rounded-xl bg-emerald-50/80 dark:bg-[#13241C] border border-emerald-200/80 dark:border-[#22342A] flex items-start gap-2.5 text-xs text-emerald-900 dark:text-[#5AE39D]">
                            <svg class="w-4 h-4 text-emerald-600 dark:text-[#5AE39D] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span><strong>Info Bukti Foto:</strong> Pada langkah berikutnya, kamu dapat menambahkan foto bukti / tangkapan layar jika memilikinya (bersifat opsional).</span>
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
                        @click="nextToStep1()"
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
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100">
                                Foto / Berkas Bukti Pendukung <span class="text-slate-400 font-normal">(opsional, maks 3 file)</span>
                            </label>
                            <button type="button" 
                                    x-show="filePreviews.length > 0" 
                                    @click="resetFiles()" 
                                    class="text-xs text-rose-600 dark:text-rose-400 hover:underline font-semibold"
                                    style="display: none;">
                                Hapus / Ganti Foto
                            </button>
                        </div>
                        
                        <div class="relative border-2 border-dashed border-slate-300 dark:border-slate-700 hover:border-primary-500 dark:hover:border-primary-500 rounded-2xl p-6 text-center transition bg-slate-50/50 dark:bg-slate-900/30">
                            <input type="file" name="attachments[]" id="attachments" multiple accept=".jpg,.jpeg,.png,.pdf"
                                @change="handleFiles($event)"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            
                            <div class="flex flex-col items-center justify-center gap-2">
                                <div class="w-12 h-12 rounded-2xl bg-primary-100/70 dark:bg-primary-950/60 text-primary-600 dark:text-[#5AE39D] flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <p class="text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100">
                                    Klik atau seret foto / dokumen ke sini
                                </p>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                    Format: <strong>JPG, JPEG, PNG, atau PDF</strong> (Maks. 5 MB per berkas)
                                </p>
                            </div>
                        </div>

                        {{-- Visual Thumbnail Previews --}}
                        <div x-show="filePreviews.length > 0" class="mt-4 space-y-2.5" style="display: none;">
                            <div class="flex items-center justify-between text-xs text-slate-700 dark:text-slate-300">
                                <span class="font-bold">Pratinjau Foto &amp; Berkas Bukti:</span>
                                <span class="font-semibold text-primary-700 dark:text-[#5AE39D]" x-text="filePreviews.length + ' dari 3 berkas dipilih'"></span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <template x-for="(f, idx) in filePreviews" :key="idx">
                                    <div class="relative bg-white dark:bg-slate-900/80 rounded-xl border border-slate-200 dark:border-slate-800 p-2.5 flex flex-col gap-2 shadow-2xs overflow-hidden">
                                        {{-- Image Thumbnail --}}
                                        <template x-if="f.isImage">
                                            <div class="w-full h-32 rounded-lg bg-slate-100 dark:bg-slate-800 overflow-hidden flex items-center justify-center border border-slate-100 dark:border-slate-800">
                                                <img :src="f.url" :alt="f.name" class="w-full h-full object-cover">
                                            </div>
                                        </template>
                                        {{-- PDF Document Card --}}
                                        <template x-if="!f.isImage">
                                            <div class="w-full h-32 rounded-lg bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex flex-col items-center justify-center gap-1.5 border border-rose-100 dark:border-rose-900/50">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                <span class="text-[11px] font-bold uppercase tracking-wider">Dokumen PDF</span>
                                            </div>
                                        </template>

                                        {{-- File Name & Size --}}
                                        <div class="min-w-0">
                                            <p class="text-xs font-bold text-slate-800 dark:text-slate-100 truncate" x-text="f.name"></p>
                                            <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5" x-text="f.size"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>
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
                                :class="privacy === 'hidden' ? 'border-primary-500 dark:border-[#289E70] bg-primary-50/80 dark:bg-[#1A3326] ring-1 ring-primary-500 dark:ring-[#289E70]' : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-[#16231D]'">
                                <input type="radio" value="hidden" x-model="privacy" class="mt-1 w-4 h-4 text-primary-600 focus:ring-primary-600 border-slate-300 dark:border-slate-700 dark:bg-slate-900">
                                <div class="ml-3.5 flex-1">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-primary-700 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        <span class="text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100">Rahasiakan Identitas Saya (Pelapor Rahasia - Disarankan)</span>
                                    </div>
                                    <p class="text-[11px] sm:text-xs text-slate-600 dark:text-slate-300 mt-1 leading-relaxed">
                                        Namamu disamarkan sebagai <strong class="text-slate-900 dark:text-slate-100">"Pelapor Rahasia"</strong>. Siswa lain dan pihak umum tidak akan mengetahui identitasmu. Guru BK memegang akses ini secara rahasia dan aman demi keselamatanmu.
                                    </p>
                                </div>
                            </label>

                            {{-- Option 2: Shown --}}
                            <label class="relative flex items-start p-4 rounded-xl border cursor-pointer transition-all card-hover"
                                :class="privacy === 'shown' ? 'border-primary-500 dark:border-[#289E70] bg-primary-50/80 dark:bg-[#1A3326] ring-1 ring-primary-500 dark:ring-[#289E70]' : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-[#16231D]'">
                                <input type="radio" value="shown" x-model="privacy" class="mt-1 w-4 h-4 text-primary-600 focus:ring-primary-600 border-slate-300 dark:border-slate-700 dark:bg-slate-900">
                                <div class="ml-3.5 flex-1">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span class="text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100">Tampilkan Nama Asli Saya</span>
                                    </div>
                                    <p class="text-[11px] sm:text-xs text-slate-600 dark:text-slate-300 mt-1 leading-relaxed">
                                        Namamu ({{ auth()->user()->name }}) akan tercantum pada berkas tindak lanjut Guru BK.
                                    </p>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Jaminan Perlindungan --}}
                    <div class="p-4 rounded-xl bg-amber-50/80 dark:bg-[#261A05] border border-amber-200/80 dark:border-amber-800/80 flex items-start gap-3">
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
                            <p class="font-normal text-slate-800 dark:text-slate-200 whitespace-pre-line leading-relaxed bg-white dark:bg-slate-900 p-3 rounded-lg border border-slate-200 dark:border-slate-800 text-justify [text-align-last:left] break-words" x-text="description || '-'"></p>
                        </div>

                        <div class="py-2.5 flex flex-col gap-2">
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-slate-500 dark:text-slate-400 font-medium">Lampiran Bukti Foto</span>
                                <span class="font-bold text-slate-900 dark:text-slate-100" x-text="filePreviews.length > 0 ? (filePreviews.length + ' file dipilih') : 'Tidak ada foto bukti (opsional)'"></span>
                            </div>
                            <div x-show="filePreviews.length > 0" class="flex flex-wrap gap-2 mt-1">
                                <template x-for="(f, idx) in filePreviews" :key="idx">
                                    <div class="inline-flex items-center gap-2 p-1.5 bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 text-xs">
                                        <template x-if="f.isImage">
                                            <img :src="f.url" :alt="f.name" class="w-8 h-8 rounded object-cover">
                                        </template>
                                        <template x-if="!f.isImage">
                                            <div class="w-8 h-8 rounded bg-rose-100 dark:bg-rose-950/60 text-rose-600 flex items-center justify-center font-bold text-[10px]">PDF</div>
                                        </template>
                                        <span class="max-w-[140px] truncate font-medium text-slate-800 dark:text-slate-200" x-text="f.name"></span>
                                    </div>
                                </template>
                            </div>
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

                    <div class="p-4 rounded-xl bg-primary-50/80 dark:bg-[#13241C] border border-primary-200/80 dark:border-[#22342A] flex items-start gap-3">
                        <svg class="w-5 h-5 text-primary-700 dark:text-[#5AE39D] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <p class="text-xs text-primary-900 dark:text-primary-100 leading-relaxed">
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
