// ============================================================
// SIPERKA — Mock Data Admin
// ============================================================

import type {
 AdminUser,
 AdminNotification,
 AdminCurrentUser,
 AdminReport,
} from "@/types";

// ── Admin Profile (logged-in admin) ──────────────────────────

export const adminCurrentUser: AdminCurrentUser = {
 id: "admin-001",
 name: "Rudi Hartawan, S.Kom.",
 email: "rudi.hartawan@sman1.sch.id",
 school: "SMA Negeri 1",
 nip: "197801012005011001",
 avatarInitials: "RH",
};

// ── Users (15 total: 10 Siswa, 3 Guru BK, 2 Admin) ──────────

export const mockUsers: AdminUser[] = [
 // ── Siswa (10) ──
 {
 id: "usr-001",
 name: "Ahmad Fauzan",
 email: "ahmad.fauzan@student.sman1.sch.id",
 role: "Siswa",
 kelas: "10-A",
 status: "Aktif",
 createdAt: "1 Jan 2026",
 avatarInitials: "AF",
 },
 {
 id: "usr-002",
 name: "Budi Santoso",
 email: "budi.santoso@student.sman1.sch.id",
 role: "Siswa",
 kelas: "10-A",
 status: "Aktif",
 createdAt: "1 Jan 2026",
 avatarInitials: "BS",
 },
 {
 id: "usr-003",
 name: "Citra Dewi",
 email: "citra.dewi@student.sman1.sch.id",
 role: "Siswa",
 kelas: "10-B",
 status: "Aktif",
 createdAt: "1 Jan 2026",
 avatarInitials: "CD",
 },
 {
 id: "usr-004",
 name: "Diana Putri",
 email: "diana.putri@student.sman1.sch.id",
 role: "Siswa",
 kelas: "10-B",
 status: "Aktif",
 createdAt: "1 Jan 2026",
 avatarInitials: "DP",
 },
 {
 id: "usr-005",
 name: "Eko Prasetyo",
 email: "eko.prasetyo@student.sman1.sch.id",
 role: "Siswa",
 kelas: "11-A",
 status: "Aktif",
 createdAt: "15 Jan 2026",
 avatarInitials: "EP",
 },
 {
 id: "usr-006",
 name: "Farah Amalia",
 email: "farah.amalia@student.sman1.sch.id",
 role: "Siswa",
 kelas: "11-A",
 status: "Aktif",
 createdAt: "15 Jan 2026",
 avatarInitials: "FA",
 },
 {
 id: "usr-007",
 name: "Gilang Ramadan",
 email: "gilang.ramadan@student.sman1.sch.id",
 role: "Siswa",
 kelas: "11-B",
 status: "Aktif",
 createdAt: "15 Jan 2026",
 avatarInitials: "GR",
 },
 {
 id: "usr-008",
 name: "Hani Wijaya",
 email: "hani.wijaya@student.sman1.sch.id",
 role: "Siswa",
 kelas: "11-B",
 status: "Nonaktif",
 createdAt: "15 Jan 2026",
 avatarInitials: "HW",
 },
 {
 id: "usr-009",
 name: "Irfan Hakim",
 email: "irfan.hakim@student.sman1.sch.id",
 role: "Siswa",
 kelas: "12-A",
 status: "Aktif",
 createdAt: "1 Feb 2026",
 avatarInitials: "IH",
 },
 {
 id: "usr-010",
 name: "Jasmine Sari",
 email: "jasmine.sari@student.sman1.sch.id",
 role: "Siswa",
 kelas: "12-A",
 status: "Aktif",
 createdAt: "1 Feb 2026",
 avatarInitials: "JS",
 },

 // ── Guru BK (3) ──
 {
 id: "usr-011",
 name: "Sari Dewi, S.Pd.",
 email: "sari.dewi@sman1.sch.id",
 role: "Guru BK",
 status: "Aktif",
 createdAt: "1 Sep 2025",
 avatarInitials: "SD",
 },
 {
 id: "usr-012",
 name: "Budi Hartono, M.Pd.",
 email: "budi.hartono@sman1.sch.id",
 role: "Guru BK",
 status: "Aktif",
 createdAt: "1 Sep 2025",
 avatarInitials: "BH",
 },
 {
 id: "usr-013",
 name: "Maya Kusuma, S.Psi.",
 email: "maya.kusuma@sman1.sch.id",
 role: "Guru BK",
 status: "Aktif",
 createdAt: "1 Sep 2025",
 avatarInitials: "MK",
 },

 // ── Admin (2) ──
 {
 id: "usr-014",
 name: "Rudi Hartawan, S.Kom.",
 email: "rudi.hartawan@sman1.sch.id",
 role: "Admin",
 status: "Aktif",
 createdAt: "1 Sep 2025",
 avatarInitials: "RH",
 },
 {
 id: "usr-015",
 name: "Sri Wahyuni",
 email: "sri.wahyuni@sman1.sch.id",
 role: "Admin",
 status: "Aktif",
 createdAt: "1 Sep 2025",
 avatarInitials: "SW",
 },
];

// ── Reports (admin monitoring view — no sensitive content) ────

