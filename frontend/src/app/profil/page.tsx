// ── Profil Page — Clean Student Profile ──────────────────────────
'use client';

import { useState } from 'react';
import { useRouter } from 'next/navigation';
import {
  User,
  Mail,
  Hash,
  Shield,
  LogOut,
  Save,
  CheckCircle,
  Eye,
  EyeOff,
  KeyRound,
  ChevronDown,
  ChevronUp,
} from 'lucide-react';
import { AppHeader, PageContainer, BottomNavigation } from '@/components/ui';
import { Button } from '@/components/ui/Button';
import { Input } from '@/components/ui/Input';
import { currentUser } from '@/data/mockData';

export default function ProfilPage() {
  const router = useRouter();

  // Edit profile state
  const [isEditing, setIsEditing] = useState(false);
  const [editName, setEditName] = useState(currentUser.name);
  const [editEmail, setEditEmail] = useState(currentUser.email);
  const [savingProfile, setSavingProfile] = useState(false);
  const [savedProfile, setSavedProfile] = useState(false);

  // Change password state
  const [showPassForm, setShowPassForm] = useState(false);
  const [passForm, setPassForm] = useState({
    current: '',
    next: '',
    confirm: '',
  });
  const [showCurrent, setShowCurrent] = useState(false);
  const [showNext, setShowNext] = useState(false);
  const [savingPass, setSavingPass] = useState(false);
  const [savedPass, setSavedPass] = useState(false);
  const [passError, setPassError] = useState('');

  const handleSaveProfile = async () => {
    setSavingProfile(true);
    await new Promise((r) => setTimeout(r, 900));
    setSavingProfile(false);
    setSavedProfile(true);
    setIsEditing(false);
    setTimeout(() => setSavedProfile(false), 3000);
  };

  const handleSavePass = async () => {
    if (!passForm.current) {
      setPassError('Kata sandi saat ini wajib diisi.');
      return;
    }
    if (passForm.next.length < 6) {
      setPassError('Kata sandi baru minimal 6 karakter.');
      return;
    }
    if (passForm.next !== passForm.confirm) {
      setPassError('Konfirmasi kata sandi tidak cocok.');
      return;
    }
    setPassError('');
    setSavingPass(true);
    await new Promise((r) => setTimeout(r, 900));
    setSavingPass(false);
    setSavedPass(true);
    setShowPassForm(false);
    setPassForm({ current: '', next: '', confirm: '' });
    setTimeout(() => setSavedPass(false), 3000);
  };

  const infoRows = [
    {
      icon: <User className="w-4 h-4 text-slate-400 dark:text-slate-500" />,
      label: 'Nama Lengkap',
      value: isEditing ? editName : currentUser.name,
    },
    {
      icon: <Mail className="w-4 h-4 text-slate-400 dark:text-slate-500" />,
      label: 'Alamat Email',
      value: isEditing ? editEmail : currentUser.email,
    },
    {
      icon: <Hash className="w-4 h-4 text-slate-400 dark:text-slate-500" />,
      label: 'Nomor Induk Siswa (NIS)',
      value: currentUser.nis,
    },
    {
      icon: <Shield className="w-4 h-4 text-slate-400 dark:text-slate-500" />,
      label: 'Peran Akun',
      value: 'Siswa Aktif',
    },
  ];

  return (
    <PageContainer withBottomNav>
      <AppHeader
        variant="logo"
        showNotification
        showAvatar
        avatarInitials={currentUser.avatarInitials}
      />

      <main className="px-4 sm:px-6 py-6 pb-28 max-w-2xl w-full mx-auto animate-fade-in">
        {/* ── Success Toasts ──────────────────────────────────── */}
        {(savedProfile || savedPass) && (
          <div className="flex items-center gap-2.5 text-emerald-800 dark:text-[#5AE39D] bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/80 rounded-xl px-4 py-3 mb-5 shadow-2xs">
            <CheckCircle className="w-4 h-4 shrink-0 text-primary-600 dark:text-[#5AE39D]" />
            <p className="text-xs font-bold">
              {savedProfile ? 'Profil berhasil diperbarui.' : 'Kata sandi berhasil diubah.'}
            </p>
          </div>
        )}

        {/* ── Profile Header ──────────────────────────────────── */}
        <div className="bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl p-6 mb-5 shadow-xs animate-slide-up">
          <div className="flex items-center gap-4">
            {/* Avatar */}
            <div className="w-16 h-16 rounded-2xl bg-primary-600 text-white flex items-center justify-center shrink-0 shadow-xs">
              <span className="text-xl font-black">
                {currentUser.avatarInitials}
              </span>
            </div>

            {/* Name + role */}
            <div className="flex-1 min-w-0">
              <p className="text-lg font-black text-slate-900 dark:text-slate-100 truncate">
                {isEditing ? editName : currentUser.name}
              </p>
              <div className="flex items-center gap-2 mt-1">
                <span className="inline-flex items-center gap-1 bg-primary-50 dark:bg-primary-950/60 border border-primary-200/60 dark:border-primary-800 text-primary-700 dark:text-[#5AE39D] rounded-full px-2.5 py-0.5 text-xs font-bold">
                  <Shield className="w-3 h-3" />
                  Siswa
                </span>
                <span className="text-xs font-mono text-slate-500 dark:text-slate-400">
                  NIS: {currentUser.nis}
                </span>
              </div>
            </div>

            {/* Edit button */}
            {!isEditing && (
              <button
                onClick={() => setIsEditing(true)}
                className="text-xs text-primary-600 dark:text-[#5AE39D] font-bold hover:underline shrink-0 cursor-pointer"
              >
                Edit Profil
              </button>
            )}
          </div>
        </div>

        {/* ── Informasi Akun ──────────────────────────────────── */}
        <div className="bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden mb-5 shadow-xs animate-slide-up">
          <div className="px-6 py-3.5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/40">
            <p className="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">
              Informasi Biodata Siswa
            </p>
          </div>

          {isEditing ? (
            /* ── Edit Form ── */
            <div className="p-6 flex flex-col gap-4">
              <Input
                label="Nama Lengkap"
                value={editName}
                onChange={(e) => setEditName(e.target.value)}
              />
              <Input
                label="Email"
                type="email"
                value={editEmail}
                onChange={(e) => setEditEmail(e.target.value)}
              />
              <div className="flex gap-2.5 mt-2">
                <Button
                  variant="primary"
                  size="sm"
                  loading={savingProfile}
                  onClick={handleSaveProfile}
                  leftIcon={<Save className="w-3.5 h-3.5" />}
                >
                  Simpan Perubahan
                </Button>
                <Button
                  variant="ghost"
                  size="sm"
                  onClick={() => {
                    setIsEditing(false);
                    setEditName(currentUser.name);
                    setEditEmail(currentUser.email);
                  }}
                >
                  Batal
                </Button>
              </div>
            </div>
          ) : (
            /* ── Info Rows ── */
            <div className="divide-y divide-slate-100 dark:divide-slate-800">
              {infoRows.map(({ icon, label, value }) => (
                <div
                  key={label}
                  className="flex items-center gap-3.5 px-6 py-3.5 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors"
                >
                  <span className="shrink-0">{icon}</span>
                  <div className="flex-1 min-w-0">
                    <p className="text-xs text-slate-500 dark:text-slate-400">{label}</p>
                    <p className="text-sm font-bold text-slate-900 dark:text-slate-100 truncate mt-0.5">
                      {value}
                    </p>
                  </div>
                </div>
              ))}
            </div>
          )}
        </div>

        {/* ── Ubah Kata Sandi ─────────────────────────────────── */}
        <div className="bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden mb-5 shadow-xs animate-slide-up">
          <button
            onClick={() => {
              setShowPassForm((v) => !v);
              setPassError('');
            }}
            className="w-full flex items-center justify-between px-6 py-4 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors cursor-pointer text-left"
          >
            <div className="flex items-center gap-3.5">
              <KeyRound className="w-5 h-5 text-slate-400 dark:text-slate-500" />
              <div>
                <p className="text-sm font-bold text-slate-900 dark:text-slate-100">
                  Ubah Kata Sandi
                </p>
                {!showPassForm && (
                  <p className="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                    Gunakan kata sandi yang aman dan tidak mudah ditebak
                  </p>
                )}
              </div>
            </div>
            {showPassForm ? (
              <ChevronUp className="w-4 h-4 text-slate-400 shrink-0" />
            ) : (
              <ChevronDown className="w-4 h-4 text-slate-400 shrink-0" />
            )}
          </button>

          {showPassForm && (
            <div className="border-t border-slate-100 dark:border-slate-800 p-6 flex flex-col gap-4">
              <Input
                label="Kata Sandi Saat Ini"
                type={showCurrent ? 'text' : 'password'}
                value={passForm.current}
                onChange={(e) => setPassForm((f) => ({ ...f, current: e.target.value }))}
                leftIcon={<KeyRound className="w-4 h-4 text-slate-400" />}
                rightIcon={
                  <button
                    type="button"
                    onClick={() => setShowCurrent((v) => !v)}
                    className="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors p-1"
                  >
                    {showCurrent ? <EyeOff className="w-4 h-4" /> : <Eye className="w-4 h-4" />}
                  </button>
                }
              />
              <Input
                label="Kata Sandi Baru"
                type={showNext ? 'text' : 'password'}
                value={passForm.next}
                onChange={(e) => setPassForm((f) => ({ ...f, next: e.target.value }))}
                leftIcon={<KeyRound className="w-4 h-4 text-slate-400" />}
                rightIcon={
                  <button
                    type="button"
                    onClick={() => setShowNext((v) => !v)}
                    className="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors p-1"
                  >
                    {showNext ? <EyeOff className="w-4 h-4" /> : <Eye className="w-4 h-4" />}
                  </button>
                }
              />
              <Input
                label="Konfirmasi Kata Sandi Baru"
                type="password"
                value={passForm.confirm}
                onChange={(e) => setPassForm((f) => ({ ...f, confirm: e.target.value }))}
                leftIcon={<KeyRound className="w-4 h-4 text-slate-400" />}
              />
              {passError && (
                <p className="text-xs text-red-600 dark:text-red-400 font-semibold">{passError}</p>
              )}
              <div className="pt-1">
                <Button
                  variant="primary"
                  size="md"
                  loading={savingPass}
                  onClick={handleSavePass}
                  leftIcon={<Save className="w-4 h-4" />}
                >
                  Simpan Kata Sandi Baru
                </Button>
              </div>
            </div>
          )}
        </div>

        {/* ── Keamanan & Keluar ────────────────────────────────── */}
        <div className="bg-surface-card border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-xs animate-slide-up">
          <div className="px-6 py-3.5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/40">
            <p className="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">
              Sesi &amp; Keamanan Akun
            </p>
          </div>

          <div className="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
              <p className="text-sm font-bold text-slate-900 dark:text-slate-100">
                Keluar dari Sesi
              </p>
              <p className="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                Pastikan seluruh laporan penting telah selesai dikirim sebelum keluar.
              </p>
            </div>
            <Button
              variant="outline"
              size="md"
              leftIcon={<LogOut className="w-4 h-4" />}
              onClick={() => router.push('/login')}
              className="shrink-0"
            >
              Keluar Akun
            </Button>
          </div>
        </div>
      </main>

      <BottomNavigation />
    </PageContainer>
  );
}
