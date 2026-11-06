// ── AdminLayout — Master layout shell for Admin pages ─────────
"use client";

import { useRouter } from "next/navigation";
import { ArrowLeft, Bell } from "lucide-react";
import Link from "next/link";
import { AdminSideNav } from "./AdminSideNav";
import { AdminBottomNav } from "./AdminBottomNav";
import { AdminTopBar } from "./AdminTopBar";
import { adminNotifications } from "@/data/mockDataAdmin";
import { SchoolLogo, ThemeToggle } from "@/components/ui";

const unreadCount = adminNotifications.filter((n) => !n.isRead).length;

interface AdminLayoutProps {
  children: React.ReactNode;
  pageTitle?: string;
  pageSubtitle?: string;
  showBackButton?: boolean;
  backHref?: string;
  withBottomNav?: boolean;
}

export function AdminLayout({
  children,
  pageTitle,
  pageSubtitle,
  showBackButton = false,
  backHref,
  withBottomNav = true,
}: AdminLayoutProps) {
  const router = useRouter();

  const handleBack = () => {
    if (backHref) router.push(backHref);
    else router.back();
  };

  return (
    <div className="min-h-screen bg-surface flex transition-theme">
      <AdminSideNav />

      <div
        className={[
          "flex-1 flex flex-col min-w-0 transition-theme",
          "lg:ml-64",
          withBottomNav ? "pb-16 lg:pb-0" : "",
        ]
          .filter(Boolean)
          .join(" ")}
        style={{ backgroundColor: "var(--background)" }}
      >
        {/* Desktop TopBar */}
        <AdminTopBar pageTitle={pageTitle} pageSubtitle={pageSubtitle} />

        {/* Mobile Header */}
        <header
          className="lg:hidden sticky top-0 z-30 border-b shrink-0 transition-theme"
          style={{
            backgroundColor: "var(--topbar-bg)",
            borderColor: "var(--topbar-border)",
          }}
        >
          <div className="h-14 px-4 flex items-center gap-3">
            {showBackButton ? (
              <>
                <button
                  onClick={handleBack}
                  className="w-8 h-8 flex items-center justify-center rounded-md text-slate-700 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                  aria-label="Kembali"
                >
                  <ArrowLeft className="w-4 h-4" aria-hidden="true" />
                </button>
                {pageTitle && (
                  <h1 className="flex-1 text-sm font-semibold text-slate-900 dark:text-slate-100 truncate">
                    {pageTitle}
                  </h1>
                )}
                <div className="w-8" aria-hidden="true" />
              </>
            ) : (
              <>
                <Link
                  href="/admin/dashboard"
                  className="flex items-center gap-2.5 group flex-1 min-w-0"
                >
                  <SchoolLogo size="sm" />
                  <div className="min-w-0">
                    <p className="text-sm font-bold text-slate-900 dark:text-slate-100 leading-tight truncate">
                      SIPERKA
                    </p>
                    <p className="text-[10px] text-slate-600 dark:text-slate-400 leading-tight hidden sm:block">
                      Admin
                    </p>
                  </div>
                </Link>

                <ThemeToggle />

                <Link
                  href="/admin/notifikasi"
                  className="relative w-8 h-8 flex items-center justify-center rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400 transition-colors"
                  aria-label={`Notifikasi${unreadCount > 0 ? `, ${unreadCount} belum dibaca` : ""}`}
                >
                  <Bell className="w-4 h-4" aria-hidden="true" />
                  {unreadCount > 0 && (
                    <span className="absolute top-1 right-1 w-2 h-2 bg-primary-500 rounded-full" />
                  )}
                </Link>
              </>
            )}
          </div>
        </header>

        {/* Page Content */}
        <div className="flex-1 min-h-0">{children}</div>
      </div>

      {withBottomNav && <AdminBottomNav />}
    </div>
  );
}
