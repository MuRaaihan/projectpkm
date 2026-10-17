<x-layouts.app title="Master Data: Kelas">
    <div class="space-y-6">
        {{-- Header & Aksi --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-slate-200">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('master.dashboard') }}" class="text-xs text-slate-500 hover:text-slate-800">Master</a>
                    <span class="text-xs text-slate-300">/</span>
                    <span class="text-xs font-semibold text-purple-700">Kelas</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                    Master Data: Kelas
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Daftar rombongan belajar (rombel) madrasah menurut tingkat dan tahun ajaran.
                </p>
            </div>

            <button type="button" 
                    @click="$dispatch('open-modal', 'modal-tambah-kelas')"
                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-xs transition active:scale-[0.98]">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kelas
            </button>
        </div>

        {{-- Filter Tahun Ajaran --}}
        <x-card class="p-4!">
            <form method="GET" action="{{ route('master.classes.index') }}" class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <label for="filter-year" class="text-xs font-semibold text-slate-700 whitespace-nowrap">Filter Tahun Ajaran:</label>
                    <select name="academic_year_id" id="filter-year" onchange="this.form.submit()" class="rounded-lg border-slate-300 text-xs py-1.5 px-3 bg-white focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Semua Tahun Ajaran</option>
                        @foreach ($academicYears as $year)
                            <option value="{{ $year->id }}" {{ $selectedYearId == $year->id ? 'selected' : '' }}>
                                {{ $year->name }} {{ $year->is_active ? '(Aktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if ($selectedYearId)
                    <a href="{{ route('master.classes.index') }}" class="text-xs text-slate-500 hover:text-slate-800 underline">
                        Reset Filter
                    </a>
                @endif
            </form>
        </x-card>

        {{-- Tabel Daftar Kelas --}}
        <x-card class="p-0! overflow-hidden">
            <x-table :headers="['Tingkat', 'Nama Kelas', 'Tahun Ajaran', 'Jumlah Siswa Aktif', 'Aksi']">
                @forelse ($classes as $class)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="px-4 py-3 sm:px-6">
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-100 font-bold text-xs text-slate-700">
                                {{ $class->grade_level }}
                            </span>
                        </td>
                        <td class="px-4 py-3 sm:px-6 font-bold text-slate-900">
                            {{ $class->name }}
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-xs text-slate-600">
                            {{ $class->academicYear->name }}
                            @if ($class->academicYear->is_active)
                                <span class="ml-1 text-[10px] bg-emerald-100 text-emerald-800 px-1.5 py-0.5 rounded font-medium">Aktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-xs font-semibold text-slate-700">
                            <a href="{{ route('master.students.index', ['class_id' => $class->id]) }}" class="text-emerald-700 hover:underline">
                                {{ $class->students_count }} siswa
                            </a>
                        </td>
                        <td class="px-4 py-3 sm:px-6">
                            <div class="flex items-center gap-2">
                                {{-- Tombol Edit --}}
                                <button type="button" 
                                        @click="$dispatch('open-modal', 'modal-edit-kelas-{{ $class->id }}')"
                                        class="p-1.5 text-slate-500 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition"
                                        title="Ubah Kelas">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    <span class="sr-only">Ubah</span>
                                </button>

                                {{-- Tombol Hapus (jika 0 siswa) --}}
                                @if ($class->students_count === 0)
                                    <form method="POST" action="{{ route('master.classes.destroy', $class) }}" onsubmit="return confirm('Hapus kelas {{ $class->name }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span class="sr-only">Hapus</span>
                                        </button>
                                    </form>
                                @endif
                            </div>

                            {{-- Modal Edit Kelas --}}
                            <x-modal id="modal-edit-kelas-{{ $class->id }}" title="Ubah Kelas {{ $class->name }}">
                                <form method="POST" action="{{ route('master.classes.update', $class) }}" class="space-y-4">
                                    @csrf
                                    @method('PUT')

                                    <x-select name="academic_year_id" label="Tahun Ajaran" required>
                                        @foreach ($academicYears as $year)
                                            <option value="{{ $year->id }}" {{ $class->academic_year_id == $year->id ? 'selected' : '' }}>
                                                {{ $year->name }} {{ $year->is_active ? '(Aktif)' : '' }}
                                            </option>
                                        @endforeach
                                    </x-select>

                                    <div class="grid grid-cols-2 gap-3">
                                        <x-select name="grade_level" label="Tingkat" required>
                                            <option value="7" {{ $class->grade_level == 7 ? 'selected' : '' }}>Kelas 7 (Tujuh)</option>
                                            <option value="8" {{ $class->grade_level == 8 ? 'selected' : '' }}>Kelas 8 (Delapan)</option>
                                            <option value="9" {{ $class->grade_level == 9 ? 'selected' : '' }}>Kelas 9 (Sembilan)</option>
                                        </x-select>

                                        <x-input name="name" label="Nama Kelas" value="{{ $class->name }}" required placeholder="Contoh: VII-A" />
                                    </div>

                                    <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                                        <x-button type="button" variant="outline" size="sm" @click="$dispatch('close-modal', 'modal-edit-kelas-{{ $class->id }}')">Batal</x-button>
                                        <x-button type="submit" variant="primary" size="sm">Simpan Perubahan</x-button>
                                    </div>
                                </form>
                            </x-modal>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4">
                            <x-empty-state title="Belum ada kelas terdaftar" description="Tambahkan rombel kelas pertama untuk madrasah." />
                        </td>
                    </tr>
                @endforelse
            </x-table>

            @if ($classes->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $classes->links() }}
                </div>
            @endif
        </x-card>

        {{-- Modal Tambah Kelas --}}
        <x-modal id="modal-tambah-kelas" title="Tambah Kelas Baru">
            <form method="POST" action="{{ route('master.classes.store') }}" class="space-y-4">
                @csrf

                <x-select name="academic_year_id" label="Tahun Ajaran" required>
                    @foreach ($academicYears as $year)
                        <option value="{{ $year->id }}" {{ $year->is_active ? 'selected' : '' }}>
                            {{ $year->name }} {{ $year->is_active ? '(Aktif)' : '' }}
                        </option>
                    @endforeach
                </x-select>

                <div class="grid grid-cols-2 gap-3">
                    <x-select name="grade_level" label="Tingkat" required>
                        <option value="7">Kelas 7 (Tujuh)</option>
                        <option value="8">Kelas 8 (Delapan)</option>
                        <option value="9">Kelas 9 (Sembilan)</option>
                    </x-select>

                    <x-input name="name" label="Nama Kelas" required placeholder="Contoh: VII-A" helper="Gunakan format singkat seperti VII-A, VIII-B." />
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <x-button type="button" variant="outline" size="sm" @click="$dispatch('close-modal', 'modal-tambah-kelas')">Batal</x-button>
                    <x-button type="submit" variant="primary" size="sm">Tambah Kelas</x-button>
                </div>
            </form>
        </x-modal>
    </div>
</x-layouts.app>
