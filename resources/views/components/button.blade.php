@props([
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, danger, outline, ghost, subtle
    'size' => 'md', // sm, md, lg
    'disabled' => false,
    'fullWidth' => false,
])

@php
    $baseClasses = 'inline-flex items-center justify-center transition-all duration-150 cursor-pointer select-none disabled:opacity-50 disabled:cursor-not-allowed';

    $variants = [
        'primary' => 'bg-primary-600 text-white hover:bg-primary-700 active:bg-primary-800 shadow-xs transition-colors',
        'secondary' => 'bg-slate-900 text-white hover:bg-slate-800 active:bg-slate-950 shadow-xs dark:bg-slate-100 dark:text-slate-900 dark:hover:bg-white',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 active:bg-red-800 shadow-xs',
        'outline' => 'bg-surface-card border border-slate-300 text-slate-800 hover:bg-slate-100 active:bg-slate-200 dark:bg-slate-800/80 dark:border-slate-700 dark:text-slate-100 dark:hover:bg-slate-800',
        'ghost' => 'bg-transparent text-primary-700 hover:bg-primary-50/70 active:bg-primary-100 dark:text-[#5AE39D] dark:hover:bg-emerald-950/40',
        'subtle' => 'bg-slate-100 text-slate-800 hover:bg-slate-200 active:bg-slate-300 dark:bg-slate-800 dark:text-slate-100 dark:hover:bg-slate-700',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs rounded-lg gap-1.5 h-8 font-semibold',
        'md' => 'px-4 py-2 text-sm rounded-xl gap-2 h-10 font-semibold',
        'lg' => 'px-6 py-2.5 text-base rounded-xl gap-2.5 h-12 font-bold',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']) . ($fullWidth ? ' w-full' : '');
@endphp

<button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
