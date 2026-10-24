<x-layouts.app title="Konfirmasi Kenaikan Kelas">
    <div class="px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8 max-w-4xl w-full mx-auto space-y-6 animate-fade-in">
        {{-- Breadcrumb & Judul --}}
        <div>
            <div class="flex items-center gap-2 mb-1.5 text-xs">
                <a href="{{ route('master.dashboard') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 transition">Master</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <a href="{{ route('master.class-operations.index') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 transition">Operasi Massal Kelas</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <span class="font-semibold text-emerald-600 dark:text-emerald-400">Pratinjau Kenaikan Kelas</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100">
                Pratinjau Kenaikan / Perpindahan Kelas
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Periksa daftar nama siswa sebelum mengonfirmasi perpindahan massal ke kelas baru.
            </p>
        </div>

        {{-- Ringkasan Perpindahan --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="p-5 rounded-2xl bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 shadow-xs">
                <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Kelas Asal (Sumber)</span>
                <div class="mt-2">
                    <p class="text-xl font-bold text-slate-900 dark:text-slate-100">Kelas {{ $fromClass->name }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Tahun Ajaran: {{ $fromClass->academicYear?->name ?? '-' }} · Tingkat {{ $fromClass->grade_level }}</p>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-emerald-50/70 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/80 shadow-xs">
                <span class="text-[11px] font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider">Kelas Tujuan Baru</span>
                <div class="mt-2">
                    <p class="text-xl font-bold text-emerald-700 dark:text-emerald-400">Kelas {{ $toClass->name }}</p>
                    <p class="text-xs text-emerald-600/80 dark:text-emerald-400/80 mt-0.5">Tahun Ajaran: {{ $toClass->academicYear?->name ?? '-' }} · Tingkat {{ $toClass->grade_level }}</p>
                </div>
            </div>
        </div>

        {{-- Alert Info --}}
        <div class="p-4 bg-emerald-50 dark:bg-emerald-950/40 rounded-2xl border border-emerald-200 dark:border-emerald-800 text-xs sm:text-sm text-emerald-900 dark:text-emerald-200 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Total siswa yang akan dipindahkan ke <strong>Kelas {{ $toClass->name }}</strong>: <strong>{{ $students->count() }} orang</strong>.</span>
            </div>
        </div>

        {{-- Tabel Siswa --}}
        <div class="bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-xs">
            <x-table :headers="['No', 'NIS Siswa', 'Nama Lengkap Siswa', 'Jenis Kelamin']">
                @foreach ($students as $index => $s)
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition">
                        <td class="px-4 py-3 sm:px-6 text-xs text-slate-400">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-4 py-3 sm:px-6 font-mono text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100">
                            {{ $s->login_id }}
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-xs sm:text-sm font-semibold text-slate-900 dark:text-slate-100">
                            {{ $s->name }}
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-xs">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold {{ $s->gender === 'L' ? 'bg-sky-50 text-sky-700 dark:bg-sky-950/40 dark:text-sky-300 border border-sky-100 dark:border-sky-800' : 'bg-pink-50 text-pink-700 dark:bg-pink-950/40 dark:text-pink-300 border border-pink-100 dark:border-pink-800' }}">
                                {{ $s->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </div>

        {{-- Form Konfirmasi Eksekusi --}}
        <form action="{{ route('master.class-operations.promote') }}" method="POST" class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2">
            @csrf
            <input type="hidden" name="from_class_id" value="{{ $fromClass->id }}" />
            <input type="hidden" name="to_class_id" value="{{ $toClass->id }}" />

            <a href="{{ route('master.class-operations.index') }}" class="min-h-[44px] inline-flex items-center justify-center px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-xl transition shadow-xs w-full sm:w-auto">
                Kembali & Batal
            </a>

            <x-button type="submit" variant="primary" class="w-full sm:w-auto min-h-[44px] px-5 py-2 text-xs sm:text-sm font-semibold" onclick="return confirm('Pindahkan {{ $students->count() }} siswa ke Kelas {{ $toClass->name }} sekarang?');">
                Konfirmasi & Pindahkan {{ $students->count() }} Siswa Sekarang
            </x-button>
        </form>
    </div>
</x-layouts.app>
