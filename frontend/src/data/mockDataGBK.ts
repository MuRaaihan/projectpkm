// ============================================================
// SIPERKA — Mock Data Guru BK
// ============================================================

import type { CounselorUser, GBKNotification, GBKReport } from "@/types";

// ── Counselor (Guru BK) ──────────────────────────────────────

export const counselorUser: CounselorUser = {
 id: "bk-001",
 name: "Sari Dewi, S.Pd.",
 email: "sari.dewi@sman1.sch.id",
 nip: "198502152010012003",
 avatarInitials: "SD",
 school: "SMA Negeri 1",
};

// ── GBK Reports (8 entries, mix of statuses) ─────────────────

export const gbkReports: GBKReport[] = [
 // ── 1. Diterima (new) ──
 {
 id: "ELP-2026-00130",
 category: "Perundungan Verbal",
 date: "17 Sep 2026",
 dateFull: "17 September 2026",
 location: "Ruang Kelas 11-A",
 status: "Diterima",
 description:
 "Saya sering diejek dan dipanggil dengan nama panggilan yang merendahkan oleh beberapa teman sekelas. Hal ini terjadi hampir setiap hari di dalam kelas dan membuat saya tidak nyaman serta takut datang ke sekolah.",
 involvedParties: "Beberapa siswa kelas 11-A",
 hasAttachment: false,
 privacy: "hidden",
 timeline: [
 {
 id: "t1",
 label: "Laporan diterima",
 datetime: "17 Sep 2026, 08:45",
 state: "done",
 },
 {
 id: "t2",
 label: "Verifikasi awal",
 datetime: undefined,
 state: "pending",
 },
 {
 id: "t3",
 label: "Dalam penanganan",
 datetime: undefined,
 state: "pending",
 },
 { id: "t4", label: "Selesai", datetime: undefined, state: "pending" },
 ],
 counselorNote: undefined,
 reporterName: undefined,
 reporterClass: undefined,
 reportedAt: "17 Sep 2026, 08:45",
 },

 // ── 2. Diterima (new, privacy shown) ──
 {
 id: "ELP-2026-00129",
 category: "Cyberbullying",
 date: "16 Sep 2026",
 dateFull: "16 September 2026",
 location: "Media Sosial (WhatsApp Group)",
 status: "Diterima",
 description:
 "Ada grup WhatsApp yang dibuat khusus untuk membicarakan saya secara negatif. Anggota grup menyebarkan foto saya yang diedit dengan cara yang tidak pantas dan mengirimkan pesan intimidasi.",
 involvedParties: "Siswa kelas 11-B (beberapa anggota)",
 hasAttachment: true,
 privacy: "shown",
 timeline: [
 {
 id: "t1",
 label: "Laporan diterima",
 datetime: "16 Sep 2026, 20:13",
 state: "done",
 },
 {
 id: "t2",
 label: "Verifikasi awal",
 datetime: undefined,
 state: "pending",
 },
 {
 id: "t3",
 label: "Dalam penanganan",
 datetime: undefined,
 state: "pending",
 },
 { id: "t4", label: "Selesai", datetime: undefined, state: "pending" },
 ],
 counselorNote: undefined,
 reporterName: "Rina Pratiwi",
 reporterClass: "11-B",
 reportedAt: "16 Sep 2026, 20:13",
 },

 // ── 3. Dalam Penanganan ──
 {
 id: "ELP-2026-00127",
 category: "Perundungan Verbal",
 date: "12 Sep 2026",
 dateFull: "12 September 2026",
 location: "Ruang Kelas 10-B",
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
 { id: "t4", label: "Selesai", datetime: undefined, state: "pending" },
 ],
 counselorNote:
 "Laporan sedang ditindaklanjuti oleh Guru BK. Kami akan menghubungi pihak terkait untuk penanganan lebih lanjut.",
 reporterName: undefined,
 reporterClass: undefined,
 reportedAt: "12 Sep 2026, 10:24",
 },

 // ── 4. Diverifikasi ──
 {
 id: "ELP-2026-00126",
 category: "Perundungan Fisik",
 date: "10 Sep 2026",
 dateFull: "10 September 2026",
 location: "Lapangan Olahraga",
 status: "Diverifikasi",
 description:
 "Saya didorong dan dijegal saat bermain di lapangan. Kejadian ini sudah terjadi beberapa kali selama jam istirahat. Saya juga pernah ditendang saat berolahraga sehingga lutut saya lecet.",
 involvedParties: "Dua siswa kelas 10-C, salah satu berambut ikal",
 hasAttachment: true,
 privacy: "shown",
 timeline: [
 {
 id: "t1",
 label: "Laporan diterima",
 datetime: "10 Sep 2026, 13:05",
 state: "done",
 },
 {
 id: "t2",
 label: "Verifikasi awal",
 datetime: "11 Sep 2026, 09:00",
 state: "active",
 },
 {
 id: "t3",
 label: "Dalam penanganan",
 datetime: undefined,
 state: "pending",
 },
 { id: "t4", label: "Selesai", datetime: undefined, state: "pending" },
 ],
 counselorNote:
 "Laporan telah diverifikasi. Wawancara awal dengan pelapor telah dilakukan pada 11 Sep 2026.",
 reporterName: "Budi Santoso",
 reporterClass: "10-A",
 reportedAt: "10 Sep 2026, 13:05",
 },

 // ── 5. Dalam Penanganan ──
 {
 id: "ELP-2026-00121",
 category: "Cyberbullying",
 date: "3 Sep 2026",
 dateFull: "3 September 2026",
 location: "Media Sosial (Instagram)",
 status: "Dalam Penanganan",
 description:
 "Ada akun anonim yang secara rutin mengirimkan DM berisi ancaman dan penghinaan kepada saya. Akun tersebut juga mengirimkan tangkapan layar percakapan pribadi saya yang disebarluaskan tanpa izin.",
 involvedParties: "Akun anonim @unknown_acc (belum teridentifikasi)",
 hasAttachment: true,
 privacy: "shown",
 timeline: [
 {
 id: "t1",
 label: "Laporan diterima",
 datetime: "3 Sep 2026, 16:22",
 state: "done",
 },
 {
 id: "t2",
 label: "Verifikasi awal",
 datetime: "4 Sep 2026, 08:30",
 state: "done",
 },
 {
 id: "t3",
 label: "Dalam penanganan",
 datetime: "5 Sep 2026, 10:00",
 state: "active",
 },
 { id: "t4", label: "Selesai", datetime: undefined, state: "pending" },
 ],
 counselorNote:
 "Sedang berkoordinasi dengan pihak keamanan sekolah untuk mengidentifikasi pemilik akun. Orang tua pelapor telah dihubungi.",
 reporterName: "Ananda Putri",
 reporterClass: "11-A",
 reportedAt: "3 Sep 2026, 16:22",
 },

 // ── 6. Selesai ──
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
 reporterName: undefined,
 reporterClass: undefined,
 reportedAt: "5 Sep 2026, 08:15",
 },

 // ── 7. Selesai ──
 {
 id: "ELP-2026-00115",
 category: "Perundungan Sosial",
 date: "28 Agu 2026",
 dateFull: "28 Agustus 2026",
 location: "Ruang Kelas 12-A",
 status: "Selesai",
 description:
 "Saya dijauhi dan diabaikan oleh teman satu kelompok belajar. Mereka sengaja tidak memberitahu saya jadwal presentasi sehingga saya tidak hadir dan mendapat nilai buruk.",
 involvedParties: "Kelompok belajar kelas 12-A (4 orang)",
 hasAttachment: false,
 privacy: "shown",
 timeline: [
 {
 id: "t1",
 label: "Laporan diterima",
 datetime: "28 Agu 2026, 14:00",
 state: "done",
 },
 {
 id: "t2",
 label: "Verifikasi awal",
 datetime: "29 Agu 2026, 09:00",
 state: "done",
 },
 {
 id: "t3",
 label: "Dalam penanganan",
 datetime: "30 Agu 2026, 10:00",
 state: "done",
 },
 {
 id: "t4",
 label: "Selesai",
 datetime: "3 Sep 2026, 15:00",
 state: "done",
 },
 ],
 counselorNote:
 "Masalah telah diselesaikan melalui mediasi kelompok. Pihak yang terlibat telah meminta maaf dan berkomitmen tidak mengulangi.",
 reporterName: "Fajar Nugroho",
 reporterClass: "12-A",
 reportedAt: "28 Agu 2026, 14:00",
 },

 // ── 8. Ditolak ──
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
 reporterName: "Dian Kusuma",
 reporterClass: "10-C",
 reportedAt: "20 Agu 2026, 13:00",
 },
];

