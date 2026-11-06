import React, { useRef, KeyboardEvent, ClipboardEvent } from 'react';

interface OTPInputProps {
  length?: number;
  value: string;
  onChange: (value: string) => void;
  disabled?: boolean;
}

export function OTPInput({ length = 6, value, onChange, disabled = false }: OTPInputProps) {
  const inputsRef = useRef<(HTMLInputElement | null)[]>([]);

  const focusInput = (index: number) => {
    if (index >= 0 && index < length) {
      inputsRef.current[index]?.focus();
    }
  };

  const handleKeyDown = (e: KeyboardEvent<HTMLInputElement>, index: number) => {
    if (e.key === 'Backspace') {
      e.preventDefault();
      const valueArr = value.split('');
      
      if (valueArr[index]) {
        // If current cell has value, clear it
        valueArr[index] = '';
        onChange(valueArr.join(''));
      } else {
        // If current cell is empty, clear previous and move focus
        if (index > 0) {
          valueArr[index - 1] = '';
          onChange(valueArr.join(''));
          focusInput(index - 1);
        }
      }
    } else if (e.key === 'ArrowLeft') {
      e.preventDefault();
      focusInput(index - 1);
    } else if (e.key === 'ArrowRight') {
      e.preventDefault();
      focusInput(index + 1);
    }
  };

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>, index: number) => {
    const val = e.target.value;
    // We only care about the last typed character in case of quick typing
    const char = val.slice(-1);

    if (/^[0-9]$/.test(char)) {
      const valueArr = value.padEnd(length, ' ').split('');
      valueArr[index] = char;
      const newValue = valueArr.join('').replace(/ /g, '');
      onChange(newValue);
      
      // Move to next input
      if (index < length - 1) {
        focusInput(index + 1);
      }
    }
  };

  const handlePaste = (e: ClipboardEvent<HTMLInputElement>) => {
    e.preventDefault();
    const pastedData = e.clipboardData.getData('text');
    // Extract only numbers
    const numbersOnly = pastedData.replace(/[^0-9]/g, '');
    
    if (!numbersOnly) return;

    // We merge the pasted string with the current value starting from index 0
    const newValue = numbersOnly.slice(0, length);
    onChange(newValue);

    // Focus the next empty input, or the last input if full
    const nextFocusIndex = Math.min(newValue.length, length - 1);
    focusInput(nextFocusIndex);
  };

  return (
    <div className="flex justify-between gap-2 sm:gap-3 w-full">
      {Array.from({ length }).map((_, index) => {
        const char = value[index] || '';
        return (
          <input
            key={index}
            ref={(el) => {
              inputsRef.current[index] = el;
            }}
            type="text"
            inputMode="numeric"
            autoComplete={index === 0 ? "one-time-code" : "off"}
            maxLength={2} // allow 2 so we can catch the second typed char before replacing
            value={char}
            onChange={(e) => handleChange(e, index)}
            onKeyDown={(e) => handleKeyDown(e, index)}
            onPaste={handlePaste}
            disabled={disabled}
            className={[
              "w-full h-12 sm:h-14 text-center text-lg sm:text-xl font-semibold",
              "bg-surface-card text-slate-900 placeholder-slate-400",
              "border rounded-md transition-colors duration-150",
              "dark:bg-slate-800 dark:text-slate-100",
              "border-slate-300 dark:border-slate-700",
              "focus:border-primary-500 focus:ring-2 focus:ring-primary-100",
              "dark:focus:border-primary-500 dark:focus:ring-primary-900/30",
              "outline-none",
              "disabled:opacity-50 disabled:cursor-not-allowed"
            ].join(' ')}
          />
        );
      })}
    </div>
  );
}

