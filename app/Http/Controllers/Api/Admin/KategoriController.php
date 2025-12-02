<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreKategoriRequest;
use App\Http\Requests\Admin\UpdateKategoriRequest;
use App\Models\KategoriPengajuan;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    use ApiTrait;

    /**
     * Mendapatkan semua kategori (API)
     */
    public function index()
    {
        $kategori = KategoriPengajuan::latest()->get();
        return $this->successResponse($kategori, 'Data kategori berhasil diambil.');
    }

    /**
     * Menyimpan kategori baru (API)
     */
    public function store(StoreKategoriRequest $request)
    {
        $kategori = KategoriPengajuan::create($request->validated());
        // Log dicatat oleh Observer
        return $this->successResponse($kategori, 'Kategori berhasil ditambahkan.', 201);
    }

    /**
     * Menampilkan satu kategori (API)
     */
    public function show(KategoriPengajuan $kategori)
    {
        return $this->successResponse($kategori, 'Detail kategori berhasil diambil.');
    }

    /**
     * Update kategori (API)
     */
    public function update(UpdateKategoriRequest $request, KategoriPengajuan $kategori)
    {
        $kategori->update($request->validated());
        // Log dicatat oleh Observer
        return $this->successResponse($kategori, 'Kategori berhasil diperbarui.');
    }

    /**
     * Hapus kategori (API)
     */
    public function destroy(KategoriPengajuan $kategori)
    {
        $kategori->delete();
        // Log dicatat oleh Observer
        return $this->successResponse(null, 'Kategori berhasil dihapus.');
    }
}