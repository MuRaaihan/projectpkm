// ── Admin — Monitoring Laporan ────────────────────────────────
"use client";

import { useState } from "react";
import { Search, Lock, FileText, MapPin } from "lucide-react";
import { AdminLayout } from "@/components/admin/AdminLayout";
import { StatusBadge } from "@/components/ui/StatusBadge";
import { adminReports } from "@/data/mockDataAdmin";
import type { ReportStatus, ReportCategory, AdminReport } from "@/types";

type FilterStatus = "Semua" | ReportStatus;
type FilterCategory = "Semua" | ReportCategory;

const statusTabs: FilterStatus[] = [
  "Semua",
  "Diterima",
  "Diverifikasi",
  "Dalam Penanganan",
  "Selesai",
  "Ditolak",
];
const categories: FilterCategory[] = [
  "Semua",
  "Perundungan Verbal",
  "Perundungan Fisik",
  "Perundungan Sosial",
  "Cyberbullying",
  "Lainnya",
];

function applyFilters(
  reports: AdminReport[],
  status: FilterStatus,
  category: FilterCategory,
  q: string,
) {
  return reports
    .filter((r) => status === "Semua" || r.status === status)
    .filter((r) => category === "Semua" || r.category === category)
    .filter(
      (r) =>
        !q ||
        r.id.toLowerCase().includes(q.toLowerCase()) ||
        r.category.toLowerCase().includes(q.toLowerCase()) ||
        r.location.toLowerCase().includes(q.toLowerCase()),
    );
}

