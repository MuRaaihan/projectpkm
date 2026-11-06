// ── KpiCard — Clean & Expressive KPI Metric Block ──────────
import { TrendingUp, TrendingDown, Minus } from 'lucide-react';

interface KpiCardProps {
  label: string;
  value: number | string;
  icon: React.ReactNode;
  accent?: 'default' | 'green' | 'amber' | 'blue' | 'red' | 'slate' | 'lime' | 'gold';
  description?: string;
  trend?: 'up' | 'down' | 'neutral';
  trendLabel?: string;
}

const accentBadge: Record<string, string> = {
  default: 'bg-primary-50 text-primary-700 dark:bg-primary-950/60 dark:text-primary-300 border-primary-200/60 dark:border-primary-800/60',
  green: 'bg-[#eaf5ee] text-[#176B4D] dark:bg-[#163628] dark:text-[#5AE39D] border-[#c9e6d8] dark:border-emerald-800/60',
  amber: 'bg-[#fef8e3] text-[#966b09] dark:bg-[#332408] dark:text-[#FAD46B] border-[#fae9b3] dark:border-amber-800/60',
  blue: 'bg-sky-50 text-sky-700 dark:bg-sky-950/60 dark:text-sky-300 border-sky-200/60 dark:border-sky-800/60',
  red: 'bg-red-50 text-red-700 dark:bg-red-950/60 dark:text-red-300 border-red-200/60 dark:border-red-800/60',
  slate: 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200 border-slate-200 dark:border-slate-700',
  lime: 'bg-[#f5fad4] text-[#3f570e] dark:bg-[#253011] dark:text-[#d2f365] border-[#e2f0a8] dark:border-lime-800/60',
  gold: 'bg-[#fef7db] text-[#8c6708] dark:bg-[#342807] dark:text-[#FAD46B] border-[#fae9b3] dark:border-amber-800/60',
};

const accentGlowBorder: Record<string, string> = {
  default: 'hover:border-primary-400 dark:hover:border-primary-600',
  green: 'hover:border-[#176B4D] dark:hover:border-[#289E70]',
  amber: 'hover:border-amber-400 dark:hover:border-amber-600',
  blue: 'hover:border-sky-400 dark:hover:border-sky-600',
  red: 'hover:border-red-400 dark:hover:border-red-600',
  slate: 'hover:border-slate-400 dark:hover:border-slate-600',
  lime: 'hover:border-lime-400 dark:hover:border-lime-500',
  gold: 'hover:border-amber-400 dark:hover:border-amber-600',
};

export function KpiCard({ label, value, icon, accent = 'default', description, trend, trendLabel }: KpiCardProps) {
  const badgeCls = accentBadge[accent] ?? accentBadge.default;
  const hoverBorder = accentGlowBorder[accent] ?? accentGlowBorder.default;

  const TrendIcon = trend === 'up' ? TrendingUp : trend === 'down' ? TrendingDown : Minus;
  const trendColor = trend === 'up'
    ? 'text-primary-700 dark:text-primary-400'
    : trend === 'down'
    ? 'text-red-600 dark:text-red-400'
    : 'text-slate-500 dark:text-slate-400';

  return (
    <div className={`relative bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl p-5 transition-all duration-200 animate-slide-up card-hover shadow-xs ${hoverBorder}`}>
      <div className="flex items-start justify-between gap-4">
        <div className="min-w-0 flex-1">
          <p className="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2 truncate">
            {label}
          </p>
          <p className="text-3xl sm:text-4xl font-extrabold tracking-tight tabular-nums text-slate-900 dark:text-slate-100 leading-none">
            {value}
          </p>
          {description && (
            <p className="text-xs text-slate-600 dark:text-slate-400 mt-2 line-clamp-1 leading-normal">
              {description}
            </p>
          )}
          {trend && trendLabel && (
            <div className={`flex items-center gap-1.5 mt-2.5 text-xs font-semibold ${trendColor}`}>
              <TrendIcon className="w-3.5 h-3.5" />
              <span>{trendLabel}</span>
            </div>
          )}
        </div>
        <div className={`w-11 h-11 rounded-xl flex items-center justify-center shrink-0 border shadow-2xs ${badgeCls}`}>
          <span className="w-5 h-5 flex items-center justify-center" aria-hidden="true">
            {icon}
          </span>
        </div>
      </div>
    </div>
  );
}
