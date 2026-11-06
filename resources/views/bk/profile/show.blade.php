<x-layouts.app title="Profil Guru BK">
    <div class="px-4 py-5 sm:px-6 sm:py-6 flex flex-col gap-6 max-w-2xl w-full mx-auto lg:px-8 lg:py-8 animate-fade-in">
        {{-- ── Breadcrumb & Title ───────────────────────────── --}}
        <div>
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('bk.dashboard') }}" class="text-xs sm:text-sm font-medium text-slate-500 hover:text-primary-700 dark:hover:text-[#5AE39D] transition-colors">
                    Dashboard Guru BK
                </a>
                <span class="text-xs text-slate-400">/</span>
                <span class="text-xs sm:text-sm font-semibold text-primary-700 dark:text-[#5AE39D]">Profil Akun</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">
                Profil Guru BK
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-1">
                Kelola informasi data petugas konseling dan pengaturan keamanan akun.
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

                <div class="flex-1 min-w-0">
                    <h2 class="text-lg sm:text-xl font-black text-slate-900 dark:text-slate-100 truncate">
                        {{ $user->name }}
                    </h2>
                    <div class="flex flex-wrap items-center gap-2 mt-1.5">
                        <span class="inline-flex items-center gap-1 bg-primary-50 dark:bg-primary-950/60 border border-primary-200/80 dark:border-primary-800 text-primary-700 dark:text-[#5AE39D] rounded-full px-2.5 py-0.5 text-xs font-bold">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            Guru BK / Konselor
                        </span>
                        <span class="text-xs font-mono text-slate-500 dark:text-slate-400">
                            NIP/ID: {{ $user->login_id }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Form Data Diri Guru BK ───────────────────────── --}}
        <div class="bg-surface-card dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-6 shadow-xs space-y-4">
            <div class="pb-3 border-b border-slate-100 dark:border-slate-800">
                <h3 class="text-base font-black text-slate-900 dark:text-slate-100">
                    Informasi Profil Petugas
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                    Data resmi petugas konseling madrasah.
                </p>
            </div>

            <form method="POST" action="{{ route('bk.profile.update') }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="p-3.5 bg-slate-50/80 dark:bg-slate-900/50 rounded-xl border border-slate-200/80 dark:border-slate-800">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 block">NIP / ID Login</span>
                    <span class="text-sm font-mono font-bold text-slate-900 dark:text-slate-100 mt-1 block">{{ $user->login_id }}</span>
                    <span class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 block">ID login madrasah dikelola oleh Admin Master.</span>
                </div>

                <div>
                    <label for="name" class="block text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100 mb-1.5">
                        Nama Lengkap &amp; Gelar <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required maxlength="255"
                        class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 py-2.5 px-3.5 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 transition">
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100 mb-1.5">
                        Nomor Kontak / WhatsApp Petugas
                    </label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" maxlength="20" placeholder="Contoh: 081234567890"
                        class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 py-2.5 px-3.5 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 transition">
                    @error('phone')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white text-xs sm:text-sm font-bold shadow-xs transition active:scale-[0.98] cursor-pointer">
                        Simpan Perubahan Profil
                    </button>
                </div>
            </form>
        </div>

        {{-- ── Kartu 2FA (FR-08) ────────────────────────────── --}}
        <div class="bg-surface-card dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-6 shadow-xs space-y-4">
            <div class="pb-3 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-black text-slate-900 dark:text-slate-100">
                        Autentikasi Dua Faktor (2FA)
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Lapisan keamanan ekstra menggunakan aplikasi authenticator standar.
                    </p>
                </div>
                <div class="w-9 h-9 rounded-xl {{ $user->hasTwoFactorEnabled() ? 'bg-primary-100 dark:bg-primary-950/70 text-primary-700 dark:text-[#5AE39D]' : 'bg-slate-100 dark:bg-slate-800 text-slate-500' }} flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 rounded-xl border {{ $user->hasTwoFactorEnabled() ? 'bg-primary-50/70 dark:bg-primary-950/40 border-primary-200 dark:border-primary-900' : 'bg-slate-50/80 dark:bg-slate-900/50 border-slate-200 dark:border-slate-800' }}">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100">Status 2FA:</span>
                        @if ($user->hasTwoFactorEnabled())
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-primary-100 dark:bg-primary-950/70 text-primary-800 dark:text-[#5AE39D] border border-primary-300 dark:border-primary-800">
                                Aktif & Terlindungi
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                Belum Aktif
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        {{ $user->hasTwoFactorEnabled() ? 'Akun konseling Anda diverifikasi dengan kode OTP setiap kali masuk.' : 'Tingkatkan keamanan akun dengan mengaktifkan TOTP 2FA.' }}
                    </p>
                </div>

                <a href="{{ route('two-factor.setup') }}" 
                   class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-bold transition shrink-0 {{ $user->hasTwoFactorEnabled() ? 'bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' : 'bg-primary-600 hover:bg-primary-700 text-white shadow-xs' }}">
                    <span>{{ $user->hasTwoFactorEnabled() ? 'Kelola 2FA & Cadangan' : 'Aktifkan 2FA Sekarang' }}</span>
                </a>
            </div>
        </div>

        {{-- ── Form Ganti Kata Sandi (FR-30) ─────────────────── --}}
        <div class="bg-surface-card dark:bg-[#16231D] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-6 shadow-xs space-y-4">
            <div class="pb-3 border-b border-slate-100 dark:border-slate-800">
                <h3 class="text-base font-black text-slate-900 dark:text-slate-100">
                    Ganti Kata Sandi
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                    Perbarui kata sandi akun secara mandiri untuk menjaga keamanan data konseling.
                </p>
            </div>

            <form method="POST" action="{{ route('bk.profile.password') }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100 mb-1.5">
                        Kata Sandi Saat Ini <span class="text-rose-500">*</span>
                    </label>
                    <input type="password" id="current_password" name="current_password" required
                        class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 py-2.5 px-3.5 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 transition">
                    @error('current_password')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100 mb-1.5">
                        Kata Sandi Baru <span class="text-rose-500">*</span>
                    </label>
                    <input type="password" id="password" name="password" required minlength="8" placeholder="Minimal 8 karakter"
                        class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 py-2.5 px-3.5 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 transition">
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Minimal 8 karakter dan tidak boleh sama dengan NIP Anda.</p>
                    @error('password')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100 mb-1.5">
                        Konfirmasi Kata Sandi Baru <span class="text-rose-500">*</span>
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Ketik ulang kata sandi baru"
                        class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 dark:border-slate-700 py-2.5 px-3.5 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-600 transition">
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white text-xs sm:text-sm font-bold shadow-xs transition active:scale-[0.98] cursor-pointer">
                        Simpan Kata Sandi Baru
                    </button>
                </div>
            </form>
        </div>

        {{-- ── Keamanan & Keluar (Sesuai Frontend guru-bk/profil/page.tsx:342-353) ── --}}
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
                        Pastikan seluruh data tindak lanjut konseling telah tersimpan sebelum keluar.
                    </p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline-flex shrink-0">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-rose-300 dark:border-rose-900 bg-rose-50/60 dark:bg-rose-950/40 text-rose-700 dark:text-rose-400 hover:bg-rose-100 dark:hover:bg-rose-900/40 text-xs font-bold transition-colors cursor-pointer shadow-2xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>Keluar dari Akun</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
