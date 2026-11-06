// ── Admin Dashboard — Professional Operational Console ────────
"use client";

import { useRouter } from "next/navigation";
import {
  Users,
  FileText,
  Clock,
  CheckCircle2,
  ShieldCheck,
  ChevronRight,
  AlertCircle,
  TrendingUp,
  Server,
  UserCheck,
  Shield,
} from "lucide-react";
import { AdminLayout } from "@/components/admin/AdminLayout";
import { StatusBadge } from "@/components/ui/StatusBadge";
import { KpiCard } from "@/components/ui/KpiCard";
import {
  adminReports,
  adminNotifications,
  adminMonthlyStats,
  getAdminStats,
  getAdminCategoryStats,
} from "@/data/mockDataAdmin";

const fmt = (n: number) => n.toString();
const maxMonthly = Math.max(...adminMonthlyStats.map((s) => s.value), 1);

const systemActivity = [
  {
    time: "09:42",
    label: "Laporan baru diterima",
    sub: "ELP-2026-00130 · Perundungan Verbal",
    dot: "bg-primary-600 dark:bg-[#5AE39D]",
  },
  {
    time: "09:31",
    label: "Status laporan diperbarui",
    sub: "ELP-2026-00127 -> Dalam Penanganan",
    dot: "bg-amber-500 dark:bg-[#FAD46B]",
  },
  {
    time: "08:55",
    label: "Pengguna baru didaftarkan",
    sub: "Ahmad Fauzan · Siswa Kelas 10-A",
    dot: "bg-sky-500 dark:bg-sky-400",
  },
  {
    time: "08:12",
    label: "Laporan ELP-00123 diselesaikan",
    sub: "Oleh Guru BK Sari Dewi, S.Pd.",
    dot: "bg-emerald-600 dark:bg-[#5AE39D]",
  },
  {
    time: "Kemarin",
    label: "Backup basis data berhasil",
    sub: "Sinkronisasi otomatis terjadwal",
    dot: "bg-slate-400 dark:text-slate-500",
  },
];