export const adminReports: AdminReport[] = [
 {
 id: "ELP-2026-00130",
 category: "Perundungan Verbal",
 date: "17 Sep 2026",
 status: "Diterima",
 privacy: "hidden",
 handledBy: "Sari Dewi, S.Pd.",
 location: "Ruang Kelas 11-A",
 },
 {
 id: "ELP-2026-00129",
 category: "Cyberbullying",
 date: "16 Sep 2026",
 status: "Diterima",
 privacy: "shown",
 handledBy: "Sari Dewi, S.Pd.",
 location: "Media Sosial",
 },
 {
 id: "ELP-2026-00127",
 category: "Perundungan Verbal",
 date: "12 Sep 2026",
 status: "Dalam Penanganan",
 privacy: "hidden",
 handledBy: "Sari Dewi, S.Pd.",
 location: "Ruang Kelas 10-B",
 },
 {
 id: "ELP-2026-00126",
 category: "Perundungan Fisik",
 date: "10 Sep 2026",
 status: "Diverifikasi",
 privacy: "shown",
 handledBy: "Budi Hartono, M.Pd.",
 location: "Lapangan Olahraga",
 },
 {
 id: "ELP-2026-00123",
 category: "Perundungan Sosial",
 date: "5 Sep 2026",
 status: "Selesai",
 privacy: "hidden",
 handledBy: "Sari Dewi, S.Pd.",
 location: "Kantin Sekolah",
 },
 {
 id: "ELP-2026-00121",
 category: "Cyberbullying",
 date: "3 Sep 2026",
 status: "Dalam Penanganan",
 privacy: "shown",
 handledBy: "Budi Hartono, M.Pd.",
 location: "Media Sosial",
 },
 {
 id: "ELP-2026-00115",
 category: "Perundungan Sosial",
 date: "28 Agu 2026",
 status: "Selesai",
 privacy: "shown",
 handledBy: "Maya Kusuma, S.Psi.",
 location: "Ruang Kelas 12-A",
 },
 {
 id: "ELP-2026-00108",
 category: "Perundungan Fisik",
 date: "20 Agu 2026",
 status: "Ditolak",
 privacy: "shown",
 handledBy: "Maya Kusuma, S.Psi.",
 location: "Lorong Sekolah",
 },
];

// ── Statistics ───────────────────────────────────────────────

export function getAdminStats() {
 const siswa = mockUsers.filter((u) => u.role === "Siswa").length;
 const guruBK = mockUsers.filter((u) => u.role === "Guru BK").length;
 const admin = mockUsers.filter((u) => u.role === "Admin").length;
 const aktif = mockUsers.filter((u) => u.status === "Aktif").length;

 return {
 totalSiswa: siswa,
 totalGuruBK: guruBK,
 totalAdmin: admin,
 totalUsers: mockUsers.length,
 activeUsers: aktif,
 totalLaporan: adminReports.length,
 laporanBaru: adminReports.filter((r) => r.status === "Diterima").length,
 laporanDalamPenanganan: adminReports.filter(
 (r) => r.status === "Dalam Penanganan" || r.status === "Diverifikasi",
 ).length,
 laporanSelesai: adminReports.filter((r) => r.status === "Selesai").length,
 laporanDitolak: adminReports.filter((r) => r.status === "Ditolak").length,
 };
}

export function getAdminCategoryStats() {
 const categories = [
 "Perundungan Verbal",
 "Perundungan Fisik",
 "Perundungan Sosial",
 "Cyberbullying",
 "Lainnya",
 ] as const;
 return categories.map((cat) => ({
 label: cat,
 value: adminReports.filter((r) => r.category === cat).length,
 }));
}

export const adminMonthlyStats = [
 { label: "Apr 2026", value: 3 },
 { label: "Mei 2026", value: 5 },
 { label: "Jun 2026", value: 2 },
 { label: "Jul 2026", value: 4 },
 { label: "Agu 2026", value: 6 },
 { label: "Sep 2026", value: 8 },
];

// ── Notifications ─────────────────────────────────────────────

export const adminNotifications: AdminNotification[] = [
 {
 id: "an-001",
 title: "Siswa baru terdaftar",
 message: "Ahmad Fauzan (Kelas 10-A) telah berhasil mendaftar ke sistem.",
 time: "2 jam lalu",
 isRead: false,
 type: "new_user",
 },
 {
 id: "an-002",
 title: "Laporan baru masuk",
 message:
 "Laporan #ELP-2026-00130 telah masuk dan menunggu penanganan Guru BK.",
 time: "3 jam lalu",
 isRead: false,
 type: "new_report",
 },
 {
 id: "an-003",
 title: "Akun pengguna dinonaktifkan",
 message:
 "Akun Hani Wijaya (Siswa, Kelas 11-B) telah dinonaktifkan oleh admin.",
 time: "1 hari lalu",
 isRead: true,
 type: "status_update",
 },
 {
 id: "an-004",
 title: "Laporan ditandai selesai",
 message:
 "Laporan #ELP-2026-00123 telah diselesaikan oleh Guru BK Sari Dewi, S.Pd.",
 time: "5 hari lalu",
 isRead: true,
 type: "status_update",
 },
 {
 id: "an-005",
 title: "Backup sistem berhasil",
 message: "Backup rutin sistem SIPERKA telah berhasil dilakukan.",
 time: "7 hari lalu",
 isRead: true,
 type: "system",
 },
];



