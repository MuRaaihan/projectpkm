// ── Buat Laporan Page — Screen 03 (Multi-step) ───────────────
"use client";

import { useState } from "react";
import { useRouter } from "next/navigation";
import {
 AppHeader,
 PageContainer,
 ProgressSteps,
 Button,
 Textarea,
 Select,
 Input,
 FileUpload,
 PrivacyCard,
} from "@/components/ui";
import { categoryOptions } from "@/data/mockData";
import type { NewReportForm } from "@/types";

const STEPS = ["Detail Kejadian", "Bukti & Privasi", "Konfirmasi"];

const emptyForm: NewReportForm = {
 description: "",
 category: "",
 date: "",
 location: "",
 involvedParties: "",
 attachment: null,
 privacy: "hidden",
};

type FormErrors = Partial<Record<keyof NewReportForm, string>>;

export default function BuatLaporanPage() {
 const router = useRouter();
 const [step, setStep] = useState(0);
 const [form, setForm] = useState<NewReportForm>(emptyForm);
 const [errors, setErrors] = useState<FormErrors>({});

 const update = <K extends keyof NewReportForm>(
 key: K,
 value: NewReportForm[K],
 ) => {
 setForm((f) => ({ ...f, [key]: value }));
 if (errors[key]) setErrors((e) => ({ ...e, [key]: undefined }));
 };

 // ── Validate per step ──
 const validateStep = (s: number): FormErrors => {
 const errs: FormErrors = {};
 if (s === 0) {
 if (!form.description.trim())
 errs.description = "Tolong ceritakan apa yang terjadi.";
 else if (form.description.trim().length < 20)
 errs.description = "Cerita terlalu singkat. Tambahkan sedikit detail.";
 if (!form.category) errs.category = "Pilih jenis kejadian.";
 if (!form.date) errs.date = "Pilih tanggal kejadian.";
 if (!form.location.trim()) errs.location = "Sebutkan lokasi kejadian.";
 }
 return errs;
 };

 const handleNext = () => {
 const errs = validateStep(step);
 if (Object.keys(errs).length) {
 setErrors(errs);
 return;
 }
 setErrors({});
 if (step < STEPS.length - 1) {
 setStep((s) => s + 1);
 } else {
 // Go to confirmation — store in sessionStorage for simplicity
 sessionStorage.setItem(
 "pendingReport",
 JSON.stringify({
 ...form,
 attachment: form.attachment ? form.attachment.name : null,
 }),
 );
 router.push("/laporan/konfirmasi");
 }
 };

 const handleBack = () => {
 if (step === 0) {
 router.back();
 } else {
 setStep((s) => s - 1);
 }
 };

 return (
 <PageContainer>
 <div className="animate-fade-in flex flex-col min-h-screen">
 <AppHeader variant="back" title="Buat Laporan" />
 
 <div className="px-6 py-4 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-700">
 <ProgressSteps steps={STEPS} currentStep={step} />
 </div>

 {/* Content — centred, form-friendly max-width */}
 <main className="px-6 py-6 flex flex-col gap-6 pb-8 max-w-2xl w-full mx-auto flex-1 animate-slide-up">
 {/* ── STEP 0: Detail Kejadian ────────────────── */}
 {step === 0 && (
 <section
 aria-labelledby="step0-heading"
 className="flex flex-col gap-5 p-5 rounded-xl border border-slate-200/90 dark:border-slate-700/80 bg-surface-card shadow-xs"
 >
 <div className="border-b border-slate-200 dark:border-slate-700 pb-4">
 <h2
 id="step0-heading"
 className="text-sm font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-100 mb-1"
 >
 Ceritakan apa yang terjadi
 </h2>
 <p className="text-xs text-slate-600 dark:text-slate-400">
 Isi berdasarkan yang kamu ingat. Tidak perlu formal.
 </p>
 </div>

 <Textarea
 label="Kronologi Kejadian"
 placeholder="Ceritakan kejadian yang kamu alami atau saksikan..."
 value={form.description}
 onChange={(e) => update("description", e.target.value)}
 error={errors.description}
 helperText="Ceritakan sesuai yang kamu ingat. Tidak perlu menggunakan bahasa formal."
 rows={5}
 showCharCount
 maxChars={1000}
 />

 <Select
 label="Jenis Kejadian"
 options={categoryOptions}
 value={form.category}
 onChange={(e) =>
 update("category", e.target.value as NewReportForm["category"])
 }
 error={errors.category}
 placeholder="Pilih jenis kejadian..."
 />

 <Input
 label="Kapan terjadi?"
 type="date"
 value={form.date}
 onChange={(e) => update("date", e.target.value)}
 error={errors.date}
 max={new Date().toISOString().split("T")[0]}
 />

 <Input
 label="Di mana terjadi?"
 type="text"
 placeholder="Contoh: Ruang Kelas, Kantin, Lorong..."
 value={form.location}
 onChange={(e) => update("location", e.target.value)}
 error={errors.location}
 />

 <Input
 label="Pihak yang terlibat (opsional)"
 type="text"
 placeholder="Contoh: nama, kelas, atau ciri-ciri"
 value={form.involvedParties}
 onChange={(e) => update("involvedParties", e.target.value)}
 helperText="Informasi ini membantu penanganan, namun tidak wajib."
 />
 </section>
 )}

 {/* ── STEP 1: Bukti & Privasi ─────────────── */}
 {step === 1 && (
 <section
 aria-labelledby="step1-heading"
 className="flex flex-col gap-5 p-5 rounded-xl border border-slate-200/90 dark:border-slate-700/80 bg-surface-card shadow-xs"
 >
 <div className="border-b border-slate-200 dark:border-slate-700 pb-4">
 <h2
 id="step1-heading"
 className="text-sm font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-100 mb-1"
 >
 Bukti &amp; Privasi
 </h2>
 <p className="text-xs text-slate-600 dark:text-slate-400">
 Lampiran bersifat opsional. Privasi bisa kamu atur di sini.
 </p>
 </div>

 <div className="flex flex-col gap-2">
 <label className="text-sm font-medium text-slate-800 dark:text-slate-200">
 Lampiran{" "}
 <span className="text-slate-600 font-normal dark:text-slate-400">(opsional)</span>
 </label>
 <FileUpload
 value={form.attachment}
 onChange={(f) => update("attachment", f)}
 />
 </div>

 <PrivacyCard
 value={form.privacy}
 onChange={(v) => update("privacy", v)}
 />

 <div className="bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-900/50 rounded-xl p-4">
 <p className="text-xs text-amber-700 dark:text-amber-400 leading-relaxed">
 Pilih dengan bijak. Jika identitas dirahasiakan, akses
 terhadap identitas pelapor dibatasi sesuai kewenangan pihak
 sekolah.
 </p>
 </div>
 </section>
 )}

 {/* ── STEP 2: Preview Ringkasan ────────────── */}
 {step === 2 && (
 <section
 aria-labelledby="step2-heading"
 className="flex flex-col gap-5 p-5 rounded-xl border border-slate-200/90 dark:border-slate-700/80 bg-surface-card shadow-xs"
 >
 <div className="border-b border-slate-200 dark:border-slate-700 pb-4">
 <h2
 id="step2-heading"
 className="text-sm font-semibold uppercase tracking-wider text-slate-900 dark:text-slate-100 mb-1"
 >
 Periksa kembali laporanmu
 </h2>
 <p className="text-xs text-slate-600 dark:text-slate-400">
 Pastikan semua informasi sudah benar sebelum melanjutkan.
 </p>
 </div>

 <div className="bg-slate-50 dark:bg-slate-900/50 rounded-xl p-4 flex flex-col gap-3 text-sm border border-slate-200/90 dark:border-slate-700/80">
 <Row label="Jenis Kejadian" value={form.category || "-"} />
 <Divider />
 <Row
 label="Tanggal"
 value={
 form.date
 ? new Date(form.date).toLocaleDateString("id-ID", {
 day: "numeric",
 month: "long",
 year: "numeric",
 })
 : "-"
 }
 />
 <Divider />
 <Row label="Lokasi" value={form.location || "-"} />
 <Divider />
 <Row
 label="Pihak yang Terlibat"
 value={form.involvedParties || "Tidak diisi"}
 />
 <Divider />
 <div>
 <p className="text-xs text-slate-600 dark:text-slate-400 mb-1">Kronologi</p>
 <p className="text-slate-800 dark:text-slate-200 leading-relaxed line-clamp-4">
 {form.description || "-"}
 </p>
 </div>
 <Divider />
 <Row
 label="Lampiran"
 value={form.attachment ? form.attachment.name : "Tidak ada"}
 />
 <Divider />
 <Row
 label="Privasi"
 value={
 form.privacy === "hidden"
 ? "Identitas dirahasiakan"
 : "Identitas ditampilkan"
 }
 />
 </div>

 <p className="text-xs text-slate-600 dark:text-slate-400 text-center mt-2">
 Kamu masih bisa mengubah informasi dengan menekan tombol Kembali.
 </p>
 </section>
 )}

 {/* ── Navigation Buttons ───────────────────── */}
 <div className="flex gap-3 mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
 <Button
 variant="outline"
 size="lg"
 onClick={handleBack}
 className="flex-1"
 >
 {step === 0 ? "Batal" : "Kembali"}
 </Button>
 <Button
 variant="primary"
 size="lg"
 onClick={handleNext}
 className="flex-1"
 >
 {step === STEPS.length - 1 ? "Lanjutkan" : "Lanjutkan"}
 </Button>
 </div>
 </main>
 </div>
 </PageContainer>
 );
}

// ── Helper sub-components ─────────────────────────────────────

function Row({ label, value }: { label: string; value: string }) {
 return (
 <div className="flex items-start justify-between gap-3">
 <p className="text-xs text-slate-600 dark:text-slate-400 shrink-0">{label}</p>
 <p className="text-right text-slate-800 dark:text-slate-200 font-medium text-xs leading-snug">
 {value}
 </p>
 </div>
 );
}

function Divider() {
 return <div className="h-px bg-slate-100 dark:bg-slate-800" aria-hidden="true" />;
}
