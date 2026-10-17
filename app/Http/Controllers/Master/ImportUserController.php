<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Services\ExcelImportService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImportUserController extends Controller
{
    public function __construct(
        protected ExcelImportService $excelService
    ) {}

    /**
     * Tampilkan halaman utama impor akun.
     */
    public function index(): View
    {
        return view('master.import.index');
    }

    /**
     * Unduh template Excel siswa.
     */
    public function downloadStudentTemplate(): StreamedResponse
    {
        return $this->excelService->generateStudentTemplate();
    }

    /**
     * Unduh template Excel Guru BK.
     */
    public function downloadBkTemplate(): StreamedResponse
    {
        return $this->excelService->generateBkTemplate();
    }

    /**
     * Unggah file dan tampilkan pratinjau validasi (FR-11).
     */
    public function preview(Request $request): View|RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx', 'max:2048'],
            'type' => ['required', 'in:siswa,bk'],
        ], [
            'file.required' => 'File Excel wajib diunggah.',
            'file.mimes' => 'Format file harus .xlsx (Excel). Format lain atau makro ditolak.',
            'file.max' => 'Ukuran file maksimal 2 MB.',
        ]);

        $file = $request->file('file');
        $type = $request->input('type');

        try {
            $result = $type === 'siswa'
                ? $this->excelService->parseAndValidateStudents($file)
                : $this->excelService->parseAndValidateBk($file);
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal membaca file Excel. Pastikan file tidak rusak dan menggunakan format .xlsx.');
        }

        if ($result['total'] === 0) {
            return back()->with('warning', 'File Excel kosong atau tidak memiliki data yang dapat dibaca.');
        }

        $token = (string) Str::uuid();

        // Simpan sementara hasil validasi di session
        session()->put('import_session_'.$token, [
            'type' => $type,
            'valid' => $result['valid'],
            'invalid' => $result['invalid'],
            'total' => $result['total'],
        ]);

        return view('master.import.preview', [
            'token' => $token,
            'type' => $type,
            'total' => $result['total'],
            'valid' => $result['valid'],
            'invalid' => $result['invalid'],
        ]);
    }

    /**
     * Unduh baris data yang bermasalah / gagal validasi.
     */
    public function downloadFailed(Request $request): StreamedResponse|RedirectResponse
    {
        $token = $request->query('token');
        $data = session()->get('import_session_'.$token);

        if (! $data || empty($data['invalid'])) {
            return redirect()->route('master.import.index')
                ->with('error', 'Data baris gagal tidak ditemukan atau sesi telah berakhir.');
        }

        return $this->excelService->exportFailedRows($data['invalid'], $data['type']);
    }

    /**
     * Konfirmasi Master untuk menyimpan baris data yang valid ke database.
     */
    public function confirm(Request $request): View|RedirectResponse
    {
        $token = $request->input('token');
        $data = session()->get('import_session_'.$token);

        if (! $data) {
            return redirect()->route('master.import.index')
                ->with('error', 'Sesi impor telah kedaluwarsa. Silakan unggah kembali file Excel.');
        }

        $validRows = $data['valid'] ?? [];
        $type = $data['type'];

        if (empty($validRows)) {
            return redirect()->route('master.import.index')
                ->with('warning', 'Tidak ada data valid yang dapat disimpan dari file ini.');
        }

        $credentials = $type === 'siswa'
            ? $this->excelService->commitStudentImport($validRows)
            : $this->excelService->commitBkImport($validRows);

        // Hapus session import dan simpan session kredensial sementara
        session()->forget('import_session_'.$token);

        $downloadToken = (string) Str::uuid();
        session()->put('credentials_download_'.$downloadToken, [
            'type' => $type,
            'credentials' => $credentials,
        ]);

        return view('master.import.success', [
            'downloadToken' => $downloadToken,
            'type' => $type,
            'count' => count($credentials),
        ]);
    }

    /**
     * Unduh sekali daftar kredensial akun awal untuk dibagikan secara tertutup (FR-11).
     */
    public function downloadCredentials(Request $request): StreamedResponse|RedirectResponse
    {
        $token = $request->query('token');
        $data = session()->get('credentials_download_'.$token);

        if (! $data || empty($data['credentials'])) {
            return redirect()->route('master.import.index')
                ->with('error', 'Tautan unduh kredensial hanya berlaku satu kali atau telah kedaluwarsa demi keamanan.');
        }

        // Hapus dari sesi setelah diambil (sekali unduh)
        session()->forget('credentials_download_'.$token);

        return $this->excelService->exportCredentials($data['credentials'], $data['type']);
    }
}
