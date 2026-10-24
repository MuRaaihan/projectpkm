@props([
    'name',
    'id' => null,
    'label' => null,
    'value' => null,
    'placeholder' => null,
    'helper' => null,
    'hint' => null,
    'rows' => 4,
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

    <textarea 
        name="{{ $name }}"
        id="{{ $id }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
        @if ($hasError) aria-invalid="true" @endif
        {{ $attributes->merge([
            'class' => 'w-full rounded-xl border text-xs sm:text-sm px-3.5 py-2.5 transition focus:outline-none focus:ring-2 ' . 
                ($hasError 
                    ? 'border-rose-500 bg-rose-50/50 text-slate-900 dark:bg-rose-950/20 dark:text-slate-100 dark:border-rose-500 focus:border-rose-500 focus:ring-rose-200 dark:focus:ring-rose-900/40' 
                    : 'border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:border-primary-600 focus:ring-primary-600/20 dark:focus:border-[#5AE39D] dark:focus:ring-[#5AE39D]/20 placeholder:text-slate-400 dark:placeholder:text-slate-500')
        ]) }}
    >{{ old($name, $value) }}</textarea>

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
