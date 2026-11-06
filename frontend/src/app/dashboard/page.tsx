// ── Dashboard Page — Screen 02 ────────────────────────────────
"use client";

import { useRouter } from "next/navigation";
import {
  FilePlus,
  FileText,
  Clock,
  CheckCircle2,
  ShieldCheck,
  ChevronRight,
  Calendar,
  MapPin,
  Sparkles,
  Check,
  Lock,
} from "lucide-react";
import {
  AppHeader,
  PageContainer,
  BottomNavigation,
  StatusBadge,
} from "@/components/ui";
import { currentUser, mockReports, getReportStats } from "@/data/mockData";

export default function DashboardPage() {
  const router = useRouter();
  const stats = getReportStats(mockReports);
  const latestReport = mockReports[0];

  return (
    <PageContainer withBottomNav>
      {/* Header — mobile/tablet only; desktop uses sidebar */}
      <AppHeader
        variant="logo"
        showNotification
        showAvatar
        avatarInitials={currentUser.avatarInitials}
      />

      <main className="px-4 py-5 sm:px-6 sm:py-6 flex flex-col gap-6 max-w-5xl w-full mx-auto lg:px-8 lg:py-8 animate-fade-in">
        {/* ── Greeting & Action Banner ─────────────────────── */}
        <section aria-labelledby="greeting-heading" className="animate-slide-up">
          <div className="relative overflow-hidden bg-gradient-to-br from-[#EAF5EE] via-white to-[#F0EFE8] dark:from-[#13241C] dark:via-[#16231D] dark:to-[#0E1713] border border-slate-300/80 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xs">
            <div className="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
              <div className="max-w-xl">
                <div className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-primary-100/90 dark:bg-primary-950/70 text-primary-800 dark:text-primary-300 text-xs font-bold mb-3.5 border border-primary-300/80 dark:border-primary-800/80 shadow-2xs">
                  <span className="w-2 h-2 rounded-full bg-primary-600 dark:bg-[#5AE39D]" />
                  <span>Ruang Aman Siswa SIPERKA</span>
                </div>
                <h1
                  id="greeting-heading"
                  className="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight"
                >
                  Halo, {currentUser.name}
                </h1>
                <p className="text-sm text-slate-600 dark:text-slate-300 mt-2 leading-relaxed">
                  Kamu tidak sendirian. Suaramu sangat berarti untuk menciptakan lingkungan sekolah yang aman dan saling menghargai. Setiap aduan ditangani langsung oleh Guru BK secara rahasia.
                </p>

                <div className="flex flex-wrap items-center gap-4 mt-4 pt-4 border-t border-slate-200/80 dark:border-slate-800/80 text-xs text-slate-500 dark:text-slate-400">
                  <span className="flex items-center gap-1.5 font-medium">
                    <ShieldCheck className="w-4 h-4 text-primary-600 dark:text-[#5AE39D]" />
                    Kerahasiaan Identitas & Data Pribadi Terjamin
                  </span>
                  <span className="flex items-center gap-1.5 font-medium">
                    <Lock className="w-3.5 h-3.5 text-primary-600 dark:text-[#5AE39D]" />
                    Tersedia Opsi Pengirim Anonim
                  </span>
                </div>
              </div>

              {/* Desktop banner CTA button */}
              <div className="shrink-0 flex flex-col gap-2.5">
                <button
                  onClick={() => router.push("/laporan/buat")}
                  className="bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white rounded-2xl px-6 py-4 flex items-center justify-between gap-5 shadow-sm hover:shadow-md card-hover group cursor-pointer transition-all border border-primary-700/60"
                >
                  <div className="flex items-center gap-3.5">
                    <div className="w-11 h-11 rounded-xl bg-[#B8E34B] text-[#176B4D] flex items-center justify-center font-bold shadow-xs group-hover:scale-105 transition-transform">
                      <FilePlus className="w-6 h-6 text-[#176B4D]" aria-hidden="true" />
                    </div>
                    <div className="text-left">
                      <p className="text-base font-extrabold text-white leading-tight">Buat Laporan Baru</p>
                      <p className="text-xs text-emerald-100 font-medium mt-0.5">Bisa pilih opsi anonim</p>
                    </div>
                  </div>
                  <ChevronRight className="w-5 h-5 text-emerald-200 group-hover:translate-x-1.5 transition-transform" />
                </button>
                <p className="text-[11px] text-center text-slate-500 dark:text-slate-400">
                  Guru BK merespon laporan dalam 1x24 jam kerja
                </p>
              </div>
            </div>
          </div>
        </section>

        {/* ── Summary & Status Overview (Asymmetrical Composition) ── */}
        <section aria-labelledby="summary-heading" className="animate-slide-up stagger-1">
          <div className="flex items-center justify-between mb-4">
            <h2
              id="summary-heading"
              className="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400"
            >
              Ringkasan Status Kasus
            </h2>
            <span className="text-xs text-primary-600 dark:text-[#5AE39D] font-bold">
              Terhubung dengan Ruang BK
            </span>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-12 gap-4">
            {/* Main Total Card - 5 cols */}
            <div className="md:col-span-5 bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs flex flex-col justify-between">
              <div>
                <div className="flex items-center justify-between mb-3">
                  <span className="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    Total Laporan Diajukan
                  </span>
                  <div className="w-10 h-10 rounded-xl bg-primary-50 dark:bg-primary-950/60 border border-primary-200/60 dark:border-primary-800/60 text-primary-700 dark:text-primary-300 flex items-center justify-center">
                    <FileText className="w-5 h-5" />
                  </div>
                </div>
                <p className="text-4xl font-black text-slate-900 dark:text-slate-100 tabular-nums">
                  {stats.total}
                </p>
                <p className="text-xs text-slate-500 dark:text-slate-400 mt-2">
                  Seluruh aduan yang tersimpan aman dalam akun Anda
                </p>
              </div>

              <div className="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                <span>Terakhir diperbarui</span>
                <span className="font-semibold text-slate-700 dark:text-slate-300">Hari ini</span>
              </div>
            </div>

            {/* Split Status Breakdown - 7 cols */}
            <div className="md:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div className="bg-surface-card border border-amber-200/80 dark:border-amber-900/50 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
                <div>
                  <div className="flex items-center justify-between mb-3">
                    <span className="text-xs font-bold uppercase tracking-wider text-amber-800 dark:text-amber-400">
                      Dalam Penanganan
                    </span>
                    <div className="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800 text-amber-700 dark:text-[#FAD46B] flex items-center justify-center">
                      <Clock className="w-4 h-4" />
                    </div>
                  </div>
                  <p className="text-3xl font-extrabold text-amber-900 dark:text-[#FAD46B] tabular-nums">
                    {stats.inProgress}
                  </p>
                  <p className="text-xs text-slate-600 dark:text-slate-400 mt-2">
                    Laporan sedang ditelaah & didampingi Guru BK
                  </p>
                </div>
                <div className="mt-4 pt-3 border-t border-amber-100 dark:border-amber-900/40">
                  <span className="inline-flex items-center gap-1.5 text-[11px] font-semibold text-amber-700 dark:text-amber-300">
                    <span className="w-2 h-2 rounded-full bg-amber-500" />
                    Tahap investigasi aktif
                  </span>
                </div>
              </div>

              <div className="bg-surface-card border border-emerald-200/80 dark:border-emerald-900/50 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
                <div>
                  <div className="flex items-center justify-between mb-3">
                    <span className="text-xs font-bold uppercase tracking-wider text-emerald-800 dark:text-emerald-400">
                      Tuntas Diselesaikan
                    </span>
                    <div className="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-[#5AE39D] flex items-center justify-center">
                      <CheckCircle2 className="w-4 h-4" />
                    </div>
                  </div>
                  <p className="text-3xl font-extrabold text-emerald-900 dark:text-[#5AE39D] tabular-nums">
                    {stats.completed}
                  </p>
                  <p className="text-xs text-slate-600 dark:text-slate-400 mt-2">
                    Kasus telah selesai dimediasi & ditutup
                  </p>
                </div>
                <div className="mt-4 pt-3 border-t border-emerald-100 dark:border-emerald-900/40">
                  <span className="inline-flex items-center gap-1.5 text-[11px] font-semibold text-emerald-700 dark:text-emerald-300">
                    <Check className="w-3.5 h-3.5 text-emerald-600 dark:text-[#5AE39D]" />
                    Pendampingan berhasil
                  </span>
                </div>
              </div>
            </div>
          </div>
        </section>

        {/* ── Recent Report + Counselor Info Card ── */}
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-slide-up stagger-2">
          {/* Recent Report (2 cols on lg) */}
          <section
            aria-labelledby="recent-heading"
            className="lg:col-span-2 bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs flex flex-col justify-between"
          >
            <div>
              <div className="flex items-center justify-between mb-4 border-b border-slate-200 dark:border-slate-800 pb-3.5">
                <div>
                  <h2
                    id="recent-heading"
                    className="text-sm font-bold text-slate-900 dark:text-slate-100"
                  >
                    Laporan Terbaru
                  </h2>
                  <p className="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                    Aktivitas tindak lanjut terakhir dari konselor
                  </p>
                </div>
                <button
                  onClick={() => router.push("/laporan")}
                  className="text-xs text-primary-600 dark:text-[#5AE39D] font-bold hover:underline flex items-center gap-1 cursor-pointer"
                >
                  <span>Lihat semua riwayat</span>
                  <ChevronRight className="w-3.5 h-3.5" />
                </button>
              </div>

              {latestReport ? (
                <div
                  onClick={() => router.push(`/laporan/${latestReport.id}`)}
                  className="w-full text-left bg-slate-50/80 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/80 p-5
                    hover:bg-[#EAF5EE]/60 dark:hover:bg-[#163628]/50 hover:border-primary-400 dark:hover:border-primary-500
                    transition-all duration-150 cursor-pointer group rounded-2xl card-hover"
                  aria-label={`Laporan ${latestReport.id}, ${latestReport.category}, status ${latestReport.status}`}
                >
                  <div className="flex items-start justify-between gap-4">
                    <div className="flex-1 min-w-0">
                      <div className="flex items-center gap-2.5 mb-2.5">
                        <span className="text-xs font-mono font-bold px-2.5 py-0.5 rounded-md bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-slate-200">
                          {latestReport.id}
                        </span>
                        <StatusBadge status={latestReport.status} />
                      </div>
                      <p className="text-base font-extrabold text-slate-900 dark:text-slate-100 mb-2 truncate">
                        {latestReport.category}
                      </p>
                      <div className="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500 dark:text-slate-400">
                        <span className="inline-flex items-center gap-1.5">
                          <Calendar className="w-3.5 h-3.5 text-slate-400" aria-hidden="true" />
                          {latestReport.date}
                        </span>
                        {latestReport.location && (
                          <span className="inline-flex items-center gap-1.5">
                            <MapPin className="w-3.5 h-3.5 text-slate-400" aria-hidden="true" />
                            {latestReport.location}
                          </span>
                        )}
                      </div>
                    </div>
                    <div className="w-9 h-9 rounded-xl bg-white dark:bg-slate-700 flex items-center justify-center shrink-0 border border-slate-200 dark:border-slate-600 group-hover:bg-primary-600 group-hover:text-white transition-colors shadow-2xs">
                      <ChevronRight className="w-4 h-4 text-slate-500 dark:text-slate-400 group-hover:text-white transition-colors" />
                    </div>
                  </div>
                </div>
              ) : (
                <div className="text-center py-8 text-sm text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-800/40 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700">
                  Belum ada laporan yang diajukan.
                </div>
              )}
            </div>

            <div className="mt-5 pt-3.5 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
              <span className="flex items-center gap-1.5">
                <Sparkles className="w-3.5 h-3.5 text-primary-600 dark:text-[#5AE39D]" />
                Respon Guru BK rata-rata 1x24 jam kerja
              </span>
            </div>
          </section>

          {/* Counselor Info Card (1 col on lg) */}
          <section aria-label="Informasi keamanan dan konseling" className="flex flex-col">
            <div className="bg-[#EAF5EE] dark:bg-[#16291F] border border-[#c9e6d8] dark:border-emerald-800/70 rounded-2xl p-6 shadow-xs flex-1 flex flex-col justify-between">
              <div>
                <div className="w-12 h-12 bg-[#176B4D] text-[#B8E34B] rounded-2xl flex items-center justify-center shrink-0 shadow-xs mb-4">
                  <ShieldCheck className="w-6 h-6" aria-hidden="true" />
                </div>
                <h3 className="text-base font-bold text-[#176B4D] dark:text-[#5AE39D]">
                  Identitas Kamu Terlindungi Penuh
                </h3>
                <p className="text-xs text-slate-700 dark:text-slate-300 mt-2.5 leading-relaxed">
                  Kamu bisa memilih opsi anonim saat mengirimkan laporan. Guru BK menangani setiap aduan secara objektif, aman, dan tanpa diskriminasi.
                </p>
              </div>

              <div className="mt-6 pt-4 border-t border-[#c9e6d8]/80 dark:border-emerald-800/50">
                <p className="text-xs font-semibold text-[#176B4D] dark:text-[#5AE39D]">
                  Butuh bantuan langsung? Kunjungi Ruang BK di lantai 2 gedung utama saat jam sekolah.
                </p>
              </div>
            </div>
          </section>
        </div>
      </main>

      <BottomNavigation />
    </PageContainer>
  );
}
