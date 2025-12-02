<?php

namespace App\Http\Controllers;

use App\Enums\PengajuanStatus;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Menampilkan dashboard admin
    public function admin()
    {
        // Data dummy untuk chart
        $stats = [
            'total' => Pengajuan::count(),
            'pending' => Pengajuan::where('status', PengajuanStatus::PENDING)->count(),
            'verified' => Pengajuan::where('status', PengajuanStatus::VERIFIED)->count(),
            'approved' => Pengajuan::where('status', PengajuanStatus::APPROVED)->count(),
            'rejected' => Pengajuan::whereIn('status', [
                PengajuanStatus::REJECTED_ADMIN,
                PengajuanStatus::REJECTED_VERIFIKATOR
            ])->count(),
        ];
        return view('dashboard.admin', compact('stats'));
    }

    // Menampilkan dashboard verifikator
    public function verifikator()
    {
         $stats = [
            'total' => Pengajuan::count(), // Total pengajuan yang perlu diverifikasi
            'pending' => Pengajuan::where('status', PengajuanStatus::PENDING)->count(),
            'verified' => Pengajuan::where('status', PengajuanStatus::VERIFIED)->count(),
        ];
        return view('dashboard.verifikator', compact('stats'));
    }

    // Menampilkan dashboard user
    public function user()
    {
        $userId = auth()->id();
        $stats = [
            'total' => Pengajuan::where('user_id', $userId)->count(),
            'pending' => Pengajuan::where('user_id', $userId)
                ->where('status', PengajuanStatus::PENDING)->count(),
            'approved' => Pengajuan::where('user_id', $userId)
                ->where('status', PengajuanStatus::APPROVED)->count(),
            'rejected' => Pengajuan::where('user_id', $userId)
                ->whereIn('status', [
                    PengajuanStatus::REJECTED_ADMIN,
                    PengajuanStatus::REJECTED_VERIFIKATOR
                ])->count(),
        ];
        return view('dashboard.user', compact('stats'));
    }
}