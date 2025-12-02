<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    use ApiTrait;

    /**
     * Mendapatkan log aktivitas (API)
     */
    public function index()
    {
        $logs = LogAktivitas::with('user:id,name')->latest()->paginate(15);
        return $this->successResponse($logs, 'Log aktivitas berhasil diambil.');
    }
}