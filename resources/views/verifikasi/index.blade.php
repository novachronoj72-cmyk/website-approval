@extends('layouts.app')

@section('title', 'Daftar Verifikasi Masuk')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pengajuan Menunggu Verifikasi</h6>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

             @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Pemohon</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuan as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($pengajuan->currentPage() - 1) * $pengajuan->perPage() }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->judul }}</td>
                            <td><span class="badge bg-secondary">{{ $item->kategori->nama_kategori }}</span></td>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('verifikator.verifikasi.show', $item) }}" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-check-circle me-1"></i> Proses
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada pengajuan baru yang perlu diverifikasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end">
                {{ $pengajuan->links() }}
            </div>
        </div>
    </div>
@endsection