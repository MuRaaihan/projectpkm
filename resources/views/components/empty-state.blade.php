@props([
    'title' => 'Belum ada data',
    'description' => 'Data yang dicari belum tersedia atau belum ditambahkan.',
    'icon' => null,
])

<div {{ $attributes->merge(['class' => 'text-center py-12 px-6 rounded-xl border border-dashed border-[#CBD5E1] bg-white']) }}>
    <div class="mx-auto w-14 h-14 rounded-full bg-[#F0FDFA] text-[#0F766E] border border-[#CCFBF1] flex items-center justify-center mb-4">
        @if ($icon)
            {{ $icon }}
        @else
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
        @endif
    </div>
    
    <h3 class="text-base sm:text-lg font-bold text-[#0F172A] tracking-tight">{{ $title }}</h3>
    
    @if ($description)
        <p class="text-sm text-[#475569] max-w-md mx-auto mt-1.5 leading-relaxed">
            {{ $description }}
        </p>
    @endif

    @if ($slot->isNotEmpty())
        <div class="mt-5">
            {{ $slot }}
        </div>
    @endif
</div>
