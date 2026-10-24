<x-layouts.app title="Kelola Kategori Perundungan">
    <div class="px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8 max-w-6xl w-full mx-auto space-y-6 animate-fade-in">
        {{-- Header Halaman --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
            <div>
                <div class="flex items-center gap-2 mb-1.5 text-xs">
                    <a href="{{ route('bk.dashboard') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 transition">Guru BK</a>
                    <span class="text-slate-300 dark:text-slate-600">/</span>
                    <span class="font-semibold text-emerald-600 dark:text-emerald-400">Kategori Perundungan</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100 flex items-center gap-2.5">
                    <span>Kelola Kategori Perundungan</span>
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Daftar jenis dan klasifikasi perundungan yang dapat dipilih oleh peserta didik saat menyampaikan aduan.
                </p>
            </div>
            <div>
                <button type="button" 
                        @click="$dispatch('open-modal', 'modal-tambah-kategori')"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 min-h-[44px] text-xs sm:text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-600 dark:hover:bg-emerald-500 rounded-xl shadow-sm transition active:scale-[0.98]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah Kategori</span>
                </button>
            </div>
        </div>

        {{-- Tabel Kategori --}}
        <div class="bg-white dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-xs">
            @if($categories->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-800 dark:text-slate-200 border-collapse">
                        <thead class="bg-slate-50/80 dark:bg-slate-900/60 border-b border-slate-200 dark:border-slate-800 text-[11px] uppercase font-bold tracking-wider text-slate-500 dark:text-slate-400">
                            <tr>
                                <th class="px-5 py-3.5">Nama Kategori</th>
                                <th class="px-5 py-3.5">Deskripsi</th>
                                <th class="px-5 py-3.5 text-center">Laporan Terkait</th>
                                <th class="px-5 py-3.5">Status</th>
                                <th class="px-5 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach($categories as $category)
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition">
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-2 h-2 rounded-full {{ $category->is_active ? 'bg-emerald-500' : 'bg-slate-300 dark:bg-slate-600' }}"></span>
                                            <span class="font-bold text-slate-900 dark:text-slate-100 text-sm">{{ $category->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-xs text-slate-500 dark:text-slate-400 max-w-xs sm:max-w-md">
                                        {{ $category->description ?: '-' }}
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $category->reports_count > 0 ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-800' : 'bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400' }}">
                                            {{ $category->reports_count }} aduan
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if($category->is_active)
                                            <x-badge variant="success">Aktif</x-badge>
                                        @else
                                            <x-badge variant="default">Nonaktif</x-badge>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-right">
                                        <div class="inline-flex items-center gap-1 justify-end">
                                            {{-- Tombol Edit --}}
                                            <button type="button" 
                                                    @click="$dispatch('open-modal', 'modal-edit-kategori-{{ $category->id }}')"
                                                    class="p-2.5 min-w-[44px] min-h-[44px] inline-flex items-center justify-center text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-slate-700 rounded-xl transition"
                                                    title="Ubah Kategori"
                                                    aria-label="Ubah kategori {{ $category->name }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>

                                            {{-- Tombol Toggle Status --}}
                                            <form method="POST" action="{{ route('bk.categories.toggle-status', $category) }}" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="p-2.5 min-w-[44px] min-h-[44px] inline-flex items-center justify-center {{ $category->is_active ? 'text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-950/30' : 'text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-950/30' }} rounded-xl transition"
                                                        title="{{ $category->is_active ? 'Nonaktifkan Kategori' : 'Aktifkan Kategori' }}"
                                                        aria-label="{{ $category->is_active ? 'Nonaktifkan' : 'Aktifkan' }} kategori {{ $category->name }}">
                                                    @if($category->is_active)
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                                    @else
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    @endif
                                                </button>
                                            </form>

                                            {{-- Tombol Hapus (Hanya Jika Belum Dipakai Laporan) --}}
                                            @if($category->reports_count > 0)
                                                <span class="p-2.5 min-w-[44px] min-h-[44px] inline-flex items-center justify-center text-slate-300 dark:text-slate-600 cursor-not-allowed" title="Kategori ini sudah digunakan laporan dan tidak boleh dihapus (hanya dinonaktifkan)">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </span>
                                            @else
                                                <form method="POST" 
                                                      action="{{ route('bk.categories.destroy', $category) }}" 
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $category->name }}? Tindakan ini tidak dapat dibatalkan.');" 
                                                      class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="p-2.5 min-w-[44px] min-h-[44px] inline-flex items-center justify-center text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/30 rounded-xl transition"
                                                            title="Hapus Kategori"
                                                            aria-label="Hapus kategori {{ $category->name }}">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                        {{-- Modal Edit Kategori --}}
                                        <x-modal id="modal-edit-kategori-{{ $category->id }}" :title="'Ubah Kategori: ' . $category->name">
                                            <form method="POST" action="{{ route('bk.categories.update', $category) }}" class="space-y-4">
                                                @csrf
                                                @method('PUT')

                                                <div>
                                                    <label for="edit_name_{{ $category->id }}" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                                        Nama Kategori <span class="text-rose-500">*</span>
                                                    </label>
                                                    <input type="text" 
                                                           id="edit_name_{{ $category->id }}" 
                                                           name="name" 
                                                           value="{{ old('name', $category->name) }}" 
                                                           required 
                                                           maxlength="100" 
                                                           class="w-full px-3 py-2 text-xs sm:text-sm border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 min-h-[42px]">
                                                </div>

                                                <div>
                                                    <label for="edit_desc_{{ $category->id }}" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                                        Deskripsi / Penjelasan
                                                    </label>
                                                    <textarea id="edit_desc_{{ $category->id }}" 
                                                              name="description" 
                                                              rows="3" 
                                                              maxlength="500" 
                                                              class="w-full px-3 py-2 text-xs sm:text-sm border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ old('description', $category->description) }}</textarea>
                                                </div>

                                                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                                                    <button type="button" 
                                                            @click="$dispatch('close-modal', 'modal-edit-kategori-{{ $category->id }}')" 
                                                            class="px-3.5 py-2 text-xs sm:text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-xl transition">
                                                        Batal
                                                    </button>
                                                    <button type="submit" 
                                                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-semibold rounded-xl transition shadow-xs">
                                                        Simpan Perubahan
                                                    </button>
                                                </div>
                                            </form>
                                        </x-modal>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($categories->hasPages())
                    <div class="px-5 py-4 border-t border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-850">
                        {{ $categories->links() }}
                    </div>
                @endif
            @else
                <div class="p-8">
                    <x-empty-state 
                        title="Belum Ada Kategori Perundungan" 
                        description="Kategori perundungan belum terdaftar. Tambahkan kategori pertama agar siswa dapat memilih saat melapor."
                    />
                </div>
            @endif
        </div>

        {{-- Modal Tambah Kategori --}}
        <x-modal id="modal-tambah-kategori" title="Tambah Kategori Perundungan Baru">
            <form method="POST" action="{{ route('bk.categories.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="new_name" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                        Nama Kategori <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           id="new_name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required 
                           maxlength="100" 
                           placeholder="Contoh: Perundungan Fisik, Verbal, Siber..." 
                           class="w-full px-3 py-2 text-xs sm:text-sm border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 min-h-[42px]">
                    @error('name')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="new_description" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                        Deskripsi / Penjelasan Singkat
                    </label>
                    <textarea id="new_description" 
                              name="description" 
                              rows="3" 
                              maxlength="500" 
                              placeholder="Jelaskan contoh bentuk perundungan pada kategori ini agar dipahami peserta didik..." 
                              class="w-full px-3 py-2 text-xs sm:text-sm border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" 
                            @click="$dispatch('close-modal', 'modal-tambah-kategori')" 
                            class="px-3.5 py-2 text-xs sm:text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-semibold rounded-xl transition shadow-xs">
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </x-modal>
    </div>
</x-layouts.app>
