@props([
    'name',
    'id' => null,
    'label' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'helper' => null,
    'hint' => null,
    'required' => false,
])

@php
    $id = $id ?? $name;
    $helperText = $helper ?? $hint;
    $hasError = $errors->has($name);
    $isPassword = ($type === 'password');
@endphp

<div class="flex flex-col gap-1.5 w-full" @if($isPassword) x-data="{ showPassword: false }" @endif>
    @if ($label)
        <label for="{{ $id }}" class="text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 flex items-center justify-between">
            <span>
                {{ $label }}
                @if ($required)
                    <span class="text-rose-600 dark:text-rose-400 font-bold ml-1" title="Kolom ini wajib diisi">(wajib)</span>
                @endif
            </span>
        </label>
    @endif

    <div class="relative">
        <input 
            @if($isPassword)
                :type="showPassword ? 'text' : 'password'"
            @else
                type="{{ $type }}"
            @endif
            name="{{ $name }}"
            id="{{ $id }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            @if ($hasError)
                aria-invalid="true"
                aria-describedby="{{ $id }}-error"
            @elseif ($helperText)
                aria-describedby="{{ $id }}-helper"
            @endif
            {{ $attributes->merge([
                'class' => 'w-full rounded-xl border text-xs sm:text-sm px-3.5 py-2.5 min-h-[44px] transition focus:outline-none focus:ring-2 ' . 
                    ($hasError 
                        ? 'border-rose-500 bg-rose-50/50 text-slate-900 dark:bg-rose-950/20 dark:text-slate-100 dark:border-rose-500 focus:border-rose-500 focus:ring-rose-200 dark:focus:ring-rose-900/40' 
                        : 'border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:border-primary-600 focus:ring-primary-600/20 dark:focus:border-[#5AE39D] dark:focus:ring-[#5AE39D]/20 placeholder:text-slate-400 dark:placeholder:text-slate-500') .
                    ($isPassword ? ' pr-12' : '')
            ]) }}
        />

        @if ($isPassword)
            <button 
                type="button" 
                @click="showPassword = !showPassword"
                class="absolute right-1 top-1/2 -translate-y-1/2 p-2 min-h-[44px] min-w-[44px] inline-flex items-center justify-center text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-600 dark:focus:ring-[#5AE39D]"
                :aria-label="showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
            >
                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                </svg>
            </button>
        @endif
    </div>

    @if ($helperText && !$hasError)
        <p id="{{ $id }}-helper" class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">{{ $helperText }}</p>
    @endif

    @error($name)
        <p id="{{ $id }}-error" class="text-xs text-rose-600 dark:text-rose-400 font-medium flex items-center gap-1.5 mt-0.5" role="alert">
            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>

