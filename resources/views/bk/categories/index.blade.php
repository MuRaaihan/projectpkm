<x-layouts.app title="Kelola Kategori Perundungan">
    <div class="px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8 max-w-6xl w-full mx-auto space-y-6 animate-fade-in">
        {{-- Header Halaman --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
            <div>
                <div class="flex items-center gap-2 mb-1.5 text-xs">
                    <a href="{{ route('bk.dashboard') }}" class="text-slate-500 hover:text-primary-700 dark:hover:text-[#5AE39D] transition">Guru BK</a>
                    <span class="text-slate-300 dark:text-slate-600">/</span>
                    <span class="font-semibold text-primary-700 dark:text-[#5AE39D]">Kategori Perundungan</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900 dark:text-slate-100 flex items-center gap-2.5">
                    <span>Kelola Kategori Perundungan</span>
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Daftar jenis dan klasifikasi perundungan yang dapat dipilih oleh peserta didik saat menyampaikan aduan.
                </p>
            </div>
            <div>
                <button type="button" 
                        @click="$dispatch('open-modal', 'modal-tambah-kategori')"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 min-h-[42px] text-xs sm:text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 active:bg-primary-800 rounded-xl shadow-xs transition cursor-pointer active:scale-[0.98]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah Kategori</span>
                </button>
            </div>
        </div>

        {{-- Tabel Kategori --}}
        <div class="bg-surface-card dark:bg-[#16231D] border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-xs">
            @if($categories->count() > 0)
                {{-- Desktop Table View --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-800 dark:text-slate-200 border-collapse">
                        <thead class="bg-slate-50/80 dark:bg-slate-900/60 border-b border-slate-200 dark:border-slate-800 text-[11px] uppercase font-bold tracking-wider text-slate-500 dark:text-slate-400">
                            <tr>
                                <th class="px-5 py-3.5">Nama Kategori</th>
                                <th class="px-5 py-3.5">Deskripsi</th>
                                <th class="px-5 py-3.5 text-center">Laporan Terkait</th>
                                <th class="px-5 py-3.5">Status</th>
                                <th class="px-5 py-3.5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach($categories as $category)
                                <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition">
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-2 h-2 rounded-full {{ $category->is_active ? 'bg-primary-600 dark:bg-[#5AE39D]' : 'bg-slate-300 dark:bg-slate-600' }}"></span>
                                            <span class="font-bold text-slate-900 dark:text-slate-100 text-sm">{{ $category->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-xs text-slate-500 dark:text-slate-400 max-w-xs sm:max-w-md">
                                        {{ $category->description ?: '-' }}
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $category->reports_count > 0 ? 'bg-primary-50 text-primary-700 dark:bg-primary-950/60 dark:text-[#5AE39D] border border-primary-200 dark:border-primary-900' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400' }}">
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
                                    <td class="px-5 py-3.5 whitespace-nowrap text-center">
                                        <div class="inline-flex items-center gap-1.5 justify-center">
                                            {{-- Tombol Ubah / Edit --}}
                                            <button type="button" 
                                                    @click="$dispatch('open-modal', 'modal-edit-kategori-{{ $category->id }}')"
                                                    class="inline-flex items-center gap-1.5 px-2.5 h-8 text-xs font-semibold rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 hover:border-primary-500 hover:text-primary-700 dark:hover:text-[#5AE39D] hover:bg-slate-50 dark:hover:bg-slate-700/50 shadow-2xs transition cursor-pointer active:scale-95"
                                                    title="Ubah Kategori {{ $category->name }}"
                                                    aria-label="Ubah kategori {{ $category->name }}">
                                                <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                <span>Ubah</span>
                                            </button>

                                            {{-- Tombol Toggle Status --}}
                                            <form method="POST" action="{{ route('bk.categories.toggle-status', $category) }}" class="inline-flex m-0">
                                                @csrf
                                                <button type="submit" 
                                                        class="inline-flex items-center gap-1.5 px-2.5 h-8 text-xs font-semibold rounded-lg border transition shadow-2xs cursor-pointer active:scale-95 {{ $category->is_active ? 'border-amber-200 dark:border-amber-900/60 bg-amber-50/70 dark:bg-amber-950/30 text-amber-700 dark:text-[#FAD46B] hover:bg-amber-100 dark:hover:bg-amber-950/60 hover:border-amber-300' : 'border-emerald-200 dark:border-emerald-900/60 bg-emerald-50/70 dark:bg-emerald-950/30 text-emerald-700 dark:text-[#5AE39D] hover:bg-emerald-100 dark:hover:bg-emerald-950/60 hover:border-emerald-300' }}"
                                                        title="{{ $category->is_active ? 'Nonaktifkan Kategori' : 'Aktifkan Kategori' }}"
                                                        aria-label="{{ $category->is_active ? 'Nonaktifkan' : 'Aktifkan' }} kategori {{ $category->name }}">
                                                    @if($category->is_active)
                                                        <svg class="w-3.5 h-3.5 text-amber-500 dark:text-[#FAD46B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                        <span>Nonaktifkan</span>
                                                    @else
                                                        <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-[#5AE39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                        <span>Aktifkan</span>
                                                    @endif
                                                </button>
                                            </form>

                                            {{-- Tombol Hapus --}}
                                            @if($category->reports_count > 0)
                                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/40 text-slate-300 dark:text-slate-600 cursor-not-allowed" 
                                                      title="Kategori ini sudah terhubung dengan {{ $category->reports_count }} aduan sehingga tidak dapat dihapus">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </span>
                                            @else
                                                <form method="POST" 
                                                      action="{{ route('bk.categories.destroy', $category) }}" 
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $category->name }}? Tindakan ini tidak dapat dibatalkan.');" 
                                                      class="inline-flex m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-rose-200 dark:border-rose-900/60 bg-white dark:bg-slate-800 text-rose-500 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40 hover:border-rose-300 shadow-2xs transition cursor-pointer active:scale-95"
                                                            title="Hapus Kategori {{ $category->name }}"
                                                            aria-label="Hapus kategori {{ $category->name }}">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Cards View (Tampilan Kartu Responsif di HP) --}}
                <div class="md:hidden divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($categories as $category)
                        <div class="p-4 space-y-3">
                            <div class="flex items-start justify-between gap-3">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full {{ $category->is_active ? 'bg-primary-600 dark:bg-[#5AE39D]' : 'bg-slate-300 dark:bg-slate-600' }}"></span>
                                        <h3 class="font-bold text-slate-900 dark:text-slate-100 text-sm">{{ $category->name }}</h3>
                                    </div>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                        {{ $category->description ?: 'Tidak ada deskripsi' }}
                                    </p>
                                </div>
                                <span class="shrink-0">
                                    @if($category->is_active)
                                        <x-badge variant="success">Aktif</x-badge>
                                    @else
                                        <x-badge variant="default">Nonaktif</x-badge>
                                    @endif
                                </span>
                            </div>

                            <div class="flex items-center justify-between pt-2.5 border-t border-slate-100 dark:border-slate-800/80 gap-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $category->reports_count > 0 ? 'bg-primary-50 text-primary-700 dark:bg-primary-950/60 dark:text-[#5AE39D]' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400' }}">
                                    {{ $category->reports_count }} aduan
                                </span>

                                <div class="inline-flex items-center gap-1.5">
                                    {{-- Tombol Ubah --}}
                                    <button type="button" 
                                            @click="$dispatch('open-modal', 'modal-edit-kategori-{{ $category->id }}')"
                                            class="inline-flex items-center gap-1 px-2.5 h-7.5 text-xs font-semibold rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 shadow-2xs">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>Ubah</span>
                                    </button>

                                    {{-- Tombol Toggle Status --}}
                                    <form method="POST" action="{{ route('bk.categories.toggle-status', $category) }}" class="inline-flex m-0">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 px-2.5 h-7.5 text-xs font-semibold rounded-lg border shadow-2xs {{ $category->is_active ? 'border-amber-200 dark:border-amber-900/60 bg-amber-50/70 text-amber-700 dark:text-[#FAD46B]' : 'border-emerald-200 dark:border-emerald-900/60 bg-emerald-50/70 text-emerald-700 dark:text-[#5AE39D]' }}">
                                            <span>{{ $category->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</span>
                                        </button>
                                    </form>

                                    {{-- Tombol Hapus --}}
                                    @if($category->reports_count == 0)
                                        <form method="POST" action="{{ route('bk.categories.destroy', $category) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $category->name }}? Tindakan ini tidak dapat dibatalkan.');" class="inline-flex m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center w-7.5 h-7.5 rounded-lg border border-rose-200 dark:border-rose-900/60 bg-white dark:bg-slate-800 text-rose-500 shadow-2xs">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Modals Edit Kategori --}}
                @foreach($categories as $category)
                    <x-modal id="modal-edit-kategori-{{ $category->id }}" :title="'Ubah Kategori: ' . $category->name">
                        <form method="POST" action="{{ route('bk.categories.update', $category) }}" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="edit_name_{{ $category->id }}" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Nama Kategori <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" 
                                       id="edit_name_{{ $category->id }}" 
                                       name="name" 
                                       value="{{ old('name', $category->name) }}" 
                                       required 
                                       maxlength="100" 
                                       class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D] min-h-[42px]">
                            </div>

                            <div>
                                <label for="edit_desc_{{ $category->id }}" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                                    Deskripsi / Penjelasan
                                </label>
                                <textarea id="edit_desc_{{ $category->id }}" 
                                          name="description" 
                                          rows="3" 
                                          maxlength="500" 
                                          class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D]">{{ old('description', $category->description) }}</textarea>
                            </div>

                            <div class="flex justify-end gap-2.5 pt-3 border-t border-slate-100 dark:border-slate-800">
                                <button type="button" 
                                        @click="$dispatch('close-modal', 'modal-edit-kategori-{{ $category->id }}')" 
                                        class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition cursor-pointer">
                                    Batal
                                </button>
                                <button type="submit" 
                                        class="px-4 py-2 bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white text-xs sm:text-sm font-bold rounded-xl transition shadow-xs cursor-pointer active:scale-[0.98]">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </x-modal>
                @endforeach

                @if($categories->hasPages())
                    <div class="px-5 py-4 border-t border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/40">
                        {{ $categories->links() }}
                    </div>
                @endif
            @else
                <div class="p-8 sm:p-12 text-center flex flex-col items-center justify-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-slate-100">Belum Ada Kategori Perundungan</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 max-w-sm">
                        Kategori perundungan belum terdaftar. Tambahkan kategori pertama agar siswa dapat memilih klasifikasi yang sesuai saat melapor.
                    </p>
                </div>
            @endif
        </div>

        {{-- Modal Tambah Kategori --}}
        <x-modal id="modal-tambah-kategori" title="Tambah Kategori Perundungan Baru">
            <form method="POST" action="{{ route('bk.categories.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="new_name" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Nama Kategori <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           id="new_name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required 
                           maxlength="100" 
                           placeholder="Contoh: Perundungan Fisik, Verbal, Siber..." 
                           class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D] min-h-[42px]">
                    @error('name')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="new_description" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Deskripsi / Penjelasan Singkat
                    </label>
                    <textarea id="new_description" 
                              name="description" 
                              rows="3" 
                              maxlength="500" 
                              placeholder="Jelaskan contoh bentuk perundungan pada kategori ini agar dipahami peserta didik..." 
                              class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D]">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-2.5 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" 
                            @click="$dispatch('close-modal', 'modal-tambah-kategori')" 
                            class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white text-xs sm:text-sm font-bold rounded-xl transition shadow-xs cursor-pointer active:scale-[0.98]">
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </x-modal>
    </div>
</x-layouts.app>
