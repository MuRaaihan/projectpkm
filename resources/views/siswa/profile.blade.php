<x-layouts.app title="Profil Siswa">
    <div class="px-4 py-5 sm:px-6 sm:py-6 flex flex-col gap-6 max-w-2xl w-full mx-auto lg:px-8 lg:py-8 animate-fade-in">
        {{-- Breadcrumb & Title --}}
        <div>
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('siswa.dashboard') }}" class="text-xs sm:text-sm font-medium text-slate-500 hover:text-primary-700 dark:hover:text-[#5AE39D] transition-colors">
                    Dashboard Siswa
                </a>
                <span class="text-xs text-slate-400">/</span>
                <span class="text-xs sm:text-sm font-semibold text-primary-700 dark:text-[#5AE39D]">Profil Akun</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">
                Profil Akun
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-1">
                Data resmi peserta didik dan pengelolaan keamanan akun kamu di SIPERKA.
            </p>
        </div>

        {{-- Flash Success Alert --}}
        @if (session('success'))
            <div class="flex items-center gap-2.5 text-emerald-800 dark:text-[#5AE39D] bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/80 rounded-2xl px-4 py-3 shadow-2xs">
                <svg class="w-5 h-5 shrink-0 text-primary-600 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-xs sm:text-sm font-bold">{{ session('success') }}</p>
            </div>
        @endif

        {{-- ── Profile Hero Header Card ──────────────────────── --}}
        <div class="bg-surface-card dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-6 shadow-xs animate-slide-up">
            <div class="flex items-center gap-4">
                {{-- Avatar Initials --}}
                @php
                    $names = explode(' ', trim($user->name));
                    $initials = count($names) >= 2 
                        ? mb_substr($names[0], 0, 1) . mb_substr($names[1], 0, 1)
                        : mb_substr($user->name, 0, 2);
                    $initials = mb_strtoupper($initials);
                @endphp
                <div class="w-16 h-16 rounded-2xl bg-primary-600 text-white flex items-center justify-center shrink-0 shadow-xs font-black text-xl tracking-wider">
                    {{ $initials }}
                </div>

                {{-- Name & Role --}}
                <div class="flex-1 min-w-0">
                    <h2 class="text-lg sm:text-xl font-black text-slate-900 dark:text-slate-100 truncate">
                        {{ $user->name }}
                    </h2>
                    <div class="flex flex-wrap items-center gap-2 mt-1.5">
                        <span class="inline-flex items-center gap-1 bg-primary-50 dark:bg-primary-950/60 border border-primary-200/80 dark:border-primary-800 text-primary-700 dark:text-[#5AE39D] rounded-full px-2.5 py-0.5 text-xs font-bold">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            Siswa Aktif
                        </span>
                        <span class="text-xs font-mono text-slate-500 dark:text-slate-400">
                            NIS: {{ $user->login_id }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Data Peserta Didik (Read-Only) ────────────────── --}}
        <div class="bg-surface-card dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-6 shadow-xs space-y-4">
            <div class="pb-3 border-b border-slate-100 dark:border-slate-800">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    Data Resmi Madrasah
                </h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <div class="p-3.5 bg-slate-50/80 dark:bg-slate-900/50 rounded-xl border border-slate-200/80 dark:border-slate-800">
                    <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block">Nomor Induk Siswa (NIS)</span>
                    <span class="text-sm font-mono font-bold text-slate-900 dark:text-slate-100 mt-1 block">{{ $user->login_id }}</span>
                </div>

                <div class="p-3.5 bg-slate-50/80 dark:bg-slate-900/50 rounded-xl border border-slate-200/80 dark:border-slate-800">
                    <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block">Nama Lengkap</span>
                    <span class="text-sm font-bold text-slate-900 dark:text-slate-100 mt-1 block">{{ $user->name }}</span>
                </div>

                <div class="p-3.5 bg-slate-50/80 dark:bg-slate-900/50 rounded-xl border border-slate-200/80 dark:border-slate-800">
                    <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block">Rombongan Belajar / Kelas</span>
                    <span class="text-sm font-bold text-slate-900 dark:text-slate-100 mt-1 block">{{ $user->schoolClass?->name ?? 'Belum Ditentukan' }}</span>
                </div>

                <div class="p-3.5 bg-slate-50/80 dark:bg-slate-900/50 rounded-xl border border-slate-200/80 dark:border-slate-800">
                    <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider block">Jenis Kelamin</span>
                    <span class="text-sm font-bold text-slate-900 dark:text-slate-100 mt-1 block">
                        {{ $user->gender === 'L' ? 'Laki-laki' : ($user->gender === 'P' ? 'Perempuan' : '-') }}
                    </span>
                </div>
            </div>

            <div class="p-3 rounded-xl bg-slate-50/70 dark:bg-slate-900/30 border border-slate-200/60 dark:border-slate-800 text-[11px] text-slate-500 dark:text-slate-400 flex items-start gap-2">
                <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Jika terdapat kekeliruan pada penulisan nama atau kelas, silakan hubungi bagian Tata Usaha madrasah untuk penyesuaian data induk.</span>
            </div>
        </div>

        {{-- ── Form Ganti Kata Sandi Mandiri (FR-38) ──────────── --}}
        <div 
            x-data="{
                showCurrent: false,
                showNext: false,
                showConfirm: false
            }"
            class="bg-surface-card dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-6 shadow-xs space-y-5"
        >
            <div class="pb-3 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-black text-slate-900 dark:text-slate-100">
                        Keamanan &amp; Kata Sandi
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Perbarui kata sandi akunmu secara mandiri.
                    </p>
                </div>
                <div class="w-9 h-9 rounded-xl bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-[#5AE39D] flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                </div>
            </div>

            <form action="{{ route('siswa.profile.password') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Kata Sandi Saat Ini --}}
                <div>
                    <label for="current_password" class="block text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100 mb-1.5">
                        Kata Sandi Saat Ini <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input :type="showCurrent ? 'text' : 'password'" 
                               name="current_password" 
                               id="current_password" 
                               required 
                               placeholder="Masukkan kata sandi lama"
                               class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 py-2.5 pl-3.5 pr-10 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-600 transition">
                        <button type="button" @click="showCurrent = !showCurrent" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                            <template x-if="showCurrent">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                            </template>
                            <template x-if="!showCurrent">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </template>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kata Sandi Baru --}}
                <div>
                    <label for="password" class="block text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100 mb-1.5">
                        Kata Sandi Baru <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input :type="showNext ? 'text' : 'password'" 
                               name="password" 
                               id="password" 
                               required 
                               placeholder="Minimal 8 karakter"
                               class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 py-2.5 pl-3.5 pr-10 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-600 transition">
                        <button type="button" @click="showNext = !showNext" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                            <template x-if="showNext">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                            </template>
                            <template x-if="!showNext">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </template>
                        </button>
                    </div>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Minimal 8 karakter dan tidak boleh sama dengan NIS kamu.</p>
                    @error('password')
                        <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Kata Sandi Baru --}}
                <div>
                    <label for="password_confirmation" class="block text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100 mb-1.5">
                        Konfirmasi Kata Sandi Baru <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input :type="showConfirm ? 'text' : 'password'" 
                               name="password_confirmation" 
                               id="password_confirmation" 
                               required 
                               placeholder="Ketik ulang kata sandi baru"
                               class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 py-2.5 pl-3.5 pr-10 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-600 transition">
                        <button type="button" @click="showConfirm = !showConfirm" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                            <template x-if="showConfirm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                            </template>
                            <template x-if="!showConfirm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </template>
                        </button>
                    </div>
                </div>

                {{-- Action Button --}}
                <div class="pt-2">
                    <button type="submit" class="w-full sm:w-auto min-h-[44px] px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white text-xs sm:text-sm font-bold shadow-xs transition card-hover flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan Kata Sandi Baru</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- ── Keamanan & Keluar (Sesuai Frontend profil/page.tsx:315-342) ── --}}
        <div class="bg-surface-card dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-2xl overflow-hidden shadow-xs animate-slide-up">
            <div class="px-6 py-3.5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/40">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                    Sesi &amp; Keamanan Akun
                </p>
            </div>

            <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-bold text-slate-900 dark:text-slate-100">
                        Keluar dari Sesi
                    </p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Pastikan seluruh laporan penting telah selesai dikirim sebelum keluar.
                    </p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline-flex shrink-0">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-rose-300 dark:border-rose-900 bg-rose-50/60 dark:bg-rose-950/40 text-rose-700 dark:text-rose-400 hover:bg-rose-100 dark:hover:bg-rose-900/40 text-xs font-bold transition-colors cursor-pointer shadow-2xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>Keluar Akun</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
