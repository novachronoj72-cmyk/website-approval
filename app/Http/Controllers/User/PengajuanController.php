<?php

namespace App\Http\Controllers\User;

use App\Enums\PengajuanStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StorePengajuanRequest;
use App\Http\Requests\User\UpdatePengajuanRequest;
use App\Models\KategoriPengajuan;
use App\Models\Pengajuan;
use Illuminate\Http\Request; // Tambahkan Request
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $pengajuan = Pengajuan::where('user_id', Auth::id())
            ->with('kategori')
            ->latest()
            ->paginate(10);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $pengajuan
            ]);
        }

        return view('user.pengajuan.index', compact('pengajuan'));
    }

    public function create()
    {
        $kategori = KategoriPengajuan::all();
        return view('user.pengajuan.create', compact('kategori'));
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

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan berhasil dibuat.',
                'data' => $pengajuan
            ], 201);
        }

        return redirect()->route('user.pengajuan.index')
                         ->with('success', 'Pengajuan berhasil dibuat.');
    }

    public function show(Request $request, Pengajuan $pengajuan)
    {
        if ($pengajuan->user_id !== Auth::id()) {
            if ($request->wantsJson()) return response()->json(['message' => 'Unauthorized'], 403);
            abort(403);
        }

        $pengajuan->load(['kategori', 'verifikasi.verifikator', 'approval.admin']);
        
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $pengajuan
            ]);
        }

        return view('user.pengajuan.show', compact('pengajuan'));
    }

    public function edit(Pengajuan $pengajuan)
    {
        if ($pengajuan->user_id !== Auth::id() || $pengajuan->status !== PengajuanStatus::PENDING) {
            abort(403, 'Pengajuan tidak dapat diedit.');
        }

        $kategori = KategoriPengajuan::all();
        return view('user.pengajuan.edit', compact('pengajuan', 'kategori'));
    }

    public function update(UpdatePengajuanRequest $request, Pengajuan $pengajuan)
    {
        // Validasi sudah dilakukan di Request, tapi pastikan file lama dihapus
        $data = $request->validated();

        if ($request->hasFile('lampiran')) {
            if ($pengajuan->lampiran) {
                Storage::disk('public')->delete($pengajuan->lampiran);
            }
            $path = $request->file('lampiran')->store('lampiran_pengajuan', 'public');
            $data['lampiran'] = $path;
        }

        $pengajuan->update($data);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan berhasil diperbarui.',
                'data' => $pengajuan
            ]);
        }

        return redirect()->route('user.pengajuan.index')
                         ->with('success', 'Pengajuan berhasil diperbarui.');
    }

    public function destroy(Request $request, Pengajuan $pengajuan)
    {
        if ($pengajuan->user_id !== Auth::id() || $pengajuan->status !== PengajuanStatus::PENDING) {
            $message = 'Pengajuan tidak dapat dihapus karena sudah diproses.';
            if ($request->wantsJson()) return response()->json(['message' => $message], 403);
            abort(403, $message);
        }

        if ($pengajuan->lampiran) {
            Storage::disk('public')->delete($pengajuan->lampiran);
        }

        $pengajuan->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan berhasil dibatalkan.'
            ]);
        }

        return redirect()->route('user.pengajuan.index')
                         ->with('success', 'Pengajuan berhasil dibatalkan.');
    }
}