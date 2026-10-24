@props([
    'variant' => 'default', // default, success, warning, danger, info, primary, or status names: baru, diverifikasi, diproses, selesai, ditolak
    'size' => 'md', // sm, md, lg
    'withDot' => true,
])

@php
    $dotClasses = [
        'default' => 'bg-slate-500',
        'success' => 'bg-emerald-600 dark:bg-[#5AE39D]',
        'warning' => 'bg-amber-500 dark:bg-[#FAD46B]',
        'danger' => 'bg-red-500 dark:bg-red-400',
        'info' => 'bg-sky-500',
        'primary' => 'bg-primary-600 dark:bg-[#5AE39D]',

        // Status Laporan Resmi SISPERKA
        'baru' => 'bg-slate-500 dark:bg-slate-300',
        'diverifikasi' => 'bg-[#176B4D] dark:bg-[#5AE39D]',
        'sudah_dibaca' => 'bg-[#176B4D] dark:bg-[#5AE39D]',
        'diproses' => 'bg-amber-500 dark:bg-[#FAD46B]',
        'sedang_ditangani' => 'bg-amber-500 dark:bg-[#FAD46B]',
        'selesai' => 'bg-[#176B4D] dark:bg-[#5AE39D]',
        'ditolak' => 'bg-red-500 dark:bg-red-400',
        'tidak_dapat_diproses' => 'bg-slate-500 dark:bg-slate-400',
    ];

    $variants = [
        'default' => 'bg-slate-100 text-slate-700 border-slate-300 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700',
        'success' => 'bg-emerald-50 text-emerald-800 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800',
        'warning' => 'bg-amber-50 text-amber-800 border-amber-200 dark:bg-amber-950/40 dark:text-amber-300 dark:border-amber-800',
        'danger' => 'bg-red-50 text-red-800 border-red-200 dark:bg-red-950/40 dark:text-red-300 dark:border-red-800',
        'info' => 'bg-sky-50 text-sky-800 border-sky-200 dark:bg-sky-950/40 dark:text-sky-300 dark:border-sky-800',
        'primary' => 'bg-primary-50 text-primary-800 border-primary-200 dark:bg-primary-950/40 dark:text-primary-300 dark:border-primary-800',

        // Status Laporan Resmi
        'baru' => 'bg-status-received-bg text-status-received-text border-slate-300/80 dark:border-slate-700',
        'diverifikasi' => 'bg-status-verified-bg text-status-verified-text border-emerald-300/70 dark:border-emerald-800/60',
        'sudah_dibaca' => 'bg-status-verified-bg text-status-verified-text border-emerald-300/70 dark:border-emerald-800/60',
        'diproses' => 'bg-status-processing-bg text-status-processing-text border-amber-300/70 dark:border-amber-800/60',
        'sedang_ditangani' => 'bg-status-processing-bg text-status-processing-text border-amber-300/70 dark:border-amber-800/60',
        'selesai' => 'bg-status-completed-bg text-status-completed-text border-emerald-300/70 dark:border-emerald-800/60',
        'ditolak' => 'bg-status-rejected-bg text-status-rejected-text border-red-300/70 dark:border-red-800/60',
        'tidak_dapat_diproses' => 'bg-status-received-bg text-status-received-text border-slate-300/80 dark:border-slate-700',
    ];

    $sizes = [
        'sm' => 'px-2.5 py-0.5 text-[11px]',
        'md' => 'px-3 py-1 text-xs font-semibold',
        'lg' => 'px-3.5 py-1.5 text-sm font-semibold',
    ];

    $classes = 'inline-flex items-center gap-1.5 font-semibold rounded-full border shadow-2xs ' . ($variants[$variant] ?? $variants['default']) . ' ' . ($sizes[$size] ?? $sizes['md']);
    $dotClass = $dotClasses[$variant] ?? $dotClasses['default'];
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($withDot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }} shrink-0" aria-hidden="true"></span>
    @endif
    {{ $slot }}
</span>
