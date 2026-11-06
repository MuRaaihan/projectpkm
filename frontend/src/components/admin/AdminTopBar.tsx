// ── AdminTopBar — Desktop Top Bar for Admin ───────────────────
"use client";

import Link from "next/link";
import { Bell } from "lucide-react";
import { adminCurrentUser, adminNotifications } from "@/data/mockDataAdmin";
import { ThemeToggle } from "@/components/ui";

interface AdminTopBarProps {
  pageTitle?: string;
  pageSubtitle?: string;
}

const unreadCount = adminNotifications.filter((n) => !n.isRead).length;

export function AdminTopBar({ pageTitle, pageSubtitle }: AdminTopBarProps) {
  return (
    <header
      className="hidden lg:flex items-center justify-between h-16 px-8 border-b sticky top-0 z-30 shrink-0 transition-theme"
      style={{
        backgroundColor: "var(--topbar-bg)",
        borderColor: "var(--topbar-border)",
      }}
    >
      {/* Page title */}
      <div>
        {pageTitle && (
          <h1 className="font-bold text-slate-900 dark:text-slate-100 text-base leading-tight">
            {pageTitle}
          </h1>
        )}
        {pageSubtitle && (
          <p className="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
            {pageSubtitle}
          </p>
        )}
      </div>

      {/* Right — Toggle + Notification + Avatar */}
      <div className="flex items-center gap-2">
        <ThemeToggle />

        <Link
          href="/admin/notifikasi"
          className="relative w-9 h-9 flex items-center justify-center rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-300 transition-colors"
          aria-label={`Notifikasi${unreadCount > 0 ? `, ${unreadCount} belum dibaca` : ""}`}
        >
          <Bell className="w-4 h-4" aria-hidden="true" />
          {unreadCount > 0 && (
            <span className="absolute top-1.5 right-1.5 w-2 h-2 bg-primary-600 rounded-full" />
          )}
        </Link>

        <Link
          href="/admin/profil"
          className="flex items-center gap-2.5 ml-1 px-2.5 py-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
          aria-label="Profil saya"
        >
          <div className="w-7 h-7 bg-slate-800 dark:bg-slate-700 rounded-full flex items-center justify-center">
            <span className="text-xs font-bold text-white">
              {adminCurrentUser.avatarInitials}
            </span>
          </div>
          <div className="hidden xl:block">
            <p className="text-xs font-semibold text-slate-900 dark:text-slate-100">
              {adminCurrentUser.name.split(",")[0]}
            </p>
          </div>
        </Link>
      </div>
    </header>
  );
}
