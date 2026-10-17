@props([
    'type' => 'info', // success, error, warning, info
    'message' => null,
    'dismissible' => true,
])

@php
    $styles = [
        'success' => [
            'box' => 'bg-emerald-50 border-emerald-200 text-emerald-900',
            'icon' => '<svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        ],
        'error' => [
            'box' => 'bg-rose-50 border-rose-200 text-rose-900',
            'icon' => '<svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        ],
        'warning' => [
            'box' => 'bg-amber-50 border-amber-200 text-amber-900',
            'icon' => '<svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
        ],
        'info' => [
            'box' => 'bg-sky-50 border-sky-200 text-sky-900',
            'icon' => '<svg class="w-5 h-5 text-sky-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
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
            class="text-slate-400 hover:text-slate-600 p-1 rounded-md transition focus:outline-none focus:ring-2 focus:ring-slate-400"
            title="Tutup pesan"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span class="sr-only">Tutup</span>
        </button>
    @endif
</div>
