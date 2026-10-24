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
        <label for="{{ $id }}" class="text-[15px] font-semibold text-[#0F172A] flex items-center justify-between">
            <span>
                {{ $label }}
                @if ($required)
                    <span class="text-[#B91C1C] font-semibold ml-1" title="Wajib diisi">*</span>
                @else
                    <span class="text-xs font-normal text-[#64748B] ml-1">(opsional)</span>
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
            'class' => 'w-full rounded-xl border text-base px-3.5 py-2.5 transition focus:outline-none focus:ring-2 ' . 
                ($hasError 
                    ? 'border-[#B91C1C] bg-[#FEF2F2] text-[#0F172A] focus:border-[#B91C1C] focus:ring-[#FEE2E2]' 
                    : 'border-[#CBD5E1] bg-white text-[#0F172A] focus:border-[#0F766E] focus:ring-[#CCFBF1] placeholder:text-[#94A3B8]')
        ]) }}
    >{{ old($name, $value) }}</textarea>

    @if ($helperText && !$hasError)
        <p id="{{ $helpId }}" class="text-sm text-[#475569] leading-relaxed">{{ $helperText }}</p>
    @endif

    @error($name)
        <p id="{{ $errorId }}" class="text-sm text-[#B91C1C] font-medium flex items-center gap-1.5 mt-0.5" role="alert">
            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>
