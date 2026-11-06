// ── GBKBottomNav — Mobile Bottom Navigation for Guru BK ──────
"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { LayoutDashboard, Inbox, Bell, User } from "lucide-react";
import { gbkNotifications, gbkReports } from "@/data/mockDataGBK";

const navItems = [
 { href: "/guru-bk/dashboard", label: "Dashboard", icon: LayoutDashboard },
 { href: "/guru-bk/laporan", label: "Laporan", icon: Inbox },
 { href: "/guru-bk/notifikasi", label: "Notifikasi", icon: Bell },
 { href: "/guru-bk/profil", label: "Profil", icon: User },
];

const unreadCount = gbkNotifications.filter((n) => !n.isRead).length;
const newReports = gbkReports.filter((r) => r.status === "Diterima").length;

export function GBKBottomNav() {
 const pathname = usePathname();

 return (
 <nav
 className="lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-surface-card border-t border-slate-200"
 aria-label="Navigasi utama"
 >
 <div className="flex items-center justify-around px-2">
 {navItems.map(({ href, label, icon: Icon }) => {
 const isActive =
 pathname === href ||
 (href === "/guru-bk/laporan" &&
 pathname.startsWith("/guru-bk/laporan"));

 const badge =
 href === "/guru-bk/laporan"
 ? newReports
 : href === "/guru-bk/notifikasi"
 ? unreadCount
 : 0;

 return (
 <Link
 key={href}
 href={href}
 aria-current={isActive ? "page" : undefined}
 className={[
 "flex flex-col items-center gap-1 py-3 px-4 rounded-2xl transition-colors duration-150 relative",
 isActive
 ? "text-primary-600"
 : "text-slate-600 hover:text-slate-700",
 ].join(" ")}
 >
 <div className="relative">
 <Icon
 className={`w-5 h-5 ${isActive ? "scale-110" : ""} transition-transform duration-150`}
 aria-hidden="true"
 />
 {badge > 0 && (
 <span className="absolute -top-1 -right-1.5 min-w-[16px] h-4 px-1 bg-primary-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center">
 {badge}
 </span>
 )}
 </div>
 <span className="text-[10px] font-semibold">{label}</span>
 </Link>
 );
 })}
 </div>
 </nav>
 );
}

