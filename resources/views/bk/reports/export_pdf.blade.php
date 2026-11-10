<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Laporan Perundungan (SIPERKA)</title>
    <style>
        @page {
            margin: 1.2cm 1.5cm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #0F172A;
            font-size: 10pt;
            line-height: 1.4;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #0F766E;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }
        .title {
            font-size: 14pt;
            font-weight: bold;
            color: #0F172A;
            margin: 0;
            text-transform: uppercase;
        }
        .subtitle {
            font-size: 10pt;
            color: #475569;
            margin: 2px 0 0 0;
        }
        .badge-confidential {
            display: inline-block;
            background-color: #FEE2E2;
            color: #991B1B;
            border: 1px solid #FECACA;
            font-size: 9pt;
            font-weight: bold;
            padding: 3px 8px;
            border-radius: 4px;
            letter-spacing: 0.5px;
        }
        .meta-box {
            margin-bottom: 15px;
            font-size: 8.5pt;
            color: #475569;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 8.5pt;
        }
        .data-table th {
            background-color: #0F766E;
            color: #FFFFFF;
            font-weight: bold;
            text-align: left;
            padding: 6px 8px;
            border: 1px solid #0D655E;
        }
        .data-table td {
            padding: 6px 8px;
            border: 1px solid #CBD5E1;
            vertical-align: top;
        }
        .data-table tr:nth-child(even) {
            background-color: #F8FAFC;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .status-badge {
            font-weight: bold;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 7.5pt;
            display: inline-block;
        }
        .status-baru { background-color: #E0F2FE; color: #075985; }
        .status-diverifikasi { background-color: #E0E7FF; color: #3730A3; }
        .status-diproses { background-color: #FEF3C7; color: #92400E; }
        .status-selesai { background-color: #DCFCE7; color: #166534; }
        .status-ditolak { background-color: #F1F5F9; color: #334155; }
        .signature-table {
            width: 100%;
            margin-top: 30px;
            font-size: 9pt;
        }
    </style>
</head>
<body>
    {{-- Header Dokumen --}}
    <table class="header-table">
        <tr>
            <td style="width: 75%;">
                <h1 class="title">MTs Soebono Mantofani</h1>
                <p class="subtitle">Sistem Pelaporan Perundungan (SIPERKA) — Rekapitulasi Laporan</p>
            </td>
            <td style="width: 25%; text-align: right; vertical-align: top;">
                <span class="badge-confidential">DOKUMEN RAHASIA</span>
            </td>
        </tr>
    </table>

    {{-- Keterangan Cetak --}}
    <div class="meta-box">
        <strong>Dicetak oleh:</strong> {{ $printedBy }} &bull; 
        <strong>Waktu cetak:</strong> {{ $printedAt }} &bull; 
        <strong>Jumlah data:</strong> {{ $reports->count() }} laporan
    </div>

    {{-- Tabel Rekap Laporan --}}
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;" class="text-center">No.</th>
                <th style="width: 11%;">Tgl Lapor</th>
                <th style="width: 14%;">Kategori</th>
                <th style="width: 16%;">Nama Pelapor</th>
                <th style="width: 8%;" class="text-center">Kelas</th>
                <th style="width: 14%;">Pihak Terlapor</th>
                <th style="width: 11%;" class="text-center">Status</th>
                <th style="width: 22%;">Catatan / Alasan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $index => $report)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                    <td><strong>{{ $report->category->name ?? 'Lainnya' }}</strong></td>
                    <td>
                        @if($report->is_hidden_identity)
                            <em>Pelapor Rahasia</em>
                        @else
                            {{ $report->reporter_display_name }}
                        @endif
                        <br><span style="font-size: 7.5pt; color: #64748B;">({{ ucfirst($report->reporter_role) }})</span>
                    </td>
                    <td class="text-center">{{ $report->reporter_class_name ?? '-' }}</td>
                    <td>{{ $report->accused_name ?: 'Tidak disebutkan' }}</td>
                    <td class="text-center">
                        <span class="status-badge status-{{ $report->status }}">
                            {{ $report->status_label }}
                        </span>
                    </td>
                    <td>
                        {{ $report->reject_reason ?: '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 20px;">
                        Tidak ada data laporan yang sesuai dengan kriteria filter.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Tanda Tangan & Pernyataan Kerahasiaan --}}
    <table class="signature-table">
        <tr>
            <td style="width: 60%; vertical-align: top; font-size: 8pt; color: #64748B;">
                <em>*Dokumen ini bersifat sangat rahasia dan diterbitkan secara resmi melalui SIPERKA MTs Soebono Mantofani semata-mata untuk penanganan bimbingan dan konseling peserta didik. Penyalahgunaan data merupakan pelanggaran privasi.</em>
            </td>
            <td style="width: 40%; text-align: center;">
                Tangerang Selatan, {{ now()->translatedFormat('d F Y') }}<br>
                Petugas Bimbingan & Konseling,<br><br><br><br>
                <strong><u>{{ $printedBy }}</u></strong>
            </td>
        </tr>
    </table>
</body>
</html>
