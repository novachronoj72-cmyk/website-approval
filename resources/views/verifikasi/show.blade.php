@use('App\Enums\VerifikasiStatus')

@extends('layouts.app')

@section('title', 'Proses Verifikasi')

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
                        <th>Email</th>
                        <td>: {{ $pengajuan->user->email }}</td>
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
            </div>
        </div>
    </div>

   {{-- ... existing code ... --}}

<!-- Form Aksi -->
<div class="col-lg-5">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Keputusan Verifikasi</h6>
        </div>
        <div class="card-body">
            {{-- Tampilkan Error Validasi jika ada --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('verifikator.verifikasi.store', $pengajuan) }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Tindakan</label>
                    <div class="d-flex gap-3">
                        {{-- OPSI 1: VERIFIKASI --}}
                        <div class="form-check">
                            {{-- PENTING: Gunakan value dari Enum langsung --}}
                            <input class="form-check-input" type="radio" name="status_verifikasi" 
                                   id="verified" 
                                   value="{{ \App\Enums\VerifikasiStatus::VERIFIED->value }}" 
                                   checked>
                            <label class="form-check-label text-success fw-bold" for="verified">
                                <i class="fa-solid fa-check"></i> Verifikasi (Lanjut ke Admin)
                            </label>
                        </div>

                        {{-- OPSI 2: TOLAK --}}
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status_verifikasi" 
                                   id="rejected" 
                                   value="{{ \App\Enums\VerifikasiStatus::REJECTED->value }}">
                            <label class="form-check-label text-danger fw-bold" for="rejected">
                                <i class="fa-solid fa-xmark"></i> Tolak Pengajuan
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="catatan_verifikasi" class="form-label">Catatan (Opsional)</label>
                    <textarea class="form-control" name="catatan_verifikasi" id="catatan_verifikasi" rows="4" placeholder="Berikan alasan..."></textarea>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-paper-plane me-2"></i> Kirim Keputusan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- ... existing code ... --}}
@endsection