@extends('layouts.app')

@section('title', 'Detail Pengajuan')

@section('content')
    <div class="row">
        <!-- Detail Utama -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pengajuan</h6>
                    
                    @if($pengajuan->status === \App\Enums\PengajuanStatus::PENDING)
                        <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                    @elseif($pengajuan->status === \App\Enums\PengajuanStatus::VERIFIED)
                         <span class="badge bg-info">Terverifikasi (Menunggu Approval)</span>
                    @elseif($pengajuan->status === \App\Enums\PengajuanStatus::APPROVED)
                         <span class="badge bg-success">Disetujui</span>
                    @else
                         <span class="badge bg-danger">Ditolak</span>
                    @endif
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 20%">Judul</th>
                            <td>: {{ $pengajuan->judul }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>: {{ $pengajuan->kategori->nama_kategori }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Dibuat</th>
                            <td>: {{ $pengajuan->created_at->format('d F Y, H:i') }}</td>
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
                                        <i class="fa-solid fa-download me-1"></i> Lihat / Download
                                    </a>
                                @else
                                    <span class="text-muted">Tidak ada lampiran</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <div class="mt-4">
                         <a href="{{ route('user.pengajuan.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline / Status Log -->
        <div class="col-lg-4">
            <!-- Status Verifikasi -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Tahap 1: Verifikasi</h6>
                </div>
                <div class="card-body">
                    @if($pengajuan->verifikasi)
                        <div class="alert {{ $pengajuan->verifikasi->status_verifikasi->value == 'verified' ? 'alert-success' : 'alert-danger' }}">
                            <strong>Status:</strong> {{ ucfirst($pengajuan->verifikasi->status_verifikasi->value) }}<br>
                            <strong>Oleh:</strong> {{ $pengajuan->verifikasi->verifikator->name }}<br>
                            <strong>Catatan:</strong> {{ $pengajuan->verifikasi->catatan_verifikasi ?? '-' }}<br>
                            <small>{{ $pengajuan->verifikasi->created_at->diffForHumans() }}</small>
                        </div>
                    @else
                        <div class="alert alert-secondary">
                            Belum diproses oleh verifikator.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Status Approval -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Tahap 2: Approval Final</h6>
                </div>
                <div class="card-body">
                     @if($pengajuan->approval)
                        <div class="alert {{ $pengajuan->approval->status_approval->value == 'approved' ? 'alert-success' : 'alert-danger' }}">
                            <strong>Status:</strong> {{ ucfirst($pengajuan->approval->status_approval->value) }}<br>
                            <strong>Oleh:</strong> {{ $pengajuan->approval->admin->name }}<br>
                            <strong>Catatan:</strong> {{ $pengajuan->approval->catatan_admin ?? '-' }}<br>
                            <small>{{ $pengajuan->approval->created_at->diffForHumans() }}</small>
                        </div>
                    @else
                         <div class="alert alert-secondary">
                            Belum diproses oleh admin.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection