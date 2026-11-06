// ── ThemeToggle ───────────────────────────────────────────────
"use client";

import { Moon, Sun } from "lucide-react";
import { useTheme } from "@/components/ThemeProvider";

interface ThemeToggleProps {
 className?: string;
}

export function ThemeToggle({ className = "" }: ThemeToggleProps) {
 const { isDark, setTheme } = useTheme();

 return (
 <button
 onClick={() => setTheme(isDark ? "light" : "dark")}
 className={`w-8 h-8 flex items-center justify-center rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400 transition-colors duration-150 ${className}`}
 aria-label={isDark ? "Mode Terang" : "Mode Gelap"}
 title={isDark ? "Mode Terang" : "Mode Gelap"}
 >
 {isDark ? (
 <Sun className="w-4 h-4 text-amber-600" aria-hidden="true" />
 ) : (
 <Moon className="w-4 h-4" aria-hidden="true" />
 )}
 </button>
 );
}
