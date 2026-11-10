<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportExportService
{
    /**
     * Sanitasi nilai sel untuk mencegah Formula Injection (CSV/Excel Formula Injection).
     * Mencegah karakter awalan '=', '+', '-', '@' dieksekusi secara otomatis oleh aplikasi spreadsheet.
     */
    public static function sanitizeCellValue(?string $value): string
    {
        if ($value === null) {
            return '';
        }

        $trimmed = trim($value);

        if ($trimmed !== '' && in_array($trimmed[0], ['=', '+', '-', '@'], true)) {
            return "'".$trimmed;
        }

        return $trimmed;
    }

    /**
     * Hasilkan dokumen PDF rekapitulasi laporan berlabel RAHASIA.
     */
    public function exportPdf(Collection $reports, array $filters = [])
    {
        $pdf = Pdf::loadView('bk.reports.export_pdf', [
            'reports' => $reports,
            'filters' => $filters,
            'printedAt' => now()->translatedFormat('d F Y, H:i').' WIB',
            'printedBy' => auth()->user()?->name ?? 'Guru BK',
        ]);

        $pdf->setPaper('a4', 'landscape');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isRemoteEnabled', false);

        return $pdf;
    }

    /**
     * Hasilkan file Excel (.xlsx) rekapitulasi laporan berlabel RAHASIA dengan proteksi formula injection.
     */
    public function exportExcel(Collection $reports, array $filters = []): StreamedResponse
    {
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rekap Laporan Perundungan');

        // Judul & Header Dokumen Resmi
        $sheet->setCellValue('A1', 'MADRASAH TSANAWIYAH SOEBONO MANTOFANI');
        $sheet->setCellValue('A2', 'REKAPITULASI LAPORAN PERUNDUNGAN (SIPERKA)');
        $sheet->setCellValue('A3', 'KLASIFIKASI: DOKUMEN RAHASIA - HANYA UNTUK KEPENTINGAN KONSELING & PENANGANAN RESMI');

        $sheet->getStyle('A1:A3')->getFont()->setBold(true);
        $sheet->getStyle('A3')->getFont()->getColor()->setARGB('FF991B1B'); // Merah tua tegas

        // Metadata Cetak
        $sheet->setCellValue('A4', 'Dicetak oleh: '.self::sanitizeCellValue(auth()->user()?->name ?? 'Guru BK').' | Tanggal: '.now()->translatedFormat('d F Y, H:i').' WIB');
        $sheet->getStyle('A4')->getFont()->setItalic(true)->setSize(9);

        // Header Tabel Kolom
        $headers = [
            'No.',
            'ID Laporan',
            'Tanggal Lapor',
            'Kategori',
            'Peran Pelapor',
            'Nama Pelapor',
            'Kelas Siswa',
            'Tanggal Kejadian',
            'Lokasi Kejadian',
            'Pihak Terlapor',
            'Status Penanganan',
            'Catatan / Alasan Penolakan',
        ];

        $startRow = 6;
        $sheet->fromArray($headers, null, 'A'.$startRow);

        // Styling Header Baris
        $headerRange = 'A'.$startRow.':L'.$startRow;
        $sheet->getStyle($headerRange)->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle($headerRange)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF0F766E'); // Primary Teal
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Isi Data Laporan
        $rowIdx = $startRow + 1;
        $no = 1;

        foreach ($reports as $report) {
            $sheet->setCellValueExplicit('A'.$rowIdx, (string) $no++, DataType::TYPE_NUMERIC);
            $sheet->setCellValueExplicit('B'.$rowIdx, substr($report->id, 0, 8), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('C'.$rowIdx, $report->created_at->format('d/m/Y H:i'), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('D'.$rowIdx, self::sanitizeCellValue($report->category->name ?? 'Lainnya'), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('E'.$rowIdx, ucfirst($report->reporter_role), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('F'.$rowIdx, self::sanitizeCellValue($report->reporter_display_name), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('G'.$rowIdx, self::sanitizeCellValue($report->reporter_class_name ?? '-'), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('H'.$rowIdx, $report->incident_date?->format('d/m/Y') ?? '-', DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('I'.$rowIdx, self::sanitizeCellValue($report->location), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('J'.$rowIdx, self::sanitizeCellValue($report->accused_name ?: 'Tidak disebutkan'), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('K'.$rowIdx, self::sanitizeCellValue($report->status_label), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('L'.$rowIdx, self::sanitizeCellValue($report->reject_reason ?: '-'), DataType::TYPE_STRING);

            $rowIdx++;
        }

        $lastRow = $rowIdx - 1;
        if ($lastRow >= $startRow + 1) {
            // Garis Border Tabel
            $sheet->getStyle('A'.$startRow.':L'.$lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle('A'.($startRow + 1).':A'.$lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B'.($startRow + 1).':C'.$lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('H'.($startRow + 1).':H'.$lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('K'.($startRow + 1).':K'.$lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // Auto size seluruh kolom
        foreach (range('A', 'L') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'rekap-laporan-siperka-rahasia-'.date('Ymd-His').'.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
