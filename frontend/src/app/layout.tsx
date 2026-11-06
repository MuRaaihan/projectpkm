import type { Metadata, Viewport } from "next";
import { Inter } from "next/font/google";
import "./globals.css";

const inter = Inter({
 subsets: ["latin"],
 variable: "--font-sans",
 display: "swap",
});

export const metadata: Metadata = {
 title: "SIPERKA",
 description:
 "Platform pelaporan Perundungan yang aman, rahasia, dan terstruktur untuk siswa.",
 icons: {
 icon: "/favicon.ico",
 },
};

export const viewport: Viewport = {
 width: "device-width",
 initialScale: 1,
 maximumScale: 1,
};

import { ThemeProvider } from "@/components/ThemeProvider";

export default function RootLayout({
 children,
}: {
 children: React.ReactNode;
}) {
 return (
 <html
 lang="id"
 className={`${inter.variable} h-full`}
 suppressHydrationWarning
 >
 <head>
 <script
 dangerouslySetInnerHTML={{
 __html: `
 try {
 if (localStorage.getItem('ui-theme') === 'dark' || (!('ui-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
 document.documentElement.classList.add('dark')
 } else {
 document.documentElement.classList.remove('dark')
 }
 } catch (_) {}
 `,
 }}
 />
 </head>
 <body className="min-h-full bg-surface antialiased transition-colors duration-200">
 <ThemeProvider>{children}</ThemeProvider>
 </body>
 </html>
 );
}
