// ── SideNav — Desktop Sidebar Navigation (Student) ────────────
'use client';

import Link from 'next/link';
import { usePathname } from 'next/navigation';
import { Home, FileText, User } from 'lucide-react';
import { SchoolLogo } from './SchoolLogo';
import { ThemeToggle } from './ThemeToggle';
import { currentUser } from '@/data/mockData';

const navItems = [
  { href: '/dashboard', label: 'Beranda', icon: Home },
  { href: '/laporan', label: 'Laporan Saya', icon: FileText },
  { href: '/profil', label: 'Profil', icon: User },
];

export function SideNav() {
  const pathname = usePathname();

  if (pathname === '/login') return null;

  return (
    <aside
      className="hidden lg:flex flex-col w-64 min-h-screen border-r fixed top-0 left-0 z-40 transition-theme"
      style={{ backgroundColor: 'var(--sidebar-bg)', borderColor: 'var(--sidebar-border)' }}
      aria-label="Navigasi utama"
    >
      {/* Brand */}
      <div
        className="h-16 flex items-center px-5 border-b shrink-0"
        style={{ borderColor: 'var(--sidebar-border)' }}
      >
        <Link href="/dashboard" className="flex items-center gap-3 min-w-0 group">
          <SchoolLogo size="sm" />
          <div className="min-w-0">
            <p className="text-sm font-black text-slate-900 dark:text-slate-100 leading-tight truncate">
              SIPERKA
            </p>
            <p className="text-[10px] font-semibold text-slate-500 dark:text-slate-400 leading-tight truncate">
              Ruang Aman Siswa
            </p>
          </div>
        </Link>
      </div>

      {/* Nav */}
      <nav className="flex-1 py-4 px-3 flex flex-col gap-1 overflow-y-auto" aria-label="Menu utama">
        <p className="px-2.5 mb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
          Navigasi
        </p>
        {navItems.map(({ href, label, icon: Icon }) => {
          const isActive =
            pathname === href ||
            (href === '/laporan' && pathname.startsWith('/laporan'));

          return (
            <Link
              key={href}
              href={href}
              aria-current={isActive ? 'page' : undefined}
              className={[
                'relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150 group',
                isActive
                  ? 'text-primary-700 dark:text-[#5AE39D]'
                  : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-slate-200',
              ].join(' ')}
              style={isActive ? {
                backgroundColor: 'var(--sidebar-active-bg)',
              } : {}}
            >
              {isActive && (
                <span className="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-primary-600 dark:bg-[#5AE39D] rounded-r-md" />
              )}
              <Icon
                className={`w-4 h-4 shrink-0 transition-colors ${
                  isActive
                    ? 'text-primary-600 dark:text-[#5AE39D]'
                    : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-700 dark:group-hover:text-slate-300'
                }`}
                aria-hidden="true"
              />
              <span>{label}</span>
            </Link>
          );
        })}
      </nav>

      {/* User area */}
      <div
        className="px-3 py-4 border-t flex items-center justify-between gap-2"
        style={{ borderColor: 'var(--sidebar-border)' }}
      >
        <Link
          href="/profil"
          className="flex items-center gap-3 px-2 py-1.5 rounded-xl hover:bg-slate-100/70 dark:hover:bg-slate-800/60 transition-colors flex-1 min-w-0 group cursor-pointer"
        >
          <div className="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center shrink-0 shadow-2xs">
            <span className="text-xs font-bold text-white">{currentUser.avatarInitials}</span>
          </div>
          <div className="flex-1 min-w-0">
            <p className="text-xs font-bold text-slate-900 dark:text-slate-100 truncate">{currentUser.name}</p>
            <p className="text-[10px] text-slate-500 dark:text-slate-400 truncate">Siswa</p>
          </div>
        </Link>
        <ThemeToggle />
      </div>
    </aside>
  );
}
