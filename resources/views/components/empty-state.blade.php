@props([
    'title' => 'Belum ada data',
    'description' => 'Data yang dicari belum tersedia atau belum ditambahkan.',
    'icon' => null,
])

<div {{ $attributes->merge(['class' => 'text-center py-12 px-6 rounded-2xl border border-dashed border-slate-300 dark:border-slate-700 bg-white dark:bg-[#16231D]']) }}>
    <div class="mx-auto w-14 h-14 rounded-2xl bg-primary-50 dark:bg-primary-950/60 text-primary-700 dark:text-[#5AE39D] border border-primary-100 dark:border-primary-800 flex items-center justify-center mb-4">
        @if ($icon)
            {{ $icon }}
        @else
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
        @endif
    </div>
    
    <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-slate-100 tracking-tight">{{ $title }}</h3>
    
    @if ($description)
        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 max-w-md mx-auto mt-1.5 leading-relaxed">
            {{ $description }}
        </p>
    @endif

    @if ($slot->isNotEmpty())
        <div class="mt-5">
            {{ $slot }}
        </div>
    @endif
</div>
