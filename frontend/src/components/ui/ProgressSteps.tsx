// ── ProgressSteps Component ───────────────────────────────────
import { Check } from "lucide-react";

interface ProgressStepsProps {
  steps: string[];
  currentStep: number; // 0-indexed
}

export function ProgressSteps({ steps, currentStep }: ProgressStepsProps) {
  return (
    <div
      className="flex items-center gap-0 px-4 py-3 max-w-2xl w-full mx-auto lg:px-8"
      role="list"
      aria-label="Langkah-langkah pengisian"
    >
      {steps.map((step, index) => {
        const isDone = index < currentStep;
        const isActive = index === currentStep;
        const isLast = index === steps.length - 1;

        return (
          <div
            key={step}
            className="flex items-center flex-1 last:flex-none"
            role="listitem"
          >
            {/* Step circle */}
            <div className="flex flex-col items-center gap-1.5">
              <div
                className={[
                  "w-8 h-8 rounded-full flex items-center justify-center shrink-0 transition-all duration-200 shadow-2xs font-mono",
                  isDone
                    ? "bg-primary-600 dark:bg-[#289E70] text-white"
                    : isActive
                    ? "bg-primary-600 dark:bg-[#289E70] text-white ring-4 ring-primary-100 dark:ring-emerald-950/80"
                    : "bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-300 dark:border-slate-700",
                ].join(" ")}
                aria-current={isActive ? "step" : undefined}
              >
                {isDone ? (
                  <Check className="w-4 h-4 text-[#B8E34B]" aria-hidden="true" />
                ) : (
                  <span className="text-xs font-bold">{index + 1}</span>
                )}
              </div>
              <span
                className={`text-[11px] font-semibold whitespace-nowrap ${
                  isActive
                    ? "text-primary-700 dark:text-[#5AE39D]"
                    : isDone
                    ? "text-slate-800 dark:text-slate-200"
                    : "text-slate-500 dark:text-slate-400"
                }`}
              >
                {step}
              </span>
            </div>

            {/* Connector line */}
            {!isLast && (
              <div
                className={`flex-1 h-0.5 mx-2 mb-5 rounded-full transition-colors duration-200 ${
                  isDone
                    ? "bg-primary-600 dark:bg-[#289E70]"
                    : "bg-slate-200 dark:bg-slate-800"
                }`}
                aria-hidden="true"
              />
            )}
          </div>
        );
      })}
    </div>
  );
}
