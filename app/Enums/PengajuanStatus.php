<?php

namespace App\Enums;

enum PengajuanStatus: string
{
    case PENDING = 'pending';
    case VERIFIED = 'verified'; // Telah diverifikasi, menunggu approval admin
    case REJECTED_VERIFIKATOR = 'rejected_verifikator'; // Ditolak oleh verifikator
    case APPROVED = 'approved'; // Disetujui final oleh admin
    case REJECTED_ADMIN = 'rejected_admin'; // Ditolak final oleh admin
}
