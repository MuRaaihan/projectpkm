// ============================================================
// SIPERKA — TypeScript Types
// ============================================================

export type ReportStatus =
 | "Diterima"
 | "Diverifikasi"
 | "Dalam Penanganan"
 | "Selesai"
 | "Ditolak";

export type ReportCategory =
 | "Perundungan Verbal"
 | "Perundungan Fisik"
 | "Perundungan Sosial"
 | "Cyberbullying"
 | "Lainnya";

export type PrivacyOption = "shown" | "hidden";

// ── Timeline Step ────────────────────────────────────────────

export type TimelineStepState = "done" | "active" | "pending";

export interface TimelineStep {
 id: string;
 label: string;
 datetime?: string;
 state: TimelineStepState;
}

// ── Report ───────────────────────────────────────────────────

export interface Report {
 id: string;
 category: ReportCategory;
 date: string; // display string e.g. "12 Sep 2026"
 dateFull: string; // display string e.g. "12 September 2026"
 location: string;
 status: ReportStatus;
 description: string;
 involvedParties?: string;
 hasAttachment: boolean;
 privacy: PrivacyOption;
 timeline: TimelineStep[];
 counselorNote?: string;
}

// ── User ─────────────────────────────────────────────────────

export interface User {
 id: string;
 name: string;
 email: string;
 nis: string;
 avatarInitials: string;
}

// ── New Report Form ──────────────────────────────────────────

export interface NewReportForm {
 description: string;
 category: ReportCategory | "";
 date: string;
 location: string;
 involvedParties: string;
 attachment: File | null;
 privacy: PrivacyOption;
}

// ── Guru BK ──────────────────────────────────────────────────

export interface CounselorUser {
 id: string;
 name: string;
 email: string;
 nip: string;
 avatarInitials: string;
 school: string;
}

export interface GBKNotification {
 id: string;
 title: string;
 message: string;
 time: string;
 isRead: boolean;
 reportId?: string;
 type: "new_report" | "status_update" | "reminder";
}

/** Extended Report with reporter info visible only when privacy === "shown" */
export interface GBKReport extends Report {
 reporterName?: string;
 reporterClass?: string;
 reportedAt: string; // when student submitted, e.g. "12 Sep 2026, 10:24"
}

// ── Admin ─────────────────────────────────────────────────────

export type UserRole = "Siswa" | "Guru BK" | "Admin";
export type UserStatus = "Aktif" | "Nonaktif";

export interface AdminUser {
 id: string;
 name: string;
 email: string;
 role: UserRole;
 kelas?: string; // only for Siswa
 status: UserStatus;
 createdAt: string; // display string e.g. "1 Jan 2026"
 avatarInitials: string;
}

export interface AdminNotification {
 id: string;
 title: string;
 message: string;
 time: string;
 isRead: boolean;
 type: "new_user" | "new_report" | "system" | "status_update";
}

export interface AdminCurrentUser {
 id: string;
 name: string;
 email: string;
 school: string;
 nip: string;
 avatarInitials: string;
}

/** Simplified report view for Admin monitoring (no detailed content) */
export interface AdminReport {
 id: string;
 category: ReportCategory;
 date: string;
 status: ReportStatus;
 privacy: PrivacyOption;
 handledBy?: string;
 location: string;
}
