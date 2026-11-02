<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'reporter_id',
        'is_hidden_identity',
        'reporter_class_name',
        'reporter_grade_level',
        'reporter_role',
        'category_id',
        'incident_date',
        'location',
        'description',
        'accused_name',
        'urgency',
        'status',
        'reject_reason',
        'closed_at',
    ];

    protected function casts(): array
    {
        return [
            'is_hidden_identity' => 'boolean',
            'incident_date' => 'date',
            'closed_at' => 'datetime',
            'description' => 'encrypted',
            'accused_name' => 'encrypted',
        ];
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id')->withTrashed();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ReportAttachment::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ReportMessage::class)->orderBy('created_at', 'asc');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(ReportNote::class)->orderBy('created_at', 'desc');
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(ReportStatusHistory::class)->orderBy('created_at', 'asc');
    }

    /**
     * Nama tampilan pelapor sesuai aturan privasi
     */
    public function getReporterDisplayNameAttribute(): string
    {
        if ($this->is_hidden_identity) {
            return 'Pelapor Rahasia';
        }

        if (! $this->reporter) {
            return 'Pelapor tidak diketahui';
        }

        if ($this->reporter->trashed()) {
            return 'Akun diarsipkan';
        }

        return $this->reporter->name;
    }

    /**
     * Label status Bahasa Indonesia
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'baru' => 'Baru',
            'diverifikasi' => 'Sudah dibaca',
            'diproses' => 'Sedang ditangani',
            'selesai' => 'Selesai',
            'ditolak' => 'Tidak dapat diproses',
            default => ucfirst($this->status),
        };
    }
}
