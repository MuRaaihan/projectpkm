<x-layouts.app title="Dashboard Master Admin">
    <div class="space-y-6">
        {{-- Sambutan Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-slate-200">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <x-badge variant="purple">Master Administrator</x-badge>
                    @if ($active_year)
                        <span class="text-xs font-mono font-semibold text-slate-500">
                            T.A. {{ $active_year->name }}
                        </span>
                    @endif
                </div>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                    Selamat datang, {{ auth()->user()->name }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Panel administrasi pengelolaan akun madrasah dan data master SISPERKA MTs Soebono Mantofani.
                </p>
            </div>
        </div>

        {{-- Pemberitahuan Hak Akses Master --}}
        <div class="p-4 rounded-xl bg-purple-50/60 border border-purple-200/80 text-xs text-purple-900 leading-relaxed flex items-start gap-3">
            <svg class="w-5 h-5 text-purple-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <strong class="font-semibold block mb-0.5">Kebijakan Privasi & Batas Kerahasiaan Akun Master:</strong>
                Sesuai aturan keamanan SISPERKA, akun Master mengelola akun pengguna, kelas, dan audit sistem, serta <strong>TIDAK MEMILIKI HAK AKSES</strong> untuk melihat isi laporan perundungan maupun identitas pelapor. Kerahasiaan pelapor dilindungi sepenuhnya oleh sistem.
            </div>
        </div>

        {{-- Kartu Ringkasan Metrik --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <x-card class="p-4!">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Siswa Terdaftar</span>
                <span class="text-2xl font-bold text-purple-700 mt-1 block">{{ $students_count }}</span>
                <span class="text-xs text-slate-400 mt-1 block">Peserta didik MTs</span>
            </x-card>

            <x-card class="p-4!">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Konselor Guru BK</span>
                <span class="text-2xl font-bold text-emerald-600 mt-1 block">{{ $bk_count }}</span>
                <span class="text-xs text-slate-400 mt-1 block">Penanggung jawab laporan</span>
            </x-card>

            <x-card class="p-4!">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Rombongan Belajar</span>
                <span class="text-2xl font-bold text-slate-900 mt-1 block">{{ $classes_count }}</span>
                <span class="text-xs text-slate-400 mt-1 block">Kelas aktif madrasah</span>
            </x-card>

            <x-card class="p-4!">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Tahun Ajaran Aktif</span>
                <span class="text-base font-bold text-slate-800 mt-2 block">{{ $active_year?->name ?? 'Belum Diatur' }}</span>
                <span class="text-xs text-slate-400 block">{{ $active_year ? 'Periode Aktif' : 'Pilih tahun aktif' }}</span>
            </x-card>
        </div>

        {{-- Menu Modul Master --}}
        <div>
            <h2 class="text-sm font-bold text-slate-900 mb-3">Menu Administrasi & Pengelolaan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                {{-- Kelola Akun Siswa --}}
                <a href="{{ route('master.students.index') }}" class="p-4 rounded-xl border border-slate-200 bg-white hover:border-purple-300 hover:shadow-xs transition group">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 rounded-lg bg-purple-50 text-purple-700 group-hover:bg-purple-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800 group-hover:text-purple-700 transition">Akun Siswa</h3>
                            <p class="text-xs text-slate-500">Kelola akun, reset sandi, dan arsip siswa.</p>
                        </div>
                    </div>
                </a>

                {{-- Kelola Guru BK --}}
                <a href="{{ route('master.bk-users.index') }}" class="p-4 rounded-xl border border-slate-200 bg-white hover:border-purple-300 hover:shadow-xs transition group">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 rounded-lg bg-emerald-50 text-emerald-700 group-hover:bg-emerald-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800 group-hover:text-emerald-700 transition">Akun Guru BK</h3>
                            <p class="text-xs text-slate-500">Kelola konselor penanggung jawab laporan.</p>
                        </div>
                    </div>
                </a>

                {{-- Impor Massal Excel --}}
                <a href="{{ route('master.import.index') }}" class="p-4 rounded-xl border border-slate-200 bg-white hover:border-purple-300 hover:shadow-xs transition group">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 rounded-lg bg-sky-50 text-sky-700 group-hover:bg-sky-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800 group-hover:text-sky-700 transition">Impor Excel Massal</h3>
                            <p class="text-xs text-slate-500">Tambah ~400 siswa sekaligus via file .xlsx.</p>
                        </div>
                    </div>
                </a>

                {{-- Operasi Massal Kelas --}}
                <a href="{{ route('master.class-operations.index') }}" class="p-4 rounded-xl border border-slate-200 bg-white hover:border-purple-300 hover:shadow-xs transition group">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 rounded-lg bg-amber-50 text-amber-700 group-hover:bg-amber-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800 group-hover:text-amber-700 transition">Operasi Massal Kelas</h3>
                            <p class="text-xs text-slate-500">Kenaikan kelas tahunan & arsip alumni.</p>
                        </div>
                    </div>
                </a>

                {{-- Data Kelas --}}
                <a href="{{ route('master.classes.index') }}" class="p-4 rounded-xl border border-slate-200 bg-white hover:border-purple-300 hover:shadow-xs transition group">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 rounded-lg bg-indigo-50 text-indigo-700 group-hover:bg-indigo-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800 group-hover:text-indigo-700 transition">Data Rombel Kelas</h3>
                            <p class="text-xs text-slate-500">Kelola daftar kelas dan jenjang tingkat.</p>
                        </div>
                    </div>
                </a>

                {{-- Data Tahun Ajaran --}}
                <a href="{{ route('master.academic-years.index') }}" class="p-4 rounded-xl border border-slate-200 bg-white hover:border-purple-300 hover:shadow-xs transition group">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 rounded-lg bg-rose-50 text-rose-700 group-hover:bg-rose-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800 group-hover:text-rose-700 transition">Tahun Ajaran</h3>
                            <p class="text-xs text-slate-500">Atur periode aktif dan riwayat tahun ajaran.</p>
                        </div>
                    </div>
                </a>

                {{-- Log Aktivitas & Audit --}}
                <a href="{{ route('master.activity-logs.index') }}" class="p-4 rounded-xl border border-slate-200 bg-white hover:border-purple-300 hover:shadow-xs transition group sm:col-span-2 lg:col-span-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 rounded-lg bg-slate-100 text-slate-700 group-hover:bg-slate-200 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800 group-hover:text-purple-700 transition">Log Aktivitas & Audit Keamanan</h3>
                                <p class="text-xs text-slate-500">Pantau seluruh catatan login, perubahan akun, dan audit keamanan sistem (read-only).</p>
                            </div>
                        </div>
                        <span class="text-xs font-semibold text-purple-700 hidden sm:inline">&rarr; Buka Log</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
