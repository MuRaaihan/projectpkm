// ── StatusUpdatePanel — Action panel for Guru BK detail page ──
"use client";

import { useState } from "react";
import { CheckCircle, Save } from "lucide-react";
import { Button } from "@/components/ui/Button";
import { Timeline } from "@/components/ui/Timeline";
import { StatusBadge } from "@/components/ui/StatusBadge";
import type { ReportStatus, TimelineStep } from "@/types";

const statusOptions: ReportStatus[] = [
  "Diterima",
  "Diverifikasi",
  "Dalam Penanganan",
  "Selesai",
  "Ditolak",
];

interface StatusUpdatePanelProps {
  reportId: string;
  currentStatus: ReportStatus;
  currentNote: string | undefined;
  timeline: TimelineStep[];
}

export function StatusUpdatePanel({
  reportId,
  currentStatus,
  currentNote,
  timeline,
}: StatusUpdatePanelProps) {
  const [selectedStatus, setSelectedStatus] =
    useState<ReportStatus>(currentStatus);
  const [note, setNote] = useState(currentNote ?? "");
  const [saved, setSaved] = useState(false);
  const [loading, setLoading] = useState(false);

  const hasChanges =
    selectedStatus !== currentStatus || note !== (currentNote ?? "");

  const handleSave = async () => {
    if (!hasChanges) return;
    setLoading(true);
    await new Promise((r) => setTimeout(r, 1000));
    setLoading(false);
    setSaved(true);
    setTimeout(() => setSaved(false), 3000);
  };

  return (
    <div className="flex flex-col gap-5">
      {/* ── Update Status ──────────────────────────── */}
      <div className="bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl p-6 flex flex-col gap-4.5 shadow-xs animate-slide-up stagger-1">
        <div className="flex items-center justify-between gap-2 border-b border-slate-100 dark:border-slate-800 pb-3">
          <h2 className="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">
            Tindak Lanjut Kasus
          </h2>
          <span className="text-xs font-mono font-bold text-slate-500 dark:text-slate-400">
            {reportId}
          </span>
        </div>

        {/* Current status */}
        <div>
          <p className="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">
            Status saat ini
          </p>
          <StatusBadge status={currentStatus} size="sm" />
        </div>

        {/* Change status */}
        <div>
          <label
            htmlFor={`status-select-${reportId}`}
            className="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-200 mb-1.5"
          >
            Perbarui Status
          </label>
          <select
            id={`status-select-${reportId}`}
            value={selectedStatus}
            onChange={(e) => {
              setSelectedStatus(e.target.value as ReportStatus);
              setSaved(false);
            }}
            className="w-full h-10 rounded-xl border border-slate-300 dark:border-slate-700 bg-surface-card dark:bg-slate-800/80 px-3.5 text-sm
              text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary-100 dark:focus:ring-emerald-950/60
              focus:border-primary-600 dark:focus:border-[#5AE39D] transition-all shadow-2xs"
          >
            {statusOptions.map((s) => (
              <option key={s} value={s} className="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">
                {s}
              </option>
            ))}
          </select>
        </div>

        {/* Note */}
        <div>
          <label
            htmlFor={`note-${reportId}`}
            className="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-200 mb-1.5"
          >
            Catatan Penanganan Konselor
          </label>
          <textarea
            id={`note-${reportId}`}
            value={note}
            onChange={(e) => {
              setNote(e.target.value);
              setSaved(false);
            }}
            rows={4}
            placeholder="Tulis catatan penanganan resmi atau hasil mediasi..."
            className="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-surface-card dark:bg-slate-800/80 p-3.5 text-sm
              text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 resize-none
              focus:outline-none focus:ring-2 focus:ring-primary-100 dark:focus:ring-emerald-950/60
              focus:border-primary-600 dark:focus:border-[#5AE39D] transition-all shadow-2xs"
          />
          <p className="text-[11px] text-slate-500 dark:text-slate-400 mt-1.5 leading-relaxed">
            Catatan ini akan tersinkronisasi dan dapat dilihat oleh siswa di halaman detail laporan mereka.
          </p>
        </div>

        {/* Save button */}
        <div className="pt-2">
          <Button
            variant="primary"
            size="md"
            fullWidth
            loading={loading}
            onClick={handleSave}
            disabled={!hasChanges || loading}
            leftIcon={<Save className="w-4 h-4" />}
          >
            Simpan Pembaruan
          </Button>
        </div>

        {/* Success state */}
        {saved && (
          <div className="flex items-center gap-2 text-emerald-800 dark:text-[#5AE39D] bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/80 rounded-xl px-3.5 py-2.5 mt-1">
            <CheckCircle className="w-4 h-4 shrink-0 text-primary-600 dark:text-[#5AE39D]" />
            <p className="text-xs font-bold">Pembaruan berhasil tersimpan ke sistem.</p>
          </div>
        )}

        {/* Warning for Ditolak */}
        {selectedStatus === "Ditolak" && selectedStatus !== currentStatus && (
          <div className="bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800/80 rounded-xl p-3.5 mt-1">
            <p className="text-xs text-amber-900 dark:text-amber-200 leading-relaxed font-medium">
              Perhatian: Menolak laporan akan menginformasikan kepada pelapor bahwa kasus ditutup. Pastikan alasan objektif telah dicantumkan pada catatan di atas.
            </p>
          </div>
        )}
      </div>

      {/* ── Timeline ───────────────────────────────── */}
      <div className="bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs animate-slide-up stagger-2">
        <h2 className="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-4 border-b border-slate-100 dark:border-slate-800 pb-3">
          Riwayat Penanganan
        </h2>
        <Timeline items={timeline} />
      </div>
    </div>
  );
}
