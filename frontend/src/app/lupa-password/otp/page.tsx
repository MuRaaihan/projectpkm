'use client';

import { useState } from 'react';
import { useRouter } from 'next/navigation';
import { Button } from '@/components/ui/Button';
import { OTPInput } from '@/components/ui/OTPInput';
import { SchoolLogo } from '@/components/ui/SchoolLogo';
import { ThemeToggle } from '@/components/ui/ThemeToggle';

export default function LupaPasswordOTPPage() {
  const router = useRouter();
  const [otp, setOtp] = useState('');
  const [loading, setLoading] = useState(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    await new Promise((r) => setTimeout(r, 800));
    setLoading(false);
    router.push('/lupa-password/reset');
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
            Verifikasi OTP
          </h1>
          <p className="text-xs text-slate-600 dark:text-slate-400 uppercase tracking-widest mt-0.5">
            SIPERKA · MTs Soebono Mantofani
          </p>
        </div>
      </div>

      <div className="bg-surface-card border border-slate-200 dark:border-slate-800 rounded-xl p-8 w-full max-w-sm shadow-xs">
        <p className="text-sm text-slate-600 dark:text-slate-400 text-center mb-6">
          Masukkan 6 digit kode OTP verifikasi yang dikirimkan ke email Anda.
        </p>

        <form onSubmit={handleSubmit} className="flex flex-col gap-6">
          <div className="flex flex-col gap-2">
            <label className="block text-sm font-semibold text-slate-900 dark:text-slate-100">
              Kode OTP
            </label>
            <OTPInput
              value={otp}
              onChange={setOtp}
              length={6}
              disabled={loading}
            />
          </div>

          <Button type="submit" className="w-full mt-2" loading={loading}>
            Verifikasi Kode
          </Button>
        </form>
      </div>
    </div>
  );
}
