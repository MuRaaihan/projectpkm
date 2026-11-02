<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportStatusHistory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'report_id',
        'from_status',
        'to_status',
        'changed_by',
        'reason',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public function changer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by')->withTrashed();
    }

    public function getToStatusLabelAttribute(): string
    {
        return match ($this->to_status) {
            'baru' => 'Laporan dibuat',
            'diverifikasi' => 'Sudah dibaca',
            'diproses' => 'Sedang ditangani',
            'selesai' => 'Selesai ditangani',
            'ditolak' => 'Tidak dapat diproses',
            default => ucfirst($this->to_status),
        };
    }
}
