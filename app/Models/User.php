<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role',
        'login_id',
        'name',
        'password',
        'class_id',
        'gender',
        'phone',
        'photo_path',
        'is_active',
        'must_change_password',
        'last_login_at',
        'locked_until',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
            'must_change_password' => 'boolean',
            'last_login_at' => 'datetime',
            'locked_until' => 'datetime',
            'two_factor_secret' => 'encrypted',
            'two_factor_recovery_codes' => 'encrypted',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    /**
     * Cek apakah 2FA sudah aktif
     */
    public function hasTwoFactorEnabled(): bool
    {
        return ! is_null($this->two_factor_confirmed_at);
    }

    /**
     * Ambil daftar recovery codes
     */
    public function recoveryCodes(): array
    {
        if (empty($this->two_factor_recovery_codes)) {
            return [];
        }

        return json_decode($this->two_factor_recovery_codes, true) ?: [];
    }

    /**
     * Gunakan satu recovery code dan hapus dari daftar
     */
    public function replaceRecoveryCode(string $code): bool
    {
        $codes = $this->recoveryCodes();
        $key = array_search(trim($code), $codes, true);

        if ($key === false) {
            return false;
        }

        unset($codes[$key]);
        $this->two_factor_recovery_codes = json_encode(array_values($codes));
        $this->save();

        return true;
    }

    /**
     * Helper check roles
     */
    public function isMaster(): bool
    {
        return $this->role === 'master';
    }

    public function isBk(): bool
    {
        return $this->role === 'bk';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    /**
     * Relasi ke kelas (hanya untuk siswa)
     */
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Relasi ke log aktivitas
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Relasi ke laporan yang dibuat
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    /**
     * Relasi ke notifikasi dalam website
     */
    public function siteNotifications(): HasMany
    {
        return $this->hasMany(AppNotification::class, 'user_id')->latest();
    }

    /**
     * Jumlah notifikasi yang belum dibaca
     */
    public function unreadNotificationsCount(): int
    {
        return $this->siteNotifications()->whereNull('read_at')->count();
    }
}
