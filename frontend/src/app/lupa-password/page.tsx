'use client';

import { useState } from 'react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';
import { Button } from '@/components/ui/Button';
import { Input } from '@/components/ui/Input';
import { SchoolLogo } from '@/components/ui/SchoolLogo';
import { ThemeToggle } from '@/components/ui/ThemeToggle';

export default function LupaPasswordPage() {
  const router = useRouter();
  const [email, setEmail] = useState('');
  const [loading, setLoading] = useState(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    await new Promise((r) => setTimeout(r, 800));
    setLoading(false);
    router.push('/lupa-password/otp');
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
            Lupa Kata Sandi
          </h1>
          <p className="text-xs text-slate-600 dark:text-slate-400 uppercase tracking-widest mt-0.5">
            SIPERKA · MTs Soebono Mantofani
          </p>
        </div>
      </div>

      <div className="bg-surface-card border border-slate-200 dark:border-slate-800 rounded-xl p-8 w-full max-w-sm shadow-xs">
        <p className="text-sm text-slate-600 dark:text-slate-400 text-center mb-6">
          Masukkan alamat email Anda untuk menerima kode OTP verifikasi.
        </p>

        <form onSubmit={handleSubmit} className="flex flex-col gap-4">
          <Input
            label="Email Terdaftar"
            type="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            placeholder="nama@email.com"
            required
            autoComplete="email"
          />

          <Button type="submit" className="w-full mt-2" loading={loading}>
            Kirim Kode OTP
          </Button>
        </form>

        <div className="mt-6 pt-5 border-t border-slate-200 dark:border-slate-800 text-center text-sm">
          <Link
            href="/login"
            className="text-primary-600 hover:text-primary-700 dark:text-primary-400 font-medium"
          >
            Kembali ke Halaman Masuk
          </Link>
        </div>
      </div>
    </div>
  );
}
