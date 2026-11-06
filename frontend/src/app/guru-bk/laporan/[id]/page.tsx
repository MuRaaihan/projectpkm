// ── Guru BK — Detail Laporan ─────────────────────────────────
"use client";

import { use } from "react";
import { Calendar, MapPin, Hash, Lock, Users, Paperclip } from "lucide-react";
import { GBKLayout } from "@/components/guru-bk/GBKLayout";
import { StatusUpdatePanel } from "@/components/guru-bk/StatusUpdatePanel";
import { StatusBadge } from "@/components/ui/StatusBadge";
import { PrivacyCard } from "@/components/ui/PrivacyCard";
import { gbkReports } from "@/data/mockDataGBK";

interface PageProps {
  params: Promise<{ id: string }>;
}

export default function GBKDetailLaporanPage({ params }: PageProps) {
  const { id } = use(params);
  const report = gbkReports.find((r) => r.id === id) ?? gbkReports[0];
  const isHidden = report.privacy === "hidden";

  return (
    <GBKLayout
      pageTitle="Detail Laporan Siswa"
      pageSubtitle="Pemeriksaan kronologi dan penetapan tindak lanjut konseling"
      showBackButton
      backHref="/guru-bk/laporan"
      withBottomNav={false}
    >
      <div className="px-4 sm:px-6 lg:px-8 py-6 pb-12 max-w-5xl w-full flex flex-col gap-6 animate-fade-in mx-auto">
        {/* ── Page Header ──────────────────────────── */}
        <div className="rounded-2xl border border-slate-200 dark:border-slate-800 bg-surface-card p-6 shadow-xs">
          <div className="flex items-center gap-2 mb-2">
            <Hash
              className="w-4 h-4 text-slate-400 dark:text-slate-500"
              aria-hidden="true"
            />
            <p className="text-xs font-mono font-bold text-slate-500 dark:text-slate-400">
              {report.id}
            </p>
          </div>
          <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h1 className="text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight">
              {report.category}
            </h1>
            <StatusBadge status={report.status as any} size="md" />
          </div>
          <p className="text-xs text-slate-500 dark:text-slate-400 mt-2">
            Dilaporkan pada {report.reportedAt}
          </p>
        </div>

        {/* ── Desktop 2-column / Mobile single column ─ */}
        <div className="flex flex-col gap-6 lg:flex-row lg:items-start">
          {/* ── Left column — Report info ──────────── */}
          <div className="flex flex-col gap-6 flex-1 min-w-0">
            {/* Reporter identity */}
            <section className="bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs animate-slide-up stagger-1">
              <h2 className="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-4 border-b border-slate-100 dark:border-slate-800 pb-2">
                Identitas Pelapor
              </h2>
              {isHidden ? (
                <div className="flex items-center gap-3.5 bg-slate-50 dark:bg-slate-800/60 rounded-xl p-4 border border-slate-200 dark:border-slate-700/80">
                  <div className="w-10 h-10 bg-slate-200 dark:bg-slate-700 rounded-xl flex items-center justify-center shrink-0">
                    <Lock
                      className="w-5 h-5 text-slate-600 dark:text-slate-300"
                      aria-hidden="true"
                    />
                  </div>
                  <div>
                    <p className="text-sm font-bold text-slate-900 dark:text-slate-100">
                      Identitas Dirahasiakan (Anonim)
                    </p>
                    <p className="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                      Siswa memilih opsi privasi tinggi. Tangani kasus secara objektif.
                    </p>
                  </div>
                </div>
              ) : (
                <div className="flex items-center gap-3.5 bg-primary-50 dark:bg-primary-950/60 rounded-xl p-4 border border-primary-200/80 dark:border-primary-800/80">
                  <div className="w-10 h-10 bg-primary-600 text-white rounded-xl flex items-center justify-center shrink-0 font-bold">
                    <span>{report.reporterName?.[0] ?? "?"}</span>
                  </div>
                  <div>
                    <p className="text-sm font-bold text-slate-900 dark:text-slate-100">
                      {report.reporterName}
                    </p>
                    <p className="text-xs text-primary-800 dark:text-primary-300 font-semibold mt-0.5">
                      Kelas {report.reporterClass}
                    </p>
                  </div>
                </div>
              )}
            </section>

            {/* Event details */}
            <section className="bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs animate-slide-up stagger-2">
              <h2 className="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-4 border-b border-slate-100 dark:border-slate-800 pb-2">
                Rincian Kejadian
              </h2>
              <div className="flex flex-col gap-3">
                <InfoRow
                  icon={<Calendar className="w-4 h-4 text-slate-400" />}
                  label="Tanggal Kejadian"
                  value={report.dateFull}
                />
                <div className="h-px bg-slate-100 dark:border-slate-800" />
                <InfoRow
                  icon={<MapPin className="w-4 h-4 text-slate-400" />}
                  label="Lokasi Tempat Kejadian"
                  value={report.location}
                />

                {report.involvedParties && (
                  <>
                    <div className="h-px bg-slate-100 dark:border-slate-800" />
                    <InfoRow
                      icon={<Users className="w-4 h-4 text-slate-400" />}
                      label="Pihak yang Terlibat"
                      value={report.involvedParties}
                    />
                  </>
                )}

                {report.hasAttachment && (
                  <>
                    <div className="h-px bg-slate-100 dark:border-slate-800" />
                    <div className="flex items-center gap-2 text-xs font-semibold text-primary-700 dark:text-[#5AE39D] py-1">
                      <Paperclip className="w-4 h-4" aria-hidden="true" />
                      <span>Lampiran dokumen atau foto bukti tersedia</span>
                    </div>
                  </>
                )}
              </div>
            </section>

            {/* Kronologi */}
            <section className="bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs animate-slide-up stagger-3">
              <h2 className="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-3 border-b border-slate-100 dark:border-slate-800 pb-2">
                Kronologi Kejadian Siswa
              </h2>
              <p className="text-sm text-slate-800 dark:text-slate-200 leading-relaxed whitespace-pre-wrap">
                {report.description}
              </p>
            </section>

            {/* Privacy */}
            <section className="bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs animate-slide-up stagger-4">
              <h2 className="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-4 border-b border-slate-100 dark:border-slate-800 pb-2">
                Pengaturan Privasi Pelapor
              </h2>
              <PrivacyCard value={report.privacy} readonly />
            </section>
          </div>

          {/* ── Right column — Action panel ────────── */}
          <div className="lg:w-88 shrink-0">
            <StatusUpdatePanel
              reportId={report.id}
              currentStatus={report.status}
              currentNote={report.counselorNote}
              timeline={report.timeline}
            />
          </div>
        </div>
      </div>
    </GBKLayout>
  );
}

// ── Sub-components ────────────────────────────────────────────

function InfoRow({
  icon,
  label,
  value,
}: {
  icon: React.ReactNode;
  label: string;
  value: string;
}) {
  return (
    <div className="flex items-start gap-3 py-1">
      <span
        className="text-slate-500 dark:text-slate-400 shrink-0 mt-0.5"
        aria-hidden="true"
      >
        {icon}
      </span>
      <div className="flex-1 min-w-0">
        <p className="text-xs text-slate-500 dark:text-slate-400">{label}</p>
        <p className="text-sm font-bold text-slate-900 dark:text-slate-100 mt-0.5">
          {value}
        </p>
      </div>
    </div>
  );
}
