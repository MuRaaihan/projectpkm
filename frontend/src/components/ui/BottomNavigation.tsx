// ── BottomNavigation Component ────────────────────────────────
'use client';

import Link from 'next/link';
import { usePathname } from 'next/navigation';
import { Home, FileText, User } from 'lucide-react';

const navItems = [
 { href: '/dashboard', label: 'Beranda', icon: Home },
 { href: '/laporan', label: 'Laporan', icon: FileText },
 { href: '/profil', label: 'Profil', icon: User },
];

export function BottomNavigation() {
 const pathname = usePathname();

 return (
  <nav
   className="lg:hidden fixed bottom-0 left-0 right-0 z-40 border-t transition-theme"
   style={{ backgroundColor: 'var(--topbar-bg)', borderColor: 'var(--topbar-border)' }}
   aria-label="Navigasi utama"
  >
   <div className="max-w-sm mx-auto px-4 flex items-center justify-around h-16">
    {navItems.map(({ href, label, icon: Icon }) => {
     const isActive =
      pathname === href ||
      (href === '/laporan' && pathname.startsWith('/laporan'));

     return (
      <Link
       key={href}
       href={href}
       className="flex flex-col items-center gap-1 py-1 px-4 min-w-[60px] relative transition-colors duration-150"
       aria-current={isActive ? 'page' : undefined}
      >
       {isActive && (
        <span className="absolute -top-0.5 left-1/2 -translate-x-1/2 w-8 h-1 bg-primary-600 rounded-full" />
       )}
       <Icon
        className={`w-5 h-5 transition-all duration-150 ${
         isActive ? 'text-primary-600 scale-110' : 'text-slate-500 dark:text-slate-400'
        }`}
        aria-hidden="true"
       />
       <span className={`text-[10px] font-semibold ${
        isActive ? 'text-primary-600' : 'text-slate-500 dark:text-slate-400'
       }`}>
        {label}
       </span>
      </Link>
     );
    })}
   </div>
  </nav>
 );
}
