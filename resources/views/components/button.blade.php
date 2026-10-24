@props([
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, danger, outline, ghost, subtle
    'size' => 'md', // sm, md, lg
    'disabled' => false,
    'fullWidth' => false,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-semibold rounded-xl transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-slate-900 disabled:opacity-50 disabled:pointer-events-none cursor-pointer select-none';

    $variants = [
        'primary' => 'bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white shadow-xs focus:ring-primary-600 border border-primary-700/60',
        'secondary' => 'bg-slate-900 text-white hover:bg-slate-800 active:bg-slate-950 shadow-xs focus:ring-slate-900 dark:bg-slate-100 dark:text-slate-900 dark:hover:bg-white',
        'danger' => 'bg-red-600 hover:bg-red-700 active:bg-red-800 text-white shadow-xs focus:ring-red-600',
        'outline' => 'border border-slate-300 dark:border-slate-700 bg-white dark:bg-[#16231D] hover:bg-slate-100 active:bg-slate-200 text-slate-800 dark:text-slate-100 dark:hover:bg-slate-800 focus:ring-slate-400',
        'ghost' => 'text-primary-700 hover:bg-primary-50 active:bg-primary-100 dark:text-[#5AE39D] dark:hover:bg-emerald-950/40 focus:ring-primary-600',
        'subtle' => 'bg-slate-100 text-slate-800 hover:bg-slate-200 active:bg-slate-300 dark:bg-slate-800 dark:text-slate-100 dark:hover:bg-slate-700 focus:ring-slate-400',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs rounded-lg gap-1.5 min-h-[36px]',
        'md' => 'px-4 py-2 text-sm rounded-xl gap-2 min-h-[44px]',
        'lg' => 'px-6 py-2.5 text-base rounded-xl gap-2.5 min-h-[48px] font-bold',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']) . ($fullWidth ? ' w-full' : '');
@endphp

<button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
