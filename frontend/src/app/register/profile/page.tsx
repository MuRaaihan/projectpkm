'use client';

import { useState } from 'react';
import { useRouter } from 'next/navigation';
import { Button } from '@/components/ui/Button';
import { Input } from '@/components/ui/Input';
import { Select } from '@/components/ui/Select';
import { SchoolLogo } from '@/components/ui/SchoolLogo';
import { ThemeToggle } from '@/components/ui/ThemeToggle';
import { mockClasses } from '@/data/mockClasses';

export default function RegisterProfilePage() {
  const router = useRouter();
  const [fullName, setFullName] = useState('');
  const [selectedClass, setSelectedClass] = useState('');
  const [isLoading, setIsLoading] = useState(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setIsLoading(true);
    await new Promise((r) => setTimeout(r, 1000));
    setIsLoading(false);
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
            Lengkapi Profil Siswa
          </h1>
          <p className="text-xs text-slate-600 dark:text-slate-400 uppercase tracking-widest mt-0.5">
            SIPERKA · MTs Soebono Mantofani
          </p>
        </div>
      </div>

      <div className="bg-surface-card border border-slate-200 dark:border-slate-800 rounded-xl p-8 w-full max-w-sm shadow-xs">
        <p className="text-sm text-slate-600 dark:text-slate-400 text-center mb-6">
          Lengkapi data diri Anda untuk menyelesaikan proses pembuatan akun.
        </p>

        <form onSubmit={handleSubmit} className="flex flex-col gap-4">
          <Input
            type="text"
            label="Nama Lengkap"
            placeholder="Masukkan nama lengkap siswa"
            value={fullName}
            onChange={(e) => setFullName(e.target.value)}
            required
            disabled={isLoading}
          />

          <Select
            label="Kelas"
            options={mockClasses}
            value={selectedClass}
            onChange={(e) => setSelectedClass(e.target.value)}
            required
            disabled={isLoading}
          />

          <Button type="submit" className="w-full mt-4" loading={isLoading}>
            Selesaikan Pendaftaran
          </Button>
        </form>
      </div>
    </div>
  );
}
