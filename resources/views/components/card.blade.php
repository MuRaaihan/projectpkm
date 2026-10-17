@props([
    'title' => null,
    'subtitle' => null,
    'footer' => null,
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden']) }}>
    @if ($title || $subtitle || isset($header))
        <div class="px-5 py-4 border-b border-slate-100 flex flex-wrap items-center justify-between gap-2">
            @if (isset($header))
                {{ $header }}
            @else
                <div>
                    @if ($title)
                        <h3 class="font-bold text-base text-slate-900 tracking-tight leading-tight">{{ $title }}</h3>
                    @endif
                    @if ($subtitle)
                        <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">{{ $subtitle }}</p>
                    @endif
                </div>
            @endif
        </div>
    @endif

    <div class="p-5 sm:p-6">
        {{ $slot }}
    </div>

    @if ($footer || isset($footerSlot))
        <div class="px-5 py-3.5 bg-slate-50/70 border-t border-slate-100 flex items-center justify-between gap-3 text-sm">
            {{ $footerSlot ?? $footer }}
        </div>
    @endif
</div>
