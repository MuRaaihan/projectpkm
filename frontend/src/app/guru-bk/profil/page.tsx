// ── Guru BK — Profil ────────────────────────────────────────────
'use client';

import { useState } from 'react';
import { useRouter } from 'next/navigation';
import {
 User,
 Mail,
 Hash,
 School,
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
import { GBKLayout } from '@/components/guru-bk/GBKLayout';
import { Button } from '@/components/ui/Button';
import { Input } from '@/components/ui/Input';
import { counselorUser } from '@/data/mockDataGBK';

export default function GBKProfilPage() {
 const router = useRouter();

 // Edit profile state
 const [isEditing, setIsEditing] = useState(false);
 const [editName, setEditName] = useState(counselorUser.name);
 const [editEmail, setEditEmail] = useState(counselorUser.email);
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
 icon: <User className="w-4 h-4 text-slate-600 dark:text-slate-400" />,
 label: 'Nama Lengkap',
 value: isEditing ? editName : counselorUser.name,
 },
 {
 icon: <Mail className="w-4 h-4 text-slate-600 dark:text-slate-400" />,
 label: 'Email',
 value: isEditing ? editEmail : counselorUser.email,
 },
 {
 icon: <Hash className="w-4 h-4 text-slate-600 dark:text-slate-400" />,
 label: 'NIP',
 value: counselorUser.nip,
 },
 {
 icon: <School className="w-4 h-4 text-slate-600 dark:text-slate-400" />,
 label: 'Sekolah',
 value: counselorUser.school,
 },
 {
 icon: <Shield className="w-4 h-4 text-slate-600 dark:text-slate-400" />,
 label: 'Role',
 value: 'Guru BK / Konselor',
 },
 ];

 return (
 <GBKLayout pageTitle="Profil" withBottomNav>
 <div className="px-6 py-5 max-w-2xl w-full mx-auto animate-fade-in">

 {/* ── Success Toasts ──────────────────────────────────── */}
 {(savedProfile || savedPass) && (
 <div className="flex items-center gap-2 text-green-700 dark:text-green-400 bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800/40 rounded-md px-3 py-2 mb-4">
 <CheckCircle className="w-4 h-4 shrink-0" />
 <p className="text-xs font-medium">
 {savedProfile ? 'Profil berhasil diperbarui.' : 'Kata sandi berhasil diubah.'}
 </p>
 </div>
 )}

 {/* ── Profile Header ──────────────────────────────────── */}
 <div className="bg-surface-card border border-slate-200 dark:border-slate-700 rounded-lg px-5 py-4 mb-4 animate-slide-up">
 <div className="flex items-center gap-4">
 {/* Avatar */}
 <div className="w-16 h-16 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center shrink-0">
 <span className="text-xl font-bold text-slate-700 dark:text-slate-200">
 {counselorUser.avatarInitials}
 </span>
 </div>

 {/* Name + role */}
 <div className="flex-1 min-w-0">
 <p className="text-base font-semibold text-slate-900 dark:text-slate-100 truncate">
 {isEditing ? editName : counselorUser.name}
 </p>
 <span className="inline-flex items-center gap-1 mt-1 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-400 rounded-md px-2 py-0.5 text-xs font-medium">
 <Shield className="w-3 h-3" />
 Guru BK / Konselor
 </span>
 </div>

 {/* Edit button */}
 {!isEditing && (
 <button
 onClick={() => setIsEditing(true)}
 className="text-xs text-primary-600 dark:text-primary-400 font-semibold hover:underline shrink-0"
 >
 Edit Profil
 </button>
 )}
 </div>
 </div>

 {/* ── Informasi Akun ──────────────────────────────────── */}
 <div className="bg-surface-card border border-slate-200 dark:border-slate-700 rounded-lg overflow-hidden mb-4 animate-slide-up">
 <div className="px-5 py-3 border-b border-slate-200 dark:border-slate-600">
 <p className="text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400">
 Informasi Akun
 </p>
 </div>

 {isEditing ? (
 /* ── Edit Form ── */
 <div className="px-5 py-4 flex flex-col gap-3">
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
 <div className="flex gap-2 mt-1">
 <Button
 variant="primary"
 size="sm"
 loading={savingProfile}
 onClick={handleSaveProfile}
 leftIcon={<Save className="w-3.5 h-3.5" />}
 >
 Simpan
 </Button>
 <Button
 variant="ghost"
 size="sm"
 onClick={() => {
 setIsEditing(false);
 setEditName(counselorUser.name);
 setEditEmail(counselorUser.email);
 }}
 >
 Batal
 </Button>
 </div>
 </div>
 ) : (
 /* ── Info Rows ── */
 <div className="divide-y divide-slate-50 dark:divide-slate-700/30">
 {infoRows.map(({ icon, label, value }) => (
 <div
 key={label}
 className="flex items-center gap-3 px-5 py-3 hover:bg-slate-50 dark:hover:bg-slate-700/20 transition-colors"
 >
 <span className="shrink-0">{icon}</span>
 <div className="flex-1 min-w-0">
 <p className="text-xs text-slate-600 dark:text-slate-400">{label}</p>
 <p className="text-sm font-medium text-slate-900 dark:text-slate-100 truncate mt-0.5">
 {value}
 </p>
 </div>
 </div>
 ))}
 </div>
 )}
 </div>

 {/* ── Privacy Notice (Unique to Guru BK) ──────────────────────── */}
 <div className="bg-primary-50/50 dark:bg-primary-900/10 border border-primary-100 dark:border-primary-800/30 rounded-lg p-4 mb-4 flex items-start gap-3 animate-slide-up">
 <div className="w-8 h-8 rounded-md bg-primary-100 dark:bg-primary-900/40 flex items-center justify-center shrink-0">
 <Shield className="w-4 h-4 text-primary-600 dark:text-primary-400" aria-hidden="true" />
 </div>
 <div>
 <p className="text-sm font-semibold text-primary-800 dark:text-primary-300">
 Kerahasiaan Data
 </p>
 <p className="text-xs text-primary-600 dark:text-primary-400 mt-1 leading-relaxed">
 Sebagai Guru BK, Anda memiliki akses ke data sensitif laporan siswa. Gunakan informasi ini hanya untuk keperluan penanganan yang sesuai prosedur.
 </p>
 </div>
 </div>

 {/* ── Ubah Kata Sandi ─────────────────────────────────── */}
 <div className="bg-surface-card border border-slate-200 dark:border-slate-700 rounded-lg overflow-hidden mb-4 animate-slide-up">
 <button
 onClick={() => {
 setShowPassForm((v) => !v);
 setPassError('');
 }}
 className="w-full flex items-center justify-between px-5 py-4 hover:bg-slate-50 dark:hover:bg-slate-700/20 transition-colors"
 >
 <div className="flex items-center gap-3">
 <KeyRound className="w-4 h-4 text-slate-600 dark:text-slate-400" />
 <div className="text-left">
 <p className="text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-0.5">
 Ubah Kata Sandi
 </p>
 {!showPassForm && (
 <p className="text-xs text-slate-600 dark:text-slate-400">
 Gunakan kata sandi yang kuat dan berbeda dari akun lain.
 </p>
 )}
 </div>
 </div>
 {showPassForm ? (
 <ChevronUp className="w-4 h-4 text-slate-600 dark:text-slate-400 shrink-0" />
 ) : (
 <ChevronDown className="w-4 h-4 text-slate-600 dark:text-slate-400 shrink-0" />
 )}
 </button>

 {showPassForm && (
 <div className="border-t border-slate-200 dark:border-slate-600 px-5 py-4 flex flex-col gap-3">
 <Input
 label="Kata Sandi Saat Ini"
 type={showCurrent ? 'text' : 'password'}
 value={passForm.current}
 onChange={(e) => setPassForm((f) => ({ ...f, current: e.target.value }))}
 leftIcon={<KeyRound className="w-4 h-4" />}
 rightIcon={
 <button
 type="button"
 onClick={() => setShowCurrent((v) => !v)}
 className="hover:text-slate-700 dark:hover:text-slate-300 transition-colors"
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
 leftIcon={<KeyRound className="w-4 h-4" />}
 rightIcon={
 <button
 type="button"
 onClick={() => setShowNext((v) => !v)}
 className="hover:text-slate-700 dark:hover:text-slate-300 transition-colors"
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
 leftIcon={<KeyRound className="w-4 h-4" />}
 />
 {passError && (
 <p className="text-xs text-red-600 dark:text-red-400 font-medium">{passError}</p>
 )}
 <Button
 variant="primary"
 size="sm"
 loading={savingPass}
 onClick={handleSavePass}
 leftIcon={<Save className="w-3.5 h-3.5" />}
 >
 Simpan Kata Sandi
 </Button>
 </div>
 )}
 </div>

 {/* ── Keamanan & Akses ────────────────────────────────── */}
 <div className="bg-surface-card border border-slate-200 dark:border-slate-700 rounded-lg overflow-hidden animate-slide-up">
 <div className="px-5 py-3 border-b border-slate-200 dark:border-slate-600">
 <p className="text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400">
 Keamanan &amp; Akses
 </p>
 </div>

 {/* Role info row */}
 <div className="flex items-center gap-3 px-5 py-3 border-b border-slate-50 dark:border-slate-700/30">
 <Shield className="w-4 h-4 text-slate-600 dark:text-slate-400 shrink-0" />
 <div className="flex-1 min-w-0">
 <p className="text-xs text-slate-600 dark:text-slate-400">Tingkat Akses</p>
 <p className="text-sm font-medium text-slate-900 dark:text-slate-100 mt-0.5">
 Guru BK: Akses penanganan dan pemantauan kasus
 </p>
 </div>
 </div>

 {/* Logout row */}
 <div className="px-5 py-4">
 <Button
 variant="outline"
 size="sm"
 leftIcon={<LogOut className="w-4 h-4" />}
 onClick={() => router.push('/login')}
 >
 Keluar dari Akun
 </Button>
 </div>
 </div>

 </div>
 </GBKLayout>
 );
}
