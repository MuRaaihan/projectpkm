@props([
    'title' => null,
    'subtitle' => null,
    'footer' => null,
    'hover' => false,
])

<div {{ $attributes->merge(['class' => 'bg-surface-card dark:bg-[#16231D] rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs overflow-hidden' . ($hover ? ' card-hover' : '')]) }}>
    @if ($title || $subtitle || isset($header))
        <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-800 flex flex-wrap items-center justify-between gap-2 bg-slate-50/40 dark:bg-slate-900/20">
            @if (isset($header))
                {{ $header }}
            @else
                <div>
                    @if ($title)
                        <h3 class="font-extrabold text-base sm:text-lg text-slate-900 dark:text-slate-100 tracking-tight leading-snug">{{ $title }}</h3>
                    @endif
                    @if ($subtitle)
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">{{ $subtitle }}</p>
                    @endif
                </div>
            @endif
        </div>
    @endif

    <div class="p-5 sm:p-6">
        {{ $slot }}
    </div>

    @if ($footer || isset($footerSlot))
        <div class="px-5 py-3.5 bg-slate-50/60 dark:bg-slate-900/40 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-3 text-xs sm:text-sm text-slate-500 dark:text-slate-400">
            {{ $footerSlot ?? $footer }}
        </div>
    @endif
</div>
