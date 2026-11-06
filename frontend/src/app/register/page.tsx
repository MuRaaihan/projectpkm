'use client';

import { useState } from 'react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';
import { Button } from '@/components/ui/Button';
import { Input } from '@/components/ui/Input';
import { SchoolLogo } from '@/components/ui/SchoolLogo';
import { ThemeToggle } from '@/components/ui/ThemeToggle';

export default function RegisterPage() {
  const router = useRouter();
  const [email, setEmail] = useState('');
  const [isLoading, setIsLoading] = useState(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setIsLoading(true);
    await new Promise((r) => setTimeout(r, 800));
    setIsLoading(false);
    router.push('/register/otp');
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
            Pendaftaran Siswa
          </h1>
          <p className="text-xs text-slate-600 dark:text-slate-400 uppercase tracking-widest mt-0.5">
            SIPERKA · MTs Soebono Mantofani
          </p>
        </div>
      </div>

      <div className="bg-surface-card border border-slate-200 dark:border-slate-800 rounded-xl p-8 w-full max-w-sm shadow-xs">
        <p className="text-sm text-slate-600 dark:text-slate-400 text-center mb-6">
          Masukkan alamat email aktif Anda untuk memulai proses pendaftaran akun siswa.
        </p>

        <form onSubmit={handleSubmit} className="flex flex-col gap-4">
          <Input
            type="email"
            label="Email Siswa"
            placeholder="nama@email.com"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            required
            disabled={isLoading}
            autoComplete="email"
          />

          <Button type="submit" className="w-full mt-2" loading={isLoading}>
            Lanjutkan Verifikasi
          </Button>

          <div className="mt-4 pt-4 border-t border-slate-200 dark:border-slate-800 text-center text-sm">
            <span className="text-slate-600 dark:text-slate-400">Sudah punya akun? </span>
            <Link 
              href="/login" 
              className="font-semibold text-primary-600 hover:text-primary-700 dark:text-primary-400"
            >
              Masuk di sini
            </Link>
          </div>
        </form>
      </div>
    </div>
  );
}
