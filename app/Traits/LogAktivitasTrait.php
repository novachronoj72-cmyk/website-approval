<?php

namespace App\Traits;

use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

trait LogAktivitasTrait
{
    /**
     * Helper untuk mencatat aktivitas.
     *
     * @param string $aktivitas Deskripsi aktivitas
     */
    protected function logAktivitas(string $aktivitas): void
    {
        LogAktivitas::create([
            'user_id' => Auth::id(), // ID user yang sedang login
            'aktivitas' => $aktivitas,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}