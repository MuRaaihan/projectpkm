// ── Login Page (Universal Auth) ───────────────────────────────────
'use client';

import { useState } from 'react';
import { useRouter } from 'next/navigation';
import { Lock, Eye, EyeOff, Mail, ShieldCheck } from 'lucide-react';
import { Button } from '@/components/ui/Button';
import { Input } from '@/components/ui/Input';
import { SchoolLogo } from '@/components/ui/SchoolLogo';
import { ThemeToggle } from '@/components/ui/ThemeToggle';
import Link from 'next/link';

export default function LoginPage() {
  const router = useRouter();
  const [form, setForm] = useState({
    email: '',
    password: '',
    remember: false,
  });
  const [showPassword, setShowPassword] = useState(false);
  const [loading, setLoading] = useState(false);
  const [errors, setErrors] = useState<{ email?: string; password?: string }>({});

  const validate = () => {
    const errs: typeof errors = {};
    if (!form.email.trim()) errs.email = 'Email atau Identitas wajib diisi.';
    if (!form.password) errs.password = 'Kata sandi wajib diisi.';
    else if (form.password.length < 6)
      errs.password = 'Kata sandi minimal 6 karakter.';
    return errs;
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    const errs = validate();
    if (Object.keys(errs).length) {
      setErrors(errs);
      return;
    }
    setErrors({});
    setLoading(true);
    await new Promise((r) => setTimeout(r, 1200));
    setLoading(false);
    router.push('/dashboard');
  };

  return (
    <div className="relative min-h-screen bg-[#EDECEA] dark:bg-[#0E1713] flex flex-col items-center justify-center px-4 py-12 transition-theme">
      {/* Top utility bar */}
      <div className="absolute top-4 right-4 sm:top-6 sm:right-6">
        <ThemeToggle />
      </div>

      {/* ── Branding ─────────────────────────────────────────── */}
      <div className="flex flex-col items-center gap-3 mb-8 text-center animate-fade-in">
        <div className="w-16 h-16 rounded-2xl bg-white dark:bg-[#16231D] border border-slate-300 dark:border-slate-800 flex items-center justify-center shadow-xs">
          <SchoolLogo size="lg" withText={false} />
        </div>
        <div>
          <h1 className="text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight">
            SIPERKA
          </h1>
          <p className="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-widest mt-1">
            Sistem Informasi Pelaporan Kasus Perundungan
          </p>
        </div>
      </div>

      {/* ── Form Card ────────────────────────────────────────── */}
      <div className="bg-white dark:bg-[#16231D] border border-slate-300 dark:border-slate-800 rounded-3xl shadow-sm p-7 sm:p-9 w-full max-w-md animate-slide-up">
        <div className="mb-6">
          <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-100/80 dark:bg-primary-950/70 text-primary-800 dark:text-primary-300 text-xs font-bold mb-3 border border-primary-300/80 dark:border-primary-800/80 shadow-2xs">
            <span className="w-2 h-2 rounded-full bg-primary-600 dark:bg-[#5AE39D]" />
            Portal Masuk Universal
          </div>
          <h2 className="text-xl font-extrabold text-slate-900 dark:text-slate-100 tracking-tight">
            Masuk ke Akun
          </h2>
          <p className="text-xs text-slate-600 dark:text-slate-400 mt-1">
            Gunakan email atau identitas resmi sekolah terdaftar.
          </p>
        </div>

        <form className="flex flex-col gap-4.5" onSubmit={handleSubmit} noValidate>
          <Input
            label="Email / Identitas"
            type="email"
            placeholder="contoh: siswa@sekolah.sch.id"
            value={form.email}
            onChange={(e) => setForm((f) => ({ ...f, email: e.target.value }))}
            error={errors.email}
            leftIcon={<Mail className="w-4 h-4 text-slate-400" aria-hidden="true" />}
            autoComplete="email"
          />

          <Input
            label="Kata Sandi"
            type={showPassword ? 'text' : 'password'}
            placeholder="Masukkan kata sandi"
            value={form.password}
            onChange={(e) => setForm((f) => ({ ...f, password: e.target.value }))}
            error={errors.password}
            leftIcon={<Lock className="w-4 h-4 text-slate-400" aria-hidden="true" />}
            rightIcon={
              <button
                type="button"
                onClick={() => setShowPassword((v) => !v)}
                className="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors p-1"
                aria-label={showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'}
              >
                {showPassword ? (
                  <EyeOff className="w-4 h-4" />
                ) : (
                  <Eye className="w-4 h-4" />
                )}
              </button>
            }
            autoComplete="current-password"
          />

          {/* Remember me + Forgot */}
          <div className="flex items-center justify-between text-xs pt-1">
            <label className="flex items-center gap-2 cursor-pointer select-none">
              <input
                type="checkbox"
                checked={form.remember}
                onChange={(e) => setForm((f) => ({ ...f, remember: e.target.checked }))}
                className="w-4 h-4 rounded border-slate-300 dark:border-slate-700 text-primary-600 focus:ring-primary-500 cursor-pointer"
              />
              <span className="text-slate-700 dark:text-slate-300 font-medium">Ingat saya</span>
            </label>
            <Link
              href="/lupa-password"
              className="font-bold text-primary-700 dark:text-[#5AE39D] hover:underline"
            >
              Lupa sandi?
            </Link>
          </div>

          <Button
            type="submit"
            fullWidth
            size="lg"
            loading={loading}
            variant="primary"
            className="mt-2 text-base"
          >
            Masuk ke SIPERKA
          </Button>
        </form>

        {/* ── Other links ─────────────────────────────────── */}
        <div className="mt-6 pt-5 border-t border-slate-200 dark:border-slate-800 flex flex-col gap-3 text-center">
          <p className="text-xs text-slate-600 dark:text-slate-400">
            Siswa baru belum punya akun?{' '}
            <Link
              href="/register"
              className="text-primary-700 dark:text-[#5AE39D] font-bold hover:underline"
            >
              Daftar akun di sini
            </Link>
          </p>

          <div className="flex items-center justify-center gap-1.5 text-[11px] text-slate-500 dark:text-slate-400 mt-1">
            <ShieldCheck className="w-3.5 h-3.5 text-primary-600 dark:text-[#5AE39D]" />
            <span>Kerahasiaan akun dilindungi sistem enkripsi</span>
          </div>
        </div>
      </div>
    </div>
  );
}