export default function AdminDashboardPage() {
  const router = useRouter();
  const stats = getAdminStats();
  const catStats = getAdminCategoryStats();
  const recentReports = adminReports.slice(0, 6);
  const unreadNotifs = adminNotifications.filter((n) => !n.isRead);
  const maxCat = Math.max(...catStats.map((c) => c.value), 1);

  return (
    <AdminLayout
      pageTitle="Panel Administrasi Sistem"
      pageSubtitle="Monitoring operasional, tata kelola akun, dan audit integritas SIPERKA"
      withBottomNav
    >
      <div className="px-4 sm:px-6 lg:px-8 py-6 flex flex-col gap-6 max-w-6xl w-full mx-auto animate-fade-in">
        {/* ── Mobile Page Header ──────────────────── */}
        <div className="lg:hidden">
          <h1 className="text-xl font-black text-slate-900 dark:text-slate-100">
            Panel Administrasi
          </h1>
          <p className="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
            Monitoring operasional sistem SIPERKA
          </p>
        </div>

        {/* ── Alert — unread notifs ─────────────── */}
        {unreadNotifs.length > 0 && (
          <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-amber-50/90 dark:bg-[#261A05] border border-amber-300 dark:border-amber-800/80 rounded-2xl p-5 shadow-xs animate-slide-up">
            <div className="flex items-start gap-3.5">
              <div className="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/50 border border-amber-300 dark:border-amber-700 text-amber-800 dark:text-[#FAD46B] flex items-center justify-center shrink-0">
                <AlertCircle className="w-5 h-5" aria-hidden="true" />
              </div>
              <div>
                <p className="text-sm font-extrabold text-amber-950 dark:text-[#FAD46B]">
                  {unreadNotifs.length} Notifikasi Sistem Memerlukan Perhatian
                </p>
                <p className="text-xs text-amber-800 dark:text-amber-200/90 mt-1">
                  {unreadNotifs[0]?.message || "Terdapat pembaruan status laporan yang perlu ditinjau admin."}
                </p>
              </div>
            </div>

            <button
              onClick={() => router.push("/admin/notifikasi")}
              className="px-4 py-2 rounded-xl bg-amber-800 hover:bg-amber-900 text-white text-xs font-bold transition-colors shrink-0 shadow-xs flex items-center justify-center gap-1 cursor-pointer"
            >
              <span>Buka Notifikasi</span>
              <ChevronRight className="w-3.5 h-3.5" />
            </button>
          </div>
        )}

        {/* ── Row 1 — System Metrics Grid ─────────── */}
        <section aria-labelledby="kpi-heading" className="animate-slide-up stagger-1">
          <div className="flex items-center justify-between mb-3.5">
            <h2
              id="kpi-heading"
              className="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400"
            >
              Matriks Pengguna & Layanan
            </h2>
            <span className="text-xs font-semibold text-slate-600 dark:text-slate-300">
              {stats.totalUsers} Total Akun Aktif
            </span>
          </div>

          <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5">
            <KpiCard
              label="Total Siswa"
              value={fmt(stats.totalSiswa)}
              icon={<Users className="w-4 h-4" />}
              accent="slate"
              description="Siswa terdaftar"
            />
            <KpiCard
              label="Guru BK"
              value={fmt(stats.totalGuruBK)}
              icon={<ShieldCheck className="w-4 h-4" />}
              accent="green"
              description="Konselor berwenang"
            />
            <KpiCard
              label="Total Laporan"
              value={fmt(stats.totalLaporan)}
              icon={<FileText className="w-4 h-4" />}
              accent="default"
              description="Kasus terdata"
            />
            <KpiCard
              label="Dalam Penanganan"
              value={fmt(stats.laporanDalamPenanganan)}
              icon={<Clock className="w-4 h-4" />}
              accent="amber"
              description="Sedang didampingi"
            />
            <KpiCard
              label="Kasus Selesai"
              value={fmt(stats.laporanSelesai)}
              icon={<CheckCircle2 className="w-4 h-4" />}
              accent="green"
              description="Tuntas ditangani"
            />
          </div>
        </section>

        {/* ── Row 2 — Charts & Distribution ───────── */}
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-slide-up stagger-2">
          {/* Tren Laporan (2/3) */}
          <section
            aria-labelledby="trend-heading"
            className="lg:col-span-2 bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs flex flex-col justify-between"
          >
            <div className="flex items-center justify-between mb-6">
              <div>
                <h2
                  id="trend-heading"
                  className="text-base font-bold text-slate-900 dark:text-slate-100"
                >
                  Tren Laporan Masuk Sekolah
                </h2>
                <p className="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                  Distribusi frekuensi kasus perundungan dalam 6 bulan terakhir
                </p>
              </div>
              <div className="w-9 h-9 rounded-xl bg-primary-50 dark:bg-primary-950/60 border border-primary-200/60 dark:border-primary-800 text-primary-700 dark:text-[#5AE39D] flex items-center justify-center">
                <TrendingUp className="w-5 h-5" aria-hidden="true" />
              </div>
            </div>

            <div className="flex items-end gap-3 h-36 pt-2 pb-2 border-b border-slate-200 dark:border-slate-800">
              {adminMonthlyStats.map((s) => (
                <div
                  key={s.label}
                  className="flex-1 flex flex-col items-center gap-2 group"
                >
                  <span className="text-xs font-bold text-slate-700 dark:text-slate-300 tabular-nums">
                    {s.value}
                  </span>
                  <div className="w-full bg-slate-100 dark:bg-slate-800/80 rounded-t-lg h-28 flex items-end overflow-hidden">
                    <div
                      className="w-full bg-primary-600 hover:bg-primary-500 rounded-t-lg transition-all duration-500 group-hover:bg-[#B8E34B]"
                      style={{
                        height: `${Math.max(12, (s.value / maxMonthly) * 100)}%`,
                      }}
                      role="img"
                      aria-label={`${s.label}: ${s.value} laporan`}
                    />
                  </div>
                  <span className="text-[11px] font-semibold text-slate-500 dark:text-slate-400 text-center leading-tight truncate w-full">
                    {s.label.replace(" 2026", "")}
                  </span>
                </div>
              ))}
            </div>

            <div className="mt-4 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
              <span>Rata-rata 4.2 kasus per bulan</span>
              <span className="font-semibold text-primary-600 dark:text-[#5AE39D]">
                Data diperbarui otomatis
              </span>
            </div>
          </section>

          {/* Distribusi Kategori (1/3) */}
          <section
            aria-labelledby="cat-heading"
            className="lg:col-span-1 bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs flex flex-col justify-between"
          >
            <div className="flex items-center justify-between mb-4">
              <div>
                <h2
                  id="cat-heading"
                  className="text-base font-bold text-slate-900 dark:text-slate-100"
                >
                  Kategori Terbanyak
                </h2>
                <p className="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                  Jenis aduan dominan
                </p>
              </div>
              <span className="text-xs font-bold px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                Top 5
              </span>
            </div>

            <div className="flex flex-col gap-4">
              {catStats.map(({ label, value }) => (
                <div key={label} className="flex flex-col gap-1.5">
                  <div className="flex items-center justify-between text-xs">
                    <span className="font-bold text-slate-700 dark:text-slate-200 truncate">
                      {label}
                    </span>
                    <span className="font-extrabold tabular-nums text-slate-900 dark:text-slate-100">
                      {value}
                    </span>
                  </div>
                  <div className="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2.5 overflow-hidden">
                    <div
                      className="h-2.5 rounded-full bg-primary-600 dark:bg-[#5AE39D] transition-all duration-700"
                      style={{ width: `${(value / maxCat) * 100}%` }}
                    />
                  </div>
                </div>
              ))}
            </div>

            <div className="mt-5 pt-3 border-t border-slate-100 dark:border-slate-800 text-center">
              <button
                onClick={() => router.push("/admin/statistik")}
                className="text-xs text-primary-600 dark:text-[#5AE39D] font-bold hover:underline cursor-pointer"
              >
                Lihat Analisis Statistik Lengkap →
              </button>
            </div>
          </section>
        </div>

        {/* ── Rows 3 & 4 — Recent Reports & System Audit ─── */}
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-slide-up stagger-3">
          {/* ── Left Column: Laporan Terbaru (2/3) ──────── */}
          <div className="lg:col-span-2 flex flex-col gap-6">
            <section aria-labelledby="reports-heading">
              <div className="flex items-center justify-between mb-3.5">
                <div>
                  <h2
                    id="reports-heading"
                    className="text-sm font-bold text-slate-900 dark:text-slate-100"
                  >
                    Seluruh Laporan Masuk Terkini
                  </h2>
                  <p className="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                    Log pengaduan dari seluruh siswa sekolah
                  </p>
                </div>
                <button
                  onClick={() => router.push("/admin/laporan")}
                  className="text-xs text-primary-600 dark:text-[#5AE39D] font-bold hover:underline flex items-center gap-1 cursor-pointer"
                >
                  <span>Buka Semua Laporan</span>
                  <ChevronRight className="w-3.5 h-3.5" />
                </button>
              </div>

              {/* Desktop table */}
              <div className="hidden md:block bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-xs">
                <table className="w-full text-sm">
                  <thead className="border-b border-slate-200 dark:border-slate-800 bg-slate-50/80 dark:bg-slate-800/60">
                    <tr>
                      <th className="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        No Tiket
                      </th>
                      <th className="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        Kategori
                      </th>
                      <th className="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 hidden sm:table-cell">
                        Tanggal
                      </th>
                      <th className="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        Status
                      </th>
                      <th className="px-4 py-3 text-right" />
                    </tr>
                  </thead>
                  <tbody className="divide-y divide-slate-100 dark:divide-slate-800">
                    {recentReports.map((r, i) => (
                      <tr
                        key={r.id}
                        className="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors cursor-pointer group"
                        onClick={() => router.push("/admin/laporan")}
                        style={{ animationDelay: `${i * 30}ms` }}
                      >
                        <td className="px-4 py-3.5 font-mono text-xs font-bold text-slate-700 dark:text-slate-300">
                          {r.id.replace("ELP-2026-", "#")}
                        </td>
                        <td className="px-4 py-3.5 text-xs font-bold text-slate-900 dark:text-slate-100">
                          {r.category}
                        </td>
                        <td className="px-4 py-3.5 text-xs text-slate-500 dark:text-slate-400 hidden sm:table-cell">
                          {r.date}
                        </td>
                        <td className="px-4 py-3.5">
                          <StatusBadge status={r.status} size="sm" />
                        </td>
                        <td className="px-4 py-3.5 text-right">
                          <span className="text-xs text-primary-600 dark:text-[#5AE39D] font-bold opacity-0 group-hover:opacity-100 transition-opacity">
                            Audit →
                          </span>
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>

              {/* Mobile list */}
              <div className="flex flex-col divide-y divide-slate-100 dark:divide-slate-800 md:hidden bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-xs">
                {recentReports.map((r) => (
                  <div
                    key={r.id}
                    className="flex items-center justify-between gap-3 px-4 py-4 hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors cursor-pointer"
                    onClick={() => router.push("/admin/laporan")}
                  >
                    <div className="flex-1 min-w-0">
                      <p className="text-[11px] font-mono font-bold text-slate-500 dark:text-slate-400">
                        {r.id}
                      </p>
                      <p className="text-xs font-bold text-slate-900 dark:text-slate-100 truncate mt-0.5">
                        {r.category}
                      </p>
                      <p className="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">
                        {r.date}
                      </p>
                    </div>
                    <StatusBadge status={r.status} size="sm" />
                  </div>
                ))}
              </div>
            </section>

            {/* Distribusi Pengguna Cards */}
            <section
              aria-labelledby="users-heading"
              className="bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs"
            >
              <div className="flex items-center justify-between mb-4">
                <h2
                  id="users-heading"
                  className="text-sm font-bold text-slate-900 dark:text-slate-100"
                >
                  Distribusi Akun Pengguna Sekolah
                </h2>
                <button
                  onClick={() => router.push("/admin/pengguna")}
                  className="text-xs text-primary-600 dark:text-[#5AE39D] font-bold hover:underline flex items-center gap-1 cursor-pointer"
                >
                  <span>Kelola Akun</span>
                  <ChevronRight className="w-3 h-3" />
                </button>
              </div>

              <div className="grid grid-cols-3 gap-4">
                <div className="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/80 text-center">
                  <p className="text-2xl font-black text-slate-900 dark:text-slate-100 tabular-nums">
                    {stats.totalSiswa}
                  </p>
                  <p className="text-xs font-semibold text-slate-600 dark:text-slate-400 mt-1">
                    Siswa Aktif
                  </p>
                </div>
                <div className="p-4 rounded-xl bg-primary-50/70 dark:bg-primary-950/50 border border-primary-200/60 dark:border-primary-800 text-center">
                  <p className="text-2xl font-black text-primary-700 dark:text-[#5AE39D] tabular-nums">
                    {stats.totalGuruBK}
                  </p>
                  <p className="text-xs font-semibold text-primary-800 dark:text-primary-300 mt-1">
                    Guru BK
                  </p>
                </div>
                <div className="p-4 rounded-xl bg-amber-50/70 dark:bg-amber-950/50 border border-amber-200/60 dark:border-amber-800 text-center">
                  <p className="text-2xl font-black text-amber-800 dark:text-[#FAD46B] tabular-nums">
                    {stats.totalAdmin}
                  </p>
                  <p className="text-xs font-semibold text-amber-800 dark:text-amber-300 mt-1">
                    Administrator
                  </p>
                </div>
              </div>
            </section>
          </div>

          {/* ── Right Column: System Audit & Activity Log (1/3) ── */}
          <section
            aria-labelledby="audit-heading"
            className="lg:col-span-1 bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-xs flex flex-col justify-between"
          >
            <div>
              <div className="flex items-center justify-between mb-4 pb-3 border-b border-slate-200 dark:border-slate-800">
                <div className="flex items-center gap-2.5">
                  <div className="w-8 h-8 rounded-lg bg-primary-50 dark:bg-primary-950/60 text-primary-700 dark:text-[#5AE39D] flex items-center justify-center">
                    <Server className="w-4 h-4" />
                  </div>
                  <div>
                    <h2
                      id="audit-heading"
                      className="text-sm font-bold text-slate-900 dark:text-slate-100"
                    >
                      Audit Sistem & Log
                    </h2>
                    <p className="text-[11px] text-slate-500 dark:text-slate-400">
                      Riwayat aktivitas keamanan
                    </p>
                  </div>
                </div>
                <span className="w-2 h-2 rounded-full bg-[#176B4D] dark:bg-[#5AE39D] ring-2 ring-emerald-400/30" />
              </div>

              <div className="space-y-4">
                {systemActivity.map((act, idx) => (
                  <div key={idx} className="flex items-start gap-3">
                    <span className={`w-2.5 h-2.5 rounded-full ${act.dot} shrink-0 mt-1.5`} />
                    <div className="min-w-0 flex-1">
                      <div className="flex items-center justify-between gap-2">
                        <p className="text-xs font-bold text-slate-900 dark:text-slate-100 truncate">
                          {act.label}
                        </p>
                        <span className="text-[10px] font-mono text-slate-500 dark:text-slate-400 shrink-0">
                          {act.time}
                        </span>
                      </div>
                      <p className="text-[11px] text-slate-600 dark:text-slate-400 mt-0.5 truncate">
                        {act.sub}
                      </p>
                    </div>
                  </div>
                ))}
              </div>
            </div>

            <div className="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800 text-center">
              <span className="text-[11px] font-semibold text-slate-500 dark:text-slate-400 flex items-center justify-center gap-1">
                <Shield className="w-3.5 h-3.5 text-primary-600 dark:text-[#5AE39D]" />
                Enkripsi data & log terjaga aman
              </span>
            </div>
          </section>
        </div>
      </div>
    </AdminLayout>
  );
}
