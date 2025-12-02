<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    use HasFactory;

    protected $table = 'log_aktivitas';

    // Nonaktifkan updated_at
    public const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'aktivitas',
        'ip_address',
        'user_agent',
    ];

    // Relasi: Satu log dimiliki oleh satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}