<x-layouts.app title="Dashboard Master Admin">
    <div class="px-4 py-5 sm:px-6 sm:py-6 flex flex-col gap-6 max-w-6xl w-full mx-auto lg:px-8 lg:py-8 animate-fade-in">
        {{-- ── Welcome Header ───────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200/80 dark:border-slate-800">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-purple-100 dark:bg-purple-950/70 text-purple-800 dark:text-purple-300 text-xs font-bold">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Master Administrator
                    </span>
                    @if ($active_year)
                        <span class="text-xs font-mono font-bold text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-2.5 py-1 rounded-lg">
                            T.A. {{ $active_year->name }}
                        </span>
                    @endif
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">
                    Selamat datang, {{ auth()->user()->name }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-1">
                    Panel administrasi sistem, tata kelola akun pengguna, dan audit keamanan operasional SIPERKA.
                </p>
            </div>
        </div>

        {{-- ── Pemberitahuan Batas Privasi Akun Master (Golden Rule) ── --}}
        <div class="p-4 sm:p-5 rounded-2xl bg-primary-50/80 dark:bg-[#0E2018] border border-primary-200 dark:border-primary-900 text-xs sm:text-sm text-primary-900 dark:text-primary-200 leading-relaxed flex items-start gap-3.5 shadow-2xs">
            <svg class="w-5 h-5 text-primary-700 dark:text-[#5AE39D] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <div>
                <strong class="font-bold block mb-0.5 text-primary-950 dark:text-white">Kebijakan Privasi &amp; Batas Akses Akun Master:</strong>
                Sesuai arsitektur keamanan SIPERKA, akun Master berfokus pada manajemen akun, kelas, dan log audit, serta <strong>TIDAK MEMILIKI AKSES</strong> ke isi laporan maupun identitas pelapor individual demi melindungi hak privasi anak.
            </div>
        </div>

        {{-- ── Matriks Pengguna & Layanan (KPI Cards) ───────── --}}
        <section aria-labelledby="users-kpi-heading" class="animate-slide-up">
            <div class="flex items-center justify-between mb-3.5">
                <h2 id="users-kpi-heading" class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    Matriks Pengguna &amp; Data Pokok
                </h2>
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                    {{ $students_count + $bk_count }} Akun Terdaftar
                </span>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Total Siswa --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs flex flex-col justify-between card-hover">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Siswa</span>
                        <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-100 font-mono block">{{ $students_count }}</span>
                        <span class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 block">Peserta didik terdaftar</span>
                    </div>
                </div>

                {{-- Guru BK --}}
                <div class="bg-primary-50/60 dark:bg-[#153222] rounded-2xl border border-primary-200/80 dark:border-primary-900/60 p-5 shadow-xs flex flex-col justify-between card-hover">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-primary-800 dark:text-[#5AE39D]">Guru BK</span>
                        <div class="w-9 h-9 rounded-xl bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-[#5AE39D] flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-2xl sm:text-3xl font-black text-primary-950 dark:text-[#5AE39D] font-mono block">{{ $bk_count }}</span>
                        <span class="text-[11px] text-primary-800/80 dark:text-primary-300/80 mt-0.5 block">Konselor penanggung jawab</span>
                    </div>
                </div>

                {{-- Rombongan Belajar --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs flex flex-col justify-between card-hover">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Rombel / Kelas</span>
                        <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-100 font-mono block">{{ $classes_count }}</span>
                        <span class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 block">Kelas aktif madrasah</span>
                    </div>
                </div>

                {{-- Tahun Ajaran Aktif --}}
                <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs flex flex-col justify-between card-hover">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Tahun Ajaran</span>
                        <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-lg sm:text-xl font-black text-slate-900 dark:text-slate-100 block truncate">{{ $active_year?->name ?? 'Belum Diatur' }}</span>
                        <span class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 block">{{ $active_year ? 'Periode aktif' : 'Atur tahun ajaran' }}</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── Statistik Laporan Agregat (FR-15: Numerik Saja) ── --}}
        @if(isset($report_stats))
            <section aria-labelledby="aggregate-stats-heading" class="space-y-4 pt-1">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 id="aggregate-stats-heading" class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                            Statistik Agregat Laporan Perundungan
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                            Data numerik kumulatif (tanpa isi laporan atau nama siswa).
                        </p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-primary-50 dark:bg-primary-950/60 text-primary-800 dark:text-[#5AE39D] border border-primary-200 dark:border-primary-900">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#B8E34B]"></span>
                        Agregat Terlindungi
                    </span>
                </div>

                {{-- Angka Ringkasan --}}
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-4 shadow-xs">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 block">Total Laporan</span>
                        <span class="text-2xl font-black text-slate-900 dark:text-slate-100 mt-1 block font-mono">{{ $report_stats['total_reports'] }}</span>
                        <span class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 block">Akumulasi laporan</span>
                    </div>

                    <div class="bg-emerald-50/60 dark:bg-[#153222] rounded-2xl border border-emerald-200/80 dark:border-emerald-800/80 p-4 shadow-xs">
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 dark:text-[#5AE39D] block">Kasus Selesai</span>
                        <span class="text-2xl font-black text-emerald-950 dark:text-[#5AE39D] mt-1 block font-mono">{{ $report_stats['resolved_reports'] }}</span>
                        <span class="text-[11px] text-emerald-800/80 dark:text-emerald-200/80 mt-0.5 block">Tuntas ditangani Guru BK</span>
                    </div>

                    <div class="bg-amber-50/60 dark:bg-[#261A05] rounded-2xl border border-amber-200/80 dark:border-amber-800/80 p-4 shadow-xs">
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-800 dark:text-[#FAD46B] block">Dalam Proses</span>
                        <span class="text-2xl font-black text-amber-950 dark:text-[#FAD46B] mt-1 block font-mono">{{ $report_stats['active_reports'] }}</span>
                        <span class="text-[11px] text-amber-800/80 dark:text-amber-200/80 mt-0.5 block">Dalam mediasi / konseling</span>
                    </div>

                    <div class="bg-rose-50/60 dark:bg-[#251012] rounded-2xl border border-rose-200/80 dark:border-rose-900/60 p-4 shadow-xs">
                        <span class="text-xs font-bold uppercase tracking-wider text-rose-800 dark:text-rose-300 block">Laporan Baru</span>
                        <span class="text-2xl font-black text-rose-950 dark:text-rose-200 mt-1 block font-mono">{{ $report_stats['new_reports'] }}</span>
                        <span class="text-[11px] text-rose-800/80 dark:text-rose-300/80 mt-0.5 block">Menunggu verifikasi BK</span>
                    </div>
                </div>

                {{-- Dua Grafik Ringkas Master --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs">
                        <div class="pb-3 border-b border-slate-100 dark:border-slate-800 mb-3">
                            <h3 class="text-sm font-black text-slate-900 dark:text-slate-100">Tren Laporan Bulanan</h3>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Fluktuasi jumlah laporan 6 bulan terakhir</p>
                        </div>
                        <div class="relative h-56 w-full">
                            <canvas id="masterTrendChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs">
                        <div class="pb-3 border-b border-slate-100 dark:border-slate-800 mb-3">
                            <h3 class="text-sm font-black text-slate-900 dark:text-slate-100">Sebaran Kategori Kasus</h3>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Persentase jenis perundungan</p>
                        </div>
                        <div class="relative h-56 w-full flex items-center justify-center">
                            <canvas id="masterCategoryChart"></canvas>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- ── Menu Modul Master (Quick Access Hub) ─────────── --}}
        <section aria-labelledby="modules-heading" class="space-y-3.5 pt-1">
            <h2 id="modules-heading" class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                Menu Administrasi &amp; Pengelolaan
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                {{-- Kelola Akun Siswa --}}
                <a href="{{ route('master.students.index') }}" class="p-5 rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-surface-card dark:bg-[#16231D] hover:border-primary-500 dark:hover:border-primary-500 hover:shadow-xs transition card-hover group min-h-[44px]">
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-primary-100/80 dark:bg-primary-950/70 text-primary-700 dark:text-[#5AE39D] group-hover:scale-105 transition-transform flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900 dark:text-slate-100 group-hover:text-primary-700 dark:group-hover:text-[#5AE39D] transition-colors">Akun Siswa</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Kelola akun, reset kata sandi, dan arsip.</p>
                        </div>
                    </div>
                </a>

                {{-- Kelola Guru BK --}}
                <a href="{{ route('master.bk-users.index') }}" class="p-5 rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-surface-card dark:bg-[#16231D] hover:border-primary-500 dark:hover:border-primary-500 hover:shadow-xs transition card-hover group min-h-[44px]">
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-emerald-100/80 dark:bg-emerald-950/70 text-emerald-700 dark:text-[#5AE39D] group-hover:scale-105 transition-transform flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900 dark:text-slate-100 group-hover:text-primary-700 dark:group-hover:text-[#5AE39D] transition-colors">Akun Guru BK</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Petugas konseling madrasah & 2FA.</p>
                        </div>
                    </div>
                </a>

                {{-- Impor Pengguna Excel --}}
                <a href="{{ route('master.import.index') }}" class="p-5 rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-surface-card dark:bg-[#16231D] hover:border-primary-500 dark:hover:border-primary-500 hover:shadow-xs transition card-hover group min-h-[44px]">
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-sky-100/80 dark:bg-sky-950/70 text-sky-700 dark:text-sky-300 group-hover:scale-105 transition-transform flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900 dark:text-slate-100 group-hover:text-primary-700 dark:group-hover:text-[#5AE39D] transition-colors">Impor Excel</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Unggah data massal siswa & guru BK.</p>
                        </div>
                    </div>
                </a>

                {{-- Rombongan Belajar --}}
                <a href="{{ route('master.classes.index') }}" class="p-5 rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-surface-card dark:bg-[#16231D] hover:border-primary-500 dark:hover:border-primary-500 hover:shadow-xs transition card-hover group min-h-[44px]">
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-amber-100/80 dark:bg-amber-950/70 text-amber-800 dark:text-[#FAD46B] group-hover:scale-105 transition-transform flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900 dark:text-slate-100 group-hover:text-primary-700 dark:group-hover:text-[#5AE39D] transition-colors">Data Kelas</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Kelola kelas per tahun ajaran.</p>
                        </div>
                    </div>
                </a>

                {{-- Tahun Ajaran --}}
                <a href="{{ route('master.academic-years.index') }}" class="p-5 rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-surface-card dark:bg-[#16231D] hover:border-primary-500 dark:hover:border-primary-500 hover:shadow-xs transition card-hover group min-h-[44px]">
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-purple-100/80 dark:bg-purple-950/70 text-purple-700 dark:text-purple-300 group-hover:scale-105 transition-transform flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900 dark:text-slate-100 group-hover:text-primary-700 dark:group-hover:text-[#5AE39D] transition-colors">Tahun Ajaran</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Kelola periode aktif madrasah.</p>
                        </div>
                    </div>
                </a>

                {{-- Operasi Massal Kelas --}}
                <a href="{{ route('master.class-operations.index') }}" class="p-5 rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-surface-card dark:bg-[#16231D] hover:border-primary-500 dark:hover:border-primary-500 hover:shadow-xs transition card-hover group min-h-[44px]">
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-indigo-100/80 dark:bg-indigo-950/70 text-indigo-700 dark:text-indigo-300 group-hover:scale-105 transition-transform flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900 dark:text-slate-100 group-hover:text-primary-700 dark:group-hover:text-[#5AE39D] transition-colors">Operasi Kelas</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Kenaikan kelas & arsip lulusan.</p>
                        </div>
                    </div>
                </a>

                {{-- Log Aktivitas Keamanan --}}
                <a href="{{ route('master.activity-logs.index') }}" class="p-5 rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-surface-card dark:bg-[#16231D] hover:border-primary-500 dark:hover:border-primary-500 hover:shadow-xs transition card-hover group min-h-[44px]">
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-rose-100/80 dark:bg-rose-950/70 text-rose-700 dark:text-rose-300 group-hover:scale-105 transition-transform flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900 dark:text-slate-100 group-hover:text-primary-700 dark:group-hover:text-[#5AE39D] transition-colors">Audit &amp; Log</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Catatan aktivitas & jejak keamanan.</p>
                        </div>
                    </div>
                </a>

                {{-- Pengaturan Website --}}
                <a href="{{ route('master.settings.index') }}" class="p-5 rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-surface-card dark:bg-[#16231D] hover:border-primary-500 dark:hover:border-primary-500 hover:shadow-xs transition card-hover group min-h-[44px]">
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-teal-100/80 dark:bg-teal-950/70 text-teal-700 dark:text-teal-300 group-hover:scale-105 transition-transform flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900 dark:text-slate-100 group-hover:text-primary-700 dark:group-hover:text-[#5AE39D] transition-colors">Pengaturan Web</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Kontak darurat & teks beranda.</p>
                        </div>
                    </div>
                </a>

                {{-- Laporan Periodik Otomatis --}}
                <a href="{{ route('periodic-reports.index') }}" class="p-5 rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-surface-card dark:bg-[#16231D] hover:border-primary-500 dark:hover:border-primary-500 hover:shadow-xs transition card-hover group min-h-[44px]">
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-orange-100/80 dark:bg-orange-950/70 text-orange-700 dark:text-orange-300 group-hover:scale-105 transition-transform flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900 dark:text-slate-100 group-hover:text-primary-700 dark:group-hover:text-[#5AE39D] transition-colors">Laporan Periodik</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Rekap otomatis bulanan & semester.</p>
                        </div>
                    </div>
                </a>
            </div>
        </section>
    </div>

    @if(isset($report_stats))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof Chart === 'undefined') return;

                Chart.defaults.font.family = '"Inter", ui-sans-serif, system-ui, -apple-system, sans-serif';

                let masterTrendChart, masterCategoryChart;

                function getMasterTheme() {
                    const isDark = document.documentElement.classList.contains('dark');
                    return {
                        isDark: isDark,
                        textColor: isDark ? '#9EB3A8' : '#64748B',
                        headingColor: isDark ? '#F2F7F4' : '#18241E',
                        gridColor: isDark ? 'rgba(34, 52, 42, 0.6)' : 'rgba(226, 232, 240, 0.6)',
                        doughnutBorder: isDark ? '#16231D' : '#ffffff',
                        primaryColor: isDark ? '#5AE39D' : '#176B4D',
                        pointBg: isDark ? '#16231D' : '#ffffff',
                        tooltipBg: isDark ? '#14201A' : '#ffffff',
                        tooltipText: isDark ? '#F2F7F4' : '#18241E',
                        tooltipBorder: isDark ? '#22342A' : '#E2E1D9',
                    };
                }

                function createOrUpdateMasterCharts() {
                    const theme = getMasterTheme();

                    // 1. Master Trend Line Chart
                    const trendCtx = document.getElementById('masterTrendChart');
                    if (trendCtx) {
                        const ctx = trendCtx.getContext('2d');
                        const gradient = ctx.createLinearGradient(0, 0, 0, 200);
                        gradient.addColorStop(0, theme.isDark ? 'rgba(90, 227, 157, 0.22)' : 'rgba(23, 107, 77, 0.2)');
                        gradient.addColorStop(1, 'rgba(23, 107, 77, 0.0)');

                        if (masterTrendChart) {
                            masterTrendChart.data.datasets[0].borderColor = theme.primaryColor;
                            masterTrendChart.data.datasets[0].backgroundColor = gradient;
                            masterTrendChart.data.datasets[0].pointBorderColor = theme.primaryColor;
                            masterTrendChart.data.datasets[0].pointBackgroundColor = theme.pointBg;
                            masterTrendChart.options.scales.x.ticks.color = theme.textColor;
                            masterTrendChart.options.scales.x.grid.color = theme.gridColor;
                            masterTrendChart.options.scales.y.ticks.color = theme.textColor;
                            masterTrendChart.options.scales.y.grid.color = theme.gridColor;
                            masterTrendChart.update();
                        } else {
                            masterTrendChart = new Chart(trendCtx, {
                                type: 'line',
                                data: {
                                    labels: {!! json_encode(array_column($report_stats['monthly_trend'], 'label')) !!},
                                    datasets: [{
                                        label: 'Kasus',
                                        data: {!! json_encode(array_column($report_stats['monthly_trend'], 'count')) !!},
                                        borderColor: theme.primaryColor,
                                        backgroundColor: gradient,
                                        borderWidth: 2.5,
                                        fill: true,
                                        tension: 0.35,
                                        pointBackgroundColor: theme.pointBg,
                                        pointBorderColor: theme.primaryColor,
                                        pointBorderWidth: 2,
                                        pointRadius: 4,
                                        pointHoverRadius: 6
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: { display: false },
                                        tooltip: {
                                            backgroundColor: theme.tooltipBg,
                                            titleColor: theme.tooltipText,
                                            bodyColor: theme.tooltipText,
                                            borderColor: theme.tooltipBorder,
                                            borderWidth: 1,
                                            padding: 10
                                        }
                                    },
                                    scales: {
                                        x: {
                                            ticks: { color: theme.textColor, font: { size: 10.5, weight: '500' } },
                                            grid: { color: theme.gridColor }
                                        },
                                        y: {
                                            beginAtZero: true,
                                            ticks: { precision: 0, color: theme.textColor, font: { size: 10.5, weight: '500' } },
                                            grid: { color: theme.gridColor }
                                        }
                                    }
                                }
                            });
                        }
                    }

                    // 2. Master Category Doughnut Chart
                    const catCtx = document.getElementById('masterCategoryChart');
                    if (catCtx) {
                        if (masterCategoryChart) {
                            masterCategoryChart.data.datasets[0].borderColor = theme.doughnutBorder;
                            masterCategoryChart.options.plugins.legend.labels.color = theme.headingColor;
                            masterCategoryChart.update();
                        } else {
                            masterCategoryChart = new Chart(catCtx, {
                                type: 'doughnut',
                                data: {
                                    labels: {!! json_encode(array_column($report_stats['category_distribution'], 'label')) !!},
                                    datasets: [{
                                        data: {!! json_encode(array_column($report_stats['category_distribution'], 'count')) !!},
                                        backgroundColor: ['#176B4D', '#289E70', '#B8E34B', '#FAD46B', '#0284C7', '#8B5CF6', '#F43F5E', '#94A3B8'],
                                        borderWidth: 2,
                                        borderColor: theme.doughnutBorder
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    cutout: '66%',
                                    plugins: {
                                        legend: {
                                            position: 'bottom',
                                            labels: {
                                                boxWidth: 9,
                                                boxHeight: 9,
                                                borderRadius: 2,
                                                color: theme.headingColor,
                                                font: { size: 10, weight: '500' },
                                                padding: 8
                                            }
                                        },
                                        tooltip: {
                                            backgroundColor: theme.tooltipBg,
                                            titleColor: theme.tooltipText,
                                            bodyColor: theme.tooltipText,
                                            borderColor: theme.tooltipBorder,
                                            borderWidth: 1,
                                            padding: 10
                                        }
                                    }
                                }
                            });
                        }
                    }
                }

                // Inisialisasi awal
                createOrUpdateMasterCharts();

                // Observer realtime mode gelap
                const observer = new MutationObserver(function (mutations) {
                    mutations.forEach(function (mutation) {
                        if (mutation.attributeName === 'class') {
                            createOrUpdateMasterCharts();
                        }
                    });
                });
                observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
            });
        </script>
    @endif
</x-layouts.app>
