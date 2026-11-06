// ── ReportCard Component ─────────────────────────────────────
"use client";

import { Calendar, MapPin, ChevronRight } from "lucide-react";
import { StatusBadge } from "./StatusBadge";
import type { Report } from "@/types";

interface ReportCardProps {
 report: Report;
 onClick?: () => void;
}

export function ReportCard({ report, onClick }: ReportCardProps) {
 return (
 <button
 onClick={onClick}
 className="w-full text-left bg-surface-card border border-slate-200 rounded-2xl p-4 shadow-sm
 hover:shadow-md hover:-translate-y-0.5 active:scale-[0.99]
 transition-all duration-150 cursor-pointer group"
 aria-label={`Laporan ${report.id}, ${report.category}, status ${report.status}`}
 >
 <div className="flex items-start justify-between gap-3">
 <div className="flex-1 min-w-0">
 {/* Report ID */}
 <p className="text-xs font-mono text-slate-600 mb-1">{report.id}</p>

 {/* Category */}
 <p className="text-sm font-semibold text-slate-900 mb-2 truncate">
 {report.category}
 </p>

 {/* Meta */}
 <div className="flex flex-wrap items-center gap-x-3 gap-y-1 mb-3">
 <span className="inline-flex items-center gap-1 text-xs text-slate-600">
 <Calendar className="w-3 h-3" aria-hidden="true" />
 {report.date}
 </span>
 {report.location && (
 <span className="inline-flex items-center gap-1 text-xs text-slate-600">
 <MapPin className="w-3 h-3" aria-hidden="true" />
 {report.location}
 </span>
 )}
 </div>

 {/* Status */}
 <StatusBadge status={report.status} />
 </div>

 {/* Chevron */}
 <ChevronRight
 className="w-4 h-4 text-slate-600 group-hover:text-primary-400 transition-colors shrink-0 mt-1"
 aria-hidden="true"
 />
 </div>
 </button>
 );
}

