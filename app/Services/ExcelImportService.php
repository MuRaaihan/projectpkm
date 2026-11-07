<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExcelImportService
{
    /**
     * Bersihkan nilai sel dari potensi formula injection.
     * Mencegah sel berawalan '=', '+', '-', '@' dieksekusi oleh spreadsheet.
     */
    public static function sanitizeCellValue(?string $value): string
    {
        if ($value === null) {
            return '';
        }

        $trimmed = trim($value);

        if ($trimmed !== '' && in_array($trimmed[0], ['=', '+', '-', '@'], true)) {
            // Berikan kutip tunggal aman di depan jika berawalan karakter formula
            return "'".$trimmed;
        }

        return $trimmed;
    }

    /**
     * Hasilkan template Excel untuk siswa.
     */
    public function generateStudentTemplate(): StreamedResponse
    {
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Siswa');

        $headers = ['NIS', 'Nama Lengkap', 'Kelas', 'Jenis Kelamin (L/P)', 'Password Awal (Opsional)'];
        $sheet->fromArray($headers, null, 'A1');

        // Contoh baris
        $examples = [
            ['12345', 'Ahmad Raka Pratama', 'VIII-A', 'L', ''],
            ['12346', 'Siti Fatimah Azzahra', 'VIII-A', 'P', ''],
        ];
        $sheet->fromArray($examples, null, 'A2');

        // Format kolom teks
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 'template-impor-siswa-sisperka.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * Hasilkan template Excel untuk Guru BK.
     */
    public function generateBkTemplate(): StreamedResponse
    {
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Guru BK');

        $headers = ['NIP/Username', 'Nama Lengkap', 'No. HP', 'Password Awal (Opsional)'];
        $sheet->fromArray($headers, null, 'A1');

        $examples = [
            ['198501012010012001', 'Ibu Rahayu, S.Psi.', '081234567890', ''],
        ];
        $sheet->fromArray($examples, null, 'A2');

        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 'template-impor-guru-bk-sisperka.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * Parsing dan validasi file siswa.
     */
    public function parseAndValidateStudents(UploadedFile $file): array
    {
        if (function_exists('set_time_limit')) {
            @set_time_limit(300);
        }
        @ini_set('max_execution_time', '300');

        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, false, false, false);

        // Ambil pemetaan kelas yang tersedia di database (case-insensitive)
        $classes = SchoolClass::all()->keyBy(fn ($c) => strtolower(trim($c->name)));

        // Ambil seluruh login_id yang sudah ada di database (termasuk soft-delete)
        $existingLoginIds = User::withTrashed()->pluck('login_id')->map(fn ($id) => strtolower($id))->flip()->toArray();

        $validRows = [];
        $invalidRows = [];
        $seenInFile = [];

        // Lewati header (baris 0)
        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            $rowNum = $i + 1;

            $nis = isset($row[0]) ? trim((string) $row[0]) : '';
            $name = isset($row[1]) ? trim((string) $row[1]) : '';
            $className = isset($row[2]) ? trim((string) $row[2]) : '';
            $gender = isset($row[3]) ? strtoupper(trim((string) $row[3])) : '';
            $password = isset($row[4]) ? trim((string) $row[4]) : '';

            // Abaikan jika baris benar-benar kosong
            if ($nis === '' && $name === '' && $className === '' && $gender === '') {
                continue;
            }

            $errors = [];

            // 1. Validasi NIS
            if ($nis === '') {
                $errors[] = 'NIS tidak boleh kosong.';
            } else {
                $nisLower = strtolower($nis);
                if (isset($seenInFile[$nisLower])) {
                    $errors[] = "NIS '{$nis}' duplikat di dalam file ini (baris {$seenInFile[$nisLower]}).";
                } elseif (isset($existingLoginIds[$nisLower])) {
                    $errors[] = "NIS '{$nis}' sudah terdaftar di database.";
                } else {
                    $seenInFile[$nisLower] = $rowNum;
                }
            }

            // 2. Validasi Nama
            if ($name === '') {
                $errors[] = 'Nama lengkap tidak boleh kosong.';
            }

            // 3. Validasi Kelas
            $classId = null;
            if ($className === '') {
                $errors[] = 'Kelas tidak boleh kosong.';
            } else {
                $classKey = strtolower($className);
                if (! isset($classes[$classKey])) {
                    $errors[] = "Kelas '{$className}' belum terdaftar di data master kelas.";
                } else {
                    $classId = $classes[$classKey]->id;
                    $className = $classes[$classKey]->name; // Standarisasi nama kelas
                }
            }

            // 4. Validasi Jenis Kelamin
            if (! in_array($gender, ['L', 'P'], true)) {
                $errors[] = 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan).';
            }

            // 5. Validasi Kata Sandi Opsional
            if ($password !== '' && strlen($password) < 8) {
                $errors[] = 'Kata sandi awal minimal 8 karakter bila diisi.';
            }

            $rowData = [
                'row_num' => $rowNum,
                'row_index' => $rowNum,
                'nis' => $nis,
                'name' => $name,
                'nama' => $name,
                'class_name' => $className,
                'class_id' => $classId,
                'gender' => $gender,
                'password' => $password,
            ];

            if (! empty($errors)) {
                $rowData['errors'] = $errors;
                $invalidRows[] = $rowData;
            } else {
                $validRows[] = $rowData;
            }
        }

        return [
            'total' => count($validRows) + count($invalidRows),
            'valid' => $validRows,
            'invalid' => $invalidRows,
        ];
    }

    /**
     * Parsing dan validasi file Guru BK.
     */
    public function parseAndValidateBk(UploadedFile $file): array
    {
        if (function_exists('set_time_limit')) {
            @set_time_limit(300);
        }
        @ini_set('max_execution_time', '300');

        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, false, false, false);

        $existingLoginIds = User::withTrashed()->pluck('login_id')->map(fn ($id) => strtolower($id))->flip()->toArray();

        $validRows = [];
        $invalidRows = [];
        $seenInFile = [];

        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            $rowNum = $i + 1;

            $nip = isset($row[0]) ? trim((string) $row[0]) : '';
            $name = isset($row[1]) ? trim((string) $row[1]) : '';
            $phone = isset($row[2]) ? trim((string) $row[2]) : '';
            $password = isset($row[3]) ? trim((string) $row[3]) : '';

            if ($nip === '' && $name === '') {
                continue;
            }

            $errors = [];

            if ($nip === '') {
                $errors[] = 'NIP / Username tidak boleh kosong.';
            } else {
                $nipLower = strtolower($nip);
                if (isset($seenInFile[$nipLower])) {
                    $errors[] = "NIP '{$nip}' duplikat di dalam file ini (baris {$seenInFile[$nipLower]}).";
                } elseif (isset($existingLoginIds[$nipLower])) {
                    $errors[] = "NIP '{$nip}' sudah terdaftar di database.";
                } else {
                    $seenInFile[$nipLower] = $rowNum;
                }
            }

            if ($name === '') {
                $errors[] = 'Nama lengkap tidak boleh kosong.';
            }

            if ($password !== '' && strlen($password) < 8) {
                $errors[] = 'Kata sandi awal minimal 8 karakter bila diisi.';
            }

            $rowData = [
                'row_num' => $rowNum,
                'row_index' => $rowNum,
                'nip' => $nip,
                'name' => $name,
                'nama' => $name,
                'phone' => $phone,
                'password' => $password,
            ];

            if (! empty($errors)) {
                $rowData['errors'] = $errors;
                $invalidRows[] = $rowData;
            } else {
                $validRows[] = $rowData;
            }
        }

        return [
            'total' => count($validRows) + count($invalidRows),
            'valid' => $validRows,
            'invalid' => $invalidRows,
        ];
    }

    /**
     * Unduh baris gagal beserta alasan errornya ke dalam Excel.
     */
    public function exportFailedRows(array $failedRows, string $type = 'siswa'): StreamedResponse
    {
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Baris Gagal');

        if ($type === 'siswa') {
            $headers = ['No Baris', 'NIS', 'Nama Lengkap', 'Kelas', 'Jenis Kelamin', 'Keterangan Masalah'];
            $sheet->fromArray($headers, null, 'A1');

            $data = [];
            foreach ($failedRows as $r) {
                $data[] = [
                    $r['row_num'],
                    self::sanitizeCellValue($r['nis'] ?? ''),
                    self::sanitizeCellValue($r['name'] ?? ''),
                    self::sanitizeCellValue($r['class_name'] ?? ''),
                    self::sanitizeCellValue($r['gender'] ?? ''),
                    implode('; ', $r['errors'] ?? []),
                ];
            }
            $sheet->fromArray($data, null, 'A2');
        } else {
            $headers = ['No Baris', 'NIP/Username', 'Nama Lengkap', 'No HP', 'Keterangan Masalah'];
            $sheet->fromArray($headers, null, 'A1');

            $data = [];
            foreach ($failedRows as $r) {
                $data[] = [
                    $r['row_num'],
                    self::sanitizeCellValue($r['nip'] ?? ''),
                    self::sanitizeCellValue($r['name'] ?? ''),
                    self::sanitizeCellValue($r['phone'] ?? ''),
                    implode('; ', $r['errors'] ?? []),
                ];
            }
            $sheet->fromArray($data, null, 'A2');
        }

        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 'baris-gagal-impor-'.date('Ymd-His').'.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * Simpan data siswa yang valid dan kembalikan kredensial yang dibuat.
     * Menggunakan Pre-Computed Hash & Chunked Bulk Insert untuk kecepatan instan (< 1 detik bahkan untuk 1000 data).
     */
    public function commitStudentImport(array $validRows): array
    {
        if (function_exists('set_time_limit')) {
            @set_time_limit(300);
        }
        @ini_set('max_execution_time', '300');

        $createdCredentials = [];
        $defaultPassword = 'SiswaMTS!';
        $defaultHash = Hash::make($defaultPassword, ['rounds' => 10]);
        $customHashCache = [];

        $now = now();
        $insertRecords = [];

        foreach ($validRows as $item) {
            $hasCustomPassword = ! empty($item['password']);
            $plainPassword = $hasCustomPassword ? $item['password'] : $defaultPassword;

            if ($hasCustomPassword) {
                $hash = $customHashCache[$plainPassword] ??= Hash::make($plainPassword, ['rounds' => 10]);
            } else {
                $hash = $defaultHash;
            }

            $name = $item['name'] ?? $item['nama'] ?? '';

            $insertRecords[] = [
                'role' => 'siswa',
                'login_id' => $item['nis'],
                'name' => $name,
                'class_id' => $item['class_id'] ?? null,
                'gender' => $item['gender'] ?? null,
                'phone' => null,
                'photo_path' => null,
                'password' => $hash,
                'is_active' => true,
                'must_change_password' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $createdCredentials[] = [
                'nis' => $item['nis'],
                'name' => $name,
                'class_name' => $item['class_name'] ?? '',
                'password' => $plainPassword,
            ];
        }

        DB::transaction(function () use ($insertRecords) {
            // Eksekusi bulk insert dalam chunk 250 record untuk performa SQL optimal
            foreach (array_chunk($insertRecords, 250) as $chunk) {
                User::insert($chunk);
            }
        });

        ActivityLog::record(
            action: 'excel_imported',
            description: 'Berhasil mengimpor '.count($validRows).' akun siswa via Excel',
            subjectType: 'import'
        );

        return $createdCredentials;
    }

    /**
     * Simpan data Guru BK yang valid dan kembalikan kredensial yang dibuat.
     * Menggunakan Pre-Computed Hash & Chunked Bulk Insert untuk kecepatan instan (< 1 detik).
     */
    public function commitBkImport(array $validRows): array
    {
        if (function_exists('set_time_limit')) {
            @set_time_limit(300);
        }
        @ini_set('max_execution_time', '300');

        $createdCredentials = [];
        $defaultPassword = 'GuruBKMTS!';
        $defaultHash = Hash::make($defaultPassword, ['rounds' => 10]);
        $customHashCache = [];

        $now = now();
        $insertRecords = [];

        foreach ($validRows as $item) {
            $hasCustomPassword = ! empty($item['password']);
            $plainPassword = $hasCustomPassword ? $item['password'] : $defaultPassword;

            if ($hasCustomPassword) {
                $hash = $customHashCache[$plainPassword] ??= Hash::make($plainPassword, ['rounds' => 10]);
            } else {
                $hash = $defaultHash;
            }

            $name = $item['name'] ?? $item['nama'] ?? '';

            $insertRecords[] = [
                'role' => 'bk',
                'login_id' => $item['nip'],
                'name' => $name,
                'class_id' => null,
                'gender' => null,
                'phone' => $item['phone'] ?? null,
                'photo_path' => null,
                'password' => $hash,
                'is_active' => true,
                'must_change_password' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $createdCredentials[] = [
                'nip' => $item['nip'],
                'name' => $name,
                'phone' => $item['phone'] ?? '',
                'password' => $plainPassword,
            ];
        }

        DB::transaction(function () use ($insertRecords) {
            foreach (array_chunk($insertRecords, 250) as $chunk) {
                User::insert($chunk);
            }
        });

        ActivityLog::record(
            action: 'excel_imported',
            description: 'Berhasil mengimpor '.count($validRows).' akun Guru BK via Excel',
            subjectType: 'import'
        );

        return $createdCredentials;
    }

    /**
     * Ekspor daftar kredensial akun baru untuk dibagikan secara tertutup (FR-11).
     * Terlindungi dari formula injection.
     */
    public function exportCredentials(array $credentials, string $type = 'siswa'): StreamedResponse
    {
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Daftar Kredensial');

        if ($type === 'siswa') {
            $headers = ['NIS', 'Nama Lengkap', 'Kelas', 'Kata Sandi Awal'];
            $sheet->fromArray($headers, null, 'A1');

            $rowIdx = 2;
            foreach ($credentials as $c) {
                $sheet->setCellValueExplicit('A'.$rowIdx, self::sanitizeCellValue($c['nis']), DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('B'.$rowIdx, self::sanitizeCellValue($c['name']), DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('C'.$rowIdx, self::sanitizeCellValue($c['class_name']), DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('D'.$rowIdx, self::sanitizeCellValue($c['password']), DataType::TYPE_STRING);
                $rowIdx++;
            }
        } else {
            $headers = ['NIP/Username', 'Nama Lengkap', 'No. HP', 'Kata Sandi Awal'];
            $sheet->fromArray($headers, null, 'A1');

            $rowIdx = 2;
            foreach ($credentials as $c) {
                $sheet->setCellValueExplicit('A'.$rowIdx, self::sanitizeCellValue($c['nip']), DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('B'.$rowIdx, self::sanitizeCellValue($c['name']), DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('C'.$rowIdx, self::sanitizeCellValue($c['phone']), DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('D'.$rowIdx, self::sanitizeCellValue($c['password']), DataType::TYPE_STRING);
                $rowIdx++;
            }
        }

        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        ActivityLog::record(
            action: 'credentials_exported',
            description: "Mengunduh daftar kredensial awal hasil impor {$type} (".count($credentials).' akun)',
            subjectType: 'export'
        );

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 'kredensial-awal-'.$type.'-'.date('Ymd-His').'.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
