// ── AppHeader Component (Student Mobile/Tablet) ────────────────
"use client";

import Link from "next/link";
import { useRouter } from "next/navigation";
import { ArrowLeft, Bell, MoreVertical } from "lucide-react";
import { SchoolLogo } from "./SchoolLogo";
import { ThemeToggle } from "./ThemeToggle";

interface AppHeaderProps {
 variant?: "logo" | "back";
 title?: string;
 backHref?: string;
 showNotification?: boolean;
 showAvatar?: boolean;
 avatarInitials?: string;
 showMore?: boolean;
 onMoreClick?: () => void;
}

export function AppHeader({
 variant = "logo",
 title,
 backHref,
 showNotification = false,
 showAvatar = false,
 avatarInitials = "AF",
 showMore = false,
 onMoreClick,
}: AppHeaderProps) {
 const router = useRouter();

 const handleBack = () => {
 if (backHref) router.push(backHref);
 else router.back();
 };

 if (variant === "logo") {
 return (
 <header
 className="lg:hidden sticky top-0 z-30 border-b transition-theme"
 style={{
 backgroundColor: "var(--topbar-bg)",
 borderColor: "var(--topbar-border)",
 }}
 >
 <div className="px-4 h-14 flex items-center justify-between gap-3">
 <Link href="/dashboard" className="flex items-center gap-2.5 group">
 <SchoolLogo size="sm" />
 <span className="font-bold text-sm text-slate-900 dark:text-slate-100 leading-tight">
 SIPERKA
 </span>
 </Link>

 <div className="flex items-center gap-0.5">
 <ThemeToggle />
 {showNotification && (
 <Link
 href="/laporan"
 className="relative w-8 h-8 flex items-center justify-center rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400 transition-colors"
 aria-label="Notifikasi"
 >
 <Bell className="w-4 h-4" aria-hidden="true" />
 <span className="absolute top-1.5 right-1.5 w-1.5 h-1.5 bg-primary-500 rounded-full" />
 </Link>
 )}
 {showAvatar && (
 <Link
 href="/profil"
 className="w-7 h-7 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center ml-1"
 aria-label="Profil saya"
 >
 <span className="text-xs font-bold text-primary-700 dark:text-primary-400">
 {avatarInitials}
 </span>
 </Link>
 )}
 </div>
 </div>
 </header>
 );
 }

 return (
 <header
 className="sticky top-0 z-30 border-b transition-theme"
 style={{
 backgroundColor: "var(--topbar-bg)",
 borderColor: "var(--topbar-border)",
 }}
 >
 <div className="px-4 h-14 flex items-center gap-3">
 <button
 onClick={handleBack}
 className="flex items-center justify-center w-8 h-8 rounded-md text-slate-700 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
 aria-label="Kembali"
 >
 <ArrowLeft className="w-4 h-4" aria-hidden="true" />
 </button>

 {title && (
 <h1 className="flex-1 text-sm font-semibold text-slate-900 dark:text-slate-100 truncate">
 {title}
 </h1>
 )}

 {showMore ? (
 <button
 onClick={onMoreClick}
 className="w-8 h-8 flex items-center justify-center rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 transition-colors"
 aria-label="Opsi lainnya"
 >
 <MoreVertical className="w-4 h-4" aria-hidden="true" />
 </button>
 ) : (
 <div className="w-8" aria-hidden="true" />
 )}
 </div>
 </header>
 );
}
