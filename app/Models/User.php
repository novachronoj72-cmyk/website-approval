<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'otp',
        'otp_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'otp_expires_at' => 'datetime',
        ];
    }

    // Relasi: User membuat banyak pengajuan
    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class);
    }

    // Relasi: User (sebagai verifikator) memverifikasi banyak pengajuan
    public function verifikasis()
    {
        return $this->hasMany(VerifikasiPengajuan::class, 'verifikator_id');
    }

    // Relasi: User (sebagai admin) meng-approve banyak pengajuan
    public function approvals()
    {
        return $this->hasMany(ApprovalPengajuan::class, 'admin_id');
    }

    // Relasi: User memiliki banyak log aktivitas
    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class);
    }

    // Helper untuk cek role
    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    public function isVerifikator(): bool
    {
        return $this->role === UserRole::VERIFIKATOR;
    }

    public function isUser(): bool
    {
        return $this->role === UserRole::USER;
    }
}