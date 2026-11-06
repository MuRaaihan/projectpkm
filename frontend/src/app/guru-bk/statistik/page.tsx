// ── Guru BK — Statistik ───────────────────────────────────────
"use client";

import { GBKLayout } from "@/components/guru-bk/GBKLayout";
import { KpiCard } from "@/components/ui/KpiCard";
import { FileText, CheckCircle2, Inbox, XCircle } from "lucide-react";
import {
 gbkReports,
 getGBKCategoryStats,
 getGBKStats,
 monthlyStats,
} from "@/data/mockDataGBK";

export default function GBKStatistikPage() {
 const stats = getGBKStats(gbkReports);
 const categoryStats = getGBKCategoryStats(gbkReports);
 const maxCategory = Math.max(...categoryStats.map((c) => c.value), 1);
 const maxMonthly = Math.max(...monthlyStats.map((m) => m.value), 1);

 const statusStats = [
 { label: "Diterima", value: stats.baru, color: "bg-blue-400" },
 {
 label: "Diverifikasi",
 value: stats.perluVerifikasi,
 color: "bg-primary-400",
 },
 {
 label: "Dalam Penanganan",
 value: stats.dalamPenanganan,
 color: "bg-amber-400",
 },
 { label: "Selesai", value: stats.selesai, color: "bg-green-500" },
 { label: "Ditolak", value: stats.ditolak, color: "bg-red-400" },
 ];
 const maxStatus = Math.max(...statusStats.map((s) => s.value), 1);

 const Section = ({
 title,
 children,
 }: {
 title: string;
 children: React.ReactNode;
 }) => (
 <div className="bg-surface-card border border-slate-200 dark:border-slate-700 rounded-lg p-5 animate-slide-up">
 <h2 className="text-sm font-semibold text-slate-900 dark:text-slate-100 mb-4">
 {title}
 </h2>
 {children}
 </div>
 );

 const BarItem = ({
 label,
 value,
 max,
 colorClass,
 }: {
 label: string;
 value: number;
 max: number;
 colorClass: string;
 }) => (
 <div className="flex items-center gap-3">
 <span className="text-xs text-slate-700 dark:text-slate-400 w-36 shrink-0 truncate">
 {label}
 </span>
 <div className="flex-1 bg-slate-100 dark:bg-slate-700/50 rounded-sm h-1.5">
 <div
 className={`h-1.5 rounded-sm transition-all duration-700 ${colorClass}`}
 style={{ width: `${(value / max) * 100}%` }}
 />
 </div>
 <span className="text-xs font-semibold text-slate-900 dark:text-slate-100 tabular-nums w-5 text-right">
 {value}
 </span>
 </div>
 );

 return (
 <GBKLayout
 pageTitle="Statistik"
 pageSubtitle="Data pemantauan laporan: periode aktif 2026"
 withBottomNav
 >
 <div className="px-6 py-5 flex flex-col gap-5 animate-fade-in max-w-5xl mx-auto w-full">
 {/* ── Mobile header ─────────────────────── */}
 <div className="lg:hidden">
 <h1 className="text-lg font-bold text-slate-900 dark:text-slate-100">
 Statistik Laporan
 </h1>
 <p className="text-sm text-slate-600 dark:text-slate-400 mt-0.5">
 Data pemantauan laporan: periode aktif 2026
 </p>
 </div>

 {/* ── Summary totals ──────────────────────── */}
 <div className="grid grid-cols-2 sm:grid-cols-4 gap-3">
 <KpiCard
 label="Total"
 value={stats.total}
 icon={<FileText className="w-4 h-4" />}
 accent="default"
 />
 <KpiCard
 label="Baru"
 value={stats.baru}
 icon={<Inbox className="w-4 h-4" />}
 accent="blue"
 />
 <KpiCard
 label="Selesai"
 value={stats.selesai}
 icon={<CheckCircle2 className="w-4 h-4" />}
 accent="green"
 />
 <KpiCard
 label="Ditolak"
 value={stats.ditolak}
 icon={<XCircle className="w-4 h-4" />}
 accent="slate"
 />
 </div>

 {/* ── Responsive 2-column on desktop ──────── */}
 <div className="grid grid-cols-1 lg:grid-cols-3 gap-5">
 {/* Left column */}
 <div className="flex flex-col gap-5 lg:col-span-2">
 {/* Per Kategori */}
 <Section title="Laporan per Kategori">
 <div className="flex flex-col gap-3">
 {categoryStats
 .filter((c) => c.value > 0)
 .map((cat) => (
 <BarItem
 key={cat.label}
 label={cat.label}
 value={cat.value}
 max={maxCategory}
 colorClass="bg-primary-500"
 />
 ))}
 {categoryStats.every((c) => c.value === 0) && (
 <p className="text-sm text-slate-600 dark:text-slate-400 text-center py-4">
 Belum ada data.
 </p>
 )}
 </div>
 </Section>

 {/* Per Status */}
 <Section title="Laporan per Status">
 <div className="flex flex-col gap-3">
 {statusStats.map((s) => (
 <BarItem
 key={s.label}
 label={s.label}
 value={s.value}
 max={maxStatus}
 colorClass={s.color}
 />
 ))}
 </div>
 </Section>
 </div>

 {/* Right column */}
 <div className="flex flex-col gap-5">
 {/* Monthly trend */}
 <Section title="Tren per Bulan (6 Bulan)">
 <div className="flex items-end gap-2 h-28 mt-2">
 {monthlyStats.map((m) => (
 <div
 key={m.label}
 className="flex-1 flex flex-col items-center gap-1.5"
 >
 <span className="text-[10px] font-semibold text-slate-900 dark:text-slate-100 tabular-nums">
 {m.value}
 </span>
 <div
 className="w-full bg-primary-500 rounded-t-sm transition-all duration-500"
 style={{
 height: `${Math.max(8, (m.value / maxMonthly) * 72)}px`,
 }}
 role="img"
 aria-label={`${m.label}: ${m.value} laporan`}
 />
 <span className="text-[9px] text-slate-600 dark:text-slate-400 text-center">
 {m.label.replace(" 2026", "")}
 </span>
 </div>
 ))}
 </div>
 </Section>

 {/* Disclaimer */}
 <div className="bg-slate-50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-700 rounded-md p-4">
 <p className="text-[11px] text-slate-600 dark:text-slate-400 leading-relaxed">
 Data statistik hanya digunakan untuk pemantauan dan evaluasi
 program sekolah. Tidak untuk publikasi atau memberi label pada
 lingkungan sekolah.
 </p>
 </div>
 </div>
 </div>
 </div>
 </GBKLayout>
 );
}
