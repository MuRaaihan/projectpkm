// ── Textarea Component ────────────────────────────────────────
import { type TextareaHTMLAttributes, forwardRef } from "react";

interface TextareaProps extends TextareaHTMLAttributes<HTMLTextAreaElement> {
  label?: string;
  error?: string;
  helperText?: string;
  showCharCount?: boolean;
  maxChars?: number;
  rows?: number;
}

export const Textarea = forwardRef<HTMLTextAreaElement, TextareaProps>(
  (
    {
      label,
      error,
      helperText,
      showCharCount,
      maxChars,
      className = "",
      id,
      value,
      rows = 4,
      ...props
    },
    ref,
  ) => {
    const inputId = id ?? label?.toLowerCase().replace(/\s+/g, "-");
    const charCount = typeof value === "string" ? value.length : 0;

    return (
      <div className="flex flex-col gap-1.5 w-full">
        {label && (
          <div className="flex items-center justify-between">
            <label
              htmlFor={inputId}
              className="text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-200"
            >
              {label}
            </label>
            {showCharCount && maxChars && (
              <span
                className={`text-xs tabular-nums font-mono ${charCount > maxChars ? "text-red-500 font-bold" : "text-slate-500 dark:text-slate-400"}`}
              >
                {charCount}/{maxChars}
              </span>
            )}
          </div>
        )}
        <textarea
          ref={ref}
          id={inputId}
          rows={rows}
          value={value}
          className={[
            "w-full text-sm bg-surface-card text-slate-900 placeholder:text-slate-500 py-3 px-3.5",
            "border rounded-xl transition-all duration-150 resize-y shadow-2xs",
            "dark:bg-slate-800/80 dark:text-slate-100 dark:placeholder:text-slate-400",
            error
              ? "border-red-400 focus:border-red-500 focus:ring-2 focus:ring-red-100 dark:focus:ring-red-950/50"
              : "border-slate-300 dark:border-slate-700 focus:border-primary-600 focus:ring-2 focus:ring-primary-100 dark:focus:border-[#5AE39D] dark:focus:ring-emerald-950/60",
            "outline-none",
            "disabled:opacity-50 disabled:cursor-not-allowed",
            className,
          ]
            .filter(Boolean)
            .join(" ")}
          {...props}
        />
        {error && (
          <p className="text-xs text-red-600 dark:text-red-400 font-medium" role="alert">
            {error}
          </p>
        )}
        {helperText && !error && (
          <p className="text-xs text-slate-500 dark:text-slate-400">
            {helperText}
          </p>
        )}
      </div>
    );
  },
);

Textarea.displayName = "Textarea";
