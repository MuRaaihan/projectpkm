// ── Admin — Manajemen Pengguna ────────────────────────────────
"use client";

import { useState } from "react";
import { useRouter } from "next/navigation";
import { Search, ChevronLeft, ChevronRight, Users, Plus, X, CheckCircle2 } from "lucide-react";
import { AdminLayout } from "@/components/admin/AdminLayout";
import { mockUsers } from "@/data/mockDataAdmin";
import type { UserRole, UserStatus, AdminUser } from "@/types";
import { Button } from "@/components/ui/Button";
import { Input } from "@/components/ui/Input";
import { Card } from "@/components/ui/Card";

type FilterRole = "Semua" | UserRole;
type FilterStatus = "Semua" | UserStatus;

const PAGE_SIZE = 10;

const roleBadge: Record<UserRole, string> = {
  Siswa: "bg-sky-50 text-sky-700 dark:bg-sky-900/20 dark:text-sky-400",
  "Guru BK":
    "bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400",
  Admin:
    "bg-purple-50 text-purple-700 dark:bg-purple-900/20 dark:text-purple-400",
};
const statusBadge: Record<UserStatus, string> = {
  Aktif: "bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400",
  Nonaktif: "bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400",
};

function applyFilters(
  users: AdminUser[],
  role: FilterRole,
  status: FilterStatus,
  q: string,
) {
  return users
    .filter((u) => role === "Semua" || u.role === role)
    .filter((u) => status === "Semua" || u.status === status)
    .filter(
      (u) =>
        !q ||
        u.name.toLowerCase().includes(q.toLowerCase()) ||
        u.email.toLowerCase().includes(q.toLowerCase()),
    );
}

