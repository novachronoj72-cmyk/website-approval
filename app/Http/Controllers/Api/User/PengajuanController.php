<?php

namespace App\Http\Controllers\Api\User;

use App\Enums\PengajuanStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StorePengajuanRequest;
use App\Http\Requests\User\UpdatePengajuanRequest;
use App\Models\Pengajuan;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    use ApiTrait;

    public function index()
    {
        $pengajuan = Pengajuan::where('user_id', Auth::id())
            ->with('kategori')
            ->latest()
            ->get();

        return $this->successResponse($pengajuan, 'Data pengajuan berhasil diambil.');
    }

    public function store(StorePengajuanRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['status'] = PengajuanStatus::PENDING;

        if ($request->hasFile('lampiran')) {
            $path = $request->file('lampiran')->store('lampiran_pengajuan', 'public');
            $data['lampiran'] = $path;
        }

        $pengajuan = Pengajuan::create($data);

        return $this->successResponse($pengajuan, 'Pengajuan berhasil dibuat.', 201);
    }

    public function show(Pengajuan $pengajuan)
    {
        if ($pengajuan->user_id !== Auth::id()) {
            return $this->errorResponse('Unauthorized access to this submission.', 403);
        }

        $pengajuan->load(['kategori', 'verifikasi', 'approval']);
        return $this->successResponse($pengajuan, 'Detail pengajuan berhasil diambil.');
    }

    public function update(UpdatePengajuanRequest $request, Pengajuan $pengajuan)
    {
        // Validasi user & status sudah di handle di Request, tapi kita cek double untuk keamanan
        if ($pengajuan->user_id !== Auth::id() || $pengajuan->status !== PengajuanStatus::PENDING) {
            return $this->errorResponse('Pengajuan tidak dapat diedit.', 403);
        }

        $data = $request->validated();

        if ($request->hasFile('lampiran')) {
            if ($pengajuan->lampiran) {
                Storage::disk('public')->delete($pengajuan->lampiran);
            }
            $path = $request->file('lampiran')->store('lampiran_pengajuan', 'public');
            $data['lampiran'] = $path;
        }

        $pengajuan->update($data);

        return $this->successResponse($pengajuan, 'Pengajuan berhasil diperbarui.');
    }

    public function destroy(Pengajuan $pengajuan)
    {
        if ($pengajuan->user_id !== Auth::id() || $pengajuan->status !== PengajuanStatus::PENDING) {
            return $this->errorResponse('Pengajuan tidak dapat dihapus.', 403);
        }

        if ($pengajuan->lampiran) {
            Storage::disk('public')->delete($pengajuan->lampiran);
        }

        $pengajuan->delete();

        return $this->successResponse(null, 'Pengajuan berhasil dihapus.');
    }
}