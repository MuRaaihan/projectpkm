<x-layouts.app title="Konfirmasi Kenaikan Kelas">
    <div class="max-w-4xl mx-auto space-y-6">
        {{-- Breadcrumb & Judul --}}
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('master.dashboard') }}" class="text-xs text-slate-500 hover:text-slate-800">Master</a>
                <span class="text-xs text-slate-300">/</span>
                <a href="{{ route('master.class-operations.index') }}" class="text-xs text-slate-500 hover:text-slate-800">Operasi Massal Kelas</a>
                <span class="text-xs text-slate-300">/</span>
                <span class="text-xs font-semibold text-purple-700">Pratinjau Kenaikan Kelas</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                Pratinjau Kenaikan / Perpindahan Kelas
            </h1>
            <p class="text-xs sm:text-sm text-slate-500">
                Periksa daftar nama siswa sebelum mengonfirmasi perpindahan massal ke kelas baru.
            </p>
        </div>

        {{-- Ringkasan Perpindahan --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-card class="bg-amber-50/50 border-amber-200">
                <span class="text-[11px] font-bold text-amber-800 uppercase tracking-wider">Kelas Asal</span>
                <div class="mt-1">
                    <p class="text-lg font-bold text-slate-900">Kelas {{ $fromClass->name }}</p>
                    <p class="text-xs text-slate-500">Tahun Ajaran: {{ $fromClass->academicYear?->name ?? '-' }} · Tingkat {{ $fromClass->grade_level }}</p>
                </div>
            </x-card>

            <x-card class="bg-purple-50/50 border-purple-200">
                <span class="text-[11px] font-bold text-purple-800 uppercase tracking-wider">Kelas Tujuan Baru</span>
                <div class="mt-1">
                    <p class="text-lg font-bold text-slate-900">Kelas {{ $toClass->name }}</p>
                    <p class="text-xs text-slate-500">Tahun Ajaran: {{ $toClass->academicYear?->name ?? '-' }} · Tingkat {{ $toClass->grade_level }}</p>
                </div>
            </x-card>
        </div>

        {{-- Alert Info --}}
        <div class="p-3 bg-purple-50 rounded-xl border border-purple-200 text-xs text-purple-900 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Total siswa yang akan dipindahkan ke <strong>Kelas {{ $toClass->name }}</strong>: <strong>{{ $students->count() }} orang</strong>.</span>
            </div>
        </div>

        {{-- Tabel Siswa --}}
        <x-card class="p-0! overflow-hidden">
            <x-table :headers="['No', 'NIS Siswa', 'Nama Lengkap Siswa', 'Jenis Kelamin']">
                @foreach ($students as $index => $s)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="px-4 py-2.5 sm:px-6 text-xs text-slate-500">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-4 py-2.5 sm:px-6 font-mono text-xs font-bold text-slate-800">
                            {{ $s->login_id }}
                        </td>
                        <td class="px-4 py-2.5 sm:px-6 text-xs font-semibold text-slate-900">
                            {{ $s->name }}
                        </td>
                        <td class="px-4 py-2.5 sm:px-6 text-xs">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium {{ $s->gender === 'L' ? 'bg-sky-50 text-sky-700' : 'bg-pink-50 text-pink-700' }}">
                                {{ $s->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </x-card>

        {{-- Form Konfirmasi Eksekusi --}}
        <form action="{{ route('master.class-operations.promote') }}" method="POST" class="flex items-center justify-between pt-2">
            @csrf
            <input type="hidden" name="from_class_id" value="{{ $fromClass->id }}" />
            <input type="hidden" name="to_class_id" value="{{ $toClass->id }}" />

            <a href="{{ route('master.class-operations.index') }}" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition">
                Kembali & Batal
            </a>

            <x-button type="submit" variant="primary" onclick="return confirm('Pindahkan {{ $students->count() }} siswa ke Kelas {{ $toClass->name }} sekarang?');">
                Konfirmasi & Pindahkan {{ $students->count() }} Siswa Sekarang
            </x-button>
        </form>
    </div>
</x-layouts.app>
