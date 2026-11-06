// ── Timeline Component ────────────────────────────────────────
import { Check } from "lucide-react";
import type { TimelineStep } from "@/types";

interface TimelineProps {
  steps?: TimelineStep[];
  items?: TimelineStep[];
}

export function Timeline({ steps, items }: TimelineProps) {
  const data = steps ?? items ?? [];

  return (
    <ol
      className="relative flex flex-col gap-0"
      aria-label="Status penanganan laporan"
    >
      {data.map((step, index) => {
        const isLast = index === data.length - 1;

        return (
          <li key={step.id} className="relative flex gap-4">
            {/* Vertical line */}
            {!isLast && (
              <div
                className={`absolute left-[13px] top-7 bottom-0 w-0.5 ${
                  step.state === "done"
                    ? "bg-primary-500 dark:bg-emerald-700"
                    : "bg-slate-200 dark:bg-slate-800"
                }`}
                aria-hidden="true"
              />
            )}

            {/* Step icon */}
            <div className="shrink-0 mt-0.5 z-10 bg-surface-card">
              {step.state === "done" ? (
                <div className="w-7 h-7 rounded-full bg-primary-600 dark:bg-[#289E70] flex items-center justify-center shadow-2xs">
                  <Check
                    className="w-3.5 h-3.5 text-white"
                    aria-hidden="true"
                  />
                </div>
              ) : step.state === "active" ? (
                <div className="w-7 h-7 rounded-full bg-amber-50 dark:bg-amber-950/60 border-2 border-amber-500 dark:border-[#FAD46B] flex items-center justify-center shadow-2xs">
                  <div
                    className="w-2.5 h-2.5 rounded-full bg-amber-500 dark:bg-[#FAD46B]"
                    aria-hidden="true"
                  />
                </div>
              ) : (
                <div className="w-7 h-7 rounded-full bg-slate-100 dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 flex items-center justify-center">
                  <div
                    className="w-2 h-2 rounded-full bg-slate-300 dark:bg-slate-600"
                    aria-hidden="true"
                  />
                </div>
              )}
            </div>

            {/* Content */}
            <div className={`pb-6 flex-1 min-w-0 ${isLast ? "pb-0" : ""}`}>
              <p
                className={`text-sm font-bold leading-tight ${
                  step.state === "done"
                    ? "text-slate-900 dark:text-slate-100"
                    : step.state === "active"
                    ? "text-amber-800 dark:text-[#FAD46B]"
                    : "text-slate-500 dark:text-slate-400"
                }`}
              >
                {step.label}
              </p>
              {step.datetime && (
                <p className="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">{step.datetime}</p>
              )}
            </div>
          </li>
        );
      })}
    </ol>
  );
}
