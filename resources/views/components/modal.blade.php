@props([
    'id',
    'title' => 'Konfirmasi Tindakan',
    'maxWidth' => 'md', // sm, md, lg, xl
])

@php
    $widths = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
    ];
@endphp

<div 
    id="{{ $id }}"
    x-data="{ open: false }"
    x-show="open"
    x-on:open-modal.window="if ($event.detail === '{{ $id }}') open = true"
    x-on:close-modal.window="if ($event.detail === '{{ $id }}') open = false"
    x-on:keydown.escape.window="open = false"
    style="display: none;"
    class="fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="{{ $id }}-title" 
    role="dialog" 
    aria-modal="true"
>
    {{-- Backdrop --}}
    <div 
        x-show="open" 
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity" 
        @click="open = false"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        {{-- Modal Dialog --}}
        <div 
            x-show="open"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all w-full {{ $widths[$maxWidth] ?? $widths['md'] }} border border-slate-200"
        >
            <div class="px-6 pt-6 pb-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900 tracking-tight" id="{{ $id }}-title">
                        {{ $title }}
                    </h3>
                    <button 
                        type="button" 
                        @click="open = false"
                        class="text-slate-400 hover:text-slate-600 p-1 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-slate-400"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span class="sr-only">Tutup</span>
                    </button>
                </div>

                <div class="mt-4 text-sm text-slate-600 leading-relaxed">
                    {{ $slot }}
                </div>
            </div>

            @if (isset($footer))
                <div class="bg-slate-50 px-6 py-3.5 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
