<?php

namespace App\Models;

use App\Enums\PengajuanStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan';

    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul',
        'deskripsi',
        'lampiran',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => PengajuanStatus::class,
        ];
    }

    // Relasi: Satu pengajuan dimiliki oleh satu User (pembuat)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi: Satu pengajuan dimiliki oleh satu Kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriPengajuan::class, 'kategori_id');
    }

    // Relasi: Satu pengajuan memiliki satu data verifikasi
    public function verifikasi()
    {
        return $this->hasOne(VerifikasiPengajuan::class);
    }

    // Relasi: Satu pengajuan memiliki satu data approval
    public function approval()
    {
        return $this->hasOne(ApprovalPengajuan::class);
    }
}