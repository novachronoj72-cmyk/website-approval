<?php

namespace App\Enums;

// Status ini digunakan di tabel approval_pengajuan
// untuk melacak keputusan admin
enum ApprovalStatus: string
{
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}