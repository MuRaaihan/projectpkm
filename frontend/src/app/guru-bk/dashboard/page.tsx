// ── Guru BK Dashboard — Professional Counseling Management ────
"use client";

import { useState } from "react";
import { useRouter } from "next/navigation";
import {
  Inbox,
  Clock,
  CheckCircle2,
  AlertCircle,
  FileText,
  BarChart2,
  ClipboardList,
  ChevronRight,
  ShieldAlert,
} from "lucide-react";
import { GBKLayout } from "@/components/guru-bk/GBKLayout";
import { KpiCard } from "@/components/ui/KpiCard";
import { StatusBadge } from "@/components/ui/StatusBadge";
import {
  gbkReports,
  getGBKStats,
  getGBKCategoryStats,
} from "@/data/mockDataGBK";

// ── Timeline dot helper ──────────────────────────────────────
function TimelineDot({ state }: { state: string }) {
  if (state === "done")
    return (
      <span className="w-2.5 h-2.5 rounded-full bg-primary-600 dark:bg-[#5AE39D] shrink-0 mt-1.5" />
    );
  if (state === "active")
    return (
      <span className="w-2.5 h-2.5 rounded-full bg-amber-500 ring-2 ring-amber-400/40 shrink-0 mt-1.5" />
    );
  return (
    <span className="w-2.5 h-2.5 rounded-full bg-slate-300 dark:bg-slate-700 shrink-0 mt-1.5" />
  );
}

const categoryBarColors = [
  "bg-primary-600 dark:bg-[#5AE39D]",
  "bg-amber-500 dark:bg-[#FAD46B]",
  "bg-[#3F570E] dark:bg-[#D2F365]",
  "bg-sky-600 dark:bg-sky-400",
  "bg-red-500 dark:bg-red-400",
];

