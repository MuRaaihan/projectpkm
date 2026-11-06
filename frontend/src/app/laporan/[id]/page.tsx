"use client";

import { use } from "react";
import { useRouter } from "next/navigation";
import { Calendar, MapPin, Hash, MessageSquare } from "lucide-react";
import {
  AppHeader,
  PageContainer,
  StatusBadge,
  Timeline,
  PrivacyCard,
  BottomNavigation,
} from "@/components/ui";
import { mockReports } from "@/data/mockData";

interface PageProps {
  params: Promise<{ id: string }>;
}

export default function DetailLaporanPage({ params }: PageProps) {
  const { id } = use(params);
  const router = useRouter();

  // Find report — fall back to first if not found (for demo)
  const report = mockReports.find((r) => r.id === id) ?? mockReports[0];

  return (
    <PageContainer withBottomNav>
      <AppHeader
        variant="back"
        title="Detail Laporan"
        backHref="/laporan"
      />

      <main className="px-4 sm:px-6 py-6 pb-24 max-w-4xl w-full mx-auto lg:px-8 animate-fade-in">
        <div className="flex flex-col gap-6 lg:flex-row lg:items-start">
          {/* ── Left column ─────────────────────────── */}
          <div className="flex flex-col gap-6 flex-1 min-w-0 animate-slide-up">
            {/* Report Info Section */}
            <div className="rounded-2xl border border-slate-200 dark:border-slate-800 bg-surface-card p-6 shadow-xs">
              <div className="flex items-center gap-2 mb-3">
                <Hash className="w-4 h-4 text-slate-400 dark:text-slate-500" aria-hidden="true" />
                <p className="text-xs font-mono font-bold text-slate-500 dark:text-slate-400">{report.id}</p>
              </div>

              <div className="flex items-start justify-between gap-3 mb-4">
                <h1 className="text-xl font-black text-slate-900 dark:text-slate-100 tracking-tight">
                  {report.category}
                </h1>
                <StatusBadge status={report.status} size="sm" />
              </div>

              <div className="flex flex-wrap gap-x-5 gap-y-2.5 pt-4 border-t border-slate-100 dark:border-slate-800">
                <span className="flex items-center gap-2 text-xs font-medium text-slate-600 dark:text-slate-400">
                  <Calendar className="w-4 h-4 text-slate-400" aria-hidden="true" />
                  {report.dateFull}
                </span>
                <span className="flex items-center gap-2 text-xs font-medium text-slate-600 dark:text-slate-400">
                  <MapPin className="w-4 h-4 text-slate-400" aria-hidden="true" />
                  {report.location}
                </span>
              </div>
            </div>

            {/* Description Section */}
            <div className="rounded-2xl border border-slate-200 dark:border-slate-800 bg-surface-card overflow-hidden shadow-xs">
              <div className="border-b border-slate-100 dark:border-slate-800 px-6 py-3.5 bg-slate-50/60 dark:bg-slate-800/40">
                <h2 className="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                  Kronologi Kejadian
                </h2>
              </div>
              <div className="p-6">
                <p className="text-sm text-slate-800 dark:text-slate-200 leading-relaxed whitespace-pre-wrap">
                  {report.description}
                </p>

                {report.involvedParties && (
                  <div className="mt-5 pt-5 border-t border-slate-100 dark:border-slate-800">
                    <p className="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">
                      Pihak Terlibat
                    </p>
                    <p className="text-sm font-semibold text-slate-800 dark:text-slate-200">
                      {report.involvedParties}
                    </p>
                  </div>
                )}
              </div>
            </div>

            {/* Privacy Section */}
            <div className="rounded-2xl border border-slate-200 dark:border-slate-800 bg-surface-card p-6 shadow-xs">
              <PrivacyCard value={report.privacy} readonly />
            </div>
          </div>

          {/* ── Right column (desktop) / Below (mobile) ─ */}
          <div className="flex flex-col gap-6 lg:w-80 shrink-0 animate-slide-up stagger-1">
            {/* Status Timeline */}
            <div className="rounded-2xl border border-slate-200 dark:border-slate-800 bg-surface-card overflow-hidden shadow-xs">
              <div className="border-b border-slate-100 dark:border-slate-800 px-6 py-3.5 bg-slate-50/60 dark:bg-slate-800/40">
                <h2 className="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                  Tahapan Penanganan
                </h2>
              </div>
              <div className="p-6">
                <Timeline items={report.timeline} />
              </div>
            </div>
          </div>
        </div>
      </main>

      <BottomNavigation />
    </PageContainer>
  );
}
