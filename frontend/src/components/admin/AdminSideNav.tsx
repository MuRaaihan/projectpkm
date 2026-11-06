// ── AdminSideNav — Desktop Sidebar for Admin ──────────────────
"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import {
  LayoutDashboard,
  Users,
  FileText,
  BarChart2,
  Bell,
  User,
  ShieldCheck,
} from "lucide-react";
import { adminNotifications, adminReports } from "@/data/mockDataAdmin";
import { adminCurrentUser } from "@/data/mockDataAdmin";
import { SchoolLogo, ThemeToggle } from "@/components/ui";

const navItems = [
  {
    href: "/admin/dashboard",
    label: "Dashboard",
    icon: LayoutDashboard,
    section: "dashboard",
  },
  {
    href: "/admin/pengguna",
    label: "Pengguna",
    icon: Users,
    section: "pengguna",
  },
  {
    href: "/admin/laporan",
    label: "Laporan",
    icon: FileText,
    section: "laporan",
  },
  {
    href: "/admin/statistik",
    label: "Statistik",
    icon: BarChart2,
    section: "statistik",
  },
  {
    href: "/admin/notifikasi",
    label: "Notifikasi",
    icon: Bell,
    section: "notifikasi",
  },
  { href: "/admin/profil", label: "Profil", icon: User, section: "profil" },
];

const unreadCount = adminNotifications.filter((n) => !n.isRead).length;
const newReports = adminReports.filter((r) => r.status === "Diterima").length;

export function AdminSideNav() {
  const pathname = usePathname();

  return (
    <aside
      className="hidden lg:flex flex-col w-64 min-h-screen border-r fixed top-0 left-0 z-40 transition-theme"
      style={{
        backgroundColor: "var(--sidebar-bg)",
        borderColor: "var(--sidebar-border)",
      }}
      aria-label="Navigasi Admin"
    >
      {/* ── Logo ─────────────────────────────────── */}
      <div
        className="h-16 flex items-center px-5 border-b shrink-0"
        style={{ borderColor: "var(--sidebar-border)" }}
      >
        <Link
          href="/admin/dashboard"
          className="flex items-center gap-3 min-w-0 group"
        >
          <SchoolLogo size="sm" />
          <div className="min-w-0">
            <p className="text-sm font-bold text-slate-900 dark:text-slate-100 leading-tight truncate">
              SIPERKA
            </p>
            <p className="text-[10px] text-slate-500 dark:text-slate-400 leading-tight truncate">
              Panel Admin
            </p>
          </div>
        </Link>
      </div>

      {/* ── Nav ──────────────────────────────────── */}
      <nav
        className="flex-1 py-4 px-3 flex flex-col gap-0.5 overflow-y-auto"
        aria-label="Menu Admin"
      >
        <p className="px-2.5 mb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
          Navigasi
        </p>
        {navItems.map(({ href, label, icon: Icon, section }) => {
          const isActive =
            pathname === href ||
            (section === "pengguna" &&
              pathname.startsWith("/admin/pengguna")) ||
            (section === "laporan" && pathname === "/admin/laporan");

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
                <span className="min-w-[18px] h-4.5 px-1.5 bg-primary-600 text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                  {badge}
                </span>
              )}
            </Link>
          );
        })}
      </nav>

      {/* ── User area ────────────────────────────── */}
      <div
        className="px-3 py-4 border-t"
        style={{ borderColor: "var(--sidebar-border)" }}
      >
        <div className="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100/60 dark:hover:bg-slate-800/60 transition-colors">
          <div className="w-8 h-8 rounded-full bg-slate-800 dark:bg-slate-700 flex items-center justify-center shrink-0">
            <span className="text-xs font-bold text-white">
              {adminCurrentUser.avatarInitials}
            </span>
          </div>
          <div className="flex-1 min-w-0">
            <p className="text-xs font-semibold text-slate-900 dark:text-slate-100 truncate">
              {adminCurrentUser.name.split(",")[0]}
            </p>
            <p className="text-[10px] text-slate-500 dark:text-slate-400 flex items-center gap-1 truncate">
              <ShieldCheck className="w-3 h-3 text-slate-600 dark:text-slate-400 shrink-0" aria-hidden="true" /> Administrator
            </p>
          </div>
          <ThemeToggle />
        </div>
      </div>
    </aside>
  );
}
