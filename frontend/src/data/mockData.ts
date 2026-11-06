// ============================================================
// SIPERKA — Mock Data
// ============================================================

import type { Report, User } from "@/types";

// ── Current User ─────────────────────────────────────────────

export const currentUser: User = {
 id: "user-001",
 name: "Alfikri",
 email: "alfikri@student.sman1.sch.id",
 nis: "2024001234",
 avatarInitials: "AF",
};

// ── Mock Reports ─────────────────────────────────────────────

export const mockReports: Report[] = [
 {
 id: "ELP-2026-00127",
 category: "Perundungan Verbal",
 date: "12 Sep 2026",
 dateFull: "12 September 2026",
 location: "Ruang Kelas",
 status: "Dalam Penanganan",
 description:
 "Teman sekelas saya sering mengejek nama saya dan memanggil dengan sebutan yang tidak pantas di depan teman-teman lain. Hal ini sudah berlangsung selama kurang lebih dua minggu dan membuat saya tidak nyaman saat belajar di kelas.",
 involvedParties: "Siswa kelas 10-B, tinggi sekitar 165 cm, rambut pendek",
 hasAttachment: false,
 privacy: "hidden",
 timeline: [
 {
 id: "t1",
 label: "Laporan diterima",
 datetime: "12 Sep 2026, 10:24",
 state: "done",
 },
 {
 id: "t2",
 label: "Verifikasi awal",
 datetime: "12 Sep 2026, 14:30",
 state: "done",
 },
 {
 id: "t3",
 label: "Dalam penanganan",
 datetime: "13 Sep 2026, 09:15",
 state: "active",
 },
 {
 id: "t4",
 label: "Selesai",
 datetime: undefined,
 state: "pending",
 },
 ],
 counselorNote:
 "Laporan sedang ditindaklanjuti oleh Guru BK. Kami akan menghubungi pihak terkait untuk penanganan lebih lanjut.",
 },
 {
 id: "ELP-2026-00123",
 category: "Perundungan Sosial",
 date: "5 Sep 2026",
 dateFull: "5 September 2026",
 location: "Kantin Sekolah",
 status: "Selesai",
 description:
 "Saya dikucilkan dari kelompok teman dan tidak diajak dalam kegiatan bersama. Beberapa teman saya menyebarkan isu yang tidak benar tentang saya.",
 involvedParties: "Beberapa siswa kelas 10-A",
 hasAttachment: false,
 privacy: "hidden",
 timeline: [
 {
 id: "t1",
 label: "Laporan diterima",
 datetime: "5 Sep 2026, 08:15",
 state: "done",
 },
 {
 id: "t2",
 label: "Verifikasi awal",
 datetime: "5 Sep 2026, 11:00",
 state: "done",
 },
 {
 id: "t3",
 label: "Dalam penanganan",
 datetime: "6 Sep 2026, 10:00",
 state: "done",
 },
 {
 id: "t4",
 label: "Selesai",
 datetime: "10 Sep 2026, 14:00",
 state: "done",
 },
 ],
 counselorNote:
 "Laporan telah diselesaikan. Mediasi antara pihak-pihak yang terlibat telah dilakukan. Terima kasih telah berani melapor.",
 },
 {
 id: "ELP-2026-00112",
 category: "Cyberbullying",
 date: "28 Agu 2026",
 dateFull: "28 Agustus 2026",
 location: "Media Sosial (Instagram)",
 status: "Diverifikasi",
 description:
 "Ada akun anonim yang menyebarkan screenshot percakapan pribadi saya tanpa izin dan menambahkan komentar yang menyudutkan.",
 involvedParties: "Tidak diketahui (akun anonim)",
 hasAttachment: true,
 privacy: "hidden",
 timeline: [
 {
 id: "t1",
 label: "Laporan diterima",
 datetime: "28 Agu 2026, 19:30",
 state: "done",
 },
 {
 id: "t2",
 label: "Verifikasi awal",
 datetime: "29 Agu 2026, 09:00",
 state: "active",
 },
 {
 id: "t3",
 label: "Dalam penanganan",
 datetime: undefined,
 state: "pending",
 },
 {
 id: "t4",
 label: "Selesai",
 datetime: undefined,
 state: "pending",
 },
 ],
 counselorNote: undefined,
 },
 {
 id: "ELP-2026-00108",
 category: "Perundungan Fisik",
 date: "20 Agu 2026",
 dateFull: "20 Agustus 2026",
 location: "Lorong Sekolah",
 status: "Ditolak",
 description:
 "Saya didorong saat berjalan di lorong. Namun setelah investigasi, kejadian tersebut dinyatakan sebagai kecelakaan yang tidak disengaja.",
 involvedParties: "Tidak diketahui dengan pasti",
 hasAttachment: false,
 privacy: "shown",
 timeline: [
 {
 id: "t1",
 label: "Laporan diterima",
 datetime: "20 Agu 2026, 13:00",
 state: "done",
 },
 {
 id: "t2",
 label: "Verifikasi awal",
 datetime: "21 Agu 2026, 10:00",
 state: "done",
 },
 {
 id: "t3",
 label: "Ditolak",
 datetime: "22 Agu 2026, 15:30",
 state: "done",
 },
 ],
 counselorNote:
 "Setelah melakukan investigasi dan wawancara dengan saksi, kejadian ini dinilai sebagai ketidaksengajaan. Laporan tidak dapat ditindaklanjuti sebagai kasus Perundungan.",
 },
];

// ── Category Options ─────────────────────────────────────────

export const categoryOptions = [
 { value: "Perundungan Verbal", label: "Perundungan Verbal" },
 { value: "Perundungan Fisik", label: "Perundungan Fisik" },
 { value: "Perundungan Sosial", label: "Perundungan Sosial" },
 { value: "Cyberbullying", label: "Cyberbullying" },
 { value: "Lainnya", label: "Lainnya" },
];

// ── Stat Summary ─────────────────────────────────────────────

export function getReportStats(reports: Report[]) {
 return {
 total: reports.length,
 inProgress: reports.filter(
 (r) =>
 r.status === "Dalam Penanganan" ||
 r.status === "Diverifikasi" ||
 r.status === "Diterima",
 ).length,
 completed: reports.filter((r) => r.status === "Selesai").length,
 };
}

// ── Generate Report ID ───────────────────────────────────────

export function generateReportId(): string {
 const num = Math.floor(Math.random() * 900) + 100;
 return `ELP-2026-00${num}`;
}



