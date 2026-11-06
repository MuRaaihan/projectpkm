@props([
    'name',
    'id' => null,
    'label' => null,
    'helper' => null,
    'hint' => null,
    'required' => false,
])

@php
    $id = $id ?? $name;
    $helperText = $helper ?? $hint;
    $hasError = $errors->has($name);
    $helpId = $helperText ? $id . '-help' : null;
    $errorId = $hasError ? $id . '-error' : null;
    $describedBy = trim(($errorId ?? '') . ' ' . ($helpId ?? '')) ?: null;
@endphp

<div class="flex flex-col gap-1.5 w-full">
    @if ($label)
        <label for="{{ $id }}" class="text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 flex items-center justify-between">
            <span>
                {{ $label }}
                @if ($required)
                    <span class="text-rose-600 dark:text-rose-400 font-bold ml-1" title="Wajib diisi">*</span>
                @else
                    <span class="text-xs font-normal text-slate-400 dark:text-slate-500 ml-1">(opsional)</span>
                @endif
            </span>
        </label>
    @endif

    <div class="relative">
        <select 
            name="{{ $name }}"
            id="{{ $id }}"
            {{ $required ? 'required' : '' }}
            @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
            @if ($hasError) aria-invalid="true" @endif
            {{ $attributes->merge([
                'class' => 'w-full min-h-[44px] appearance-none cursor-pointer rounded-xl border text-xs sm:text-sm pl-3.5 pr-10 py-2.5 transition focus:outline-none focus:ring-2 ' . 
                    ($hasError 
                        ? 'border-rose-500 bg-rose-50/50 text-slate-900 dark:bg-rose-950/20 dark:text-slate-100 dark:border-rose-500 focus:border-rose-500 focus:ring-rose-200 dark:focus:ring-rose-900/40' 
                        : 'border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:border-primary-600 focus:ring-primary-600/20 dark:focus:border-[#5AE39D] dark:focus:ring-[#5AE39D]/20')
            ]) }}
        >
            {{ $slot }}
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 dark:text-slate-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>

    @if ($helperText && !$hasError)
        <p id="{{ $helpId }}" class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">{{ $helperText }}</p>
    @endif

    @error($name)
        <p id="{{ $errorId }}" class="text-xs text-rose-600 dark:text-rose-400 font-medium flex items-center gap-1.5 mt-0.5" role="alert">
            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>