// ── Stats helper ─────────────────────────────────────────────

export function getGBKStats(reports: GBKReport[]) {
 return {
 total: reports.length,
 baru: reports.filter((r) => r.status === "Diterima").length,
 perluVerifikasi: reports.filter((r) => r.status === "Diverifikasi").length,
 dalamPenanganan: reports.filter((r) => r.status === "Dalam Penanganan")
 .length,
 selesai: reports.filter((r) => r.status === "Selesai").length,
 ditolak: reports.filter((r) => r.status === "Ditolak").length,
 };
}

// ── Category stats ───────────────────────────────────────────

export function getGBKCategoryStats(reports: GBKReport[]) {
 const categories = [
 "Perundungan Verbal",
 "Perundungan Fisik",
 "Perundungan Sosial",
 "Cyberbullying",
 "Lainnya",
 ] as const;
 return categories.map((cat) => ({
 label: cat,
 value: reports.filter((r) => r.category === cat).length,
 }));
}

// ── Monthly stats (mock — last 6 months) ────────────────────

export const monthlyStats = [
 { label: "Apr 2026", value: 3 },
 { label: "Mei 2026", value: 5 },
 { label: "Jun 2026", value: 2 },
 { label: "Jul 2026", value: 4 },
 { label: "Agu 2026", value: 6 },
 { label: "Sep 2026", value: 8 },
];

