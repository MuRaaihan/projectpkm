@props([
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, danger, outline, ghost
    'size' => 'md', // sm, md, lg
    'disabled' => false,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg transition focus:outline-none focus:ring-2 focus:ring-offset-2 active:scale-[0.98] disabled:opacity-50 disabled:pointer-events-none cursor-pointer select-none';

    $variants = [
        'primary' => 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-xs focus:ring-emerald-500',
        'secondary' => 'bg-slate-100 hover:bg-slate-200 text-slate-700 focus:ring-slate-400',
        'danger' => 'bg-rose-600 hover:bg-rose-700 text-white shadow-xs focus:ring-rose-500',
        'outline' => 'border border-slate-300 hover:bg-slate-50 text-slate-700 focus:ring-slate-400',
        'ghost' => 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 focus:ring-slate-400',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs gap-1.5',
        'md' => 'px-4 py-2 text-sm gap-2',
        'lg' => 'px-5 py-2.5 text-base gap-2.5',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

<button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
