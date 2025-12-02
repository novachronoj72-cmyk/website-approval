<?php

namespace App\Http\Controllers\Api\Verifikator;

use App\Enums\PengajuanStatus;
use App\Enums\VerifikasiStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Verifikator\StoreVerifikasiRequest;
use App\Models\Pengajuan;
use App\Models\VerifikasiPengajuan;
use App\Traits\ApiTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VerifikasiController extends Controller
{
    use ApiTrait;

    public function index()
    {
        $pengajuan = Pengajuan::where('status', PengajuanStatus::PENDING)
            ->with(['user', 'kategori'])
            ->latest()
            ->get();

        return $this->successResponse($pengajuan, 'Daftar pengajuan pending berhasil diambil.');
    }

    public function show(Pengajuan $pengajuan)
    {
        return $this->successResponse($pengajuan->load(['user', 'kategori']), 'Detail pengajuan.');
    }

    public function store(StoreVerifikasiRequest $request, Pengajuan $pengajuan)
    {
        if ($pengajuan->status !== PengajuanStatus::PENDING) {
            return $this->errorResponse('Pengajuan sudah tidak valid untuk diverifikasi.', 403);
        }

        DB::transaction(function () use ($request, $pengajuan) {
            VerifikasiPengajuan::create([
                'pengajuan_id' => $pengajuan->id,
                'verifikator_id' => Auth::id(),
                'status_verifikasi' => $request->status_verifikasi,
                'catatan_verifikasi' => $request->catatan_verifikasi,
            ]);

            if ($request->status_verifikasi === VerifikasiStatus::VERIFIED->value) {
                $pengajuan->update(['status' => PengajuanStatus::VERIFIED]);
            } else {
                $pengajuan->update(['status' => PengajuanStatus::REJECTED_VERIFIKATOR]);
            }
        });

        return $this->successResponse(null, 'Verifikasi berhasil disimpan.');
    }
}