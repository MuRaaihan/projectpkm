"use client";

import { useState } from "react";
import { useRouter } from "next/navigation";
import {
  FileText,
  Calendar,
  ChevronRight,
  PlusCircle,
} from "lucide-react";
import {
  AppHeader,
  PageContainer,
  BottomNavigation,
  StatusBadge,
} from "@/components/ui";
import { mockReports } from "@/data/mockData";
import type { ReportStatus } from "@/types";

type FilterTab = "Semua" | ReportStatus;

const tabs: FilterTab[] = [
  "Semua",
  "Diterima",
  "Diverifikasi",
  "Dalam Penanganan",
  "Selesai",
  "Ditolak",
];

function filterReports(tab: FilterTab) {
  if (tab === "Semua") return mockReports;
  return mockReports.filter((r) => r.status === tab);
}

export default function LaporanSayaPage() {
  const router = useRouter();
  const [activeTab, setActiveTab] = useState<FilterTab>("Semua");

  const filtered = filterReports(activeTab);

  return (
    <PageContainer withBottomNav>
      <AppHeader
        variant="logo"
        showAvatar
        showNotification
        avatarInitials="AF"
      />

      <main className="flex flex-col w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 pb-24 animate-fade-in">
        {/* ── Page Title Header ──────────────────────────── */}
        <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
          <div>
            <h1 className="text-2xl font-bold text-slate-900 dark:text-slate-100 tracking-tight">
              Laporan Saya
            </h1>
            <p className="text-sm text-slate-600 dark:text-slate-400 mt-1">
              Pantau tahapan tindak lanjut laporan yang telah kamu ajukan ({mockReports.length} total laporan)
            </p>
          </div>

          <button
            onClick={() => router.push("/laporan/buat")}
            className="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white text-xs font-semibold shadow-xs card-hover transition-colors shrink-0"
          >
            <PlusCircle className="w-4 h-4 text-[#B8E34B]" />
            <span>Buat Laporan Baru</span>
          </button>
        </div>

        {/* ── Filter Tabs ──────────────────────────── */}
        <div
          className="flex gap-2 pb-4 overflow-x-auto scrollbar-hide border-b border-slate-200/80 dark:border-slate-800 mb-6"
          role="tablist"
          aria-label="Filter status laporan"
        >
          {tabs.map((tab) => {
            const isActive = activeTab === tab;
            const count = filterReports(tab).length;
            return (
              <button
                key={tab}
                role="tab"
                aria-selected={isActive}
                onClick={() => setActiveTab(tab)}
                className={`shrink-0 flex items-center gap-2 px-3.5 py-2 rounded-lg text-xs font-semibold whitespace-nowrap transition-all duration-150 ${
                  isActive
                    ? "bg-primary-600 text-white shadow-xs"
                    : "bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200/80 dark:hover:bg-slate-700/80"
                }`}
              >
                {isActive && (
                  <span className="w-1.5 h-1.5 rounded-full bg-[#B8E34B]" />
                )}
                <span>{tab}</span>
                {count > 0 && (
                  <span
                    className={`text-[10px] font-bold px-1.5 py-0.2 rounded-full ${
                      isActive
                        ? "bg-white/20 text-white"
                        : "bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300"
                    }`}
                  >
                    {count}
                  </span>
                )}
              </button>
            );
          })}
        </div>

        {/* ── Report List ──────────────────────────── */}
        <div
          className="animate-slide-up"
          role="tabpanel"
          aria-label={`Laporan: ${activeTab}`}
        >
          {filtered.length === 0 ? (
            <EmptyState tab={activeTab} onAction={() => router.push("/laporan/buat")} />
          ) : (
            <div className="flex flex-col gap-3">
              {filtered.map((report) => (
                <div
                  key={report.id}
                  onClick={() => router.push(`/laporan/${report.id}`)}
                  className="bg-surface-card border border-slate-200 dark:border-slate-800 rounded-xl p-5
                    hover:border-primary-400 dark:hover:border-primary-600 hover:shadow-sm card-hover
                    cursor-pointer transition-all duration-150 flex flex-col sm:flex-row sm:items-center justify-between gap-4 group"
                >
                  <div className="flex-1 min-w-0">
                    <div className="flex items-center gap-2 mb-2">
                      <span className="text-xs font-mono font-bold text-slate-500 dark:text-slate-400">
                        {report.id}
                      </span>
                      <span className="text-slate-300 dark:text-slate-600">•</span>
                      <span className="inline-flex items-center gap-1 text-xs text-slate-500 dark:text-slate-400">
                        <Calendar className="w-3.5 h-3.5" />
                        {report.date}
                      </span>
                    </div>

                    <h2 className="text-base font-bold text-slate-900 dark:text-slate-100 mb-1 truncate group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                      {report.category}
                    </h2>

                    <p className="text-xs text-slate-600 dark:text-slate-400 line-clamp-2 leading-relaxed">
                      {report.description}
                    </p>
                  </div>

                  <div className="flex items-center justify-between sm:justify-end gap-3 shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100 dark:border-slate-800/80">
                    <StatusBadge status={report.status} />
                    <div className="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 group-hover:bg-primary-50 dark:group-hover:bg-primary-900/30 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                      <ChevronRight className="w-4 h-4" />
                    </div>
                  </div>
                </div>
              ))}
            </div>
          )}
        </div>
      </main>

      <BottomNavigation />
    </PageContainer>
  );
}

// ── Empty State ───────────────────────────────────────────────

function EmptyState({ tab, onAction }: { tab: FilterTab; onAction: () => void }) {
  return (
    <div className="flex flex-col items-center justify-center gap-4 py-16 px-4 text-center bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl shadow-xs">
      <div className="w-14 h-14 bg-slate-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-slate-500 dark:text-slate-400">
        <FileText className="w-7 h-7" />
      </div>
      <div className="max-w-sm">
        <p className="text-base font-bold text-slate-900 dark:text-slate-100">
          Tidak ada laporan
        </p>
        <p className="text-xs text-slate-500 dark:text-slate-400 mt-1.5 leading-relaxed">
          {tab === "Semua"
            ? "Kamu belum membuat laporan apapun. Jangan ragu untuk melaporkan jika kamu melihat atau mengalami perundungan."
            : `Tidak ada laporan dengan status "${tab}".`}
        </p>
      </div>
      {tab === "Semua" && (
        <button
          onClick={onAction}
          className="mt-2 inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white text-xs font-semibold shadow-xs card-hover transition-colors"
        >
          <PlusCircle className="w-4 h-4 text-[#B8E34B]" />
          <span>Buat Laporan Sekarang</span>
        </button>
      )}
    </div>
  );
}
