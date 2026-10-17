@props([
    'title' => 'Belum ada data',
    'description' => 'Data yang kamu cari belum tersedia atau belum ditambahkan.',
    'icon' => null,
])

<div {{ $attributes->merge(['class' => 'text-center py-12 px-4 rounded-2xl border border-dashed border-slate-200 bg-white/60']) }}>
    <div class="mx-auto w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mb-3">
        @if ($icon)
            {{ $icon }}
        @else
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
        @endif
    </div>
    
    <h3 class="text-sm font-bold text-slate-800 tracking-tight">{{ $title }}</h3>
    
    @if ($description)
        <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 leading-relaxed">
            {{ $description }}
        </p>
    @endif

    @if ($slot->isNotEmpty())
        <div class="mt-4">
            {{ $slot }}
        </div>
    @endif
</div>
