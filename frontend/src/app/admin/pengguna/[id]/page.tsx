// ── Admin — Detail Pengguna ───────────────────────────────────
"use client";

import { use, useState } from "react";
import {
  Mail,
  Hash,
  Calendar,
  BookOpen,
  Shield,
  Save,
  CheckCircle,
  ToggleLeft,
  ToggleRight,
} from "lucide-react";
import { AdminLayout } from "@/components/admin/AdminLayout";
import { Card } from "@/components/ui/Card";
import { Button } from "@/components/ui/Button";
import { Input } from "@/components/ui/Input";
import { mockUsers } from "@/data/mockDataAdmin";
import type { UserRole, UserStatus } from "@/types";

interface PageProps {
  params: Promise<{ id: string }>;
}

const roleBadge: Record<UserRole, string> = {
  Siswa:
    "bg-sky-50 dark:bg-sky-950/50 border border-sky-200 dark:border-sky-800 text-sky-700 dark:text-sky-300",
  "Guru BK":
    "bg-primary-50 dark:bg-primary-950/50 border border-primary-200 dark:border-primary-800 text-primary-700 dark:text-[#5AE39D]",
  Admin:
    "bg-purple-50 dark:bg-purple-950/50 border border-purple-200 dark:border-purple-800 text-purple-700 dark:text-purple-300",
};

