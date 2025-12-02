<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPengajuan extends Model
{
    use HasFactory;

    protected $table = 'kategori_pengajuan';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    // Relasi: Satu kategori dimiliki oleh banyak pengajuan
    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class, 'kategori_id');
    }
}