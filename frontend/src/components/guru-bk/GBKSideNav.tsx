// ── GBKSideNav — Desktop Sidebar for Guru BK ─────────────────
"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import {
  LayoutDashboard,
  Inbox,
  Clock,
  CheckCircle2,
  BarChart2,
  Bell,
  User,
  ShieldCheck,
} from "lucide-react";
import { gbkNotifications, gbkReports } from "@/data/mockDataGBK";
import { counselorUser } from "@/data/mockDataGBK";
import { SchoolLogo, ThemeToggle } from "@/components/ui";

const navItems = [
  {
    href: "/guru-bk/dashboard",
    label: "Dashboard",
    icon: LayoutDashboard,
    section: "dashboard",
  },
  {
    href: "/guru-bk/laporan",
    label: "Laporan Masuk",
    icon: Inbox,
    section: "laporan",
  },
  {
    href: "/guru-bk/statistik",
    label: "Statistik",
    icon: BarChart2,
    section: "statistik",
  },
  {
    href: "/guru-bk/notifikasi",
    label: "Notifikasi",
    icon: Bell,
    section: "notifikasi",
  },
  { href: "/guru-bk/profil", label: "Profil", icon: User, section: "profil" },
];

const statItems = [
  {
    label: "Perlu Tindakan",
    icon: Clock,
    count: gbkReports.filter(
      (r) => r.status === "Diterima" || r.status === "Diverifikasi",
    ).length,
    accent: "text-amber-600 dark:text-amber-400",
    bg: "bg-amber-50 dark:bg-amber-900/20",
  },
  {
    label: "Selesai",
    icon: CheckCircle2,
    count: gbkReports.filter((r) => r.status === "Selesai").length,
    accent: "text-primary-600 dark:text-primary-400",
    bg: "bg-primary-50 dark:bg-primary-900/20",
  },
];

const unreadCount = gbkNotifications.filter((n) => !n.isRead).length;
const newReports = gbkReports.filter((r) => r.status === "Diterima").length;

export function GBKSideNav() {
  const pathname = usePathname();

  return (
    <aside
      className="hidden lg:flex flex-col w-64 min-h-screen border-r fixed top-0 left-0 z-40 transition-theme"
      style={{
        backgroundColor: "var(--sidebar-bg)",
        borderColor: "var(--sidebar-border)",
      }}
      aria-label="Navigasi Guru BK"
    >
      {/* ── Logo ─────────────────────────────────── */}
      <div
        className="h-16 flex items-center px-5 border-b shrink-0"
        style={{ borderColor: "var(--sidebar-border)" }}
      >
        <Link
          href="/guru-bk/dashboard"
          className="flex items-center gap-3 min-w-0 group"
        >
          <SchoolLogo size="sm" />
          <div className="min-w-0">
            <p className="text-sm font-bold text-slate-900 dark:text-slate-100 leading-tight truncate">
              SIPERKA
            </p>
            <p className="text-[10px] text-slate-500 dark:text-slate-400 leading-tight truncate">
              Portal Guru BK
            </p>
          </div>
        </Link>
      </div>

      {/* ── Nav ──────────────────────────────────── */}
      <nav
        className="flex-1 py-4 px-3 flex flex-col gap-0.5 overflow-y-auto"
        aria-label="Menu Guru BK"
      >
        <p className="px-2.5 mb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
          Navigasi
        </p>
        {navItems.map(({ href, label, icon: Icon, section }) => {
          const isActive =
            pathname === href ||
            (section === "laporan" && pathname.startsWith("/guru-bk/laporan"));

          const badge =
            section === "notifikasi"
              ? unreadCount
              : section === "laporan"
              ? newReports
              : 0;

          return (
            <Link
              key={section}
              href={href}
              aria-current={isActive ? "page" : undefined}
              className={[
                "relative flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 group",
                isActive
                  ? "text-primary-700 dark:text-primary-300"
                  : "text-slate-600 dark:text-slate-400 hover:bg-slate-100/60 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-slate-200",
              ].join(" ")}
              style={
                isActive
                  ? { backgroundColor: "var(--sidebar-active-bg)" }
                  : {}
              }
            >
              {isActive && (
                <span className="absolute left-0 top-1/2 -translate-y-1/2 w-0.5 h-5 bg-primary-600 dark:bg-primary-400 rounded-full" />
              )}
              <Icon
                className={`w-4 h-4 shrink-0 transition-colors ${
                  isActive
                    ? "text-primary-600 dark:text-primary-400"
                    : "text-slate-500 dark:text-slate-500 group-hover:text-slate-700 dark:group-hover:text-slate-300"
                }`}
                aria-hidden="true"
              />
              <span className="flex-1">{label}</span>
              {badge > 0 && (
                <span className="min-w-[18px] h-[18px] px-1.5 bg-primary-600 text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                  {badge}
                </span>
              )}
            </Link>
          );
        })}

        {/* Quick stat block */}
        <div className="mt-4 px-2.5">
          <p className="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-2">
            Ringkasan Kasus
          </p>
          <div className="flex flex-col gap-1.5">
            {statItems.map(({ label, icon: Icon, count, accent, bg }) => (
              <div
                key={label}
                className={`flex items-center gap-2.5 px-3 py-2 rounded-lg border border-slate-200/50 dark:border-slate-800 ${bg}`}
              >
                <Icon
                  className={`w-3.5 h-3.5 shrink-0 ${accent}`}
                  aria-hidden="true"
                />
                <span className={`text-xs font-medium flex-1 ${accent}`}>{label}</span>
                <span className={`text-xs font-bold tabular-nums ${accent}`}>
                  {count}
                </span>
              </div>
            ))}
          </div>
        </div>
      </nav>

      {/* ── User area ────────────────────────────── */}
      <div
        className="px-3 py-4 border-t"
        style={{ borderColor: "var(--sidebar-border)" }}
      >
        <div className="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100/60 dark:hover:bg-slate-800/60 transition-colors">
          <div className="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center shrink-0">
            <span className="text-xs font-bold text-white">
              {counselorUser.avatarInitials}
            </span>
          </div>
          <div className="flex-1 min-w-0">
            <p className="text-xs font-semibold text-slate-900 dark:text-slate-100 truncate">
              {counselorUser.name}
            </p>
            <p className="text-[10px] text-slate-500 dark:text-slate-400 flex items-center gap-1 truncate">
              <ShieldCheck className="w-3 h-3 text-primary-600 shrink-0" aria-hidden="true" /> Guru BK / Konselor
            </p>
          </div>
          <ThemeToggle />
        </div>
      </div>
    </aside>
  );
}
