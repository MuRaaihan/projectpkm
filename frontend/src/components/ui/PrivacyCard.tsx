// ── PrivacyCard Component ─────────────────────────────────────
import { Lock, Eye } from "lucide-react";
import type { PrivacyOption } from "@/types";

interface PrivacyCardProps {
  value: PrivacyOption;
  onChange?: (value: PrivacyOption) => void;
  readonly?: boolean;
}

export function PrivacyCard({
  value,
  onChange,
  readonly = false,
}: PrivacyCardProps) {
  const options: {
    id: PrivacyOption;
    icon: React.ReactNode;
    title: string;
    desc: string;
  }[] = [
    {
      id: "hidden",
      icon: <Lock className="w-4 h-4" aria-hidden="true" />,
      title: "Rahasiakan identitas saya",
      desc: "Hanya pihak yang berwenang yang dapat melihat identitas pelapor.",
    },
    {
      id: "shown",
      icon: <Eye className="w-4 h-4" aria-hidden="true" />,
      title: "Tampilkan identitas saya",
      desc: "Identitas saya dapat dilihat oleh Guru BK dan pihak terkait.",
    },
  ];

  if (readonly) {
    const selected = options.find((o) => o.id === value)!;
    return (
      <div className="flex items-start gap-3 p-4 bg-primary-50 dark:bg-primary-900/10 rounded-lg border border-primary-100 dark:border-primary-900/30">
        <div className="w-8 h-8 bg-primary-100 dark:bg-primary-900/30 rounded-md flex items-center justify-center text-primary-600 dark:text-primary-400 shrink-0">
          {selected.icon}
        </div>
        <div>
          <p className="text-sm font-semibold text-primary-800 dark:text-primary-300">
            {selected.title}
          </p>
          <p className="text-xs text-slate-600 dark:text-slate-400 mt-0.5">
            {selected.desc}
          </p>
        </div>
      </div>
    );
  }

  return (
    <fieldset className="flex flex-col gap-2.5">
      <legend className="text-sm font-semibold text-slate-900 dark:text-slate-100 mb-1 flex items-center gap-1.5">
        <Lock className="w-4 h-4 text-primary-500" aria-hidden="true" />
        Privasi Laporan
      </legend>
      {options.map((opt) => {
        const isSelected = value === opt.id;
        return (
          <label
            key={opt.id}
            className={[
              "flex items-start gap-3 p-4 rounded-lg border cursor-pointer transition-all duration-150",
              isSelected
                ? "border-primary-400 dark:border-primary-600 bg-primary-50 dark:bg-primary-900/10"
                : "border-slate-200 dark:border-slate-700 bg-surface-card dark:bg-slate-800/30 hover:border-slate-300 dark:hover:border-slate-600",
            ].join(" ")}
          >
            <input
              type="radio"
              name="privacy"
              value={opt.id}
              checked={isSelected}
              onChange={() => onChange?.(opt.id)}
              className="mt-0.5 accent-primary-600 dark:accent-primary-500 shrink-0"
            />
            <div className="flex-1 min-w-0">
              <p className="text-sm font-semibold text-slate-900 dark:text-slate-100">
                {opt.title}
              </p>
              <p className="text-xs text-slate-600 dark:text-slate-400 mt-0.5">
                {opt.desc}
              </p>
            </div>
          </label>
        );
      })}
    </fieldset>
  );
}
