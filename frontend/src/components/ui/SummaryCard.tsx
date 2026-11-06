// ── SummaryCard Component ─────────────────────────────────────
interface SummaryCardProps {
 label: string;
 value: number | string;
 icon?: React.ReactNode;
 accent?: "blue" | "amber" | "green" | "slate";
}

const accentClasses = {
 blue: {
 bg: "bg-primary-50",
 text: "text-primary-600",
 num: "text-primary-700",
 },
 amber: { bg: "bg-amber-50", text: "text-amber-600", num: "text-amber-700" },
 green: { bg: "bg-green-50", text: "text-green-600", num: "text-green-700" },
 slate: { bg: "bg-slate-50", text: "text-slate-700", num: "text-slate-800" },
};

export function SummaryCard({
 label,
 value,
 icon,
 accent = "blue",
}: SummaryCardProps) {
 const cls = accentClasses[accent];

 return (
 <div className={`${cls.bg} rounded-2xl p-4 flex flex-col gap-1.5 min-w-0`}>
 {icon && (
 <span className={`${cls.text} mb-0.5`} aria-hidden="true">
 {icon}
 </span>
 )}
 <p
 className={`text-2xl font-bold ${cls.num} leading-none`}
 aria-label={`${label}: ${value}`}
 >
 {value}
 </p>
 <p className="text-xs text-slate-600 font-medium leading-tight">
 {label}
 </p>
 </div>
 );
}