export default function AdminLaporanPage() {
  const [activeStatus, setActiveStatus] = useState<FilterStatus>("Semua");
  const [activeCategory, setActiveCategory] = useState<FilterCategory>("Semua");
  const [query, setQuery] = useState("");

  const filtered = applyFilters(
    adminReports,
    activeStatus,
    activeCategory,
    query,
  );

  return (
    <AdminLayout
      pageTitle="Monitoring Laporan"
      pageSubtitle="Pantauan operasional sistem dan tindak lanjut kasus oleh Guru BK"
      withBottomNav
    >
      <div className="px-4 sm:px-6 lg:px-8 py-6 flex flex-col gap-5 max-w-6xl w-full mx-auto animate-fade-in">
        {/* ── Mobile page header ────────────────── */}
        <div className="lg:hidden">
          <h1 className="text-xl font-bold text-slate-900 dark:text-slate-100">
            Monitoring Laporan
          </h1>
          <p className="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
            Total {adminReports.length} laporan sistem
          </p>
        </div>

        {/* ── Toolbar ───────────────────────────── */}
        <div className="flex flex-col sm:flex-row gap-3">
          <div className="relative flex-1">
            <Search
              className="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
              aria-hidden="true"
            />
            <input
              type="search"
              value={query}
              onChange={(e) => setQuery(e.target.value)}
              placeholder="Cari ID tiket, kategori, atau lokasi kejadian..."
              className="w-full h-10 pl-10 pr-4 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-surface-card dark:bg-slate-800 text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
            />
          </div>

          <select
            value={activeCategory}
            onChange={(e) =>
              setActiveCategory(e.target.value as FilterCategory)
            }
            className="h-10 px-3.5 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-surface-card dark:bg-slate-800 text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 sm:w-52"
          >
            {categories.map((c) => (
              <option key={c} value={c}>
                {c === "Semua" ? "Semua Kategori" : c}
              </option>
            ))}
          </select>
        </div>

        {/* ── Status tabs ───────────────────────── */}
        <div className="flex gap-2 overflow-x-auto pb-1 scrollbar-hide">
          {statusTabs.map((s) => {
            const count =
              s === "Semua"
                ? adminReports.length
                : adminReports.filter((r) => r.status === s).length;
            const isActive = activeStatus === s;
            return (
              <button
                key={s}
                onClick={() => setActiveStatus(s)}
                className={`flex items-center gap-2 px-3.5 py-2 text-xs font-semibold rounded-lg transition-all duration-150 whitespace-nowrap shrink-0 ${
                  isActive
                    ? "bg-primary-600 text-white shadow-xs"
                    : "bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200/80 dark:hover:bg-slate-700"
                }`}
              >
                {isActive && (
                  <span className="w-1.5 h-1.5 rounded-full bg-[#B8E34B]" />
                )}
                <span>{s}</span>
                <span
                  className={`px-1.5 py-0.2 rounded-full text-[10px] font-bold ${
                    isActive
                      ? "bg-white/20 text-white"
                      : "bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300"
                  }`}
                >
                  {count}
                </span>
              </button>
            );
          })}
        </div>

        {/* ── Result count ──────────────────────── */}
        <p className="text-xs text-slate-500 dark:text-slate-400">
          Menampilkan {filtered.length} laporan {query && `dengan kata kunci "${query}"`}
        </p>

        {/* ── Table ─────────────────────────────── */}
        {filtered.length === 0 ? (
          <div className="flex flex-col items-center gap-3 py-16 text-center bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl">
            <div className="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center">
              <FileText className="w-5 h-5 text-slate-400" aria-hidden="true" />
            </div>
            <p className="text-sm font-bold text-slate-800 dark:text-slate-200">
              Tidak ada laporan ditemukan
            </p>
            <p className="text-xs text-slate-500 dark:text-slate-400">
              Coba sesuaikan kata kunci atau filter status yang dipilih.
            </p>
          </div>
        ) : (
          <>
            {/* Desktop table */}
            <div className="hidden md:block bg-surface-card border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden shadow-xs">
              <table className="w-full text-sm">
                <thead>
                  <tr className="border-b border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-800/50">
                    <th className="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                      ID
                    </th>
                    <th className="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                      Kategori
                    </th>
                    <th className="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400 hidden md:table-cell">
                      Tanggal
                    </th>
                    <th className="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400 hidden lg:table-cell">
                      Lokasi
                    </th>
                    <th className="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                      Pelapor
                    </th>
                    <th className="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                      Status
                    </th>
                  </tr>
                </thead>
                <tbody className="divide-y divide-slate-100 dark:divide-slate-800">
                  {filtered.map((r) => (
                    <tr
                      key={r.id}
                      className="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors"
                    >
                      <td className="px-4 py-3 font-mono text-xs font-semibold text-slate-600 dark:text-slate-400 whitespace-nowrap">
                        {r.id.replace("ELP-2026-", "#")}
                      </td>
                      <td className="px-4 py-3 text-xs font-semibold text-slate-900 dark:text-slate-100">
                        {r.category}
                      </td>
                      <td className="px-4 py-3 text-xs text-slate-500 dark:text-slate-400 hidden md:table-cell whitespace-nowrap">
                        {r.date}
                      </td>
                      <td className="px-4 py-3 text-xs text-slate-500 dark:text-slate-400 hidden lg:table-cell">
                        <div className="flex items-center gap-1.5">
                          <MapPin
                            className="w-3.5 h-3.5 text-slate-400 shrink-0"
                            aria-hidden="true"
                          />
                          <span className="truncate max-w-[140px]">
                            {r.location}
                          </span>
                        </div>
                      </td>
                      <td className="px-4 py-3">
                        {r.privacy === "hidden" ? (
                          <span className="inline-flex items-center gap-1 text-xs text-slate-500 dark:text-slate-400">
                            <Lock
                              className="w-3 h-3 text-slate-400 shrink-0"
                              aria-hidden="true"
                            />
                            <span>Anonim</span>
                          </span>
                        ) : (
                          <span className="text-xs text-slate-700 dark:text-slate-300">
                            Terbuka
                          </span>
                        )}
                      </td>
                      <td className="px-4 py-3">
                        <StatusBadge status={r.status} size="sm" />
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>

            {/* Mobile list */}
            <div className="flex flex-col divide-y divide-slate-100 dark:divide-slate-800 md:hidden bg-surface-card border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden shadow-xs">
              {filtered.map((r) => (
                <div key={r.id} className="flex items-start justify-between gap-3 px-4 py-3.5">
                  <div className="flex-1 min-w-0">
                    <div className="flex items-center gap-2 mb-1">
                      <p className="text-[11px] font-mono font-semibold text-slate-500 dark:text-slate-400">
                        {r.id}
                      </p>
                      {r.privacy === "hidden" && (
                        <Lock
                          className="w-3 h-3 text-slate-400 shrink-0"
                          aria-hidden="true"
                        />
                      )}
                    </div>
                    <p className="text-xs font-bold text-slate-900 dark:text-slate-100">
                      {r.category}
                    </p>
                    <p className="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">
                      {r.date} · {r.location}
                    </p>
                  </div>
                  <StatusBadge status={r.status} size="sm" />
                </div>
              ))}
            </div>
          </>
        )}
      </div>
    </AdminLayout>
  );
}
