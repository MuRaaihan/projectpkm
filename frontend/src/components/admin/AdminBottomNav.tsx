// ── AdminBottomNav — Mobile Bottom Navigation for Admin ───────
"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { LayoutDashboard, Users, FileText, Bell, User } from "lucide-react";
import { adminNotifications, adminReports } from "@/data/mockDataAdmin";

const navItems = [
 { href: "/admin/dashboard", label: "Dashboard", icon: LayoutDashboard },
 { href: "/admin/pengguna", label: "Pengguna", icon: Users },
 { href: "/admin/laporan", label: "Laporan", icon: FileText },
 { href: "/admin/notifikasi", label: "Notifikasi", icon: Bell },
 { href: "/admin/profil", label: "Profil", icon: User },
];

const unreadCount = adminNotifications.filter((n) => !n.isRead).length;
const newReports = adminReports.filter((r) => r.status === "Diterima").length;

export function AdminBottomNav() {
 const pathname = usePathname();

 return (
 <nav
 className="lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-surface-card border-t border-slate-200"
 aria-label="Navigasi utama"
 >
 <div className="flex items-center justify-around px-1">
 {navItems.map(({ href, label, icon: Icon }) => {
 const isActive =
 pathname === href ||
 (href === "/admin/pengguna" &&
 pathname.startsWith("/admin/pengguna"));

 const badge =
 href === "/admin/notifikasi"
 ? unreadCount
 : href === "/admin/laporan"
 ? newReports
 : 0;

 return (
 <Link
 key={href}
 href={href}
 aria-current={isActive ? "page" : undefined}
 className={[
 "flex flex-col items-center gap-1 py-3 px-3 rounded-2xl transition-colors duration-150 relative",
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
 <span className="absolute -top-1 -right-1.5 min-w-[15px] h-4 px-1 bg-primary-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center">
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

