<x-layouts.app title="Kelola Akun Guru BK">
    <div class="space-y-6 animate-fade-in">
        {{-- Header & Tombol Tambah --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
            <div>
                <div class="flex items-center gap-2 mb-1.5 text-xs">
                    <a href="{{ route('master.dashboard') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 transition">Master</a>
                    <span class="text-slate-300 dark:text-slate-600">/</span>
                    <span class="font-semibold text-emerald-600 dark:text-emerald-400">Akun Guru BK</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100 flex items-center gap-2.5">
                    <span>Manajemen Akun Guru BK</span>
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Kelola data dan kredensial akses konselor madrasah penanggung jawab laporan perundungan.
                </p>
            </div>

            <a href="{{ route('master.bk-users.create') }}" class="min-h-[42px] inline-flex items-center justify-center px-4 py-2 text-xs sm:text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-600 dark:hover:bg-emerald-500 rounded-xl shadow-sm transition active:scale-[0.98]">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Guru BK
            </a>
        </div>

        {{-- Bar Pencarian & Filter Status --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700/80 rounded-2xl p-4 sm:p-5 shadow-xs">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                {{-- Tab Filter Status --}}
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0 text-xs sm:text-sm font-medium">
                    <a href="{{ route('master.bk-users.index', ['status' => 'active', 'q' => $search]) }}" 
                       class="min-h-[40px] inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl transition {{ $status === 'active' ? 'bg-emerald-600 text-white font-semibold shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60' }}">
                        @if($status === 'active')<span class="w-1.5 h-1.5 rounded-full bg-[#B8E34B]"></span>@endif
                        Aktif
                    </a>
                    <a href="{{ route('master.bk-users.index', ['status' => 'inactive', 'q' => $search]) }}" 
                       class="min-h-[40px] inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl transition {{ $status === 'inactive' ? 'bg-amber-600 text-white font-semibold shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60' }}">
                        @if($status === 'inactive')<span class="w-1.5 h-1.5 rounded-full bg-[#B8E34B]"></span>@endif
                        Nonaktif
                    </a>
                    <a href="{{ route('master.bk-users.index', ['status' => 'archived', 'q' => $search]) }}" 
                       class="min-h-[40px] inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl transition {{ $status === 'archived' ? 'bg-slate-700 text-white font-semibold shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60' }}">
                        @if($status === 'archived')<span class="w-1.5 h-1.5 rounded-full bg-[#B8E34B]"></span>@endif
                        Diarsipkan
                    </a>
                    <a href="{{ route('master.bk-users.index', ['status' => 'all', 'q' => $search]) }}" 
                       class="min-h-[40px] inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl transition {{ $status === 'all' ? 'bg-slate-900 dark:bg-slate-700 text-white font-semibold shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60' }}">
                        Semua Status
                    </a>
                </div>

                {{-- Form Pencarian --}}
                <form method="GET" action="{{ route('master.bk-users.index') }}" class="flex items-center gap-2.5">
                    <input type="hidden" name="status" value="{{ $status }}" />
                    <div class="relative w-full sm:w-64">
                        <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama, NIP, no HP..." class="w-full min-h-[40px] pl-9 pr-3 py-1.5 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500" />
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    @if ($search)
                        <a href="{{ route('master.bk-users.index', ['status' => $status]) }}" class="min-h-[40px] inline-flex items-center text-xs sm:text-sm font-semibold text-emerald-600 dark:text-emerald-400 hover:underline px-1">Batal</a>
                    @endif
                </form>
            </div>
        </div>

        {{-- Tabel Daftar Guru BK --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-xs">
            <x-table :headers="['NIP / Username', 'Nama Guru BK', 'No. HP', 'Status', 'Sesi Terakhir', 'Aksi']">
                @forelse ($bkUsers as $user)
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition">
                        <td class="px-4 py-3 sm:px-6 font-mono text-xs sm:text-sm font-bold text-slate-900 dark:text-slate-100">
                            {{ $user->login_id }}
                        </td>
                        <td class="px-4 py-3 sm:px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 flex items-center justify-center font-bold text-xs shrink-0 border border-emerald-200 dark:border-emerald-700">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-sm text-slate-900 dark:text-slate-100">
                                        {{ $user->name }}
                                    </p>
                                    <span class="inline-flex items-center px-1.5 py-0.2 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400">
                                        Guru BK
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-xs sm:text-sm text-slate-600 dark:text-slate-300">
                            {{ $user->phone ?? '-' }}
                        </td>
                        <td class="px-4 py-3 sm:px-6">
                            @if ($user->trashed())
                                <x-badge variant="purple">Diarsipkan</x-badge>
                            @elseif (! $user->is_active)
                                <x-badge variant="danger">Nonaktif</x-badge>
                            @else
                                <x-badge variant="success">Aktif</x-badge>
                            @endif
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-xs text-slate-500 dark:text-slate-400">
                            {{ $user->last_login_at?->format('d/m/Y H:i') ?? 'Belum pernah' }}
                        </td>
                        <td class="px-4 py-3 sm:px-6">
                            <div class="flex items-center gap-1.5">
                                @if (! $user->trashed())
                                    {{-- Edit --}}
                                    <a href="{{ route('master.bk-users.edit', $user) }}" class="p-2 text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-slate-700 rounded-lg transition" title="Ubah Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span class="sr-only">Ubah data {{ $user->name }}</span>
                                    </a>

                                    {{-- Toggle Aktif / Nonaktif --}}
                                    <form method="POST" action="{{ route('master.bk-users.toggle-status', $user) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="p-2 {{ $user->is_active ? 'text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-950/30' : 'text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-950/30' }} rounded-lg transition" title="{{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}">
                                            @if ($user->is_active)
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                </svg>
                                                <span class="sr-only">Nonaktifkan akun {{ $user->name }}</span>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="sr-only">Aktifkan akun {{ $user->name }}</span>
                                            @endif
                                        </button>
                                    </form>

                                    {{-- Reset Password --}}
                                    <form method="POST" action="{{ route('master.bk-users.reset-password', $user) }}" onsubmit="return confirm('Reset kata sandi akun {{ $user->name }}? Sistem akan membuat kata sandi sementara baru.');" class="inline">
                                        @csrf
                                        <button type="submit" class="p-2 text-slate-400 hover:text-sky-600 dark:hover:text-sky-400 hover:bg-sky-50 dark:hover:bg-slate-700 rounded-lg transition" title="Reset Kata Sandi">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                            </svg>
                                            <span class="sr-only">Reset kata sandi {{ $user->name }}</span>
                                        </button>
                                    </form>

                                    {{-- Arsipkan (Soft Delete) --}}
                                    <form method="POST" action="{{ route('master.bk-users.archive', $user) }}" onsubmit="return confirm('Arsipkan akun Guru BK {{ $user->name }}? Akun ini tidak akan bisa masuk tetapi datanya tersimpan.');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-purple-600 dark:hover:text-purple-400 hover:bg-purple-50 dark:hover:bg-slate-700 rounded-lg transition" title="Arsipkan Akun">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                            </svg>
                                            <span class="sr-only">Arsipkan akun {{ $user->name }}</span>
                                        </button>
                                    </form>
                                @else
                                    {{-- Pulihkan dari Arsip --}}
                                    <form method="POST" action="{{ route('master.bk-users.restore', $user->id) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-950/30 rounded-lg transition text-xs font-semibold flex items-center gap-1.5" title="Pulihkan Akun">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.032 8.032 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Pulihkan
                                        </button>
                                    </form>

                                    {{-- Hapus Permanen (Modal Konfirmasi Password Master) --}}
                                    <button type="button" 
                                            @click="$dispatch('open-modal', 'modal-force-delete-{{ $user->id }}')" 
                                            class="p-2 text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/30 rounded-lg transition" 
                                            title="Hapus Permanen">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <span class="sr-only">Hapus permanen {{ $user->name }}</span>
                                    </button>

                                    <x-modal id="modal-force-delete-{{ $user->id }}" title="Konfirmasi Hapus Permanen Guru BK">
                                        <form method="POST" action="{{ route('master.bk-users.force-delete', $user->id) }}" class="space-y-4">
                                            @csrf
                                            @method('DELETE')

                                            <div class="p-3.5 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 rounded-xl text-xs text-rose-800 dark:text-rose-300 leading-relaxed">
                                                <strong>Peringatan Keamanan Kritis:</strong> Tindakan ini akan menghapus akun Guru BK <strong>{{ $user->name }} ({{ $user->login_id }})</strong> secara permanen dan tidak dapat dikembalikan.
                                            </div>

                                            <x-input type="password" name="master_password" label="Masukkan Kata Sandi Master Anda untuk Konfirmasi" required placeholder="Kata sandi akun Master Anda" />

                                            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                                                <x-button type="button" variant="outline" size="sm" @click="$dispatch('close-modal', 'modal-force-delete-{{ $user->id }}')">Batal</x-button>
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
                        <td colspan="6" class="p-8">
                            <x-empty-state title="Tidak ada data Guru BK" description="Belum ada akun Guru BK yang sesuai dengan kriteria filter." />
                        </td>
                    </tr>
                @endforelse
            </x-table>

            @if ($bkUsers->hasPages())
                <div class="p-4 sm:p-5 border-t border-slate-200 dark:border-slate-800">
                    {{ $bkUsers->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
