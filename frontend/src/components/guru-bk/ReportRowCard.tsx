// ── ReportRowCard — Laporan card for Guru BK list view ────────
"use client";

import { Calendar, MapPin, Paperclip, Lock } from "lucide-react";
import { StatusBadge } from "@/components/ui/StatusBadge";
import type { GBKReport } from "@/types";

interface ReportRowCardProps {
 report: GBKReport;
 onClick?: () => void;
}

export function ReportRowCard({ report, onClick }: ReportRowCardProps) {
 const isHidden = report.privacy === "hidden";

 return (
 <button
 onClick={onClick}
 className="w-full text-left bg-surface-card border border-slate-200 rounded-2xl p-4 shadow-sm
 hover:shadow-md hover:-translate-y-0.5 active:scale-[0.99]
 transition-all duration-150 cursor-pointer group"
 aria-label={`Laporan ${report.id}, ${report.category}, status ${report.status}`}
 >
 <div className="flex items-start gap-3">
 {/* Left — Main info */}
 <div className="flex-1 min-w-0">
 {/* Report ID + attachment */}
 <div className="flex items-center gap-2 mb-1">
 <p className="text-xs font-mono text-slate-600">{report.id}</p>
 {report.hasAttachment && (
 <Paperclip
 className="w-3 h-3 text-slate-600"
 aria-label="Ada lampiran"
 />
 )}
 </div>

 {/* Category */}
 <p className="text-sm font-semibold text-slate-900 mb-1.5 truncate">
 {report.category}
 </p>

 {/* Reporter — masked if hidden */}
 <div className="flex items-center gap-1 mb-2">
 {isHidden ? (
 <>
 <Lock
 className="w-3 h-3 text-slate-600 shrink-0"
 aria-hidden="true"
 />
 <span className="text-xs text-slate-600 italic">
 Identitas dirahasiakan
 </span>
 </>
 ) : (
 <span className="text-xs text-slate-700 font-medium">
 {report.reporterName} · Kelas {report.reporterClass}
 </span>
 )}
 </div>

 {/* Meta */}
 <div className="flex flex-wrap items-center gap-x-3 gap-y-1">
 <span className="inline-flex items-center gap-1 text-xs text-slate-600">
 <Calendar className="w-3 h-3" aria-hidden="true" />
 {report.date}
 </span>
 {report.location && (
 <span className="inline-flex items-center gap-1 text-xs text-slate-600">
 <MapPin className="w-3 h-3" aria-hidden="true" />
 <span className="truncate max-w-[120px]">
 {report.location}
 </span>
 </span>
 )}
 </div>
 </div>

 {/* Right — Status */}
 <div className="shrink-0 flex flex-col items-end gap-2 mt-0.5">
 <StatusBadge status={report.status} size="sm" />
 <span className="text-[10px] text-slate-600">
 {report.reportedAt}
 </span>
 </div>
 </div>
 </button>
 );
}

