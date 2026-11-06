// ── Admin — Notifikasi ────────────────────────────────────────
"use client";

import { useState } from "react";
import { Bell, UserPlus, FileText, Settings, AlertCircle } from "lucide-react";
import { AdminLayout } from "@/components/admin/AdminLayout";
import { adminNotifications as initialNotifications } from "@/data/mockDataAdmin";
import type { AdminNotification } from "@/types";

const typeConfig: Record<
 AdminNotification["type"],
 {
 icon: React.ElementType;
 iconBg: string;
 iconColor: string;
 }
> = {
 new_user: {
 icon: UserPlus,
 iconBg: "bg-sky-50 dark:bg-sky-900/20",
 iconColor: "text-sky-600 dark:text-sky-400",
 },
 new_report: {
 icon: FileText,
 iconBg: "bg-amber-50 dark:bg-amber-900/20",
 iconColor: "text-amber-600 dark:text-amber-400",
 },
 status_update: {
 icon: AlertCircle,
 iconBg: "bg-primary-50 dark:bg-primary-900/20",
 iconColor: "text-primary-600 dark:text-primary-400",
 },
 system: {
 icon: Settings,
 iconBg: "bg-slate-100 dark:bg-slate-700",
 iconColor: "text-slate-600 dark:text-slate-400",
 },
};

// Group notifications by "today" / "yesterday" / "earlier"
function groupNotifications(notifs: AdminNotification[]) {
 const today = notifs.filter(
 (n) => n.time.includes("jam") || n.time.includes("menit"),
 );
 const yesterday = notifs.filter((n) => n.time === "1 hari lalu");
 const earlier = notifs.filter(
 (n) => !today.includes(n) && !yesterday.includes(n),
 );
 return { today, yesterday, earlier };
}

export default function AdminNotifikasiPage() {
 const [notifications, setNotifications] =
 useState<AdminNotification[]>(initialNotifications);
 const unreadCount = notifications.filter((n) => !n.isRead).length;

 const markAllRead = () =>
 setNotifications((prev) => prev.map((n) => ({ ...n, isRead: true })));
 const markRead = (id: string) =>
 setNotifications((prev) =>
 prev.map((n) => (n.id === id ? { ...n, isRead: true } : n)),
 );

 const groups = groupNotifications(notifications);

 const NotifList = ({
 items,
 label,
 }: {
 items: AdminNotification[];
 label: string;
 }) => {
 if (items.length === 0) return null;
 return (
 <div>
 <p className="text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-2 px-1">
 {label}
 </p>
 <div className="bg-surface-card border border-slate-200 dark:border-slate-700 rounded-lg overflow-hidden divide-y divide-slate-50 dark:divide-slate-700/30">
 {items.map((notif) => {
 const { icon: Icon, iconBg, iconColor } = typeConfig[notif.type];
 return (
 <button
 key={notif.id}
 onClick={() => markRead(notif.id)}
 className={[
 "w-full text-left px-4 py-3.5 flex items-start gap-3 transition-colors duration-150",
 notif.isRead
 ? "hover:bg-slate-50 dark:hover:bg-slate-700/20"
 : "bg-primary-50/50 dark:bg-primary-900/10 hover:bg-primary-50 dark:hover:bg-primary-900/20",
 ].join(" ")}
 >
 <div
 className={`w-8 h-8 ${iconBg} rounded-lg flex items-center justify-center shrink-0 mt-0.5`}
 >
 <Icon className={`w-4 h-4 ${iconColor}`} aria-hidden="true" />
 </div>
 <div className="flex-1 min-w-0">
 <div className="flex items-start gap-2 justify-between">
 <p
 className={`text-sm font-semibold ${notif.isRead ? "text-slate-800 dark:text-slate-200" : "text-slate-900 dark:text-slate-100"}`}
 >
 {notif.title}
 {!notif.isRead && (
 <span className="inline-block w-1.5 h-1.5 bg-primary-500 rounded-full ml-1.5 align-middle" />
 )}
 </p>
 <span className="text-[10px] text-slate-600 dark:text-slate-400 shrink-0">
 {notif.time}
 </span>
 </div>
 <p className="text-xs text-slate-600 dark:text-slate-400 mt-1 leading-relaxed">
 {notif.message}
 </p>
 </div>
 </button>
 );
 })}
 </div>
 </div>
 );
 };

 return (
 <AdminLayout
 pageTitle="Notifikasi"
 pageSubtitle={
 unreadCount > 0 ? `${unreadCount} belum dibaca` : "Semua sudah dibaca"
 }
 withBottomNav
 >
 <div className="px-6 py-5 max-w-2xl w-full flex flex-col gap-5 animate-fade-in">
 {/* ── Header ────────────────────────────── */}
 <div className="flex items-center justify-between lg:hidden">
 <div>
 <h1 className="text-lg font-bold text-slate-900 dark:text-slate-100">
 Notifikasi
 </h1>
 {unreadCount > 0 && (
 <p className="text-sm text-slate-600 dark:text-slate-400 mt-0.5">
 {unreadCount} belum dibaca
 </p>
 )}
 </div>
 {unreadCount > 0 && (
 <button
 onClick={markAllRead}
 className="text-xs text-primary-600 dark:text-primary-400 font-medium hover:underline"
 >
 Tandai semua dibaca
 </button>
 )}
 </div>

 {unreadCount > 0 && (
 <div className="hidden lg:flex justify-end">
 <button
 onClick={markAllRead}
 className="text-xs text-primary-600 dark:text-primary-400 font-medium hover:underline"
 >
 Tandai semua dibaca
 </button>
 </div>
 )}

 {notifications.length === 0 ? (
 <div className="flex flex-col items-center gap-3 py-20 text-center">
 <div className="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-lg flex items-center justify-center">
 <Bell className="w-5 h-5 text-slate-600" aria-hidden="true" />
 </div>
 <p className="text-sm font-medium text-slate-800 dark:text-slate-200">
 Tidak ada notifikasi
 </p>
 </div>
 ) : (
 <>
 <NotifList items={groups.today} label="Hari Ini" />
 <NotifList items={groups.yesterday} label="Kemarin" />
 <NotifList items={groups.earlier} label="Sebelumnya" />
 </>
 )}

 <p className="text-xs text-slate-600 dark:text-slate-400 text-center mt-2">
 Notifikasi muncul otomatis saat ada aktivitas baru di sistem
 </p>
 </div>
 </AdminLayout>
 );
}
