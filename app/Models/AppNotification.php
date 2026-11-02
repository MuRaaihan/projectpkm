<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppNotification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'url',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    public function markAsRead(): void
    {
        if (! $this->isRead()) {
            $this->update(['read_at' => now()]);
        }
    }

    /**
     * Kirim notifikasi ramah dan singkat dalam website tanpa detail sensitif
     */
    public static function send(int $userId, string $type, string $title, string $message, ?string $url = null): self
    {
        return self::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'url' => $url,
        ]);
    }

    /**
     * Tandai otomatis seluruh notifikasi terkait laporan tertentu sebagai sudah dibaca untuk pengguna yang sedang membuka halaman.
     */
    public static function markAsReadForReport(int $userId, Report|string $report): int
    {
        $reportId = $report instanceof Report ? (string) $report->id : (string) $report;

        return static::where('user_id', $userId)
            ->whereNull('read_at')
            ->where(function ($query) use ($reportId) {
                $query->where('url', 'like', "%/laporan/{$reportId}%")
                    ->orWhere('url', 'like', "%{$reportId}%");
            })
            ->update(['read_at' => now()]);
    }
}
