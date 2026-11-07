<x-layouts.app title="Kelola Akun Siswa">
    <div class="px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8 max-w-6xl w-full mx-auto space-y-6 animate-fade-in">
        {{-- Header & Tombol Tambah / Impor --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
            <div>
                <div class="flex items-center gap-2 mb-1.5 text-xs">
                    <a href="{{ route('master.dashboard') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 transition">Master</a>
                    <span class="text-slate-300 dark:text-slate-600">/</span>
                    <span class="font-semibold text-emerald-600 dark:text-emerald-400">Akun Siswa</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100 flex items-center gap-2.5">
                    <span>Manajemen Akun Siswa</span>
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Kelola data dan kredensial akun peserta didik MTs Soebono Mantofani.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('master.import.index') }}" class="min-h-[44px] inline-flex items-center justify-center px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50 rounded-xl shadow-xs transition active:scale-[0.98]">
                    <svg class="w-4 h-4 mr-2 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Impor Excel
                </a>
                <a href="{{ route('master.students.create') }}" class="min-h-[44px] inline-flex items-center justify-center px-4 py-2 text-xs sm:text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-600 dark:hover:bg-emerald-500 rounded-xl shadow-sm transition active:scale-[0.98]">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Siswa
                </a>
            </div>
        </div>

        {{-- Bar Pencarian & Filter Status / Kelas --}}
        <div class="bg-white dark:bg-[#16231D] border border-slate-200/80 dark:border-slate-800 rounded-2xl p-4 sm:p-5 shadow-xs">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                {{-- Tab Filter Status --}}
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 lg:pb-0 text-xs sm:text-sm font-medium">
                    <a href="{{ route('master.students.index', ['status' => 'active', 'class_id' => $classId, 'q' => $search]) }}" 
                       class="min-h-[44px] inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl transition {{ $status === 'active' ? 'bg-emerald-600 text-white font-semibold shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60' }}">
                        @if($status === 'active')<span class="w-1.5 h-1.5 rounded-full bg-[#B8E34B]"></span>@endif
                        Aktif
                    </a>
                    <a href="{{ route('master.students.index', ['status' => 'inactive', 'class_id' => $classId, 'q' => $search]) }}" 
                       class="min-h-[44px] inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl transition {{ $status === 'inactive' ? 'bg-amber-600 text-white font-semibold shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60' }}">
                        @if($status === 'inactive')<span class="w-1.5 h-1.5 rounded-full bg-[#B8E34B]"></span>@endif
                        Nonaktif
                    </a>
                    <a href="{{ route('master.students.index', ['status' => 'archived', 'class_id' => $classId, 'q' => $search]) }}" 
                       class="min-h-[44px] inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl transition {{ $status === 'archived' ? 'bg-slate-700 text-white font-semibold shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60' }}">
                        @if($status === 'archived')<span class="w-1.5 h-1.5 rounded-full bg-[#B8E34B]"></span>@endif
                        Diarsipkan
                    </a>
                    <a href="{{ route('master.students.index', ['status' => 'all', 'class_id' => $classId, 'q' => $search]) }}" 
                       class="min-h-[44px] inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl transition {{ $status === 'all' ? 'bg-slate-900 dark:bg-slate-700 text-white font-semibold shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60' }}">
                        Semua Status
                    </a>
                </div>

                {{-- Filter Kelas & Pencarian --}}
                <form method="GET" action="{{ route('master.students.index') }}" class="flex flex-wrap items-center gap-2.5">
                    <input type="hidden" name="status" value="{{ $status }}" />

                    {{-- Dropdown Kelas --}}
                    <div class="relative inline-flex items-center">
                        <select name="class_id" onchange="this.form.submit()" class="min-h-[44px] appearance-none cursor-pointer text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 py-2.5 pl-3.5 pr-9 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 dark:focus:border-[#5AE39D] transition font-medium">
                            <option value="">Semua Kelas</option>
                            @foreach ($classes as $c)
                                <option value="{{ $c->id }}" {{ (string) $classId === (string) $c->id ? 'selected' : '' }}>
                                    {{ $c->name }} (Tingkat {{ $c->grade_level }})
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 dark:text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    {{-- Search Input --}}
                    <div class="relative w-full sm:w-60">
                        <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama atau NIS..." class="w-full min-h-[44px] pl-9 pr-3 py-1.5 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    @if ($search || $classId)
                        <a href="{{ route('master.students.index', ['status' => $status]) }}" class="min-h-[44px] inline-flex items-center text-xs sm:text-sm font-semibold text-emerald-600 dark:text-emerald-400 hover:underline px-1">Reset</a>
                    @endif
                </form>
            </div>
        </div>

        {{-- Tabel Daftar Siswa --}}
        <div class="bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-xs">
            <x-table :headers="['NIS (Login)', 'Nama Siswa', 'Kelas', 'L/P', 'Status', 'Aksi']">
                @forelse ($students as $student)
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition">
                        <td class="px-4 py-3 sm:px-6 font-mono text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100">
                            {{ $student->login_id }}
                        </td>
                        <td class="px-4 py-3 sm:px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 flex items-center justify-center font-bold text-xs shrink-0 border border-emerald-100 dark:border-emerald-800">
                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-sm text-slate-900 dark:text-slate-100 truncate">
                                        {{ $student->name }}
                                    </p>
                                    @if($student->last_login_at)
                                        <p class="text-[11px] text-slate-400">Masuk: {{ $student->last_login_at->format('d/m/Y') }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-xs sm:text-sm text-slate-600 dark:text-slate-300">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300">
                                {{ $student->schoolClass?->name ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-xs">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold {{ $student->gender === 'L' ? 'bg-sky-50 text-sky-700 dark:bg-sky-950/40 dark:text-sky-300 border border-sky-100 dark:border-sky-800' : 'bg-pink-50 text-pink-700 dark:bg-pink-950/40 dark:text-pink-300 border border-pink-100 dark:border-pink-800' }}">
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
                        <td class="px-4 py-3 sm:px-5 whitespace-nowrap text-center">
                            <div class="inline-flex items-center gap-1.5 justify-center">
                                @if (! $student->trashed())
                                    {{-- Edit --}}
                                    <a href="{{ route('master.students.edit', $student) }}" 
                                       class="inline-flex items-center gap-1.5 px-2.5 h-8 text-xs font-semibold rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 hover:border-emerald-500 hover:text-emerald-700 dark:hover:text-[#5AE39D] hover:bg-slate-50 dark:hover:bg-slate-700/50 shadow-2xs transition cursor-pointer active:scale-95" 
                                       title="Ubah Data Siswa {{ $student->name }}"
                                       aria-label="Ubah data {{ $student->name }}">
                                        <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        <span>Ubah</span>
                                    </a>

                                    {{-- Toggle Aktif / Nonaktif --}}
                                    <form method="POST" action="{{ route('master.students.toggle-status', $student) }}" 
                                          data-confirm="{{ $student->is_active ? 'Nonaktifkan akun siswa ' . $student->name . ' (NIS: ' . $student->login_id . ')? Siswa tidak akan dapat masuk ke sistem sampai akun diaktifkan kembali.' : 'Aktifkan kembali akun siswa ' . $student->name . ' (NIS: ' . $student->login_id . ')? Siswa akan dapat masuk kembali ke sistem.' }}"
                                          data-confirm-title="{{ $student->is_active ? 'Konfirmasi Nonaktifkan Siswa' : 'Konfirmasi Aktifkan Siswa' }}"
                                          data-confirm-button="{{ $student->is_active ? 'Ya, Nonaktifkan' : 'Ya, Aktifkan' }}"
                                          data-confirm-color="{{ $student->is_active ? '#D97706' : '#10B981' }}"
                                          data-confirm-icon="{{ $student->is_active ? 'warning' : 'question' }}"
                                          class="inline-flex m-0">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg border transition shadow-2xs cursor-pointer active:scale-95 {{ $student->is_active ? 'border-amber-200 dark:border-amber-900/60 bg-amber-50/70 dark:bg-amber-950/30 text-amber-600 dark:text-[#FAD46B] hover:bg-amber-100 dark:hover:bg-amber-950/60 hover:border-amber-300' : 'border-emerald-200 dark:border-emerald-900/60 bg-emerald-50/70 dark:bg-emerald-950/30 text-emerald-700 dark:text-[#5AE39D] hover:bg-emerald-100 dark:hover:bg-emerald-950/60 hover:border-emerald-300' }}" 
                                                title="{{ $student->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}"
                                                aria-label="{{ $student->is_active ? 'Nonaktifkan akun' : 'Aktifkan akun' }} {{ $student->name }}">
                                            @if ($student->is_active)
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                                            @else
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            @endif
                                        </button>
                                    </form>

                                    {{-- Reset Password --}}
                                    <form method="POST" action="{{ route('master.students.reset-password', $student) }}" 
                                          data-confirm="Reset kata sandi akun siswa {{ $student->name }} (NIS: {{ $student->login_id }})? Sistem akan membuat kata sandi acak sementara baru dan mewajibkan siswa langsung menggantinya saat masuk."
                                          data-confirm-title="Konfirmasi Reset Kata Sandi"
                                          data-confirm-button="Ya, Reset Sandi"
                                          data-confirm-color="#D97706"
                                          class="inline-flex m-0">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-amber-200 dark:border-amber-900/60 bg-amber-50/70 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 hover:bg-amber-100 dark:hover:bg-amber-950/60 hover:border-amber-300 shadow-2xs transition cursor-pointer active:scale-95" 
                                                title="Reset Kata Sandi"
                                                aria-label="Reset kata sandi {{ $student->name }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>
                                        </button>
                                    </form>

                                    {{-- Arsipkan (Soft Delete) --}}
                                    <form method="POST" action="{{ route('master.students.archive', $student) }}" 
                                          data-confirm="Arsipkan akun siswa ini? Akun tidak dapat masuk namun seluruh riwayat laporan tetap aman tersimpan."
                                          data-confirm-title="Konfirmasi Arsipkan Akun"
                                          data-confirm-button="Ya, Arsipkan"
                                          data-confirm-color="#9333EA"
                                          class="inline-flex m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-purple-200 dark:border-purple-900/60 bg-purple-50/70 dark:bg-purple-950/30 text-purple-600 dark:text-purple-300 hover:bg-purple-100 dark:hover:bg-purple-950/60 hover:border-purple-300 shadow-2xs transition cursor-pointer active:scale-95" 
                                                title="Arsipkan Akun"
                                                aria-label="Arsipkan akun {{ $student->name }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                                        </button>
                                    </form>
                                @else
                                    {{-- Pulihkan Akun (Restore) --}}
                                    <form method="POST" action="{{ route('master.students.restore', $student->id) }}" 
                                          data-confirm="Pulihkan kembali akun siswa {{ $student->name }} (NIS: {{ $student->login_id }}) dari arsip? Akun akan kembali aktif dan dapat masuk ke sistem."
                                          data-confirm-title="Konfirmasi Pulihkan Akun"
                                          data-confirm-button="Ya, Pulihkan Akun"
                                          data-confirm-color="#10B981"
                                          data-confirm-icon="question"
                                          class="inline-flex m-0">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1.5 px-2.5 h-8 text-xs font-semibold rounded-lg border border-emerald-200 dark:border-emerald-900/60 bg-emerald-50/70 dark:bg-emerald-950/30 text-emerald-700 dark:text-[#5AE39D] hover:bg-emerald-100 dark:hover:bg-emerald-950/60 hover:border-emerald-300 shadow-2xs transition cursor-pointer active:scale-95" 
                                                title="Pulihkan Akun"
                                                aria-label="Pulihkan akun {{ $student->name }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.032 8.032 0 01-15.357-2m15.357 2H15" /></svg>
                                            <span>Pulihkan</span>
                                        </button>
                                    </form>

                                    {{-- Hapus Permanen (Modal Konfirmasi Password Master) --}}
                                    <button type="button" 
                                            @click="$dispatch('open-modal', 'modal-force-delete-student-{{ $student->id }}')" 
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-rose-200 dark:border-rose-900/60 bg-rose-50/70 dark:bg-rose-950/30 text-rose-600 dark:text-rose-400 hover:bg-rose-100 dark:hover:bg-rose-950/60 hover:border-rose-300 shadow-2xs transition cursor-pointer active:scale-95" 
                                            title="Hapus Permanen"
                                            aria-label="Hapus permanen {{ $student->name }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8">
                            <x-empty-state title="Tidak ada data siswa" description="Belum ada data siswa yang sesuai dengan filter atau kata kunci." />
                        </td>
                    </tr>
                @endforelse
            </x-table>

            {{-- Modals Hapus Permanen di Luar Tabel --}}
            @foreach ($students as $student)
                @if ($student->trashed())
                    <x-modal id="modal-force-delete-student-{{ $student->id }}" title="Konfirmasi Hapus Permanen Siswa">
                        <form method="POST" action="{{ route('master.students.force-delete', $student->id) }}" 
                              data-confirm="PERINGATAN KRITIS: Tindakan ini permanen dan tidak dapat dibatalkan. Apakah Anda benar-benar yakin ingin menghapus akun {{ $student->name }} secara permanen?"
                              data-confirm-title="Peringatan Hapus Permanen Siswa"
                              data-confirm-button="Ya, Hapus Permanen"
                              data-confirm-color="#DC2626"
                              data-confirm-icon="error"
                              class="space-y-4">
                            @csrf
                            @method('DELETE')

                            <div class="p-3.5 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 rounded-xl text-xs text-rose-800 dark:text-rose-300 leading-relaxed">
                                <strong>Peringatan Keamanan Kritis:</strong> Tindakan ini akan menghapus akun siswa <strong>{{ $student->name }} (NIS: {{ $student->login_id }})</strong> secara permanen.
                            </div>

                            <x-input type="password" name="master_password" label="Masukkan Kata Sandi Master Anda untuk Konfirmasi" required placeholder="Kata sandi akun Master Anda" />

                            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                                <x-button type="button" variant="outline" size="sm" @click="$dispatch('close-modal', 'modal-force-delete-student-{{ $student->id }}')">Batal</x-button>
                                <x-button type="submit" variant="danger" size="sm">Hapus Permanen Sekarang</x-button>
                            </div>
                        </form>
                    </x-modal>
                @endif
            @endforeach

            @if ($students->hasPages())
                <div class="p-4 sm:p-5 border-t border-slate-200 dark:border-slate-800">
                    {{ $students->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
