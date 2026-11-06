// ── StatBar — Simple CSS horizontal bar chart ─────────────────

interface StatBarProps {
 label: string;
 value: number;
 max: number;
 colorClass?: string;
}

export function StatBar({
 label,
 value,
 max,
 colorClass = "bg-primary-500",
}: StatBarProps) {
 const pct = max > 0 ? Math.round((value / max) * 100) : 0;
 return (
 <div className="flex items-center gap-3">
 <span className="text-xs text-slate-700 w-36 shrink-0 truncate">
 {label}
 </span>
 <div className="flex-1 bg-slate-100 rounded-full h-2.5 min-w-0">
 <div
 className={`h-2.5 rounded-full ${colorClass} transition-all duration-700`}
 style={{ width: `${pct}%` }}
 role="progressbar"
 aria-valuenow={value}
 aria-valuemax={max}
 aria-label={`${label}: ${value}`}
 />
 </div>
 <span className="text-xs font-bold text-slate-800 w-5 text-right shrink-0">
 {value}
 </span>
 </div>
 );
}
