<x-layouts.app title="Pratinjau Impor Akun">
    <div class="space-y-6">
        {{-- Breadcrumb & Judul --}}
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('master.dashboard') }}" class="text-xs text-slate-500 hover:text-slate-800">Master</a>
                <span class="text-xs text-slate-300">/</span>
                <a href="{{ route('master.import.index') }}" class="text-xs text-slate-500 hover:text-slate-800">Impor Excel</a>
                <span class="text-xs text-slate-300">/</span>
                <span class="text-xs font-semibold text-purple-700">Hasil Verifikasi File</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                Hasil Verifikasi Data Impor ({{ $type === 'siswa' ? 'Akun Siswa' : 'Akun Guru BK' }})
            </h1>
            <p class="text-xs sm:text-sm text-slate-500">
                Tinjau baris data yang valid dan perbaiki baris data yang bermasalah sebelum disimpan ke sistem.
            </p>
        </div>

        {{-- Ringkasan Statistik Verifikasi --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-card class="bg-slate-50/60 border-slate-200">
                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Baris Terbaca</span>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ $total }}</p>
            </x-card>

            <x-card class="bg-emerald-50/60 border-emerald-200">
                <span class="text-[11px] font-bold text-emerald-700 uppercase tracking-wider">Data Valid & Siap Diimpor</span>
                <p class="text-2xl font-bold text-emerald-700 mt-1">{{ count($valid) }}</p>
            </x-card>

            <x-card class="bg-rose-50/60 border-rose-200">
                <span class="text-[11px] font-bold text-rose-700 uppercase tracking-wider">Data Gagal / Duplikat</span>
                <p class="text-2xl font-bold text-rose-700 mt-1">{{ count($invalid) }}</p>
            </x-card>
        </div>

        {{-- Jika ada baris gagal / invalid --}}
        @if (count($invalid) > 0)
            <x-card class="border-rose-200 bg-rose-50/30">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-3 border-b border-rose-200/60">
                    <div>
                        <h3 class="text-sm font-bold text-rose-900">Ditemukan {{ count($invalid) }} Baris Data Bermasalah</h3>
                        <p class="text-xs text-rose-700">Baris di bawah ini tidak akan disimpan ke database. Anda dapat mengunduh daftar kesalahan ini untuk diperbaiki.</p>
                    </div>

                    <a href="{{ route('master.import.download-failed', ['token' => $token]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-rose-700 bg-white border border-rose-300 hover:bg-rose-50 rounded-lg shadow-xs transition shrink-0">
                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Unduh Baris Gagal (.XLSX)
                    </a>
                </div>

                <div class="mt-4 max-h-60 overflow-y-auto rounded-lg border border-rose-200 bg-white">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-rose-100/60 text-rose-950 font-semibold border-b border-rose-200">
                            <tr>
                                <th class="p-2.5">Baris Excel</th>
                                <th class="p-2.5">Data Input</th>
                                <th class="p-2.5">Penyebab Kesalahan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-rose-100">
                            @foreach ($invalid as $item)
                                <tr class="hover:bg-rose-50/50">
                                    <td class="p-2.5 font-mono font-bold text-rose-800">
                                        #{{ $item['row_index'] }}
                                    </td>
                                    <td class="p-2.5 text-slate-700">
                                        @if ($type === 'siswa')
                                            NIS: <strong>{{ $item['raw_data']['nis'] ?? '-' }}</strong> | Nama: {{ $item['raw_data']['nama'] ?? '-' }} | Kelas: {{ $item['raw_data']['kelas'] ?? '-' }}
                                        @else
                                            NIP/User: <strong>{{ $item['raw_data']['nip'] ?? '-' }}</strong> | Nama: {{ $item['raw_data']['nama'] ?? '-' }}
                                        @endif
                                    </td>
                                    <td class="p-2.5 text-rose-600 font-medium">
                                        {{ implode(', ', $item['errors']) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>
        @endif

        {{-- Tabel Pratinjau Data Valid --}}
        <x-card class="p-0! overflow-hidden">
            <div class="p-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Pratinjau Data Valid yang Siap Disimpan</h3>
                    <p class="text-xs text-slate-500">Menampilkan hingga 50 baris pertama data yang memenuhi syarat validasi.</p>
                </div>
                <x-badge variant="success">{{ count($valid) }} Baris Valid</x-badge>
            </div>

            @if ($type === 'siswa')
                <x-table :headers="['NIS (Login)', 'Nama Lengkap Siswa', 'Kelas', 'Jenis Kelamin']">
                    @forelse (array_slice($valid, 0, 50) as $row)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-4 py-2.5 sm:px-6 font-mono text-xs font-bold text-slate-800">
                                {{ $row['nis'] }}
                            </td>
                            <td class="px-4 py-2.5 sm:px-6 text-xs font-semibold text-slate-900">
                                {{ $row['nama'] }}
                            </td>
                            <td class="px-4 py-2.5 sm:px-6 text-xs text-slate-700">
                                Kelas {{ $row['class_name'] }}
                            </td>
                            <td class="px-4 py-2.5 sm:px-6 text-xs">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium {{ $row['gender'] === 'L' ? 'bg-sky-50 text-sky-700' : 'bg-pink-50 text-pink-700' }}">
                                    {{ $row['gender'] === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4">
                                <x-empty-state title="Tidak ada data valid" description="Seluruh baris pada file Excel ini gagal verifikasi." />
                            </td>
                        </tr>
                    @endforelse
                </x-table>
            @else
                <x-table :headers="['NIP / Username', 'Nama Guru BK', 'No. HP']">
                    @forelse (array_slice($valid, 0, 50) as $row)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-4 py-2.5 sm:px-6 font-mono text-xs font-bold text-slate-800">
                                {{ $row['nip'] }}
                            </td>
                            <td class="px-4 py-2.5 sm:px-6 text-xs font-semibold text-slate-900">
                                {{ $row['nama'] }}
                            </td>
                            <td class="px-4 py-2.5 sm:px-6 text-xs text-slate-600">
                                {{ $row['phone'] ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-4">
                                <x-empty-state title="Tidak ada data valid" description="Seluruh baris pada file Excel ini gagal verifikasi." />
                            </td>
                        </tr>
                    @endforelse
                </x-table>
            @endif
        </x-card>

        {{-- Tindakan Aksi --}}
        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('master.import.index') }}" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition">
                Batal & Unggah Ulang
            </a>

            @if (count($valid) > 0)
                <form action="{{ route('master.import.confirm') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}" />
                    <x-button type="submit" variant="primary" onclick="return confirm('Simpan {{ count($valid) }} akun ke dalam database sekarang?');">
                        Konfirmasi & Simpan {{ count($valid) }} Akun ke Database
                    </x-button>
                </form>
            @endif
        </div>
    </div>
</x-layouts.app>
