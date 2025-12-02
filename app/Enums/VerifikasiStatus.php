<?php

namespace App\Enums;

// Status ini digunakan di tabel verifikasi_pengajuan
// untuk melacak keputusan verifikator
enum VerifikasiStatus: string
{
    case VERIFIED = 'verified';
    case REJECTED = 'rejected';
}