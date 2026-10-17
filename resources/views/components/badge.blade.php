@props([
    'variant' => 'default', // default, success, warning, danger, info, primary
    'size' => 'md', // sm, md
])

@php
    $variants = [
        'default' => 'bg-slate-100 text-slate-700 border-slate-200',
        'success' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'warning' => 'bg-amber-50 text-amber-700 border-amber-200',
        'danger' => 'bg-rose-50 text-rose-700 border-rose-200',
        'info' => 'bg-sky-50 text-sky-700 border-sky-200',
        'purple' => 'bg-purple-50 text-purple-700 border-purple-200',
        // Status Laporan spesifik SISPERKA
        'baru' => 'bg-blue-50 text-blue-700 border-blue-200',
        'diverifikasi' => 'bg-amber-50 text-amber-700 border-amber-200',
        'diproses' => 'bg-purple-50 text-purple-700 border-purple-200',
        'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'ditolak' => 'bg-rose-50 text-rose-700 border-rose-200',
    ];

    $sizes = [
        'sm' => 'px-2 py-0.5 text-[11px]',
        'md' => 'px-2.5 py-1 text-xs',
    ];

    $classes = 'inline-flex items-center font-medium rounded-full border ' . ($variants[$variant] ?? $variants['default']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
