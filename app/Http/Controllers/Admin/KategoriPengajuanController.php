<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreKategoriRequest;
use App\Http\Requests\Admin\UpdateKategoriRequest;
use App\Models\KategoriPengajuan;
use Illuminate\Http\Request;

class KategoriPengajuanController extends Controller
{
    public function index(Request $request)
    {
        $kategori = KategoriPengajuan::latest()->paginate(10);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $kategori
            ]);
        }

        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(StoreKategoriRequest $request)
    {
        $kategori = KategoriPengajuan::create($request->validated());

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan.',
                'data' => $kategori
            ], 201);
        }

        return redirect()->route('admin.kategori.index')
                         ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(KategoriPengajuan $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(UpdateKategoriRequest $request, KategoriPengajuan $kategori)
    {
        $kategori->update($request->validated());

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil diperbarui.',
                'data' => $kategori
            ]);
        }

        return redirect()->route('admin.kategori.index')
                         ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Request $request, KategoriPengajuan $kategori)
    {
        $kategori->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus.'
            ]);
        }

        return redirect()->route('admin.kategori.index')
                         ->with('success', 'Kategori berhasil dihapus.');
    }
}