export default function AdminDetailPenggunaPage({ params }: PageProps) {
  const { id } = use(params);
  const user = mockUsers.find((u) => u.id === id) ?? mockUsers[0];

  const [status, setStatus] = useState<UserStatus>(user.status);
  const [isEditing, setIsEditing] = useState(false);
  const [editName, setEditName] = useState(user.name);
  const [editEmail, setEditEmail] = useState(user.email);
  const [saving, setSaving] = useState(false);
  const [saved, setSaved] = useState(false);
  const [toggling, setToggling] = useState(false);

  const handleSave = async () => {
    setSaving(true);
    await new Promise((r) => setTimeout(r, 900));
    setSaving(false);
    setSaved(true);
    setIsEditing(false);
    setTimeout(() => setSaved(false), 3000);
  };

  const handleToggleStatus = async () => {
    setToggling(true);
    await new Promise((r) => setTimeout(r, 700));
    setStatus((s) => (s === "Aktif" ? "Nonaktif" : "Aktif"));
    setToggling(false);
  };

  const isAktif = status === "Aktif";
  const statusBadgeClass = isAktif
    ? "bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300"
    : "bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300";
  const statusDotClass = isAktif
    ? "bg-emerald-500 dark:bg-[#5AE39D]"
    : "bg-red-500 dark:bg-red-400";

  return (
    <AdminLayout
      pageTitle="Detail Pengguna"
      showBackButton
      backHref="/admin/pengguna"
      withBottomNav={false}
    >
      <div className="px-4 py-5 pb-10 max-w-4xl w-full mx-auto lg:px-8 lg:py-6 animate-fade-in">
        {/* Page Header */}
        <div className="mb-6">
          <h1 className="text-xl sm:text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight leading-tight">
            Detail Pengguna
          </h1>
          <p className="text-xs font-mono text-slate-500 dark:text-slate-400 mt-1">
            ID Akun: {user.id}
          </p>
        </div>

        <div className="flex flex-col gap-6 lg:flex-row lg:items-start">
          {/* Left — Identity card */}
          <div className="flex flex-col gap-4 lg:w-72 shrink-0">
            <Card padding="md" className="border border-slate-200 dark:border-slate-800 shadow-xs">
              <div className="flex flex-col items-center gap-3 py-3">
                <div className="w-20 h-20 bg-primary-100 dark:bg-primary-950/70 border border-primary-200 dark:border-primary-800 rounded-2xl flex items-center justify-center shadow-xs">
                  <span className="text-2xl font-black text-primary-800 dark:text-[#5AE39D]">
                    {user.avatarInitials}
                  </span>
                </div>
                <div className="text-center w-full px-2">
                  <p className="font-extrabold text-slate-900 dark:text-slate-100 text-base truncate">
                    {isEditing ? editName : user.name}
                  </p>
                  <span
                    className={`inline-flex items-center mt-1.5 px-3 py-1 rounded-full text-xs font-bold ${roleBadge[user.role]}`}
                  >
                    {user.role}
                  </span>
                </div>
              </div>

              {/* Status badge */}
              <div
                className={`mt-2 flex items-center justify-center gap-2 py-2 px-3 rounded-xl ${statusBadgeClass}`}
              >
                <div className={`w-2 h-2 rounded-full ${statusDotClass}`} />
                <span className="text-xs font-bold">
                  Status: {status}
                </span>
              </div>
            </Card>

            {/* Toggle status button */}
            <Button
              variant={status === "Aktif" ? "outline" : "primary"}
              size="md"
              fullWidth
              loading={toggling}
              onClick={handleToggleStatus}
              leftIcon={
                status === "Aktif" ? (
                  <ToggleLeft className="w-4 h-4" />
                ) : (
                  <ToggleRight className="w-4 h-4" />
                )
              }
            >
              {status === "Aktif" ? "Nonaktifkan Akun" : "Aktifkan Akun"}
            </Button>

            {status === "Aktif" && !toggling && (
              <p className="text-xs text-slate-500 dark:text-slate-400 text-center -mt-1 leading-relaxed">
                Menonaktifkan akan mencegah pengguna masuk ke sistem.
              </p>
            )}
          </div>

          {/* Right — Info + edit */}
          <div className="flex flex-col gap-5 flex-1 min-w-0">
            {/* Account info */}
            <Card padding="md" className="border border-slate-200 dark:border-slate-800 shadow-xs">
              <div className="flex items-center justify-between mb-4 pb-3 border-b border-slate-200/80 dark:border-slate-800">
                <h2 className="text-sm font-extrabold text-slate-900 dark:text-slate-100 tracking-tight">
                  Informasi Akun
                </h2>
                {!isEditing && (
                  <button
                    onClick={() => setIsEditing(true)}
                    className="text-xs text-primary-600 dark:text-[#5AE39D] font-bold hover:underline cursor-pointer"
                  >
                    Edit Profil
                  </button>
                )}
              </div>

              {isEditing ? (
                <div className="flex flex-col gap-3.5">
                  <Input
                    label="Nama Lengkap"
                    value={editName}
                    onChange={(e) => setEditName(e.target.value)}
                  />
                  <Input
                    label="Alamat Email"
                    type="email"
                    value={editEmail}
                    onChange={(e) => setEditEmail(e.target.value)}
                  />
                  <div className="flex gap-2.5 mt-2">
                    <Button
                      variant="primary"
                      size="sm"
                      loading={saving}
                      onClick={handleSave}
                      leftIcon={<Save className="w-3.5 h-3.5" />}
                    >
                      Simpan Perubahan
                    </Button>
                    <Button
                      variant="ghost"
                      size="sm"
                      onClick={() => {
                        setIsEditing(false);
                        setEditName(user.name);
                        setEditEmail(user.email);
                      }}
                    >
                      Batal
                    </Button>
                  </div>
                </div>
              ) : (
                <div className="flex flex-col gap-3.5">
                  {[
                    {
                      icon: <Shield className="w-4 h-4 text-slate-500 dark:text-slate-400" />,
                      label: "Nama Lengkap",
                      value: user.name,
                    },
                    {
                      icon: <Mail className="w-4 h-4 text-slate-500 dark:text-slate-400" />,
                      label: "Alamat Email",
                      value: user.email,
                    },
                    {
                      icon: <Hash className="w-4 h-4 text-slate-500 dark:text-slate-400" />,
                      label: "ID Akun Sistem",
                      value: user.id,
                    },
                    {
                      icon: <Shield className="w-4 h-4 text-slate-500 dark:text-slate-400" />,
                      label: "Peran / Hak Akses",
                      value: user.role,
                    },
                    ...(user.kelas
                      ? [
                          {
                            icon: (
                              <BookOpen className="w-4 h-4 text-slate-500 dark:text-slate-400" />
                            ),
                            label: "Kelas Terdaftar",
                            value: user.kelas,
                          },
                        ]
                      : []),
                    {
                      icon: <Calendar className="w-4 h-4 text-slate-500 dark:text-slate-400" />,
                      label: "Tanggal Registrasi",
                      value: user.createdAt,
                    },
                  ].map(({ icon, label, value }, i, arr) => (
                    <div key={label}>
                      <div className="flex items-center gap-3">
                        <span className="shrink-0">{icon}</span>
                        <div className="flex-1 min-w-0">
                          <p className="text-xs font-semibold text-slate-500 dark:text-slate-400">
                            {label}
                          </p>
                          <p className="text-sm font-bold text-slate-900 dark:text-slate-100 mt-0.5 truncate">
                            {value}
                          </p>
                        </div>
                      </div>
                      {i < arr.length - 1 && (
                        <div className="h-px bg-slate-200/80 dark:bg-slate-800 mt-3.5 ml-7" />
                      )}
                    </div>
                  ))}
                </div>
              )}
            </Card>

            {/* Success message */}
            {saved && (
              <div className="flex items-center gap-2.5 text-emerald-800 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 rounded-xl px-4 py-3 text-xs font-semibold animate-slide-up">
                <CheckCircle className="w-4 h-4 shrink-0 text-emerald-600 dark:text-emerald-400" />
                <p>Perubahan data akun berhasil disimpan.</p>
              </div>
            )}

            {/* Notice Surface with high contrast in dark mode */}
            <div className="bg-[#EDECEA]/60 dark:bg-[#13211B] border border-slate-300 dark:border-slate-800 rounded-2xl p-4.5 shadow-2xs">
              <div className="flex items-start gap-3">
                <Shield className="w-4 h-4 text-primary-600 dark:text-[#5AE39D] shrink-0 mt-0.5" />
                <p className="text-xs text-slate-700 dark:text-slate-300 leading-relaxed font-medium">
                  Perubahan data pengguna yang dilakukan Admin akan langsung diterapkan ke sistem secara real-time. Pastikan informasi yang dimasukkan telah diverifikasi dengan pihak sekolah.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AdminLayout>
  );
}
