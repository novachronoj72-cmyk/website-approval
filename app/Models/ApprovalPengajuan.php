<?php

namespace App\Models;

use App\Enums\ApprovalStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalPengajuan extends Model
{
    use HasFactory;

    protected $table = 'approval_pengajuan';

    protected $fillable = [
        'pengajuan_id',
        'admin_id',
        'catatan_admin',
        'status_approval',
    ];

    protected function casts(): array
    {
        return [
            'status_approval' => ApprovalStatus::class,
        ];
    }

    // Relasi: Satu approval dimiliki oleh satu Pengajuan
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    // Relasi: Satu approval dimiliki oleh satu User (Admin)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}