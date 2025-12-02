<?php

namespace App\Models;

use App\Enums\VerifikasiStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifikasiPengajuan extends Model
{
    use HasFactory;

    protected $table = 'verifikasi_pengajuan';

    protected $fillable = [
        'pengajuan_id',
        'verifikator_id',
        'catatan_verifikasi',
        'status_verifikasi',
    ];

    protected function casts(): array
    {
        return [
            'status_verifikasi' => VerifikasiStatus::class,
        ];
    }

    // Relasi: Satu verifikasi dimiliki oleh satu Pengajuan
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    // Relasi: Satu verifikasi dimiliki oleh satu User (Verifikator)
    public function verifikator()
    {
        return $this->belongsTo(User::class, 'verifikator_id');
    }
}