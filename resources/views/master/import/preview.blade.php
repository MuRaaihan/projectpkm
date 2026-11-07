<x-layouts.app title="Pratinjau Impor Akun">
    <div class="px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8 max-w-6xl w-full mx-auto space-y-6 animate-fade-in">
        {{-- Breadcrumb & Judul --}}
        <div>
            <div class="flex items-center gap-2 mb-1.5 text-xs">
                <a href="{{ route('master.dashboard') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 transition">Master</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <a href="{{ route('master.import.index') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 transition">Impor Excel</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <span class="font-semibold text-emerald-600 dark:text-emerald-400">Hasil Verifikasi Berkas</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100 flex items-center gap-2.5">
                <span>Hasil Verifikasi Data Impor ({{ $type === 'siswa' ? 'Akun Siswa' : 'Akun Guru BK' }})</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Tinjau baris data yang valid dan periksa baris data yang bermasalah sebelum disimpan ke dalam sistem.
            </p>
        </div>

        {{-- Ringkasan Statistik Verifikasi --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="p-5 rounded-2xl bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 shadow-xs">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Baris Terbaca</span>
                <p class="text-3xl font-extrabold text-slate-900 dark:text-slate-100 mt-1">{{ $total }}</p>
            </div>

            <div class="p-5 rounded-2xl bg-emerald-50/70 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/80 shadow-xs">
                <span class="text-[11px] font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider">Data Valid & Siap Diimpor</span>
                <p class="text-3xl font-extrabold text-emerald-700 dark:text-emerald-400 mt-1">{{ count($valid) }}</p>
            </div>

            <div class="p-5 rounded-2xl bg-rose-50/70 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-900/60 shadow-xs">
                <span class="text-[11px] font-bold text-rose-600 dark:text-rose-400 uppercase tracking-wider">Data Gagal / Duplikat</span>
                <p class="text-3xl font-extrabold text-rose-600 dark:text-rose-400 mt-1">{{ count($invalid) }}</p>
            </div>
        </div>

        {{-- Jika ada baris gagal / invalid --}}
        @if (count($invalid) > 0)
            <div class="border border-rose-200 dark:border-rose-900/60 bg-rose-50/40 dark:bg-rose-950/20 rounded-2xl p-5 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-3 border-b border-rose-200/60 dark:border-rose-900/40">
                    <div>
                        <h3 class="text-sm sm:text-base font-bold text-rose-950 dark:text-rose-200">Ditemukan {{ count($invalid) }} Baris Data Bermasalah</h3>
                        <p class="text-xs text-rose-800 dark:text-rose-300 mt-0.5">Baris di bawah ini tidak akan disimpan ke database. Anda dapat mengunduh daftar kesalahan ini untuk diperbaiki.</p>
                    </div>

                    <a href="{{ route('master.import.download-failed', ['token' => $token]) }}" class="min-h-[44px] inline-flex items-center justify-center gap-2 px-3.5 py-1.5 text-xs sm:text-sm font-semibold text-rose-700 dark:text-rose-300 bg-white dark:bg-slate-800 border border-rose-300 dark:border-rose-700 hover:bg-rose-50 rounded-xl shadow-xs transition shrink-0">
                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Unduh Baris Gagal (.XLSX)
                    </a>
                </div>

                <div class="max-h-64 overflow-y-auto rounded-xl border border-rose-200 dark:border-rose-900/60 bg-white dark:bg-[#16231D]">
                    <table class="w-full text-left text-xs sm:text-sm">
                        <thead class="bg-rose-100/70 dark:bg-rose-950/50 text-rose-950 dark:text-rose-200 font-semibold border-b border-rose-200 dark:border-rose-900/60">
                            <tr>
                                <th class="p-3">Baris Excel</th>
                                <th class="p-3">Data Input</th>
                                <th class="p-3">Penyebab Kesalahan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-rose-100 dark:divide-rose-900/30">
                            @foreach ($invalid as $item)
                                <tr class="hover:bg-rose-50/50 dark:hover:bg-rose-950/20">
                                    <td class="p-3 font-mono font-bold text-rose-800 dark:text-rose-300">
                                        #{{ $item['row_num'] ?? $item['row_index'] ?? ($loop->iteration + 1) }}
                                    </td>
                                    <td class="p-3 text-slate-800 dark:text-slate-200">
                                        @if ($type === 'siswa')
                                            NIS: <strong>{{ $item['nis'] ?? $item['raw_data']['nis'] ?? '-' }}</strong> | Nama: {{ $item['name'] ?? $item['nama'] ?? $item['raw_data']['nama'] ?? '-' }} | Kelas: {{ $item['class_name'] ?? $item['kelas'] ?? $item['raw_data']['kelas'] ?? '-' }}
                                        @else
                                            NIP/User: <strong>{{ $item['nip'] ?? $item['raw_data']['nip'] ?? '-' }}</strong> | Nama: {{ $item['name'] ?? $item['nama'] ?? $item['raw_data']['nama'] ?? '-' }}
                                        @endif
                                    </td>
                                    <td class="p-3 text-rose-600 dark:text-rose-400 font-medium">
                                        {{ is_array($item['errors']) ? implode(', ', $item['errors']) : $item['errors'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- Tabel Pratinjau Data Valid --}}
        <div class="bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-xs">
            <div class="p-4 sm:p-5 bg-slate-50/70 dark:bg-slate-900/60 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 dark:text-slate-100">Pratinjau Data Valid yang Siap Disimpan</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Menampilkan hingga 50 baris pertama data yang memenuhi syarat validasi.</p>
                </div>
                <x-badge variant="success">{{ count($valid) }} Baris Valid</x-badge>
            </div>

            @if ($type === 'siswa')
                <x-table :headers="['NIS (Login)', 'Nama Lengkap Siswa', 'Kelas', 'Jenis Kelamin']">
                    @forelse (array_slice($valid, 0, 50) as $row)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition">
                            <td class="px-4 py-3 sm:px-6 font-mono text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100">
                                {{ $row['nis'] }}
                            </td>
                            <td class="px-4 py-3 sm:px-6 text-xs sm:text-sm font-semibold text-slate-900 dark:text-slate-100">
                                {{ $row['name'] ?? $row['nama'] ?? '-' }}
                            </td>
                            <td class="px-4 py-3 sm:px-6 text-xs sm:text-sm text-slate-700 dark:text-slate-300">
                                Kelas {{ $row['class_name'] }}
                            </td>
                            <td class="px-4 py-3 sm:px-6 text-xs">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold {{ $row['gender'] === 'L' ? 'bg-sky-50 text-sky-700 dark:bg-sky-950/40 dark:text-sky-300 border border-sky-100 dark:border-sky-800' : 'bg-pink-50 text-pink-700 dark:bg-pink-950/40 dark:text-pink-300 border border-pink-100 dark:border-pink-800' }}">
                                    {{ $row['gender'] === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8">
                                <x-empty-state title="Tidak ada data valid" description="Seluruh baris pada file Excel ini gagal verifikasi." />
                            </td>
                        </tr>
                    @endforelse
                </x-table>
            @else
                <x-table :headers="['NIP / Username', 'Nama Guru BK', 'No. HP']">
                    @forelse (array_slice($valid, 0, 50) as $row)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition">
                            <td class="px-4 py-3 sm:px-6 font-mono text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100">
                                {{ $row['nip'] }}
                            </td>
                            <td class="px-4 py-3 sm:px-6 text-xs sm:text-sm font-semibold text-slate-900 dark:text-slate-100">
                                {{ $row['name'] ?? $row['nama'] ?? '-' }}
                            </td>
                            <td class="px-4 py-3 sm:px-6 text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                                {{ $row['phone'] ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-8">
                                <x-empty-state title="Tidak ada data valid" description="Seluruh baris pada file Excel ini gagal verifikasi." />
                            </td>
                        </tr>
                    @endforelse
                </x-table>
            @endif
        </div>

        {{-- Tindakan Aksi --}}
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2">
            <a href="{{ route('master.import.index') }}" class="min-h-[44px] inline-flex items-center justify-center px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-xl transition shadow-xs w-full sm:w-auto">
                Batal & Unggah Ulang
            </a>

            @if (count($valid) > 0)
                <form action="{{ route('master.import.confirm') }}" method="POST" 
                      data-confirm="Simpan {{ count($valid) }} data akun {{ $type === 'siswa' ? 'siswa' : 'Guru BK' }} ke dalam database sekarang?"
                      data-confirm-title="Konfirmasi Impor Akun Massal"
                      data-confirm-button="Ya, Simpan Akun"
                      data-confirm-color="#10B981"
                      data-confirm-icon="question"
                      class="w-full sm:w-auto">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}" />
                    <x-button type="submit" variant="primary" class="w-full sm:w-auto min-h-[44px] px-5 py-2 text-xs sm:text-sm font-semibold">
                        Konfirmasi & Simpan {{ count($valid) }} Akun ke Database
                    </x-button>
                </form>
            @endif
        </div>
    </div>
</x-layouts.app>
