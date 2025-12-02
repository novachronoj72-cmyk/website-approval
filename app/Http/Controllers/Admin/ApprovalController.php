<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ApprovalStatus;
use App\Enums\PengajuanStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreApprovalRequest;
use App\Models\ApprovalPengajuan;
use App\Models\Pengajuan;
use App\Traits\LogAktivitasTrait;
use Illuminate\Http\Request; // Tambahkan Request
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    use LogAktivitasTrait;

    public function index(Request $request)
    {
        $pengajuan = Pengajuan::where('status', PengajuanStatus::VERIFIED)
            ->with(['user', 'kategori', 'verifikasi.verifikator'])
            ->latest()
            ->paginate(10);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $pengajuan
            ]);
        }

        return view('admin.approval.index', compact('pengajuan'));
    }

    public function show(Request $request, Pengajuan $pengajuan)
    {
        if ($pengajuan->status !== PengajuanStatus::VERIFIED) {
            $message = 'Pengajuan ini tidak dalam status menunggu approval.';
            
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $message], 400);
            }

            return redirect()->route('admin.approval.index')->with('error', $message);
        }

        $pengajuan->load('verifikasi.verifikator');

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $pengajuan]);
        }

        return view('admin.approval.show', compact('pengajuan'));
    }

    public function store(StoreApprovalRequest $request, Pengajuan $pengajuan)
    {
        if ($pengajuan->status !== PengajuanStatus::VERIFIED) {
            $message = 'Pengajuan tidak valid untuk approval.';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $message], 403);
            }
            abort(403, $message);
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
                $this->logAktivitas("Menyetujui (Approve) pengajuan #{$pengajuan->id}: {$pengajuan->judul}");
            } else {
                $pengajuan->update(['status' => PengajuanStatus::REJECTED_ADMIN]);
                $this->logAktivitas("Menolak (Reject) pengajuan #{$pengajuan->id}: {$pengajuan->judul}");
            }
        });

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Keputusan approval berhasil disimpan.',
                'data' => $pengajuan->fresh()
            ]);
        }

        return redirect()->route('admin.approval.index')
            ->with('success', 'Keputusan approval berhasil disimpan.');
    }
}