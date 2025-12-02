<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $logs = LogAktivitas::with('user')->latest()->paginate(15);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $logs
            ]);
        }

        return view('admin.log.index', compact('logs'));
    }
}