// ── Notifications ────────────────────────────────────────────

export const gbkNotifications: GBKNotification[] = [
 {
 id: "notif-001",
 title: "Laporan baru masuk",
 message: "Laporan #ELP-2026-00130 telah diterima dan menunggu verifikasi.",
 time: "2 jam lalu",
 isRead: false,
 reportId: "ELP-2026-00130",
 type: "new_report",
 },
 {
 id: "notif-002",
 title: "Laporan baru masuk",
 message: "Laporan #ELP-2026-00129 telah diterima. Melampirkan bukti.",
 time: "5 jam lalu",
 isRead: false,
 reportId: "ELP-2026-00129",
 type: "new_report",
 },
 {
 id: "notif-003",
 title: "Pengingat penanganan",
 message: "Laporan #ELP-2026-00127 sudah dalam penanganan selama 5 hari.",
 time: "1 hari lalu",
 isRead: true,
 reportId: "ELP-2026-00127",
 type: "reminder",
 },
 {
 id: "notif-004",
 title: "Menunggu verifikasi",
 message:
 "Laporan #ELP-2026-00126 telah diverifikasi dan siap ditindaklanjuti.",
 time: "2 hari lalu",
 isRead: true,
 reportId: "ELP-2026-00126",
 type: "status_update",
 },
 {
 id: "notif-005",
 title: "Laporan selesai",
 message: "Laporan #ELP-2026-00123 telah ditandai sebagai selesai.",
 time: "5 hari lalu",
 isRead: true,
 reportId: "ELP-2026-00123",
 type: "status_update",
 },
];



