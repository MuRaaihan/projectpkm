@props([
    'type' => 'info', // success, error, warning, info
    'message' => null,
    'dismissible' => true,
])

@php
    $styles = [
        'success' => [
            'box' => 'bg-emerald-50 dark:bg-emerald-950/40 border-emerald-200 dark:border-emerald-800 text-emerald-900 dark:text-emerald-200',
            'icon' => '<svg class="w-5 h-5 text-emerald-600 dark:text-[#5AE39D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        ],
        'error' => [
            'box' => 'bg-rose-50 dark:bg-rose-950/40 border-rose-200 dark:border-rose-900/60 text-rose-900 dark:text-rose-200',
            'icon' => '<svg class="w-5 h-5 text-rose-600 dark:text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        ],
        'warning' => [
            'box' => 'bg-amber-50 dark:bg-amber-950/40 border-amber-200 dark:border-amber-800 text-amber-900 dark:text-amber-200',
            'icon' => '<svg class="w-5 h-5 text-amber-600 dark:text-[#FAD46B] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
        ],
        'info' => [
            'box' => 'bg-sky-50 dark:bg-sky-950/40 border-sky-200 dark:border-sky-800 text-sky-900 dark:text-sky-200',
            'icon' => '<svg class="w-5 h-5 text-sky-600 dark:text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        ],
    ];

    $current = $styles[$type] ?? $styles['info'];
@endphp

<div 
    role="alert" 
    x-data="{ show: true }" 
    x-show="show" 
    class="flex items-start gap-3 p-4 rounded-xl border text-sm {{ $current['box'] }} shadow-xs transition"
>
    <div class="mt-0.5">
        {!! $current['icon'] !!}
    </div>

    <div class="flex-1 font-medium leading-relaxed">
        {{ $message ?? $slot }}
    </div>

    @if ($dismissible)
        <button 
            type="button" 
            @click="show = false" 
            class="min-w-[44px] min-h-[44px] -my-2 -mr-2 inline-flex items-center justify-center opacity-70 hover:opacity-100 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-current"
            title="Tutup pesan"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span class="sr-only">Tutup pemberitahuan</span>
        </button>
    @endif
</div>
