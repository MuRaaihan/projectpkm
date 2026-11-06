// ── Konfirmasi Laporan — Screen 04 ───────────────────────────
"use client";

import { useState, useEffect } from "react";
import { useRouter } from "next/navigation";
import { Calendar, MapPin, Users, Paperclip, Hash, ClipboardList } from "lucide-react";
import {
 AppHeader,
 PageContainer,
 Button,
 PrivacyCard,
} from "@/components/ui";
import { generateReportId } from "@/data/mockData";
import type { PrivacyOption } from "@/types";

interface PendingReport {
 description: string;
 category: string;
 date: string;
 location: string;
 involvedParties: string;
 attachment: string | null;
 privacy: PrivacyOption;
}

export default function KonfirmasiPage() {
 const router = useRouter();
 const [report, setReport] = useState<PendingReport | null>(null);
 const [privacy, setPrivacy] = useState<PrivacyOption>("hidden");
 const [reportId] = useState(() => generateReportId());
 const [loading, setLoading] = useState(false);

 useEffect(() => {
 const raw = sessionStorage.getItem("pendingReport");
 if (raw) {
 const parsed: PendingReport = JSON.parse(raw);
 setReport(parsed);
 setPrivacy(parsed.privacy);
 } else {
 // If accessed directly without form data, use demo data
 setReport({
 description:
 "Teman sekelas saya sering mengejek nama saya dan memanggil dengan sebutan yang tidak pantas di depan teman-teman lain.",
 category: "Perundungan Verbal",
 date: "2026-09-12",
 location: "Ruang Kelas",
 involvedParties: "Siswa kelas 10-B",
 attachment: null,
 privacy: "hidden",
 });
 }
 }, []);

 const formattedDate = report?.date
 ? new Date(report.date).toLocaleDateString("id-ID", {
 day: "numeric",
 month: "long",
 year: "numeric",
 })
 : "-";

 const handleSubmit = async () => {
 setLoading(true);
 await new Promise((r) => setTimeout(r, 1500));
 sessionStorage.removeItem("pendingReport");
 sessionStorage.setItem("lastReportId", reportId);
 setLoading(false);
 router.push("/laporan/sukses");
 };

 if (!report) return null;

 return (
 <PageContainer>
 <AppHeader
 variant="back"
 title="Konfirmasi Laporan"
 backHref="/laporan/buat"
 />

 <main className="px-6 py-5 flex flex-col gap-6 pb-8 max-w-2xl w-full mx-auto lg:px-8 lg:py-6 animate-fade-in">
 {/* ── Report Summary Section ──────────────────── */}
 <section className="animate-slide-up" style={{ animationDelay: "100ms" }}>
 <h2 className="text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-4">
 Ringkasan Laporan
 </h2>
 <div className="rounded-xl border border-slate-200/90 dark:border-slate-700/80 bg-surface-card p-4 flex flex-col gap-4 shadow-xs">
 {/* Report ID */}
 <InfoRow
 icon={<Hash className="w-4 h-4 text-primary-500" />}
 label="Nomor Laporan"
 value={reportId}
 mono
 />
 <Divider />

 {/* Category */}
 <InfoRow
 icon={<ClipboardList className="w-4 h-4 text-slate-600 dark:text-slate-400" />}
 label="Kategori"
 value={report.category}
 />
 <Divider />

 {/* Date */}
 <InfoRow
 icon={<Calendar className="w-4 h-4 text-slate-600 dark:text-slate-400" />}
 label="Tanggal"
 value={formattedDate}
 />
 <Divider />

 {/* Location */}
 <InfoRow
 icon={<MapPin className="w-4 h-4 text-slate-600 dark:text-slate-400" />}
 label="Lokasi"
 value={report.location}
 />
 <Divider />

 {/* Description */}
 <div>
 <p className="text-xs text-slate-600 dark:text-slate-400 mb-1.5">Kronologi</p>
 <p className="text-sm text-slate-900 dark:text-slate-100 leading-relaxed line-clamp-4">
 {report.description}
 </p>
 </div>

 {/* Involved parties */}
 {report.involvedParties && (
 <>
 <Divider />
 <InfoRow
 icon={<Users className="w-4 h-4 text-slate-600 dark:text-slate-400" />}
 label="Pihak yang terlibat"
 value={report.involvedParties}
 />
 </>
 )}

 {/* Attachment */}
 {report.attachment && (
 <>
 <Divider />
 <InfoRow
 icon={<Paperclip className="w-4 h-4 text-slate-600 dark:text-slate-400" />}
 label="Lampiran"
 value={report.attachment}
 />
 </>
 )}
 </div>
 </section>

 {/* ── Privacy Section ──────────────────────── */}
 <section className="animate-slide-up" style={{ animationDelay: "150ms" }}>
 <h2 className="text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-4">
 Pengaturan Privasi
 </h2>
 <div className="rounded-lg border border-slate-200 dark:border-slate-700 bg-surface-card p-4">
 <PrivacyCard value={privacy} onChange={setPrivacy} />
 </div>
 </section>

 <section className="flex flex-col gap-3 animate-slide-up" style={{ animationDelay: "200ms" }}>
 {/* ── Warning ──────────────────────────────── */}
 <p className="text-xs text-slate-600 dark:text-slate-400 text-center leading-relaxed px-2 mb-2">
 Pastikan informasi yang kamu masukkan sudah sesuai sebelum mengirim
 laporan.
 </p>

 {/* ── Submit Button ─────────────────────────── */}
 <Button
 variant="primary"
 size="lg"
 fullWidth
 loading={loading}
 onClick={handleSubmit}
 className="rounded-md"
 >
 Kirim Laporan
 </Button>

 <Button
 variant="ghost"
 size="md"
 fullWidth
 onClick={() => router.push("/laporan/buat")}
 disabled={loading}
 className="rounded-md"
 >
 Ubah Laporan
 </Button>
 </section>
 </main>
 </PageContainer>
 );
}

// ── Sub-components ────────────────────────────────────────────

function InfoRow({
 icon,
 label,
 value,
 mono = false,
}: {
 icon: React.ReactNode;
 label: string;
 value: string;
 mono?: boolean;
}) {
 return (
 <div className="flex items-start gap-3">
 <span className="mt-0.5 shrink-0" aria-hidden="true">
 {icon}
 </span>
 <div className="flex-1 min-w-0">
 <p className="text-xs text-slate-600 dark:text-slate-400">{label}</p>
 <p
 className={`text-sm font-medium text-slate-900 dark:text-slate-100 mt-0.5 break-all ${
 mono ? "font-mono" : ""
 }`}
 >
 {value}
 </p>
 </div>
 </div>
 );
}

function Divider() {
 return <div className="h-px bg-slate-100 dark:bg-slate-700/50" aria-hidden="true" />;
}

