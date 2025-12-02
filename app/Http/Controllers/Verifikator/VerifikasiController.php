<?php

namespace App\Http\Controllers\Verifikator;

use App\Enums\PengajuanStatus;
use App\Enums\VerifikasiStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Verifikator\StoreVerifikasiRequest;
use App\Models\Pengajuan;
use App\Models\VerifikasiPengajuan;
use App\Traits\LogAktivitasTrait;
use Illuminate\Http\Request; // Tambahkan ini untuk type hinting jika diperlukan
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VerifikasiController extends Controller
{
    use LogAktivitasTrait;

    /**
     * Tampilkan daftar pengajuan yang statusnya PENDING (Belum diverifikasi)
     */
    public function index()
    {
        $pengajuan = Pengajuan::where('status', PengajuanStatus::PENDING)
            ->with(['user', 'kategori']) // Pastikan relasi user & kategori dimuat
            ->latest()
            ->paginate(10);

        // [JSON RESPONSE] Jika request meminta JSON (API)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Daftar pengajuan pending',
                'data'    => $pengajuan
            ], 200);
        }

        return view('verifikasi.index', compact('pengajuan'));
    }

    /**
     * Tampilkan detail pengajuan untuk diverifikasi
     */
    public function show(Pengajuan $pengajuan)
    {
        // Pastikan hanya pengajuan PENDING yang bisa diakses
        if ($pengajuan->status !== PengajuanStatus::PENDING) {
            
            // [JSON RESPONSE] Error jika status bukan pending
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengajuan ini sudah diproses sebelumnya atau tidak valid.',
                ], 422);
            }

            return redirect()->route('verifikator.verifikasi.index')
                ->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        // [JSON RESPONSE] Success ambil detail
        if (request()->wantsJson()) {
            // Load relasi yang mungkin dibutuhkan di detail
            $pengajuan->load(['user', 'kategori', 'dokumen']); 
            
            return response()->json([
                'success' => true,
                'message' => 'Detail pengajuan',
                'data'    => $pengajuan
            ], 200);
        }

        return view('verifikator.show', compact('pengajuan'));
    }

    /**
     * Proses Verifikasi (Terima / Tolak)
     */
     public function store(StoreVerifikasiRequest $request, Pengajuan $pengajuan)
    {
        // 1. Validasi Status Awal (Harus PENDING)
        if ($pengajuan->status !== PengajuanStatus::PENDING) {
            
            // [JSON RESPONSE]
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal: Pengajuan ini statusnya bukan pending (Mungkin sudah diproses orang lain).'
                ], 409); // 409 Conflict
            }

            return redirect()->back()->with('error', 'Gagal: Pengajuan ini statusnya bukan pending (Mungkin sudah diproses orang lain).');
        }

        // 2. Ambil data yang sudah divalidasi
        $validated = $request->validated();
        $inputStatus = $validated['status_verifikasi']; // string: 'verified' atau 'rejected'

        try {
            DB::transaction(function () use ($inputStatus, $validated, $pengajuan) {
                // A. Simpan history ke tabel verifikasi_pengajuan
                VerifikasiPengajuan::create([
                    'pengajuan_id' => $pengajuan->id,
                    'verifikator_id' => Auth::id(),
                    'status_verifikasi' => $inputStatus, 
                    'catatan_verifikasi' => $validated['catatan_verifikasi'] ?? null,
                ]);
    
                // B. Update Status Utama di tabel 'pengajuan'
                if ($inputStatus === VerifikasiStatus::VERIFIED->value) {
                    $pengajuan->update([
                        'status' => PengajuanStatus::VERIFIED
                    ]);
                    $this->logAktivitas("Memverifikasi pengajuan #{$pengajuan->id}");
                } else {
                    $pengajuan->update([
                        'status' => PengajuanStatus::REJECTED_VERIFIKATOR
                    ]);
                    $this->logAktivitas("Menolak verifikasi pengajuan #{$pengajuan->id}");
                }
            });

            // [JSON RESPONSE] Success
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Keputusan berhasil disimpan.',
                    'data'    => $pengajuan->fresh() // Mengembalikan data terbaru setelah update
                ], 200);
            }
    
            return redirect()->route('verifikator.index')
                ->with('success', 'Keputusan berhasil disimpan.');

        } catch (\Exception $e) {
            // [JSON RESPONSE] Error Server
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan pada server.',
                    'error'   => $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Terjadi kesalahan server.');
        }
    }
}