export default function AdminPenggunaPage() {
  const router = useRouter();
  const [query, setQuery] = useState("");
  const [filterRole, setFilterRole] = useState<FilterRole>("Semua");
  const [filterStatus, setFilterStatus] = useState<FilterStatus>("Semua");
  const [page, setPage] = useState(1);
  const [isAddingGBK, setIsAddingGBK] = useState(false);
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [successMessage, setSuccessMessage] = useState("");

  const filtered = applyFilters(mockUsers, filterRole, filterStatus, query);
  const totalPages = Math.ceil(filtered.length / PAGE_SIZE);
  const paginated = filtered.slice((page - 1) * PAGE_SIZE, page * PAGE_SIZE);

  const handleFilter = (role: FilterRole, status: FilterStatus, q: string) => {
    setPage(1);
    setFilterRole(role);
    setFilterStatus(status);
    setQuery(q);
  };

  const tabRoles: FilterRole[] = ["Semua", "Siswa", "Guru BK", "Admin"];

  return (
    <AdminLayout
      pageTitle="Manajemen Pengguna"
      pageSubtitle={`${mockUsers.length} pengguna terdaftar di sistem`}
      withBottomNav
    >
      <div className="px-4 sm:px-6 lg:px-8 py-6 flex flex-col gap-5 max-w-6xl w-full mx-auto animate-fade-in">
        {/* ── Page header & Actions ────────────────── */}
        <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
          <div className="lg:hidden">
            <h1 className="text-xl font-bold text-slate-900 dark:text-slate-100">
              Pengguna
            </h1>
            <p className="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
              {mockUsers.length} akun terdaftar
            </p>
          </div>
          <div className="hidden lg:block" />
          <Button onClick={() => setIsAddingGBK(true)} className="w-full sm:w-auto shrink-0">
            <Plus className="w-4 h-4 mr-2" />
            Tambah Guru BK
          </Button>
        </div>

        {/* ── Success banner if recently added ──────── */}
        {successMessage && (
          <div className="flex items-center gap-2.5 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs font-semibold animate-slide-up">
            <CheckCircle2 className="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" />
            <span>{successMessage}</span>
          </div>
        )}

        {/* ── Toolbar ───────────────────────────── */}
        <div className="flex flex-col sm:flex-row gap-3">
          {/* Search */}
          <div className="relative flex-1">
            <Search
              className="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
              aria-hidden="true"
            />
            <input
              type="search"
              value={query}
              onChange={(e) =>
                handleFilter(filterRole, filterStatus, e.target.value)
              }
              placeholder="Cari nama atau email pengguna..."
              className="w-full h-10 pl-10 pr-4 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-surface-card dark:bg-slate-800 text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
            />
          </div>

          {/* Status filter */}
          <select
            value={filterStatus}
            onChange={(e) =>
              handleFilter(filterRole, e.target.value as FilterStatus, query)
            }
            className="h-10 px-3.5 text-xs sm:text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-surface-card dark:bg-slate-800 text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500 sm:w-40"
          >
            <option value="Semua">Semua Status</option>
            <option value="Aktif">Aktif</option>
            <option value="Nonaktif">Nonaktif</option>
          </select>
        </div>

        {/* ── Role filter tabs ──────────────────── */}
        <div className="flex gap-2 overflow-x-auto pb-1 scrollbar-hide">
          {tabRoles.map((r) => {
            const isActive = filterRole === r;
            const count = r === "Semua" ? mockUsers.length : mockUsers.filter((u) => u.role === r).length;
            return (
              <button
                key={r}
                onClick={() => handleFilter(r, filterStatus, query)}
                className={`flex items-center gap-2 px-3.5 py-2 text-xs font-semibold rounded-lg transition-all duration-150 whitespace-nowrap shrink-0 ${
                  isActive
                    ? "bg-primary-600 text-white shadow-xs"
                    : "bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200/80 dark:hover:bg-slate-700"
                }`}
              >
                {isActive && (
                  <span className="w-1.5 h-1.5 rounded-full bg-[#B8E34B]" />
                )}
                <span>{r}</span>
                <span
                  className={`px-1.5 py-0.2 rounded-full text-[10px] font-bold ${
                    isActive
                      ? "bg-white/20 text-white"
                      : "bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300"
                  }`}
                >
                  {count}
                </span>
              </button>
            );
          })}
        </div>

        {/* ── Result count ──────────────────────── */}
        <p className="text-xs text-slate-500 dark:text-slate-400">
          Menampilkan {filtered.length} pengguna {query && `untuk kata kunci "${query}"`}
        </p>

        {/* ── Content ───────────────────────────── */}
        {filtered.length === 0 ? (
          <div className="flex flex-col items-center gap-3 py-16 text-center bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl">
            <div className="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center">
              <Users className="w-5 h-5 text-slate-400" aria-hidden="true" />
            </div>
            <p className="text-sm font-bold text-slate-800 dark:text-slate-200">
              Tidak ada pengguna ditemukan
            </p>
            <p className="text-xs text-slate-500 dark:text-slate-400">
              Coba sesuaikan kata kunci pencarian atau filter peranan.
            </p>
          </div>
        ) : (
          <>
            {/* Desktop table */}
            <div className="hidden md:block bg-surface-card border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden shadow-xs">
              <table className="w-full text-sm">
                <thead>
                  <tr className="border-b border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-800/50">
                    <th className="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                      Pengguna
                    </th>
                    <th className="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                      Peran
                    </th>
                    <th className="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400 hidden lg:table-cell">
                      Kelas
                    </th>
                    <th className="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                      Status
                    </th>
                    <th className="text-left px-4 py-3 text-[11px] font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400 hidden xl:table-cell">
                      Bergabung
                    </th>
                    <th className="px-4 py-3" />
                  </tr>
                </thead>
                <tbody className="divide-y divide-slate-100 dark:divide-slate-800">
                  {paginated.map((user) => (
                    <tr
                      key={user.id}
                      className="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors cursor-pointer group"
                      onClick={() => router.push(`/admin/pengguna/${user.id}`)}
                    >
                      <td className="px-4 py-3">
                        <div className="flex items-center gap-3">
                          <div className="w-8 h-8 bg-primary-50 dark:bg-primary-900/20 rounded-full flex items-center justify-center shrink-0">
                            <span className="text-xs font-bold text-primary-700 dark:text-primary-400">
                              {user.avatarInitials}
                            </span>
                          </div>
                          <div className="min-w-0">
                            <p className="font-semibold text-slate-900 dark:text-slate-100 text-sm truncate">
                              {user.name}
                            </p>
                            <p className="text-xs text-slate-500 dark:text-slate-400 truncate">
                              {user.email}
                            </p>
                          </div>
                        </div>
                      </td>
                      <td className="px-4 py-3">
                        <span
                          className={`inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium ${roleBadge[user.role]}`}
                        >
                          {user.role}
                        </span>
                      </td>
                      <td className="px-4 py-3 text-xs text-slate-500 dark:text-slate-400 hidden lg:table-cell">
                        {user.kelas ?? "-"}
                      </td>
                      <td className="px-4 py-3">
                        <span
                          className={`inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[11px] font-medium ${statusBadge[user.status]}`}
                        >
                          <span
                            className={`w-1.5 h-1.5 rounded-full ${user.status === "Aktif" ? "bg-emerald-500" : "bg-red-500"}`}
                          />
                          {user.status}
                        </span>
                      </td>
                      <td className="px-4 py-3 text-xs text-slate-500 dark:text-slate-400 hidden xl:table-cell">
                        {user.createdAt}
                      </td>
                      <td className="px-4 py-3 text-right">
                        <span className="text-xs text-primary-600 dark:text-primary-400 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">
                          Detail
                        </span>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>

            {/* Mobile list */}
            <div className="flex flex-col divide-y divide-slate-100 dark:divide-slate-800 md:hidden bg-surface-card border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden shadow-xs">
              {paginated.map((user) => (
                <button
                  key={user.id}
                  onClick={() => router.push(`/admin/pengguna/${user.id}`)}
                  className="flex items-center gap-3 px-4 py-3.5 text-left hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors"
                >
                  <div className="w-8 h-8 bg-primary-50 dark:bg-primary-900/20 rounded-full flex items-center justify-center shrink-0">
                    <span className="text-xs font-bold text-primary-700 dark:text-primary-400">
                      {user.avatarInitials}
                    </span>
                  </div>
                  <div className="flex-1 min-w-0">
                    <p className="font-bold text-slate-900 dark:text-slate-100 text-sm truncate">
                      {user.name}
                    </p>
                    <p className="text-xs text-slate-500 dark:text-slate-400 truncate">
                      {user.email}
                    </p>
                    {user.kelas && (
                      <p className="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">
                        Kelas {user.kelas}
                      </p>
                    )}
                  </div>
                  <div className="flex flex-col items-end gap-1 shrink-0">
                    <span
                      className={`inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium ${roleBadge[user.role]}`}
                    >
                      {user.role}
                    </span>
                    <span
                      className={`inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-medium ${statusBadge[user.status]}`}
                    >
                      {user.status}
                    </span>
                  </div>
                </button>
              ))}
            </div>

            {/* Pagination */}
            {totalPages > 1 && (
              <div className="flex items-center justify-between py-3 border-t border-slate-200/80 dark:border-slate-800">
                <p className="text-xs text-slate-500 dark:text-slate-400">
                  {(page - 1) * PAGE_SIZE + 1} - {Math.min(page * PAGE_SIZE, filtered.length)} dari {filtered.length} pengguna
                </p>
                <div className="flex items-center gap-1.5">
                  <button
                    onClick={() => setPage((p) => Math.max(1, p - 1))}
                    disabled={page === 1}
                    className="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 disabled:text-slate-300 dark:disabled:text-slate-600 disabled:cursor-not-allowed transition-colors"
                    aria-label="Sebelumnya"
                  >
                    <ChevronLeft className="w-4 h-4" />
                  </button>
                  <span className="text-xs font-semibold text-slate-800 dark:text-slate-200 px-2">
                    {page} / {totalPages}
                  </span>
                  <button
                    onClick={() => setPage((p) => Math.min(totalPages, p + 1))}
                    disabled={page === totalPages}
                    className="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 disabled:text-slate-300 dark:disabled:text-slate-600 disabled:cursor-not-allowed transition-colors"
                    aria-label="Berikutnya"
                  >
                    <ChevronRight className="w-4 h-4" />
                  </button>
                </div>
              </div>
            )}
          </>
        )}
      </div>

      {isAddingGBK && (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
          <Card className="w-full max-w-md p-6 animate-scale-in">
            <div className="flex items-center justify-between mb-5">
              <h2 className="text-base font-bold text-slate-900 dark:text-slate-100">
                Tambah Akun Guru BK
              </h2>
              <button
                onClick={() => setIsAddingGBK(false)}
                className="p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800"
              >
                <X className="w-4 h-4" />
              </button>
            </div>
            <form
              onSubmit={(e) => {
                e.preventDefault();
                setIsSubmitting(true);
                setTimeout(() => {
                  setIsSubmitting(false);
                  setIsAddingGBK(false);
                  setSuccessMessage("Akun Guru BK baru berhasil ditambahkan.");
                  setTimeout(() => setSuccessMessage(""), 4000);
                }, 800);
              }}
              className="space-y-4"
            >
              <div>
                <label className="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                  Nama Lengkap
                </label>
                <Input required placeholder="Masukkan nama dan gelar lengkap" />
              </div>
              <div>
                <label className="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                  Email Akun
                </label>
                <Input required type="email" placeholder="email@sekolah.sch.id" />
              </div>
              <div>
                <label className="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                  Kata Sandi Awal
                </label>
                <Input required type="password" placeholder="Minimal 8 karakter" minLength={8} />
              </div>
              <div className="grid grid-cols-2 gap-3">
                <div>
                  <label className="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                    Peran
                  </label>
                  <Input value="GURU_BK" readOnly className="bg-slate-50 dark:bg-slate-800 text-slate-500 text-xs" />
                </div>
                <div>
                  <label className="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                    Status
                  </label>
                  <Input value="Aktif" readOnly className="bg-slate-50 dark:bg-slate-800 text-slate-500 text-xs" />
                </div>
              </div>
              <div className="pt-3 flex gap-3">
                <Button
                  type="button"
                  variant="outline"
                  className="flex-1"
                  onClick={() => setIsAddingGBK(false)}
                >
                  Batal
                </Button>
                <Button type="submit" className="flex-1" disabled={isSubmitting} loading={isSubmitting}>
                  Simpan Akun
                </Button>
              </div>
            </form>
          </Card>
        </div>
      )}
    </AdminLayout>
  );
}
