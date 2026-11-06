// ── StatusBadge Component ─────────────────────────────────────
import type { ReportStatus } from "@/types";

interface StatusBadgeProps {
  status: ReportStatus;
  size?: "sm" | "md";
}

const statusConfig: Record<
  ReportStatus,
  { label: string; className: string; dot: string }
> = {
  Diterima: {
    label: "Diterima",
    className: "bg-status-received-bg text-status-received-text border border-slate-300/80 dark:border-slate-700/70",
    dot: "bg-slate-500 dark:bg-slate-300",
  },
  Diverifikasi: {
    label: "Diverifikasi",
    className: "bg-status-verified-bg text-status-verified-text border border-emerald-300/70 dark:border-emerald-800/60",
    dot: "bg-[#176B4D] dark:bg-[#5AE39D]",
  },
  "Dalam Penanganan": {
    label: "Dalam Penanganan",
    className: "bg-status-processing-bg text-status-processing-text border border-amber-300/70 dark:border-amber-800/60",
    dot: "bg-amber-500 dark:bg-[#FAD46B]",
  },
  Selesai: {
    label: "Selesai",
    className: "bg-status-completed-bg text-status-completed-text border border-emerald-300/70 dark:border-emerald-800/60",
    dot: "bg-[#176B4D] dark:bg-[#5AE39D]",
  },
  Ditolak: {
    label: "Ditolak",
    className: "bg-status-rejected-bg text-status-rejected-text border border-red-300/70 dark:border-red-800/60",
    dot: "bg-red-500 dark:bg-red-400",
  },
};

export function StatusBadge({ status, size = "md" }: StatusBadgeProps) {
  const cfg = statusConfig[status] ?? statusConfig["Diterima"];
  const sizeClass =
    size === "sm" ? "px-2.5 py-0.5 text-[11px]" : "px-3 py-1 text-xs";

  return (
    <span
      className={`inline-flex items-center gap-1.5 rounded-full font-semibold shadow-2xs ${sizeClass} ${cfg.className}`}
    >
      <span
        className={`w-1.5 h-1.5 rounded-full ${cfg.dot} shrink-0`}
        aria-hidden="true"
      />
      {cfg.label}
    </span>
  );
}
