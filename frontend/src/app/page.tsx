"use client";

import { useState, useEffect } from "react";
import Image from "next/image";
import Link from "next/link";
import {
  Menu,
  X,
  ArrowRight,
  MessageSquare,
  Search,
  CheckCircle,
  Lock,
  Users,
  ShieldCheck,
  Settings,
  Check,
  Home,
  FileText,
  User as UserIcon,
  LogIn,
  Send,
  UserCheck,
  CircleCheck,
  Calendar,
  MapPin,
  Clock,
  ChevronRight,
  FilePlus,
} from "lucide-react";

import { Button } from "@/components/ui/Button";
import { SchoolLogo } from "@/components/ui/SchoolLogo";
import { ThemeToggle } from "@/components/ui/ThemeToggle";

/* =========================================================
   HERO ILLUSTRATION
   ========================================================= */

function ReportingIllustration() {
  return (
    <div className="relative flex items-center justify-center min-h-[420px] lg:min-h-[520px]">
      {/* Background shape */}
      <div className="absolute w-[340px] h-[340px] sm:w-[440px] sm:h-[440px] rounded-full bg-primary-50/80 dark:bg-primary-900/20 border border-primary-100/60 dark:border-primary-800/40" />

      {/* Decorative accents */}
      <div className="absolute top-10 right-8 w-3.5 h-3.5 rounded-full bg-lime-400 shadow-xs" />
      <div className="absolute bottom-16 left-8 w-3 h-3 rounded-full bg-amber-400 shadow-xs" />
      <div className="absolute top-24 left-6 w-4 h-4 rounded-full border-2 border-primary-400" />

      {/* Gambar Hero SIPERKA */}
      <div className="relative z-10 w-full max-w-[500px]">
        <Image
          src="/siperka-hero-v3.png"
          alt="Siswa melaporkan perundungan kepada Guru BK melalui SIPERKA"
          width={670}
          height={670}
          priority
          className="w-full h-auto object-contain"
        />
      </div>
    </div>
  );
}

/* =========================================================
   PHONE MOCKUP COMPONENT
   ========================================================= */

type PhoneMockupType =
  | "login"
  | "dashboard"
  | "buat"
  | "konfirmasi"
  | "sukses"
  | "status";

