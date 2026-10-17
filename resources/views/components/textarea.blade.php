@props([
    'name',
    'id' => null,
    'label' => null,
    'value' => null,
    'placeholder' => null,
    'helper' => null,
    'rows' => 4,
    'required' => false,
])

@php
    $id = $id ?? $name;
    $hasError = $errors->has($name);
@endphp

<div class="flex flex-col gap-1.5 w-full">
    @if ($label)
        <label for="{{ $id }}" class="text-xs font-semibold text-slate-700 flex items-center justify-between">
            <span>
                {{ $label }}
                @if ($required)
                    <span class="text-rose-500 font-bold ml-0.5">*</span>
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
        {{ $attributes->merge([
            'class' => 'w-full rounded-lg border text-sm px-3.5 py-2.5 transition focus:outline-none focus:ring-2 ' . 
                ($hasError 
                    ? 'border-rose-300 bg-rose-50/30 text-rose-900 focus:border-rose-500 focus:ring-rose-200' 
                    : 'border-slate-300 bg-white text-slate-800 focus:border-emerald-500 focus:ring-emerald-100 placeholder:text-slate-400')
        ]) }}
    >{{ old($name, $value) }}</textarea>

    @if ($helper && !$hasError)
        <p class="text-[11px] text-slate-500 leading-normal">{{ $helper }}</p>
    @endif

    @error($name)
        <p class="text-xs text-rose-600 font-medium flex items-center gap-1 mt-0.5" role="alert">
            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>
