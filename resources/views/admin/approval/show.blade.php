@extends('layouts.app')

@section('title', 'Approval Final')

@section('content')
<div class="row">
    <!-- Detail Pengajuan -->
    <div class="col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail Pengajuan</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th style="width: 30%">Nama Pemohon</th>
                        <td>: {{ $pengajuan->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Judul</th>
                        <td>: {{ $pengajuan->judul }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>: {{ $pengajuan->kategori->nama_kategori }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>: <br>{!! nl2br(e($pengajuan->deskripsi)) !!}</td>
                    </tr>
                    <tr>
                        <th>Lampiran</th>
                        <td>: 
                            @if($pengajuan->lampiran)
                                <a href="{{ asset('storage/' . $pengajuan->lampiran) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-download me-1"></i> Download
                                </a>
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                    </tr>
                </table>

                <hr>
                <h6 class="font-weight-bold text-info">Info Verifikasi</h6>
                <div class="alert alert-info">
                    <strong>Verifikator:</strong> {{ $pengajuan->verifikasi->verifikator->name }}<br>
                    <strong>Catatan Verifikator:</strong> {{ $pengajuan->verifikasi->catatan_verifikasi ?? '-' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Form Aksi -->
    <div class="col-lg-5">
        <div class="card shadow mb-4 border-left-success">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Keputusan Final Admin</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.approval.store', $pengajuan) }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Keputusan</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_approval" id="approved" value="approved" checked>
                                <label class="form-check-label text-success fw-bold" for="approved">
                                    <i class="fa-solid fa-thumbs-up"></i> Setujui (Approve)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_approval" id="rejected" value="rejected">
                                <label class="form-check-label text-danger fw-bold" for="rejected">
                                    <i class="fa-solid fa-thumbs-down"></i> Tolak (Reject)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="catatan_admin" class="form-label">Catatan Admin (Opsional)</label>
                        <textarea class="form-control" name="catatan_admin" id="catatan_admin" rows="4" placeholder="Catatan ini akan dilihat oleh user."></textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fa-solid fa-check-double me-2"></i> Simpan Keputusan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection