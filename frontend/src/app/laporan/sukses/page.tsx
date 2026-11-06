// ── Success State ─────────────────────────────────────────────
"use client";

import { useEffect, useState } from "react";
import { useRouter } from "next/navigation";
import { CheckCircle, ArrowRight, Home } from "lucide-react";
import { Button, PageContainer } from "@/components/ui";

export default function SuksesPage() {
 const router = useRouter();
 const [reportId, setReportId] = useState("ELP-2026-00127");

 useEffect(() => {
 const id = sessionStorage.getItem("lastReportId");
 if (id) setReportId(id);
 }, []);

 return (
 <PageContainer>
 <main
 className="min-h-[calc(100vh-0px)] flex flex-col items-center justify-center
 px-6 py-12 text-center max-w-lg w-full mx-auto animate-fade-in"
 >
 {/* ── Success Icon ──────────────────────────── */}
 <div className="relative mb-6">
 <div className="w-24 h-24 bg-primary-50 dark:bg-primary-950/40 rounded-full flex items-center justify-center border-4 border-primary-100 dark:border-primary-900/50">
 <CheckCircle
 className="w-12 h-12 text-primary-600 dark:text-primary-400"
 aria-hidden="true"
 />
 </div>
 </div>

 {/* ── Heading ───────────────────────────────── */}
 <h1 className="text-xl font-bold text-slate-900 dark:text-slate-100 mb-2">
 Laporan berhasil dikirim
 </h1>
 <p className="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-6 max-w-[280px]">
 Laporan kamu telah diterima oleh pihak sekolah. Tim kami akan segera
 menindaklanjuti.
 </p>

 {/* ── Report ID ─────────────────────────────── */}
 <div className="bg-surface-card border border-slate-200/90 dark:border-slate-700/80 rounded-xl shadow-xs px-6 py-4 mb-8 w-full max-w-[280px]">
 <p className="text-xs text-slate-600 dark:text-slate-400 mb-1">Nomor Laporan</p>
 <p
 className="text-lg font-bold font-mono text-primary-700 dark:text-primary-500 tracking-wide"
 aria-label={`Nomor laporan ${reportId}`}
 >
 {reportId}
 </p>
 <p className="text-xs text-slate-600 dark:text-slate-400 mt-1">
 Simpan nomor ini untuk memantau statusnya.
 </p>
 </div>

 {/* ── Steps after submission ────────────────── */}
 <div className="flex flex-col gap-2 w-full mb-8">
 {[
 { num: "1", text: "Laporan kamu telah kami terima" },
 { num: "2", text: "Tim akan memverifikasi laporan" },
 { num: "3", text: "Penanganan akan segera dimulai" },
 ].map(({ num, text }) => (
 <div key={num} className="flex items-center gap-3 text-left">
 <div className="w-6 h-6 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center shrink-0">
 <span className="text-xs font-bold text-primary-600 dark:text-primary-500">
 {num}
 </span>
 </div>
 <p className="text-xs text-slate-700 dark:text-slate-200">{text}</p>
 </div>
 ))}
 </div>

 {/* ── CTAs ──────────────────────────────────── */}
 <div className="flex flex-col gap-3 w-full">
 <Button
 variant="primary"
 size="lg"
 fullWidth
 rightIcon={<ArrowRight className="w-4 h-4" />}
 onClick={() => router.push(`/laporan/${reportId}`)}
 >
 Lihat Status Laporan
 </Button>
 <Button
 variant="ghost"
 size="md"
 fullWidth
 leftIcon={<Home className="w-4 h-4" />}
 onClick={() => router.push("/dashboard")}
 >
 Kembali ke Beranda
 </Button>
 </div>
 </main>
 </PageContainer>
 );
}
