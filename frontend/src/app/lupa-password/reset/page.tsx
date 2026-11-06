'use client';

import { useState } from 'react';
import { useRouter } from 'next/navigation';
import { Button } from '@/components/ui/Button';
import { Input } from '@/components/ui/Input';
import { SchoolLogo } from '@/components/ui/SchoolLogo';
import { ThemeToggle } from '@/components/ui/ThemeToggle';

export default function LupaPasswordResetPage() {
  const router = useRouter();
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (password !== confirmPassword) {
      setError('Konfirmasi kata sandi tidak cocok.');
      return;
    }
    setError('');
    setLoading(true);
    await new Promise((r) => setTimeout(r, 900));
    setLoading(false);
    router.push('/login');
  };

  return (
    <div className="relative min-h-screen bg-surface dark:bg-slate-950 flex flex-col items-center justify-center px-4 py-12">
      <div className="absolute top-4 right-4 sm:top-6 sm:right-6">
        <ThemeToggle />
      </div>

      {/* ── Branding ─────────────────────────────────────────── */}
      <div className="flex flex-col items-center gap-3 mb-8">
        <SchoolLogo size="lg" />
        <div className="text-center">
          <h1 className="text-xl font-bold text-slate-900 dark:text-slate-100 tracking-tight">
            Reset Kata Sandi
          </h1>
          <p className="text-xs text-slate-600 dark:text-slate-400 uppercase tracking-widest mt-0.5">
            SIPERKA · MTs Soebono Mantofani
          </p>
        </div>
      </div>

      <div className="bg-surface-card border border-slate-200 dark:border-slate-800 rounded-xl p-8 w-full max-w-sm shadow-xs">
        <p className="text-sm text-slate-600 dark:text-slate-400 text-center mb-6">
          Masukkan kata sandi baru untuk akun Anda.
        </p>

        <form onSubmit={handleSubmit} className="flex flex-col gap-4">
          <Input
            label="Kata Sandi Baru"
            type="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            placeholder="Minimal 6 karakter"
            minLength={6}
            required
          />

          <Input
            label="Konfirmasi Kata Sandi Baru"
            type="password"
            value={confirmPassword}
            onChange={(e) => {
              setConfirmPassword(e.target.value);
              if (error) setError('');
            }}
            placeholder="Ulangi kata sandi baru"
            minLength={6}
            required
            error={error}
          />

          <Button type="submit" className="w-full mt-2" loading={loading}>
            Simpan Kata Sandi
          </Button>
        </form>
      </div>
    </div>
  );
}
