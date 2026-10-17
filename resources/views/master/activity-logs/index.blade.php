<x-layouts.app title="Log Aktivitas & Audit Keamanan">
    <div class="space-y-6">
        {{-- Header --}}
        <div class="pb-2 border-b border-slate-200">
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('master.dashboard') }}" class="text-xs text-slate-500 hover:text-slate-800">Master</a>
                <span class="text-xs text-slate-300">/</span>
                <span class="text-xs font-semibold text-purple-700">Log Aktivitas</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                        Log Aktivitas & Audit Keamanan
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500">
                        Rekam jejak tindakan pengguna, perubahan akun, dan peristiwa keamanan sistem (Hanya Baca / Read-Only).
                    </p>
                </div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-700 rounded-lg text-xs font-mono font-semibold self-start sm:self-auto">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Audit Log Immutability Active
                </div>
            </div>
        </div>

        {{-- Filter & Pencarian --}}
        <x-card class="p-4!">
            <form method="GET" action="{{ route('master.activity-logs.index') }}" class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-2">
                    {{-- Filter Jenis Aksi --}}
                    <select name="action" onchange="this.form.submit()" class="text-xs rounded-lg border border-slate-300 py-1.5 pl-2.5 pr-8 bg-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">Semua Jenis Aktivitas</option>
                        @foreach ($actionTypes as $key => $label)
                            <option value="{{ $key }}" {{ $action === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Search Input --}}
                    <div class="relative w-full sm:w-64">
                        <input type="text" name="q" value="{{ $search }}" placeholder="Cari deskripsi, pelaku, IP..." class="w-full pl-8 pr-3 py-1.5 text-xs rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-purple-500 bg-white" />
                        <svg class="w-4 h-4 text-slate-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                @if ($search || $action)
                    <a href="{{ route('master.activity-logs.index') }}" class="text-xs text-slate-500 hover:text-slate-800 self-end sm:self-auto">
                        Reset Filter
                    </a>
                @endif
            </form>
        </x-card>

        {{-- Tabel Log Aktivitas --}}
        <x-card class="p-0! overflow-hidden">
            <x-table :headers="['Waktu (WIB)', 'Pelaku / Pengguna', 'Aktivitas', 'Deskripsi / Rincian', 'Alamat IP']">
                @forelse ($logs as $log)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="px-4 py-3 sm:px-6 font-mono text-[11px] text-slate-600 whitespace-nowrap">
                            {{ $log->created_at->format('d/m/Y H:i:s') }}
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-xs whitespace-nowrap">
                            @if ($log->user)
                                <div class="font-bold text-slate-800">{{ $log->user->name }}</div>
                                <div class="text-[11px] font-mono text-slate-500">
                                    {{ $log->user->login_id }} · <span class="capitalize text-purple-700 font-semibold">{{ $log->user->role }}</span>
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
                                    str_contains($log->action, 'reset') || str_contains($log->action, 'archived') => 'purple',
                                    default => 'neutral',
                                };
                            @endphp
                            <x-badge :variant="$badgeVariant">
                                {{ $actionTypes[$log->action] ?? $log->action }}
                            </x-badge>
                        </td>
                        <td class="px-4 py-3 sm:px-6 text-xs text-slate-700 leading-relaxed">
                            {{ $log->description }}
                        </td>
                        <td class="px-4 py-3 sm:px-6 font-mono text-[11px] text-slate-500 whitespace-nowrap">
                            {{ $log->ip_address ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4">
                            <x-empty-state title="Belum ada catatan log" description="Tidak ditemukan catatan audit aktivitas yang sesuai dengan filter pencarian." />
                        </td>
                    </tr>
                @endforelse
            </x-table>

            @if ($logs->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $logs->links() }}
                </div>
            @endif
        </x-card>
    </div>
</x-layouts.app>
