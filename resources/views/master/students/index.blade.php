<x-layouts.app title="Kelola Akun Siswa">
    <div class="space-y-6">
        {{-- Header & Tombol Tambah / Impor --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-slate-200">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('master.dashboard') }}" class="text-xs text-slate-500 hover:text-slate-800">Master</a>
                    <span class="text-xs text-slate-300">/</span>
                    <span class="text-xs font-semibold text-purple-700">Akun Siswa</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                    Manajemen Akun Siswa
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Kelola data dan kredensial akun peserta didik MTs Soebono Mantofani.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('master.import.index') }}" class="inline-flex items-center justify-center px-3.5 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg shadow-xs transition active:scale-[0.98]">
                    <svg class="w-4 h-4 mr-1.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Impor Excel
                </a>
                <a href="{{ route('master.students.create') }}" class="inline-flex items-center justify-center px-3.5 py-2 text-sm font-semibold text-white bg-purple-700 hover:bg-purple-800 rounded-lg shadow-xs transition active:scale-[0.98]">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Siswa
                </a>
            </div>
        </div>

        {{-- Bar Pencarian & Filter Status / Kelas --}}
        <x-card class="p-4!">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                {{-- Tab Filter Status --}}
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 lg:pb-0 text-xs font-medium">
                    <a href="{{ route('master.students.index', ['status' => 'active', 'class_id' => $classId, 'q' => $search]) }}" 
                       class="px-3 py-1.5 rounded-lg transition {{ $status === 'active' ? 'bg-purple-700 text-white font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                        Aktif
                    </a>
                    <a href="{{ route('master.students.index', ['status' => 'inactive', 'class_id' => $classId, 'q' => $search]) }}" 
                       class="px-3 py-1.5 rounded-lg transition {{ $status === 'inactive' ? 'bg-amber-600 text-white font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                        Nonaktif
                    </a>
                    <a href="{{ route('master.students.index', ['status' => 'archived', 'class_id' => $classId, 'q' => $search]) }}" 
                       class="px-3 py-1.5 rounded-lg transition {{ $status === 'archived' ? 'bg-slate-700 text-white font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                        Diarsipkan
                    </a>
                    <a href="{{ route('master.students.index', ['status' => 'all', 'class_id' => $classId, 'q' => $search]) }}" 
                       class="px-3 py-1.5 rounded-lg transition {{ $status === 'all' ? 'bg-slate-900 text-white font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                        Semua Status
                    </a>
                </div>

                {{-- Filter Kelas & Pencarian --}}
                <form method="GET" action="{{ route('master.students.index') }}" class="flex flex-wrap items-center gap-2">
                    <input type="hidden" name="status" value="{{ $status }}" />

                    {{-- Dropdown Kelas --}}
                    <select name="class_id" onchange="this.form.submit()" class="text-xs rounded-lg border border-slate-300 py-1.5 pl-2.5 pr-8 bg-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">Semua Kelas</option>
                        @foreach ($classes as $c)
                            <option value="{{ $c->id }}" {{ (string) $classId === (string) $c->id ? 'selected' : '' }}>
                                {{ $c->name }} (Tingkat {{ $c->grade_level }})
                            </option>
                        @endforeach
                    </select>

                    {{-- Search Input --}}
                    <div class="relative w-full sm:w-56">
                        <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama atau NIS..." class="w-full pl-8 pr-3 py-1.5 text-xs rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-purple-500 bg-white" />
                        <svg class="w-4 h-4 text-slate-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    @if ($search || $classId)
                        <a href="{{ route('master.students.index', ['status' => $status]) }}" class="text-xs text-slate-500 hover:text-slate-800">Reset</a>
                    @endif
                </form>
            </div>
        </x-card>

        {{-- Tabel Daftar Siswa --}}
        <x-card class="p-0! overflow-hidden">
            <x-table :headers="['NIS (Login)', 'Nama Siswa', 'Kelas', 'L/P', 'Status', 'Aksi']">
                @forelse ($students as $student)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="px-4 py-3 sm:px-6 font-mono text-xs font-bold text-slate-800">
                            {{ $student->login_id }}
                        </td>
                        <td class="px-4 py-3 sm:px-6 font-semibold text-slate-900">
                            {{ $student->name }}
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-xs text-slate-700">
                            {{ $student->schoolClass?->name ?? '-' }}
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-xs">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold {{ $student->gender === 'L' ? 'bg-sky-50 text-sky-700' : 'bg-pink-50 text-pink-700' }}">
                                {{ $student->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 sm:px-6">
                            @if ($student->trashed())
                                <x-badge variant="purple">Diarsipkan</x-badge>
                            @elseif (! $student->is_active)
                                <x-badge variant="danger">Nonaktif</x-badge>
                            @else
                                <x-badge variant="success">Aktif</x-badge>
                            @endif
                        </td>
                        <td class="px-4 py-3 sm:px-6">
                            <div class="flex items-center gap-1.5">
                                @if (! $student->trashed())
                                    {{-- Edit --}}
                                    <a href="{{ route('master.students.edit', $student) }}" class="p-1.5 text-slate-500 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition" title="Ubah Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    {{-- Toggle Aktif / Nonaktif --}}
                                    <form method="POST" action="{{ route('master.students.toggle-status', $student) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="p-1.5 {{ $student->is_active ? 'text-amber-600 hover:bg-amber-50' : 'text-emerald-600 hover:bg-emerald-50' }} rounded-lg transition" title="{{ $student->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}">
                                            @if ($student->is_active)
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @endif
                                        </button>
                                    </form>

                                    {{-- Reset Password (Modal) --}}
                                    <button type="button" 
                                            @click="$dispatch('open-modal', 'modal-reset-student-{{ $student->id }}')" 
                                            class="p-1.5 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition" 
                                            title="Reset Kata Sandi">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                        </svg>
                                    </button>

                                    <x-modal id="modal-reset-student-{{ $student->id }}" title="Reset Kata Sandi Siswa">
                                        <form method="POST" action="{{ route('master.students.reset-password', $student) }}" class="space-y-4">
                                            @csrf
                                            <p class="text-xs text-slate-600 leading-relaxed">
                                                Apakah Anda yakin ingin mengatur ulang kata sandi untuk <strong>{{ $student->name }} (NIS: {{ $student->login_id }})</strong>?
                                            </p>
                                            <div class="p-3 bg-purple-50 rounded-lg border border-purple-200 text-xs text-purple-900">
                                                Sistem akan membuat kata sandi acak baru dan mewajibkan siswa langsung menggantinya pada saat login berikutnya.
                                            </div>
                                            <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                                                <x-button type="button" variant="outline" size="sm" @click="$dispatch('close-modal', 'modal-reset-student-{{ $student->id }}')">Batal</x-button>
                                                <x-button type="submit" variant="primary" size="sm">Ya, Reset Kata Sandi</x-button>
                                            </div>
                                        </form>
                                    </x-modal>

                                    {{-- Arsipkan (Soft Delete) --}}
                                    <form method="POST" action="{{ route('master.students.archive', $student) }}" class="inline" onsubmit="return confirm('Arsipkan akun siswa ini? Akun tidak dapat login namun seluruh riwayat laporan tetap aman tersimpan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-500 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition" title="Arsipkan Akun">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    {{-- Pulihkan Akun (Restore) --}}
                                    <form method="POST" action="{{ route('master.students.restore', $student->id) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-lg transition text-xs font-semibold flex items-center gap-1" title="Pulihkan Akun">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.032 8.032 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Pulihkan
                                        </button>
                                    </form>

                                    {{-- Hapus Permanen (Modal Konfirmasi Password Master) --}}
                                    <button type="button" 
                                            @click="$dispatch('open-modal', 'modal-force-delete-student-{{ $student->id }}')" 
                                            class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition" 
                                            title="Hapus Permanen">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>

                                    <x-modal id="modal-force-delete-student-{{ $student->id }}" title="Konfirmasi Hapus Permanen Siswa">
                                        <form method="POST" action="{{ route('master.students.force-delete', $student->id) }}" class="space-y-4">
                                            @csrf
                                            @method('DELETE')

                                            <div class="p-3 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-900 leading-relaxed">
                                                <strong>Peringatan Keamanan Kritis:</strong> Tindakan ini akan menghapus akun siswa <strong>{{ $student->name }} (NIS: {{ $student->login_id }})</strong> secara permanen.
                                            </div>

                                            <x-input type="password" name="master_password" label="Masukkan Kata Sandi Master Anda untuk Konfirmasi" required placeholder="Kata sandi akun Master Anda" />

                                            <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                                                <x-button type="button" variant="outline" size="sm" @click="$dispatch('close-modal', 'modal-force-delete-student-{{ $student->id }}')">Batal</x-button>
                                                <x-button type="submit" variant="danger" size="sm">Hapus Permanen Sekarang</x-button>
                                            </div>
                                        </form>
                                    </x-modal>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4">
                            <x-empty-state title="Tidak ada data siswa" description="Belum ada data siswa yang sesuai dengan filter atau kata kunci." />
                        </td>
                    </tr>
                @endforelse
            </x-table>

            @if ($students->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $students->links() }}
                </div>
            @endif
        </x-card>
    </div>
</x-layouts.app>
