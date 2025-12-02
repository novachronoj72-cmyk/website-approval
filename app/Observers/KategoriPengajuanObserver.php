<?php

namespace App\Observers;

use App\Models\KategoriPengajuan;
use App\Traits\LogAktivitasTrait;

class KategoriPengajuanObserver
{
    use LogAktivitasTrait;

    /**
     * Handle the KategoriPengajuan "created" event.
     */
    public function created(KategoriPengajuan $kategori): void
    {
        $this->logAktivitas("Membuat kategori baru: '{$kategori->nama_kategori}'");
    }

    /**
     * Handle the KategoriPengajuan "updated" event.
     */
    public function updated(KategoriPengajuan $kategori): void
    {
        $this->logAktivitas("Memperbarui kategori: '{$kategori->nama_kategori}'");
    }

    /**
     * Handle the KategoriPengajuan "deleted" event.
     */
    public function deleted(KategoriPengajuan $kategori): void
    {
        $this->logAktivitas("Menghapus kategori: '{$kategori->nama_kategori}'");
    }
}