export default function GBKDashboardPage() {
  const router = useRouter();
  const [filterMode, setFilterMode] = useState<"all" | "urgent" | "progress" | "done">("all");
  const stats = getGBKStats(gbkReports);
  const categoryStats = getGBKCategoryStats(gbkReports);

  // Filtered reports based on counselor quick pill
  const filteredReports = gbkReports.filter((r) => {
    if (filterMode === "urgent") return r.status === "Diterima" || r.status === "Diverifikasi";
    if (filterMode === "progress") return r.status === "Dalam Penanganan";
    if (filterMode === "done") return r.status === "Selesai";
    return true;
  });

  const recentReports = filteredReports.slice(0, 5);

  // Last 4 reports that have at least one timeline entry with a datetime
  const activityReports = gbkReports
    .filter((r) => r.timeline.some((t) => t.datetime))
    .slice(0, 4);

  return (
    <GBKLayout
      pageTitle="Portal Konseling Guru BK"
      pageSubtitle="Monitoring dan penanganan resmi aduan perundungan siswa"
      withBottomNav
    >
      <div className="px-4 sm:px-6 lg:px-8 py-6 flex flex-col gap-6 max-w-6xl w-full mx-auto animate-fade-in">
        {/* ── Mobile page title ────────────────────────────── */}
        <div className="lg:hidden">
          <h1 className="text-xl font-black text-slate-900 dark:text-slate-100">
            Portal Guru BK
          </h1>
          <p className="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
            Monitoring penanganan aduan siswa
          </p>
        </div>

        {/* ── Alert banner — laporan baru prioritas ────────── */}
        {stats.baru > 0 && (
          <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-amber-50/90 dark:bg-[#261A05] border border-amber-300 dark:border-amber-800/80 rounded-2xl p-5 shadow-xs animate-slide-up">
            <div className="flex items-start gap-4">
              <div className="w-11 h-11 rounded-xl bg-amber-100 dark:bg-amber-900/50 border border-amber-300 dark:border-amber-700 text-amber-800 dark:text-[#FAD46B] flex items-center justify-center shrink-0">
                <ShieldAlert className="w-6 h-6" aria-hidden="true" />
              </div>
              <div>
                <p className="text-base font-extrabold text-amber-950 dark:text-[#FAD46B]">
                  {stats.baru} Laporan Baru Memerlukan Verifikasi Segera
                </p>
                <p className="text-xs text-amber-800 dark:text-amber-200/90 mt-1 leading-relaxed">
                  Laporan masuk membutuhkan validasi kronologi dalam 1x24 jam kerja untuk menentukan pendampingan konseling yang tepat.
                </p>
              </div>
            </div>

            <button
              onClick={() => router.push("/guru-bk/laporan")}
              className="px-5 py-2.5 rounded-xl bg-amber-800 hover:bg-amber-900 text-white text-xs font-bold transition-colors shrink-0 shadow-xs cursor-pointer flex items-center justify-center gap-1.5"
            >
              <span>Tinjau Laporan</span>
              <ChevronRight className="w-4 h-4" />
            </button>
          </div>
        )}

        {/* ── Asymmetrical KPI Matrix ──────────────────────── */}
        <section aria-labelledby="kpi-heading" className="animate-slide-up stagger-1">
          <div className="flex items-center justify-between mb-3.5">
            <h2
              id="kpi-heading"
              className="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400"
            >
              Statistik Kasus Sekolah
            </h2>
            <span className="text-xs font-semibold text-slate-600 dark:text-slate-300">
              Total {gbkReports.length} laporan tercatat
            </span>
          </div>

          <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5">
            <KpiCard
              label="Total Kasus"
              value={stats.total}
              icon={<FileText className="w-4 h-4" />}
              accent="default"
              description="Seluruh kasus terdata"
            />
            <KpiCard
              label="Aduan Baru"
              value={stats.baru}
              icon={<Inbox className="w-4 h-4" />}
              accent="red"
              description="Perlu ditinjau"
            />
            <KpiCard
              label="Validasi"
              value={stats.perluVerifikasi}
              icon={<AlertCircle className="w-4 h-4" />}
              accent="gold"
              description="Tahap verifikasi"
            />
            <KpiCard
              label="Konseling"
              value={stats.dalamPenanganan}
              icon={<Clock className="w-4 h-4" />}
              accent="amber"
              description="Proses pendampingan"
            />
            <KpiCard
              label="Tuntas"
              value={stats.selesai}
              icon={<CheckCircle2 className="w-4 h-4" />}
              accent="green"
              description="Kasus diselesaikan"
            />
          </div>
        </section>

        {/* ── Case Queue + Category Distribution ─────────── */}
        <div className="grid grid-cols-1 lg:grid-cols-5 gap-6 animate-slide-up stagger-2">
          {/* Left col: Antrean Laporan (3/5) */}
          <section aria-labelledby="recent-heading" className="lg:col-span-3 min-w-0 flex flex-col justify-between">
            <div>
              <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 mb-3.5">
                <div>
                  <h2
                    id="recent-heading"
                    className="text-sm font-bold text-slate-900 dark:text-slate-100"
                  >
                    Antrean Tindak Lanjut Kasus
                  </h2>
                  <p className="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                    Pilih filter untuk mempersempit prioritas penanganan
                  </p>
                </div>

                {/* Quick filter pills */}
                <div className="flex items-center gap-1.5 p-1 bg-slate-100 dark:bg-slate-800 rounded-xl">
                  <button
                    onClick={() => setFilterMode("all")}
                    className={`px-2.5 py-1 text-xs font-semibold rounded-lg transition-all ${
                      filterMode === "all"
                        ? "bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 shadow-2xs"
                        : "text-slate-600 dark:text-slate-400 hover:text-slate-900"
                    }`}
                  >
                    Semua
                  </button>
                  <button
                    onClick={() => setFilterMode("urgent")}
                    className={`px-2.5 py-1 text-xs font-semibold rounded-lg transition-all ${
                      filterMode === "urgent"
                        ? "bg-white dark:bg-slate-700 text-amber-700 dark:text-amber-300 shadow-2xs"
                        : "text-slate-600 dark:text-slate-400 hover:text-slate-900"
                    }`}
                  >
                    Mendesak
                  </button>
                  <button
                    onClick={() => setFilterMode("progress")}
                    className={`px-2.5 py-1 text-xs font-semibold rounded-lg transition-all ${
                      filterMode === "progress"
                        ? "bg-white dark:bg-slate-700 text-primary-700 dark:text-primary-300 shadow-2xs"
                        : "text-slate-600 dark:text-slate-400 hover:text-slate-900"
                    }`}
                  >
                    Konseling
                  </button>
                </div>
              </div>

              {/* Desktop table */}
              <div className="hidden md:block bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-xs">
                <table className="w-full text-sm">
                  <thead className="border-b border-slate-200 dark:border-slate-800 bg-slate-50/80 dark:bg-slate-800/60">
                    <tr>
                      <th className="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        No Tiket
                      </th>
                      <th className="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        Kategori Kasus
                      </th>
                      <th className="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        Tanggal Masuk
                      </th>
                      <th className="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        Status
                      </th>
                      <th className="px-4 py-3 text-right" />
                    </tr>
                  </thead>
                  <tbody className="divide-y divide-slate-100 dark:divide-slate-800">
                    {recentReports.map((report) => (
                      <tr
                        key={report.id}
                        className="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors cursor-pointer group"
                        onClick={() =>
                          router.push(`/guru-bk/laporan/${report.id}`)
                        }
                      >
                        <td className="px-4 py-3.5 font-mono text-xs font-bold text-slate-700 dark:text-slate-300">
                          {report.id}
                        </td>
                        <td className="px-4 py-3.5 text-sm font-bold text-slate-900 dark:text-slate-100">
                          {report.category}
                        </td>
                        <td className="px-4 py-3.5 text-xs text-slate-500 dark:text-slate-400">
                          {report.date}
                        </td>
                        <td className="px-4 py-3.5">
                          <StatusBadge status={report.status as any} size="sm" />
                        </td>
                        <td className="px-4 py-3.5 text-right">
                          <span className="text-xs text-primary-600 dark:text-[#5AE39D] font-bold flex items-center justify-end gap-1 group-hover:translate-x-1 transition-transform">
                            Kelola
                            <ChevronRight className="w-3.5 h-3.5" />
                          </span>
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>

              {/* Mobile list */}
              <div className="md:hidden bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden divide-y divide-slate-100 dark:divide-slate-800 shadow-xs">
                {recentReports.map((report) => (
                  <button
                    key={report.id}
                    className="w-full text-left px-4 py-4 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors flex items-center justify-between gap-3"
                    onClick={() =>
                      router.push(`/guru-bk/laporan/${report.id}`)
                    }
                  >
                    <div className="flex-1 min-w-0">
                      <div className="flex items-center gap-2 mb-1.5">
                        <span className="font-mono text-xs font-bold text-slate-600 dark:text-slate-300">
                          {report.id}
                        </span>
                        <StatusBadge status={report.status as any} size="sm" />
                      </div>
                      <p className="text-sm font-bold text-slate-900 dark:text-slate-100 truncate">
                        {report.category}
                      </p>
                      <p className="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        {report.date}
                      </p>
                    </div>
                    <ChevronRight className="w-4 h-4 text-slate-400 shrink-0" />
                  </button>
                ))}
              </div>
            </div>

            <div className="mt-4 flex justify-end">
              <button
                onClick={() => router.push("/guru-bk/laporan")}
                className="text-xs text-primary-600 dark:text-[#5AE39D] font-bold hover:underline flex items-center gap-1 cursor-pointer"
              >
                <span>Buka seluruh daftar kasus Guru BK</span>
                <ChevronRight className="w-3.5 h-3.5" />
              </button>
            </div>
          </section>

          {/* Right col: Distribusi Kategori (2/5) */}
          <section aria-labelledby="category-heading" className="lg:col-span-2">
            <div className="flex items-center justify-between mb-3.5">
              <h2
                id="category-heading"
                className="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400"
              >
                Distribusi Kategori
              </h2>
              <button
                onClick={() => router.push("/guru-bk/statistik")}
                className="flex items-center gap-1 text-xs text-primary-600 dark:text-[#5AE39D] font-bold hover:underline cursor-pointer"
              >
                <BarChart2 className="w-3.5 h-3.5" aria-hidden="true" />
                <span>Analitik</span>
              </button>
            </div>

            <div className="bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-xs flex flex-col gap-4">
              {categoryStats
                .filter((c) => c.value > 0)
                .map(({ label, value }, idx) => {
                  const pct = Math.round((value / gbkReports.length) * 100);
                  const barColor = categoryBarColors[idx % categoryBarColors.length];
                  return (
                    <div key={label} className="flex flex-col gap-1.5">
                      <div className="flex items-center justify-between text-xs">
                        <span className="font-bold text-slate-800 dark:text-slate-200 truncate">
                          {label}
                        </span>
                        <span className="font-extrabold tabular-nums text-slate-900 dark:text-slate-100">
                          {value} ({pct}%)
                        </span>
                      </div>
                      <div className="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2.5 overflow-hidden">
                        <div
                          className={`h-2.5 rounded-full transition-all duration-500 ${barColor}`}
                          style={{ width: `${pct}%` }}
                        />
                      </div>
                    </div>
                  );
                })}

              {/* Zero-count categories */}
              {categoryStats
                .filter((c) => c.value === 0)
                .map(({ label }) => (
                  <div key={label} className="flex items-center justify-between text-xs text-slate-400 dark:text-slate-500 pt-1 border-t border-slate-100 dark:border-slate-800/60">
                    <span className="truncate">{label}</span>
                    <span className="tabular-nums font-semibold">0</span>
                  </div>
                ))}
            </div>
          </section>
        </div>

        {/* ── Aktivitas Tindak Lanjut ───────────────────────── */}
        <section aria-labelledby="activity-heading" className="animate-slide-up stagger-3">
          <div className="flex items-center justify-between mb-3.5">
            <h2
              id="activity-heading"
              className="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400"
            >
              Log Catatan Konseling & Investigasi
            </h2>
            <button
              onClick={() => router.push("/guru-bk/laporan")}
              className="text-xs text-primary-600 dark:text-[#5AE39D] font-bold hover:underline cursor-pointer"
            >
              Lihat Riwayat Lengkap
            </button>
          </div>

          <div className="bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden divide-y divide-slate-100 dark:divide-slate-800 shadow-xs">
            {activityReports.length === 0 ? (
              <div className="px-4 py-8 text-center">
                <ClipboardList
                  className="w-8 h-8 text-slate-400 mx-auto mb-2"
                  aria-hidden="true"
                />
                <p className="text-sm text-slate-500 dark:text-slate-400">
                  Belum ada aktivitas tindak lanjut tercatat.
                </p>
              </div>
            ) : (
              activityReports.map((report) => {
                const lastActivity = [...report.timeline]
                  .reverse()
                  .find((t) => t.datetime);

                return (
                  <div
                    key={report.id}
                    className="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors"
                  >
                    <div className="flex items-start gap-3.5 min-w-0">
                      <TimelineDot state="done" />
                      <div className="min-w-0">
                        <div className="flex items-center gap-2 mb-1">
                          <span className="font-mono text-xs font-bold text-slate-700 dark:text-slate-300">
                            {report.id}
                          </span>
                          <span className="text-xs font-bold text-slate-900 dark:text-slate-100 truncate">
                            {report.category}
                          </span>
                        </div>
                        <p className="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                          {report.counselorNote || lastActivity?.label || "Aktivitas investigasi tercatat"}
                        </p>
                        <p className="text-[11px] text-slate-400 dark:text-slate-500 mt-1">
                          Tahapan: {lastActivity?.label || "Penanganan"} {lastActivity?.datetime ? `· ${lastActivity.datetime}` : ""}
                        </p>
                      </div>
                    </div>

                    <button
                      onClick={() => router.push(`/guru-bk/laporan/${report.id}`)}
                      className="text-xs text-primary-600 dark:text-[#5AE39D] font-bold hover:underline shrink-0 self-start sm:self-center cursor-pointer"
                    >
                      Buka Kasus →
                    </button>
                  </div>
                );
              })
            )}
          </div>
        </section>
      </div>
    </GBKLayout>
  );
}
