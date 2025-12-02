<?php

namespace App\Http\Controllers\Api\Admin;

use App\Enums\ApprovalStatus;
use App\Enums\PengajuanStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreApprovalRequest;
use App\Models\ApprovalPengajuan;
use App\Models\Pengajuan;
use App\Traits\ApiTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    use ApiTrait;

    public function index()
    {
        $pengajuan = Pengajuan::where('status', PengajuanStatus::VERIFIED)
            ->with(['user', 'kategori', 'verifikasi.verifikator'])
            ->latest()
            ->get();

        return $this->successResponse($pengajuan, 'Daftar pengajuan siap approve berhasil diambil.');
    }

    public function show(Pengajuan $pengajuan)
    {
        return $this->successResponse($pengajuan->load(['user', 'kategori', 'verifikasi']), 'Detail pengajuan.');
    }

    public function store(StoreApprovalRequest $request, Pengajuan $pengajuan)
    {
        if ($pengajuan->status !== PengajuanStatus::VERIFIED) {
            return $this->errorResponse('Pengajuan tidak valid untuk approval.', 403);
        }

        DB::transaction(function () use ($request, $pengajuan) {
            ApprovalPengajuan::create([
                'pengajuan_id' => $pengajuan->id,
                'admin_id' => Auth::id(),
                'status_approval' => $request->status_approval,
                'catatan_admin' => $request->catatan_admin,
            ]);

            if ($request->status_approval === ApprovalStatus::APPROVED->value) {
                $pengajuan->update(['status' => PengajuanStatus::APPROVED]);
            } else {
                $pengajuan->update(['status' => PengajuanStatus::REJECTED_ADMIN]);
            }
        });

        return $this->successResponse(null, 'Approval berhasil disimpan.');
    }
}