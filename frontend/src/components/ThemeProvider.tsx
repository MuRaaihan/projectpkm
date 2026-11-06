"use client";

import { createContext, useContext, useEffect, useState } from "react";

type Theme = "dark" | "light" | "system";

type ThemeProviderProps = {
 children: React.ReactNode;
};

type ThemeProviderState = {
 theme: Theme;
 setTheme: (theme: Theme) => void;
 isDark: boolean;
};

const initialState: ThemeProviderState = {
 theme: "system",
 setTheme: () => null,
 isDark: false,
};

const ThemeProviderContext = createContext<ThemeProviderState>(initialState);

export function ThemeProvider({ children }: ThemeProviderProps) {
 const [theme, setTheme] = useState<Theme>("light");
 const [isDark, setIsDark] = useState(false);
 const [mounted, setMounted] = useState(false);

 useEffect(() => {
 const stored = localStorage.getItem("ui-theme") as Theme | null;
 if (stored) {
 setTheme(stored);
 }
 setMounted(true);
 }, []);

 useEffect(() => {
 if (!mounted) return;

 const root = window.document.documentElement;
 root.classList.remove("light", "dark");

 let activeTheme = theme;
 if (theme === "system") {
 activeTheme = window.matchMedia("(prefers-color-scheme: dark)").matches
 ? "dark"
 : "light";
 }

 root.classList.add(activeTheme);
 setIsDark(activeTheme === "dark");

 // Add CSS variables for dark mode manually if needed, but Tailwind 4 using .dark selector
 // handles color overrides via globals.css properly if we use dark: or CSS custom properties under .dark
 }, [theme, mounted]);

 const value = {
 theme,
 setTheme: (theme: Theme) => {
 localStorage.setItem("ui-theme", theme);
 setTheme(theme);
 },
 isDark,
 };

 return (
 <ThemeProviderContext.Provider value={value}>
 {children}
 </ThemeProviderContext.Provider>
 );
}

export const useTheme = () => {
 const context = useContext(ThemeProviderContext);
 if (context === undefined)
 throw new Error("useTheme must be used within a ThemeProvider");
 return context;
};
