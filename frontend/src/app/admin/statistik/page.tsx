// ── Admin — Statistik ─────────────────────────────────────────
"use client";

import { AdminLayout } from "@/components/admin/AdminLayout";
import { KpiCard } from "@/components/ui/KpiCard";
import { Users, FileText, CheckCircle2, TrendingUp } from "lucide-react";
import {
 adminReports,
 getAdminStats,
 getAdminCategoryStats,
 adminMonthlyStats,
} from "@/data/mockDataAdmin";

export default function AdminStatistikPage() {
 const stats = getAdminStats();
 const categoryStats = getAdminCategoryStats();
 const maxCategory = Math.max(...categoryStats.map((c) => c.value), 1);
 const maxMonthly = Math.max(...adminMonthlyStats.map((m) => m.value), 1);

 const statusStats = [
 {
 label: "Diterima",
 value: adminReports.filter((r) => r.status === "Diterima").length,
 color: "bg-slate-400",
 },
 {
 label: "Diverifikasi",
 value: adminReports.filter((r) => r.status === "Diverifikasi").length,
 color: "bg-sky-400",
 },
 {
 label: "Dalam Penanganan",
 value: adminReports.filter((r) => r.status === "Dalam Penanganan").length,
 color: "bg-amber-400",
 },
 {
 label: "Selesai",
 value: adminReports.filter((r) => r.status === "Selesai").length,
 color: "bg-primary-500",
 },
 {
 label: "Ditolak",
 value: adminReports.filter((r) => r.status === "Ditolak").length,
 color: "bg-red-400",
 },
 ];
 const maxStatus = Math.max(...statusStats.map((s) => s.value), 1);

 const userRoleStats = [
 { label: "Siswa", value: stats.totalSiswa, color: "bg-sky-400" },
 { label: "Guru BK", value: stats.totalGuruBK, color: "bg-primary-500" },
 { label: "Admin", value: stats.totalAdmin, color: "bg-slate-400" },
 ];
 const maxRole = Math.max(...userRoleStats.map((r) => r.value), 1);

 const Section = ({
 title,
 children,
 }: {
 title: string;
 children: React.ReactNode;
 }) => (
 <div className="bg-surface-card border border-slate-200 dark:border-slate-700 rounded-lg p-5">
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
 <AdminLayout
 pageTitle="Statistik"
 pageSubtitle="Ringkasan data sistem SIPERKA 2026"
 withBottomNav
 >
 <div className="px-6 py-5 flex flex-col gap-5 animate-fade-in">
 {/* ── Mobile header ─────────────────────── */}
 <div className="lg:hidden">
 <h1 className="text-lg font-bold text-slate-900 dark:text-slate-100">
 Statistik
 </h1>
 <p className="text-sm text-slate-600 dark:text-slate-400 mt-0.5">
 Ringkasan data sistem SIPERKA 2026
 </p>
 </div>

 {/* ── KPI Row ───────────────────────────── */}
 <div className="grid grid-cols-2 sm:grid-cols-4 gap-3">
 <KpiCard
 label="Total Pengguna"
 value={stats.totalUsers}
 icon={<Users className="w-4 h-4" />}
 accent="slate"
 />
 <KpiCard
 label="Pengguna Aktif"
 value={stats.activeUsers}
 icon={<Users className="w-4 h-4" />}
 accent="green"
 />
 <KpiCard
 label="Total Laporan"
 value={stats.totalLaporan}
 icon={<FileText className="w-4 h-4" />}
 accent="default"
 />
 <KpiCard
 label="Laporan Selesai"
 value={stats.laporanSelesai}
 icon={<CheckCircle2 className="w-4 h-4" />}
 accent="green"
 />
 </div>

 {/* ── Charts 2-col ──────────────────────── */}
 <div className="grid grid-cols-1 lg:grid-cols-2 gap-5">
 <Section title="Laporan per Kategori">
 <div className="flex flex-col gap-3">
 {categoryStats
 .filter((c) => c.value > 0)
 .map((c) => (
 <BarItem
 key={c.label}
 label={c.label}
 value={c.value}
 max={maxCategory}
 colorClass="bg-primary-500"
 />
 ))}
 </div>
 </Section>

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

 <div className="grid grid-cols-1 lg:grid-cols-2 gap-5">
 {/* Tren bulanan */}
 <Section title="Tren Laporan (6 Bulan Terakhir)">
 <div className="flex items-end gap-2 h-28 mt-2">
 {adminMonthlyStats.map((m) => (
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

 {/* Pengguna per role */}
 <Section title="Distribusi Pengguna per Role">
 <div className="flex flex-col gap-3">
 {userRoleStats.map((r) => (
 <BarItem
 key={r.label}
 label={r.label}
 value={r.value}
 max={maxRole}
 colorClass={r.color}
 />
 ))}
 </div>
 <div className="mt-4 pt-3 border-t border-slate-200 dark:border-slate-700 flex items-center justify-between">
 <span className="text-xs text-slate-600 dark:text-slate-400">
 Total pengguna
 </span>
 <span className="text-sm font-bold text-slate-900 dark:text-slate-100 tabular-nums">
 {stats.totalUsers}
 </span>
 </div>

 {/* Notice */}
 <div className="mt-4 bg-slate-50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-700 rounded-md p-3">
 <p className="text-[11px] text-slate-600 dark:text-slate-400 leading-relaxed">
 Data statistik digunakan untuk keperluan administrasi dan
 pemantauan sistem. Tidak untuk dipublikasikan.
 </p>
 </div>
 </Section>
 </div>
 </div>
 </AdminLayout>
 );
}
