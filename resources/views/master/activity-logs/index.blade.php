<x-layouts.app title="Log Aktivitas & Audit Keamanan">
    <div class="space-y-6 animate-fade-in">
        {{-- Header --}}
        <div>
            <div class="flex items-center gap-2 mb-1.5 text-xs">
                <a href="{{ route('master.dashboard') }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 transition">Master</a>
                <span class="text-slate-300 dark:text-slate-600">/</span>
                <span class="font-semibold text-emerald-600 dark:text-emerald-400">Log Aktivitas</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 border-b border-slate-200 dark:border-slate-800">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100 flex items-center gap-2.5">
                        <span>Log Aktivitas & Audit Keamanan</span>
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                        Rekam jejak tindakan pengguna, perubahan akun, dan peristiwa keamanan sistem (Hanya Baca / Read-Only).
                    </p>
                </div>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 rounded-xl text-xs font-mono font-semibold self-start sm:self-auto shrink-0">
                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Audit Log Immutability Active
                </div>
            </div>
        </div>

        {{-- Filter & Pencarian --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700/80 rounded-2xl p-4 sm:p-5 shadow-xs">
            <form method="GET" action="{{ route('master.activity-logs.index') }}" class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-3">
                    {{-- Filter Jenis Aksi --}}
                    <select name="action" onchange="this.form.submit()" class="min-h-[40px] text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 py-2 pl-3 pr-8 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">Semua Jenis Aktivitas</option>
                        @foreach ($actionTypes as $key => $label)
                            <option value="{{ $key }}" {{ ($action ?? '') === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Search Input --}}
                    <div class="relative w-full sm:w-72">
                        <input type="text" name="q" value="{{ $search }}" placeholder="Cari deskripsi, pelaku, IP..." class="w-full min-h-[40px] pl-9 pr-4 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 placeholder-slate-400" />
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                @if ($search || ($action ?? ''))
                    <a href="{{ route('master.activity-logs.index') }}" class="text-xs sm:text-sm text-emerald-600 dark:text-emerald-400 hover:underline font-semibold self-end sm:self-auto">
                        Reset Filter
                    </a>
                @endif
            </form>
        </div>

        {{-- Tabel Log Aktivitas --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-xs">
            <x-table :headers="['Waktu (WIB)', 'Pelaku / Pengguna', 'Aktivitas', 'Deskripsi / Rincian', 'Alamat IP']">
                @forelse ($logs as $log)
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition">
                        <td class="px-4 py-3 sm:px-6 font-mono text-[11px] sm:text-xs text-slate-500 dark:text-slate-400 whitespace-nowrap">
                            {{ $log->created_at->format('d/m/Y H:i:s') }}
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-xs sm:text-sm whitespace-nowrap">
                            @if ($log->user)
                                <div class="font-bold text-slate-900 dark:text-slate-100">{{ $log->user->name }}</div>
                                <div class="text-[11px] font-mono text-slate-400 mt-0.5">
                                    {{ $log->user->login_id }} · <span class="capitalize text-emerald-600 dark:text-emerald-400 font-semibold">{{ $log->user->role }}</span>
                                </div>
                            @else
                                <span class="text-slate-400 italic">Sistem / Tamu</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-xs whitespace-nowrap">
                            @php
                                $badgeVariant = match(true) {
                                    str_contains($log->action, 'failed') || str_contains($log->action, 'deleted') => 'danger',
                                    str_contains($log->action, 'success') || str_contains($log->action, 'created') => 'success',
                                    str_contains($log->action, 'reset') || str_contains($log->action, 'archived') => 'teal',
                                    default => 'neutral',
                                };
                            @endphp
                            <x-badge :variant="$badgeVariant">
                                {{ $actionTypes[$log->action] ?? $log->action }}
                            </x-badge>
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-xs sm:text-sm text-slate-700 dark:text-slate-300 leading-relaxed">
                            {{ $log->description }}
                        </td>
                        <td class="px-4 py-3 sm:px-6 font-mono text-[11px] text-slate-400 whitespace-nowrap">
                            {{ $log->ip_address ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8">
                            <x-empty-state title="Belum ada catatan log" description="Tidak ditemukan catatan audit aktivitas yang sesuai dengan filter pencarian." />
                        </td>
                    </tr>
                @endforelse
            </x-table>

            @if ($logs->hasPages())
                <div class="p-4 sm:p-5 border-t border-slate-200 dark:border-slate-800">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