function PhoneMockup({ type }: { type: PhoneMockupType }) {
  return (
    <div className="relative w-[215px] sm:w-[225px] lg:w-[230px] mx-auto select-none">
      {/* Soft Ground Shadow */}
      <div className="absolute -bottom-4 left-1/2 -translate-x-1/2 w-[160px] h-6 rounded-full bg-black/15 dark:bg-black/40 blur-lg pointer-events-none" />

      {/* iPhone Frame */}
      <div
        className="
          relative
          rounded-[2.8rem]
          bg-[#141A17]
          p-[5px]
          shadow-[0_16px_40px_rgba(20,26,23,0.35)]
          border border-[#2C3831]
        "
      >
        {/* Side Buttons */}
        <div className="absolute -left-[4px] top-24 w-[3.5px] h-8 rounded-l-md bg-[#2C3831]" />
        <div className="absolute -left-[4px] top-36 w-[3.5px] h-12 rounded-l-md bg-[#2C3831]" />
        <div className="absolute -right-[4px] top-32 w-[3.5px] h-16 rounded-r-md bg-[#2C3831]" />

        {/* Screen */}
        <div
          className="
            relative
            overflow-hidden
            rounded-[2.5rem]
            bg-[#F8FAF9]
            aspect-[9/19.2]
            flex flex-col
          "
        >
          {/* Dynamic Island */}
          <div className="absolute z-50 top-[9px] left-1/2 -translate-x-1/2 pointer-events-none">
            <div className="w-[68px] h-[19px] rounded-full bg-black flex items-center justify-end pr-2">
              <div className="w-[4.5px] h-[4.5px] rounded-full bg-[#1F2C24]" />
            </div>
          </div>

          {/* Status Bar */}
          <div className="h-9 shrink-0 z-40 flex items-center justify-between px-5 pt-2 text-[8.5px] font-semibold text-slate-800">
            <span>08:24</span>
            <div className="flex items-center gap-1 text-[7px]">
              <span>LTE</span>
              <span>100%</span>
            </div>
          </div>

          {/* ====================================================== */}
          {/* 01. LOGIN (Universal Auth /login) */}
          {/* ====================================================== */}
          {type === "login" && (
            <div className="flex-1 flex flex-col justify-center bg-[#EDECEA] px-3.5 pb-3 text-center">
              <div className="flex justify-center mb-1">
                <div className="w-8 h-8 rounded-xl bg-white border border-slate-300 flex items-center justify-center shadow-xs">
                  <SchoolLogo size="sm" withText={false} />
                </div>
              </div>

              <p className="text-[10px] font-black text-slate-900 tracking-tight leading-tight">
                SIPERKA
              </p>
              <p className="text-[5px] font-bold text-slate-500 uppercase tracking-widest mt-0.5">
                Sistem Pelaporan Sekolah
              </p>

              <div className="mt-2 bg-white border border-slate-200/90 rounded-2xl p-2.5 text-left shadow-xs">
                <div className="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full bg-primary-100 text-primary-800 text-[5px] font-bold mb-1 border border-primary-200">
                  <span className="w-1.5 h-1.5 rounded-full bg-primary-600" />
                  Portal Masuk Universal
                </div>

                <p className="text-[7.5px] font-extrabold text-slate-900 leading-tight">
                  Masuk ke Akun
                </p>
                <p className="text-[5px] text-slate-500 mt-0.5 leading-tight">
                  Gunakan email atau identitas resmi terdaftar.
                </p>

                <label className="block text-[5px] font-bold text-slate-700 mt-2">
                  Email / Identitas
                </label>
                <div className="h-6 mt-0.5 border border-slate-200 rounded-lg px-2 flex items-center bg-slate-50/80">
                  <span className="text-[5.5px] text-slate-600">
                    siswa@sekolah.sch.id
                  </span>
                </div>

                <label className="block text-[5px] font-bold text-slate-700 mt-1.5">
                  Kata Sandi
                </label>
                <div className="h-6 mt-0.5 border border-slate-200 rounded-lg px-2 flex items-center justify-between bg-slate-50/80">
                  <span className="text-[5.5px] text-slate-400">••••••••</span>
                  <span className="text-[6px] text-slate-400">👁</span>
                </div>

                <div className="flex items-center justify-between mt-1.5">
                  <span className="text-[4.5px] text-slate-500">Ingat saya</span>
                  <span className="text-[4.5px] font-semibold text-primary-600">
                    Lupa sandi?
                  </span>
                </div>

                <div className="w-full h-6.5 mt-2 rounded-xl bg-primary-600 flex items-center justify-center text-white text-[6.5px] font-bold shadow-xs">
                  Masuk ke SIPERKA
                </div>

                <p className="text-[4.5px] text-center text-slate-500 mt-1.5">
                  Belum punya akun?{" "}
                  <span className="font-bold text-primary-600">Daftar</span>
                </p>
              </div>
            </div>
          )}

          {/* ====================================================== */}
          {/* 02. DASHBOARD (Student Home /dashboard) */}
          {/* ====================================================== */}
          {type === "dashboard" && (
            <div className="flex-1 flex flex-col bg-[#F8FAF9] overflow-hidden text-left">
              {/* AppHeader Mobile */}
              <div className="h-[36px] shrink-0 bg-white border-b border-slate-200/90 flex items-center justify-between px-3">
                <div className="flex items-center gap-1.5">
                  <SchoolLogo size="sm" withText={false} />
                  <div>
                    <p className="text-[7.5px] font-black text-slate-900 leading-tight">
                      SIPERKA
                    </p>
                    <p className="text-[4.5px] text-slate-400 leading-tight">
                      Ruang Aman Siswa
                    </p>
                  </div>
                </div>

                <div className="w-5 h-5 rounded-full bg-primary-600 text-white text-[6px] font-bold flex items-center justify-center">
                  AF
                </div>
              </div>

              {/* Main Content */}
              <div className="flex-1 overflow-hidden px-3 pt-2 flex flex-col gap-2">
                {/* Greeting Banner */}
                <div className="bg-gradient-to-br from-[#EAF5EE] to-[#F0EFE8] border border-primary-200/70 rounded-xl p-2.5">
                  <div className="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full bg-white/90 text-primary-800 text-[4.5px] font-bold">
                    <span className="w-1.5 h-1.5 rounded-full bg-primary-600" />
                    Ruang Aman Siswa
                  </div>
                  <p className="text-[8.5px] font-black text-slate-900 mt-1 leading-tight">
                    Halo, Ahmad Fauzi 👋
                  </p>
                  <p className="text-[5px] text-slate-600 leading-tight mt-0.5">
                    Suaramu sangat berarti untuk sekolah aman.
                  </p>

                  <div className="mt-2 bg-primary-600 rounded-lg p-1.5 text-white flex items-center justify-between shadow-2xs">
                    <div className="flex items-center gap-1.5">
                      <div className="w-5 h-5 rounded-md bg-[#B8E34B] text-[#176B4D] flex items-center justify-center shrink-0">
                        <FilePlus className="w-3 h-3 text-[#176B4D]" />
                      </div>
                      <div>
                        <p className="text-[6.5px] font-extrabold leading-tight">
                          Buat Laporan Baru
                        </p>
                        <p className="text-[4.5px] text-emerald-100">
                          Bisa opsi anonim
                        </p>
                      </div>
                    </div>
                    <ChevronRight className="w-3 h-3 text-emerald-200" />
                  </div>
                </div>

                {/* KPI Metrics */}
                <div className="grid grid-cols-3 gap-1.5">
                  <div className="bg-white border border-slate-200 rounded-lg p-1.5 text-center shadow-2xs">
                    <p className="text-[9px] font-black text-primary-700">4</p>
                    <p className="text-[4.5px] text-slate-500 font-semibold">Total</p>
                  </div>
                  <div className="bg-white border border-slate-200 rounded-lg p-1.5 text-center shadow-2xs">
                    <p className="text-[9px] font-black text-amber-600">2</p>
                    <p className="text-[4.5px] text-slate-500 font-semibold">Diproses</p>
                  </div>
                  <div className="bg-white border border-slate-200 rounded-lg p-1.5 text-center shadow-2xs">
                    <p className="text-[9px] font-black text-emerald-600">1</p>
                    <p className="text-[4.5px] text-slate-500 font-semibold">Selesai</p>
                  </div>
                </div>

                {/* Recent Report */}
                <div className="bg-white border border-slate-200 rounded-xl p-2 shadow-2xs">
                  <div className="flex items-center justify-between mb-1">
                    <span className="text-[5px] font-bold text-slate-400 uppercase tracking-wider">
                      Laporan Terkini
                    </span>
                    <span className="text-[4.5px] font-semibold text-primary-600">
                      Lihat Semua
                    </span>
                  </div>
                  <div className="flex items-center justify-between">
                    <div>
                      <p className="text-[6.5px] font-extrabold text-slate-900 leading-tight">
                        Perundungan Verbal
                      </p>
                      <p className="text-[5px] font-mono text-slate-500 mt-0.5">
                        SPK-2026-001
                      </p>
                    </div>
                    <span className="text-[4.5px] font-bold text-primary-700 bg-primary-50 border border-primary-200 px-1.5 py-0.5 rounded-full">
                      Diverifikasi
                    </span>
                  </div>
                </div>
              </div>

              {/* Bottom Nav */}
              <div className="h-[34px] shrink-0 bg-white border-t border-slate-200 flex items-center justify-around">
                <div className="flex flex-col items-center text-primary-600">
                  <Home className="w-2.5 h-2.5" />
                  <span className="text-[4.5px] font-bold">Beranda</span>
                </div>
                <div className="flex flex-col items-center text-slate-400">
                  <FileText className="w-2.5 h-2.5" />
                  <span className="text-[4.5px]">Laporan</span>
                </div>
                <div className="flex flex-col items-center text-slate-400">
                  <UserIcon className="w-2.5 h-2.5" />
                  <span className="text-[4.5px]">Profil</span>
                </div>
              </div>
            </div>
          )}

          {/* ====================================================== */}
          {/* 03. BUAT LAPORAN (/laporan/buat) */}
          {/* ====================================================== */}
          {type === "buat" && (
            <div className="flex-1 flex flex-col bg-[#F8FAF9] overflow-hidden text-left">
              {/* Header */}
              <div className="h-[36px] shrink-0 bg-white border-b border-slate-200 px-3 flex items-center justify-between">
                <span className="text-[7.5px] font-bold text-slate-900">
                  ← Buat Laporan
                </span>
                <span className="text-[5px] font-bold text-primary-700 bg-primary-50 border border-primary-200 px-1.5 py-0.5 rounded-full">
                  Langkah 1/2
                </span>
              </div>

              {/* Progress Steps */}
              <div className="bg-white px-3 py-1.5 border-b border-slate-100 flex items-center justify-between text-[5px]">
                <div className="flex items-center gap-1 font-bold text-primary-700">
                  <span className="w-3 h-3 rounded-full bg-primary-600 text-white flex items-center justify-center text-[4.5px]">
                    1
                  </span>
                  <span>Detail</span>
                </div>
                <div className="w-8 h-0.5 bg-slate-200" />
                <div className="flex items-center gap-1 text-slate-400">
                  <span className="w-3 h-3 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center text-[4.5px]">
                    2
                  </span>
                  <span>Ringkasan</span>
                </div>
              </div>

              {/* Form Content */}
              <div className="flex-1 overflow-hidden px-3 pt-2 flex flex-col gap-1.5">
                <div>
                  <span className="text-[5px] font-bold text-slate-700">
                    Kategori Perundungan
                  </span>
                  <div className="h-5.5 mt-0.5 bg-white border border-slate-200 rounded-md px-1.5 flex items-center justify-between text-[5.5px] text-slate-800 font-medium">
                    <span>Perundungan Verbal</span>
                    <span className="text-slate-400 text-[6px]">⌄</span>
                  </div>
                </div>

                <div className="grid grid-cols-2 gap-1.5">
                  <div>
                    <span className="text-[5px] font-bold text-slate-700">
                      Tanggal
                    </span>
                    <div className="h-5.5 mt-0.5 bg-white border border-slate-200 rounded-md px-1.5 flex items-center gap-1 text-[5px] text-slate-700">
                      <Calendar className="w-2.5 h-2.5 text-slate-400" />
                      <span>12 Sep 2026</span>
                    </div>
                  </div>
                  <div>
                    <span className="text-[5px] font-bold text-slate-700">
                      Lokasi
                    </span>
                    <div className="h-5.5 mt-0.5 bg-white border border-slate-200 rounded-md px-1.5 flex items-center gap-1 text-[5px] text-slate-700">
                      <MapPin className="w-2.5 h-2.5 text-slate-400" />
                      <span className="truncate">Lapangan</span>
                    </div>
                  </div>
                </div>

                <div>
                  <div className="flex justify-between text-[5px] font-bold text-slate-700">
                    <span>Kronologi Kejadian</span>
                    <span className="text-slate-400 font-normal">184/1000</span>
                  </div>
                  <div className="h-13 mt-0.5 bg-white border border-slate-200 rounded-md p-1.5 text-[5px] text-slate-700 leading-tight">
                    Teman sekelas sering mengejek nama dan memanggil sebutan tidak pantas...
                  </div>
                </div>

                <div>
                  <span className="text-[5px] font-bold text-slate-700">
                    Pihak Terlibat (Opsional)
                  </span>
                  <div className="h-5 mt-0.5 bg-white border border-slate-200 rounded-md px-1.5 flex items-center text-[5px] text-slate-400">
                    Siswa kelas 10-B
                  </div>
                </div>
              </div>

              {/* Action Buttons */}
              <div className="h-[36px] shrink-0 bg-white border-t border-slate-200 px-3 flex items-center gap-1.5">
                <div className="flex-1 h-6 rounded-lg border border-slate-200 text-[5px] font-bold text-slate-600 flex items-center justify-center">
                  Batal
                </div>
                <div className="flex-1 h-6 rounded-lg bg-primary-600 text-[5px] font-bold text-white flex items-center justify-center shadow-xs">
                  Lanjutkan →
                </div>
              </div>
            </div>
          )}

          {/* ====================================================== */}
          {/* 04. PERIKSA DETAIL / KONFIRMASI (/laporan/konfirmasi) */}
          {/* ====================================================== */}
          {type === "konfirmasi" && (
            <div className="flex-1 flex flex-col bg-[#F8FAF9] overflow-hidden text-left">
              {/* Header */}
              <div className="h-[36px] shrink-0 bg-white border-b border-slate-200 px-3 flex items-center justify-between">
                <span className="text-[7.5px] font-bold text-slate-900">
                  ← Ringkasan Laporan
                </span>
                <span className="text-[5px] font-bold text-primary-700 bg-primary-50 border border-primary-200 px-1.5 py-0.5 rounded-full">
                  Langkah 2/2
                </span>
              </div>

              {/* Content */}
              <div className="flex-1 overflow-hidden px-3 pt-2 flex flex-col gap-2">
                <div className="bg-white border border-slate-200 rounded-xl p-2 shadow-2xs">
                  <p className="text-[6.5px] font-extrabold text-slate-900 leading-tight">
                    Ringkasan Detail Kasus
                  </p>
                  <p className="text-[4.5px] text-slate-500 mb-1.5">
                    Pastikan detail sudah sesuai sebelum dikirim.
                  </p>

                  <div className="bg-slate-50 border border-slate-200/80 rounded-lg divide-y divide-slate-200/60 text-[5px]">
                    <div className="p-1 flex justify-between">
                      <span className="text-slate-500">Kategori:</span>
                      <span className="font-bold text-slate-800">
                        Perundungan Verbal
                      </span>
                    </div>
                    <div className="p-1 flex justify-between">
                      <span className="text-slate-500">Tanggal:</span>
                      <span className="font-semibold text-slate-800">
                        12 Sep 2026
                      </span>
                    </div>
                    <div className="p-1 flex justify-between">
                      <span className="text-slate-500">Lokasi:</span>
                      <span className="font-semibold text-slate-800">
                        Lapangan Olahraga
                      </span>
                    </div>
                    <div className="p-1">
                      <span className="text-slate-500 block mb-0.5">Kronologi:</span>
                      <p className="text-[4.5px] text-slate-700 leading-tight">
                        Ejekan berulang kali saat jam istirahat.
                      </p>
                    </div>
                  </div>
                </div>

                {/* Privacy Card Component */}
                <div className="bg-primary-50/70 border border-primary-200/80 rounded-xl p-2 shadow-2xs">
                  <div className="flex items-center gap-1.5 mb-1">
                    <Lock className="w-2.5 h-2.5 text-primary-700" />
                    <span className="text-[5.5px] font-bold text-primary-900">
                      Opsi Privasi Pelapor
                    </span>
                  </div>
                  <div className="bg-white rounded-lg p-1.5 border border-primary-200 flex items-start gap-1.5">
                    <div className="w-2.5 h-2.5 rounded-full bg-primary-600 text-white flex items-center justify-center text-[4px] font-bold shrink-0 mt-0.5">
                      ✓
                    </div>
                    <div>
                      <p className="text-[5px] font-bold text-slate-900">
                        Sembunyikan Identitas (Anonim)
                      </p>
                      <p className="text-[4px] text-slate-500 leading-tight mt-0.5">
                        Identitasmu dirahasiakan dan hanya ditangani Guru BK.
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              {/* Action Buttons */}
              <div className="h-[36px] shrink-0 bg-white border-t border-slate-200 px-3 flex items-center gap-1.5">
                <div className="flex-1 h-6 rounded-lg border border-slate-200 text-[5px] font-bold text-slate-600 flex items-center justify-center">
                  Kembali
                </div>
                <div className="flex-1 h-6 rounded-lg bg-primary-600 text-[5px] font-bold text-white flex items-center justify-center shadow-xs">
                  Kirim Laporan
                </div>
              </div>
            </div>
          )}

          {/* ====================================================== */}
          {/* 05. LAPORAN BERHASIL (/laporan/sukses) */}
          {/* ====================================================== */}
          {type === "sukses" && (
            <div className="flex-1 flex flex-col items-center justify-center bg-[#F8FAF9] text-center px-3.5">
              <div className="w-11 h-11 rounded-full bg-primary-100 border-2 border-primary-200 text-primary-600 flex items-center justify-center shadow-xs">
                <CheckCircle className="w-6 h-6 text-primary-600" />
              </div>

              <p className="text-[9px] font-black text-slate-900 mt-2">
                Laporan Berhasil Dikirim!
              </p>
              <p className="text-[5px] text-slate-500 mt-0.5 leading-tight max-w-[150px]">
                Laporanmu telah diterima sistem dan segera ditindaklanjuti Guru BK.
              </p>

              <div className="mt-2.5 bg-white border border-slate-200 rounded-xl px-3 py-2 w-full max-w-[150px] shadow-2xs">
                <p className="text-[4.5px] font-bold text-slate-400 uppercase tracking-wider">
                  Nomor Registrasi Laporan
                </p>
                <p className="text-[8px] font-extrabold font-mono text-primary-700 tracking-wider mt-0.5">
                  SPK-2026-004
                </p>
                <p className="text-[4px] text-slate-400 mt-0.5">
                  Simpan nomor ini untuk memantau status
                </p>
              </div>

              <div className="mt-2.5 w-full max-w-[150px] h-6 rounded-lg bg-primary-600 text-white text-[5.5px] font-bold flex items-center justify-center shadow-xs">
                Pantau Status Laporan →
              </div>

              <p className="text-[4.5px] text-slate-500 font-semibold mt-1.5">
                Kembali ke Beranda
              </p>
            </div>
          )}

          {/* ====================================================== */}
          {/* 06. STATUS & PANTAU LAPORAN (/laporan/[id]) */}
          {/* ====================================================== */}
          {type === "status" && (
            <div className="flex-1 flex flex-col bg-[#F8FAF9] overflow-hidden text-left">
              {/* Header */}
              <div className="h-[36px] shrink-0 bg-white border-b border-slate-200 px-3 flex items-center justify-between">
                <span className="text-[7.5px] font-bold text-slate-900">
                  ← Detail Laporan
                </span>
                <span className="text-[5px] font-bold text-amber-700 bg-amber-50 border border-amber-200 px-1.5 py-0.5 rounded-full">
                  Proses
                </span>
              </div>

              {/* Content */}
              <div className="flex-1 overflow-hidden px-3 pt-2 flex flex-col gap-2">
                {/* Summary Card */}
                <div className="bg-white border border-slate-200 rounded-xl p-2 shadow-2xs">
                  <div className="flex items-center justify-between">
                    <div>
                      <p className="text-[4.5px] font-mono text-slate-400">
                        SPK-2026-004
                      </p>
                      <p className="text-[6.5px] font-black text-slate-900 leading-tight">
                        Perundungan Verbal
                      </p>
                    </div>
                    <span className="text-[4.5px] font-bold text-amber-800 bg-amber-100/80 border border-amber-300 px-1.5 py-0.5 rounded-full">
                      Dalam Penanganan
                    </span>
                  </div>
                </div>

                {/* Timeline Card */}
                <div className="bg-white border border-slate-200 rounded-xl p-2 shadow-2xs">
                  <p className="text-[5.5px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">
                    Tahapan Penanganan
                  </p>

                  <div className="space-y-1.5">
                    {/* Step 1 */}
                    <div className="flex items-start gap-1.5">
                      <div className="w-3.5 h-3.5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[4.5px] font-bold shrink-0 mt-0.5">
                        ✓
                      </div>
                      <div>
                        <p className="text-[5.5px] font-bold text-slate-900 leading-tight">
                          Laporan Diterima
                        </p>
                        <p className="text-[4.5px] text-slate-400">
                          12 Sep 2026 · 10:24
                        </p>
                      </div>
                    </div>

                    <div className="ml-1.5 h-2 border-l-2 border-emerald-300" />

                    {/* Step 2 */}
                    <div className="flex items-start gap-1.5">
                      <div className="w-3.5 h-3.5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[4.5px] font-bold shrink-0 mt-0.5">
                        ✓
                      </div>
                      <div>
                        <p className="text-[5.5px] font-bold text-slate-900 leading-tight">
                          Verifikasi Guru BK
                        </p>
                        <p className="text-[4.5px] text-slate-400">
                          13 Sep 2026 · 09:15
                        </p>
                      </div>
                    </div>

                    <div className="ml-1.5 h-2 border-l-2 border-amber-300" />

                    {/* Step 3 */}
                    <div className="flex items-start gap-1.5">
                      <div className="w-3.5 h-3.5 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center text-[4.5px] font-bold shrink-0 mt-0.5">
                        ⏳
                      </div>
                      <div>
                        <p className="text-[5.5px] font-bold text-slate-900 leading-tight">
                          Tindak Lanjut & Konseling
                        </p>
                        <p className="text-[4.5px] text-amber-700 font-medium">
                          Sedang Berlangsung
                        </p>
                      </div>
                    </div>
                  </div>
                </div>

                {/* Counselor Note */}
                <div className="bg-[#EAF5EE] border border-primary-200/80 rounded-xl p-2">
                  <p className="text-[5px] font-bold text-primary-800">
                    Catatan Guru BK:
                  </p>
                  <p className="text-[4.5px] text-slate-700 mt-0.5 leading-tight">
                    Jadwal pendampingan telah dikoordinasikan. Siswa dijadwalkan sesi konseling tertutup.
                  </p>
                </div>
              </div>
            </div>
          )}
        </div>
      </div>
    </div>
  );
}

/* =========================================================
   MAIN LANDING PAGE
   ========================================================= */

export default function LandingPage() {
  const [isScrolled, setIsScrolled] = useState(false);
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 20);
    };

    window.addEventListener("scroll", handleScroll);
    return () => {
      window.removeEventListener("scroll", handleScroll);
    };
  }, []);

  const closeMenu = () => {
    setMobileMenuOpen(false);
  };

  return (
    <div className="min-h-screen bg-[#F8FAF9] text-slate-900 flex flex-col font-sans selection:bg-primary-200 selection:text-primary-900 dark:bg-[#0B110E] dark:text-slate-100">
      {/* =====================================================
          NAVBAR
          ===================================================== */}
      <header
        className={`fixed top-0 left-0 right-0 z-50 transition-all duration-300 border-b ${
          isScrolled
            ? "bg-white/95 backdrop-blur-md border-slate-200 shadow-xs dark:bg-[#0B110E]/95 dark:border-slate-800"
            : "bg-white/85 backdrop-blur-md border-slate-200/80 dark:bg-[#0B110E]/85 dark:border-slate-800"
        }`}
      >
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex items-center justify-between h-16">
            {/* Brand Logo */}
            <div className="flex items-center gap-3">
              <SchoolLogo size="sm" />
              <div className="flex flex-col">
                <span className="font-extrabold text-base sm:text-lg text-slate-900 dark:text-slate-100 tracking-tight leading-tight">
                  SIPERKA
                </span>
                <span className="text-[9px] uppercase tracking-wider text-slate-500 dark:text-slate-400 font-semibold hidden sm:inline">
                  Sistem Pelaporan Sekolah
                </span>
              </div>
            </div>

            {/* Desktop Navigation */}
            <nav className="hidden md:flex items-center gap-8">
              <a
                href="#tentang"
                className="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors"
              >
                Tentang
              </a>
              <a
                href="#cara-kerja"
                className="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors"
              >
                Cara Kerja
              </a>
              <a
                href="#pengguna"
                className="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors"
              >
                Fitur Peran
              </a>
            </nav>

            {/* Right Actions */}
            <div className="hidden md:flex items-center gap-3">
              <ThemeToggle />
              <Link href="/login">
                <Button variant="primary" size="sm">
                  Lapor Sekarang
                </Button>
              </Link>
            </div>

            {/* Mobile Actions */}
            <div className="flex md:hidden items-center gap-2">
              <ThemeToggle />
              <button
                onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                className="p-2 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg"
                aria-label="Toggle menu"
              >
                {mobileMenuOpen ? (
                  <X className="w-5 h-5" />
                ) : (
                  <Menu className="w-5 h-5" />
                )}
              </button>
            </div>
          </div>
        </div>

        {/* Mobile Menu Dropdown */}
        {mobileMenuOpen && (
          <div className="md:hidden absolute top-16 left-0 right-0 bg-white dark:bg-[#101713] border-b border-slate-200 dark:border-slate-800 shadow-md p-4 flex flex-col gap-3">
            <a
              href="#tentang"
              onClick={closeMenu}
              className="block font-medium text-slate-700 dark:text-slate-200 p-2 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg"
            >
              Tentang
            </a>
            <a
              href="#cara-kerja"
              onClick={closeMenu}
              className="block font-medium text-slate-700 dark:text-slate-200 p-2 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg"
            >
              Cara Kerja
            </a>
            <a
              href="#pengguna"
              onClick={closeMenu}
              className="block font-medium text-slate-700 dark:text-slate-200 p-2 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg"
            >
              Fitur Peran
            </a>
            <Link
              href="/login"
              onClick={closeMenu}
              className="block w-full mt-2"
            >
              <Button variant="primary" fullWidth>
                Mulai Menggunakan SIPERKA
              </Button>
            </Link>
          </div>
        )}
      </header>

      <main className="flex-1 pt-16">
        {/* ===================================================
            HERO SECTION
            =================================================== */}
        <section className="relative overflow-hidden pt-12 pb-20 lg:pt-20 lg:pb-24 bg-[#EDECEA] dark:bg-[#0E1713] border-b border-slate-300 dark:border-slate-800">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-10 items-center">
              {/* Hero Copy */}
              <div className="flex flex-col items-start text-left max-w-2xl">
                <div className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-primary-100/90 dark:bg-primary-950/70 text-primary-800 dark:text-primary-300 text-xs font-bold mb-5 border border-primary-300/80 dark:border-primary-800/80 shadow-2xs">
                  <span className="w-2 h-2 rounded-full bg-primary-600 dark:bg-[#5AE39D]" />
                  Ruang Konseling Digital Siswa & Guru BK
                </div>

                <h1 className="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 dark:text-slate-100 tracking-tight leading-[1.12] mb-5">
                  Berani Bersuara, <br className="hidden sm:inline" />
                  <span className="text-primary-600 dark:text-[#5AE39D] underline decoration-[#B8E34B] decoration-4 underline-offset-8">
                    Ciptakan Sekolah Bebas Perundungan.
                  </span>
                </h1>

                <p className="text-base sm:text-lg text-slate-700 dark:text-slate-300 leading-relaxed mb-6 max-w-xl">
                  SIPERKA adalah Sistem Informasi Pelaporan Kasus Perundungan yang menghubungkan siswa langsung dengan Guru BK secara aman, rahasia, dan terstruktur. Suaramu dilindungi dan didengar tanpa rasa takut.
                </p>

                <div className="flex flex-wrap gap-2.5 mb-8">
                  <span className="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-200 shadow-2xs">
                    <Lock className="w-3.5 h-3.5 text-primary-600 dark:text-[#5AE39D]" />
                    Opsi 100% Anonim
                  </span>
                  <span className="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-200 shadow-2xs">
                    <CheckCircle className="w-3.5 h-3.5 text-[#8C6708] dark:text-[#FAD46B]" />
                    Respon Cepat Guru BK
                  </span>
                  <span className="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-200 shadow-2xs">
                    <ShieldCheck className="w-3.5 h-3.5 text-[#3F570E] dark:text-[#D2F365]" />
                    Pendampingan Objektif
                  </span>
                </div>

                <div className="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                  <Link href="/login">
                    <Button
                      variant="primary"
                      size="lg"
                      className="w-full sm:w-auto gap-2.5 shadow-sm card-hover text-base px-7"
                    >
                      Mulai Menggunakan SIPERKA
                      <ArrowRight className="w-4 h-4 text-[#B8E34B]" />
                    </Button>
                  </Link>

                  <a href="#cara-kerja">
                    <Button
                      variant="outline"
                      size="lg"
                      className="w-full sm:w-auto card-hover text-base px-7"
                    >
                      Pelajari Cara Kerja
                    </Button>
                  </a>
                </div>
              </div>

              {/* Character Illustration */}
              <ReportingIllustration />
            </div>
          </div>
        </section>

        {/* ===================================================
            APA ITU SIPERKA (FEATURES)
            =================================================== */}
        <section
          id="tentang"
          className="py-20 bg-white dark:bg-[#16231D] border-b border-slate-300 dark:border-slate-800"
        >
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span className="inline-flex items-center px-3 py-1 rounded-full bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 border border-primary-200/60 dark:border-primary-800 text-xs font-bold mb-4">
              TENTANG SISTEM
            </span>

            <h2 className="text-3xl font-extrabold text-slate-900 dark:text-white mb-4 tracking-tight">
              Apa itu SIPERKA?
            </h2>

            <p className="text-base sm:text-lg text-slate-600 dark:text-slate-400 max-w-3xl mx-auto mb-16 leading-relaxed">
              SIPERKA adalah sistem informasi berbasis web yang membantu siswa
              menyampaikan laporan terkait perundungan secara lebih terstruktur
              serta membantu Guru BK dalam mengelola, memverifikasi, memantau,
              dan mencatat tindak lanjut laporan.
            </p>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
              {[
                {
                  icon: (
                    <MessageSquare className="w-6 h-6 text-[#176B4D] dark:text-[#86efac]" />
                  ),
                  badge: "Langkah 1",
                  title: "Sampaikan",
                  desc: "Laporkan kejadian yang kamu alami atau saksikan dengan aman dan terlindungi.",
                  cardBg: "bg-[#f0f7f3] dark:bg-[#12231b] border-emerald-200/80 dark:border-emerald-850",
                  badgeColor: "text-[#176B4D] dark:text-[#86efac]",
                },
                {
                  icon: (
                    <Search className="w-6 h-6 text-[#966b09] dark:text-[#fde68a]" />
                  ),
                  badge: "Langkah 2",
                  title: "Pantau",
                  desc: "Lihat perkembangan laporan secara transparan melalui nomor tiket unik.",
                  cardBg: "bg-[#fef9eb] dark:bg-[#261f0a] border-amber-200/80 dark:border-amber-850",
                  badgeColor: "text-[#8c6708] dark:text-[#fde68a]",
                },
                {
                  icon: (
                    <CheckCircle className="w-6 h-6 text-[#4d6614] dark:text-[#c4e84a]" />
                  ),
                  badge: "Langkah 3",
                  title: "Tindak Lanjut",
                  desc: "Guru BK mendampingi dan mencatat proses penanganan sampai tuntas.",
                  cardBg: "bg-[#f7faeb] dark:bg-[#1a230c] border-lime-200/80 dark:border-lime-900/40",
                  badgeColor: "text-[#4d6614] dark:text-[#c4e84a]",
                },
              ].map((feature, i) => (
                <div
                  key={i}
                  className={`flex flex-col items-center text-center p-7 rounded-2xl border transition-all hover:-translate-y-1 hover:shadow-sm ${feature.cardBg}`}
                >
                  <div className="w-13 h-13 rounded-xl bg-white dark:bg-slate-800 shadow-2xs border border-slate-200/90 dark:border-slate-700 flex items-center justify-center mb-4">
                    {feature.icon}
                  </div>

                  <span className={`text-[11px] font-bold uppercase tracking-wider mb-1 ${feature.badgeColor}`}>
                    {feature.badge}
                  </span>

                  <h3 className="text-xl font-bold text-slate-900 dark:text-slate-100 mb-2">
                    {feature.title}
                  </h3>

                  <p className="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                    {feature.desc}
                  </p>
                </div>
              ))}
            </div>
          </div>
        </section>

        {/* ===================================================
            CARA MENGGUNAKAN SIPERKA (6 PHONE MOCKUPS)
            =================================================== */}
        <section
          id="cara-kerja"
          className="py-20 lg:py-24 bg-[#F8FAF9] dark:bg-[#0E1713] border-b border-slate-300 dark:border-slate-800"
        >
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {/* Heading */}
            <div className="text-center max-w-2xl mx-auto mb-16">
              <span className="inline-flex items-center px-3 py-1 rounded-full bg-primary-100 dark:bg-primary-900/40 text-primary-800 dark:text-primary-300 border border-primary-200/80 dark:border-primary-800 text-xs font-bold mb-4">
                PANDUAN ALUR
              </span>

              <h2 className="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Bagaimana Cara Menggunakan SIPERKA?
              </h2>

              <p className="mt-4 text-base sm:text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                Enam langkah sederhana untuk menyampaikan laporan dan memantau
                proses penanganannya secara terstruktur.
              </p>
            </div>

            {/* Steps Grid */}
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-10 gap-y-16 items-start">
              {/* Step 01 */}
              <div className="text-center">
                <div className="flex justify-center mb-5">
                  <div className="relative">
                    <PhoneMockup type="login" />
                    <div className="absolute -top-3 -left-3 w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-xs font-bold shadow-md ring-2 ring-white dark:ring-slate-900 font-mono">
                      01
                    </div>
                  </div>
                </div>

                <h3 className="text-lg font-bold text-slate-900 dark:text-white">
                  Masuk ke SIPERKA
                </h3>
                <p className="mt-2 text-sm text-slate-600 dark:text-slate-400 max-w-xs mx-auto leading-relaxed">
                  Login menggunakan akun terdaftar untuk mengakses seluruh layanan.
                </p>
              </div>

              {/* Step 02 */}
              <div className="text-center">
                <div className="flex justify-center mb-5">
                  <div className="relative">
                    <PhoneMockup type="dashboard" />
                    <div className="absolute -top-3 -left-3 w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-xs font-bold shadow-md ring-2 ring-white dark:ring-slate-900 font-mono">
                      02
                    </div>
                  </div>
                </div>

                <h3 className="text-lg font-bold text-slate-900 dark:text-white">
                  Buka Dashboard
                </h3>
                <p className="mt-2 text-sm text-slate-600 dark:text-slate-400 max-w-xs mx-auto leading-relaxed">
                  Pilih menu Buat Laporan untuk mulai menyampaikan kejadian yang dialami.
                </p>
              </div>

              {/* Step 03 */}
              <div className="text-center">
                <div className="flex justify-center mb-5">
                  <div className="relative">
                    <PhoneMockup type="buat" />
                    <div className="absolute -top-3 -left-3 w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-xs font-bold shadow-md ring-2 ring-white dark:ring-slate-900 font-mono">
                      03
                    </div>
                  </div>
                </div>

                <h3 className="text-lg font-bold text-slate-900 dark:text-white">
                  Buat Laporan
                </h3>
                <p className="mt-2 text-sm text-slate-600 dark:text-slate-400 max-w-xs mx-auto leading-relaxed">
                  Ceritakan kronologi, tentukan kategori, dan lengkapi rincian kejadian.
                </p>
              </div>

              {/* Step 04 */}
              <div className="text-center">
                <div className="flex justify-center mb-5">
                  <div className="relative">
                    <PhoneMockup type="konfirmasi" />
                    <div className="absolute -top-3 -left-3 w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-xs font-bold shadow-md ring-2 ring-white dark:ring-slate-900 font-mono">
                      04
                    </div>
                  </div>
                </div>

                <h3 className="text-lg font-bold text-slate-900 dark:text-white">
                  Periksa Detail
                </h3>
                <p className="mt-2 text-sm text-slate-600 dark:text-slate-400 max-w-xs mx-auto leading-relaxed">
                  Tinjau kembali ringkasan laporan serta atur tingkat privasi pelapor.
                </p>
              </div>

              {/* Step 05 */}
              <div className="text-center">
                <div className="flex justify-center mb-5">
                  <div className="relative">
                    <PhoneMockup type="sukses" />
                    <div className="absolute -top-3 -left-3 w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-xs font-bold shadow-md ring-2 ring-white dark:ring-slate-900 font-mono">
                      05
                    </div>
                  </div>
                </div>

                <h3 className="text-lg font-bold text-slate-900 dark:text-white">
                  Laporan Dikirim
                </h3>
                <p className="mt-2 text-sm text-slate-600 dark:text-slate-400 max-w-xs mx-auto leading-relaxed">
                  Dapatkan nomor tiket laporan untuk memantau status penanganan.
                </p>
              </div>

              {/* Step 06 */}
              <div className="text-center">
                <div className="flex justify-center mb-5">
                  <div className="relative">
                    <PhoneMockup type="status" />
                    <div className="absolute -top-3 -left-3 w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-xs font-bold shadow-md ring-2 ring-white dark:ring-slate-900 font-mono">
                      06
                    </div>
                  </div>
                </div>

                <h3 className="text-lg font-bold text-slate-900 dark:text-white">
                  Pantau Penanganan
                </h3>
                <p className="mt-2 text-sm text-slate-600 dark:text-slate-400 max-w-xs mx-auto leading-relaxed">
                  Ikuti riwayat tahapan verifikasi hingga tindak lanjut Guru BK selesai.
                </p>
              </div>
            </div>

            {/* Bottom Note */}
            <div className="mt-16 max-w-3xl mx-auto border-t border-slate-300 dark:border-slate-800 pt-8 text-center">
              <p className="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                Tampilan pada ilustrasi merupakan representasi alur penggunaan
                antarmuka SIPERKA dan disesuaikan dengan fitur sistem yang tersedia.
              </p>
            </div>
          </div>
        </section>

        {/* ===================================================
            SIAPA YANG MENGGUNAKAN (ROLES)
            =================================================== */}
        <section
          id="pengguna"
          className="py-20 bg-white dark:bg-[#101713] border-b border-slate-200/90 dark:border-slate-800"
        >
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-14">
              <span className="inline-flex items-center px-3 py-1 rounded-full bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 border border-primary-200/60 dark:border-primary-800 text-xs font-bold mb-4">
                EKOSISTEM PENGGUNA
              </span>

              <h2 className="text-3xl font-extrabold text-slate-900 dark:text-white mb-4 tracking-tight">
                Siapa yang Menggunakan SIPERKA?
              </h2>

              <p className="text-base sm:text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                Dirancang spesifik untuk mendukung tiga peran utama warga sekolah
                dengan hak akses yang teratur.
              </p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
              {[
                {
                  role: "SISWA / I",
                  icon: <Users className="w-5 h-5 text-primary-700 dark:text-primary-300" />,
                  color:
                    "bg-primary-50 text-primary-800 border-primary-200/70 dark:bg-primary-900/30 dark:text-primary-300 dark:border-primary-800",
                  features: [
                    "Membuat laporan kejadian",
                    "Melihat riwayat laporan pribadi",
                    "Memantau status penanganan",
                    "Opsi kerahasiaan identitas",
                  ],
                },
                {
                  role: "GURU BK",
                  icon: <ShieldCheck className="w-5 h-5 text-amber-700 dark:text-amber-300" />,
                  color:
                    "bg-amber-50 text-amber-800 border-amber-200/70 dark:bg-amber-900/30 dark:text-amber-300 dark:border-amber-800",
                  features: [
                    "Menerima notifikasi laporan baru",
                    "Memverifikasi keabsahan laporan",
                    "Memperbarui status penanganan",
                    "Mencatat tindak lanjut dan konseling",
                  ],
                },
                {
                  role: "ADMINISTRATOR",
                  icon: <Settings className="w-5 h-5 text-slate-700 dark:text-slate-300" />,
                  color:
                    "bg-slate-100 text-slate-800 border-slate-200/90 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-700",
                  features: [
                    "Manajemen akun pengguna",
                    "Pemantauan operasional sistem",
                    "Analitik dan statistik sekolah",
                    "Pengaturan kategori & konfigurasi",
                  ],
                },
              ].map((card, i) => (
                <div
                  key={i}
                  className="bg-[#FCFCFB] dark:bg-[#151c18] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-6 shadow-2xs hover:shadow-xs transition-shadow"
                >
                  <div
                    className={`inline-flex items-center gap-2 px-3 py-1.5 rounded-lg font-bold text-xs mb-5 border ${card.color}`}
                  >
                    {card.icon}
                    {card.role}
                  </div>

                  <ul className="space-y-3">
                    {card.features.map((feat, j) => (
                      <li key={j} className="flex items-center gap-3">
                        <Check className="w-4 h-4 text-primary-600 dark:text-primary-400 shrink-0" />
                        <span className="text-sm text-slate-700 dark:text-slate-300">
                          {feat}
                        </span>
                      </li>
                    ))}
                  </ul>
                </div>
              ))}
            </div>
          </div>
        </section>

        {/* ===================================================
            PRIVASI & SEBELUM MEMBUAT LAPORAN
            =================================================== */}
        <section className="py-20 bg-[#F5F4EE] dark:bg-[#0B110E] border-b border-slate-200/90 dark:border-slate-800">
          <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            {/* Privacy Card */}
            <div className="bg-white dark:bg-[#111A15] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-8 flex flex-col items-start shadow-2xs">
              <div className="w-12 h-12 bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 rounded-xl flex items-center justify-center mb-6 border border-amber-200/60 dark:border-amber-800/60">
                <Lock className="w-6 h-6" />
              </div>

              <h3 className="text-xl font-bold text-slate-900 dark:text-white mb-3">
                Identitas Dirahasiakan
              </h3>

              <p className="text-slate-600 dark:text-slate-400 leading-relaxed text-sm">
                Informasi pelapor hanya dapat diakses oleh pihak Guru BK yang
                berwenang untuk keperluan pendampingan dan penyelesaian kasus.
                Kamu berhak memilih opsi anonim saat mengirimkan laporan.
              </p>
            </div>

            {/* Before Report Guide */}
            <div className="bg-white dark:bg-[#111A15] border border-slate-200/90 dark:border-slate-800 rounded-2xl p-8 shadow-2xs">
              <h3 className="text-xl font-bold text-slate-900 dark:text-white mb-4">
                Sebelum Membuat Laporan
              </h3>

              <ul className="space-y-2.5 mb-6 text-sm text-slate-700 dark:text-slate-300">
                {[
                  "Ceritakan kejadian secara objektif dan jujur",
                  "Sertakan waktu dan lokasi kejadian jika diketahui",
                  "Gunakan bahasa yang jelas dan mudah dipahami",
                  "Lampirkan bukti pendukung (jika tersedia)",
                  "Periksa kembali rincian sebelum menekan kirim",
                ].map((item, index) => (
                  <li key={index} className="flex items-start gap-2.5">
                    <span className="text-primary-600 dark:text-primary-400 font-bold mt-0.5">
                      •
                    </span>
                    <span>{item}</span>
                  </li>
                ))}
              </ul>

              <div className="rounded-xl border border-primary-200/80 bg-primary-50/70 dark:border-primary-900/60 dark:bg-primary-950/30 p-4">
                <p className="text-xs leading-relaxed text-primary-900 dark:text-primary-200">
                  <span className="font-bold">Catatan Etika:</span> SIPERKA adalah
                  wadah pendampingan dan pembinaan, bukan untuk mencari kesalahan
                  secara sepihak. Laporan diproses secara profesional oleh Guru BK.
                </p>
              </div>
            </div>
          </div>
        </section>

        {/* ===================================================
            FINAL CTA (Fixed Finding #08: Clean rich emerald)
            =================================================== */}
        <section className="py-20 bg-primary-600 dark:bg-[#123F28] relative text-white">
          <div className="max-w-4xl mx-auto px-4 text-center">
            <span className="inline-flex items-center px-3 py-1 rounded-full bg-lime-400 text-primary-950 text-xs font-bold mb-4 shadow-xs">
              MULAI SEKARANG
            </span>

            <h2 className="text-3xl md:text-4xl font-extrabold text-white mb-4 tracking-tight">
              Siap Mewujudkan Sekolah Bebas Perundungan?
            </h2>

            <p className="text-base sm:text-lg text-white/90 mb-8 max-w-2xl mx-auto leading-relaxed">
              Sampaikan aspirasi dan laporanmu melalui sistem yang aman,
              terpercaya, dan langsung terhubung dengan Guru BK.
            </p>

            <Link href="/login">
              <Button
                variant="primary"
                size="lg"
                className="!bg-white !text-primary-800 hover:!bg-primary-50 border-none font-bold text-base px-8 py-3.5 h-auto shadow-md hover:shadow-lg transition-all"
              >
                Lapor Sekarang
                <ArrowRight className="w-5 h-5 ml-2" />
              </Button>
            </Link>
          </div>
        </section>
      </main>

      {/* =====================================================
          FOOTER
          ===================================================== */}
      <footer className="bg-white dark:bg-[#0B110E] py-12 border-t border-slate-200/90 dark:border-slate-800">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center text-center">
          <div className="mb-4">
            <SchoolLogo size="md" />
          </div>

          <h4 className="text-lg font-extrabold text-slate-900 dark:text-white mb-1 tracking-tight">
            SIPERKA
          </h4>

          <p className="text-xs text-slate-500 dark:text-slate-400 mb-6">
            Sistem Informasi Pelaporan Kasus Perundungan
          </p>

          <div className="w-12 h-px bg-slate-200 dark:bg-slate-800 mb-6" />

          <p className="text-sm font-medium text-slate-600 dark:text-slate-300 max-w-md">
            Bersama mewujudkan lingkungan sekolah yang aman, inklusif, dan saling
            menghargai.
          </p>

          <p className="text-xs text-slate-400 dark:text-slate-600 mt-8">
            &copy; {new Date().getFullYear()} SIPERKA · Teknik Informatika Universitas Pamulang. All rights reserved.
          </p>
        </div>
      </footer>
    </div>
  );
}
