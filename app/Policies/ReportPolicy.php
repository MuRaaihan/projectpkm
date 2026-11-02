<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;

class ReportPolicy
{
    /**
     * Siswa dan Guru BK dapat mengakses daftar laporan (Siswa dibatasi hanya miliknya sendiri di Controller).
     * Master TIDAK BOLEH mengakses daftar laporan.
     */
    public function viewAny(User $user): bool
    {
        return $user->isSiswa() || $user->isBk();
    }

    /**
     * Siswa hanya boleh melihat laporannya sendiri.
     * Guru BK boleh melihat seluruh laporan.
     * Master TIDAK BOLEH melihat laporan apa pun.
     */
    public function view(User $user, Report $report): bool
    {
        if ($user->isMaster()) {
            return false;
        }

        if ($user->isBk()) {
            return true;
        }

        if ($user->isSiswa()) {
            return $report->reporter_id === $user->id;
        }

        return false;
    }

    /**
     * Hanya siswa yang dapat membuat laporan.
     */
    public function create(User $user): bool
    {
        return $user->isSiswa();
    }

    /**
     * Otorisasi pengunduhan / penampilan berkas bukti.
     * Hanya pemilik laporan (siswa) dan Guru BK yang berhak.
     * Master DILARANG.
     */
    public function viewAttachment(User $user, Report $report): bool
    {
        return $this->view($user, $report);
    }

    /**
     * Hanya Guru BK yang dapat mengubah status laporan.
     */
    public function updateStatus(User $user, Report $report): bool
    {
        return $user->isBk();
    }

    /**
     * Hanya Guru BK yang dapat menambahkan catatan internal.
     */
    public function addNote(User $user, Report $report): bool
    {
        return $user->isBk();
    }

    /**
     * Guru BK atau siswa pemilik laporan dapat mengirim balasan/pesan.
     */
    public function sendMessage(User $user, Report $report): bool
    {
        return $user->isBk() || ($user->isSiswa() && $report->reporter_id === $user->id);
    }

    /**
     * Hanya Guru BK yang dapat membuka identitas pelapor rahasia.
     */
    public function revealIdentity(User $user, Report $report): bool
    {
        return $user->isBk();
    }
}
