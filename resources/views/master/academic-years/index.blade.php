<x-layouts.app title="Master Data: Tahun Ajaran">
    <div class="space-y-6">
        {{-- Header & Tombol Tambah --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-slate-200">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('master.dashboard') }}" class="text-xs text-slate-500 hover:text-slate-800">Master</a>
                    <span class="text-xs text-slate-300">/</span>
                    <span class="text-xs font-semibold text-purple-700">Tahun Ajaran</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                    Master Data: Tahun Ajaran
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Kelola daftar periode tahun ajaran madrasah. Hanya satu tahun ajaran yang berstatus aktif.
                </p>
            </div>

            <button type="button" 
                    @click="$dispatch('open-modal', 'modal-tambah-tahun')"
                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-xs transition active:scale-[0.98]">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Tahun Ajaran
            </button>
        </div>

        {{-- Tabel Daftar Tahun Ajaran --}}
        <x-card class="p-0! overflow-hidden">
            <x-table :headers="['Nama Tahun Ajaran', 'Status', 'Tanggal Periode', 'Jumlah Kelas', 'Aksi']">
                @forelse ($academicYears as $year)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="px-4 py-3 sm:px-6 font-semibold text-slate-900">
                            {{ $year->name }}
                        </td>
                        <td class="px-4 py-3 sm:px-6">
                            @if ($year->is_active)
                                <x-badge variant="success">Aktif Sekarang</x-badge>
                            @else
                                <x-badge variant="default">Tidak Aktif</x-badge>
                            @endif
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-xs text-slate-600">
                            @if ($year->starts_on || $year->ends_on)
                                {{ $year->starts_on?->format('d/m/Y') ?? '-' }} s/d {{ $year->ends_on?->format('d/m/Y') ?? '-' }}
                            @else
                                <span class="text-slate-400 italic">Belum diatur</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-sm text-slate-700 font-medium">
                            <a href="{{ route('master.classes.index', ['academic_year_id' => $year->id]) }}" class="text-emerald-700 hover:underline">
                                {{ $year->classes_count }} kelas
                            </a>
                        </td>
                        <td class="px-4 py-3 sm:px-6">
                            <div class="flex items-center gap-2">
                                {{-- Tombol Edit --}}
                                <button type="button" 
                                        @click="$dispatch('open-modal', 'modal-edit-tahun-{{ $year->id }}')"
                                        class="p-1.5 text-slate-500 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition"
                                        title="Ubah Tahun Ajaran">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    <span class="sr-only">Ubah</span>
                                </button>

                                {{-- Tombol Hapus (jika 0 kelas) --}}
                                @if ($year->classes_count === 0)
                                    <form method="POST" action="{{ route('master.academic-years.destroy', $year) }}" onsubmit="return confirm('Hapus tahun ajaran {{ $year->name }}?');" class="inline">
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

                            {{-- Modal Edit Tahun Ajaran --}}
                            <x-modal id="modal-edit-tahun-{{ $year->id }}" title="Ubah Tahun Ajaran {{ $year->name }}">
                                <form method="POST" action="{{ route('master.academic-years.update', $year) }}" class="space-y-4">
                                    @csrf
                                    @method('PUT')

                                    <x-input name="name" label="Nama Tahun Ajaran" value="{{ $year->name }}" required placeholder="Mis. 2026/2027" />

                                    <div class="grid grid-cols-2 gap-3">
                                        <x-input type="date" name="starts_on" label="Tanggal Mulai" value="{{ $year->starts_on?->format('Y-m-d') }}" />
                                        <x-input type="date" name="ends_on" label="Tanggal Selesai" value="{{ $year->ends_on?->format('Y-m-d') }}" />
                                    </div>

                                    <div class="flex items-center gap-2 pt-2">
                                        <input type="checkbox" name="is_active" id="active-{{ $year->id }}" value="1" {{ $year->is_active ? 'checked' : '' }} class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4" />
                                        <label for="active-{{ $year->id }}" class="text-xs font-semibold text-slate-700">Jadikan Tahun Ajaran Aktif</label>
                                    </div>

                                    <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                                        <x-button type="button" variant="outline" size="sm" @click="$dispatch('close-modal', 'modal-edit-tahun-{{ $year->id }}')">Batal</x-button>
                                        <x-button type="submit" variant="primary" size="sm">Simpan Perubahan</x-button>
                                    </div>
                                </form>
                            </x-modal>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4">
                            <x-empty-state title="Belum ada data tahun ajaran" description="Tambahkan tahun ajaran pertama untuk memulai pengelompokan kelas dan siswa." />
                        </td>
                    </tr>
                @endforelse
            </x-table>

            @if ($academicYears->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $academicYears->links() }}
                </div>
            @endif
        </x-card>

        {{-- Modal Tambah Tahun Ajaran --}}
        <x-modal id="modal-tambah-tahun" title="Tambah Tahun Ajaran Baru">
            <form method="POST" action="{{ route('master.academic-years.store') }}" class="space-y-4">
                @csrf

                <x-input name="name" label="Nama Tahun Ajaran" required placeholder="Contoh: 2026/2027" helper="Gunakan format tahun (misal 2026/2027)." />

                <div class="grid grid-cols-2 gap-3">
                    <x-input type="date" name="starts_on" label="Tanggal Mulai" />
                    <x-input type="date" name="ends_on" label="Tanggal Selesai" />
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" name="is_active" id="tambah-active" value="1" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4" />
                    <label for="tambah-active" class="text-xs font-semibold text-slate-700">Jadikan Tahun Ajaran Aktif</label>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <x-button type="button" variant="outline" size="sm" @click="$dispatch('close-modal', 'modal-tambah-tahun')">Batal</x-button>
                    <x-button type="submit" variant="primary" size="sm">Tambah Sekarang</x-button>
                </div>
            </form>
        </x-modal>
    </div>
</x-layouts.app>
