@extends('layouts.app')

@section('title', 'Approval Pengajuan')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pengajuan Siap Di-Approve (Telah Diverifikasi)</h6>
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
                            <th>Diverifikasi Oleh</th>
                            <th>Tanggal Verifikasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuan as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($pengajuan->currentPage() - 1) * $pengajuan->perPage() }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->judul }}</td>
                            <td>{{ $item->verifikasi->verifikator->name ?? '-' }}</td>
                            <td>{{ $item->verifikasi->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.approval.show', $item) }}" class="btn btn-success btn-sm">
                                    <i class="fa-solid fa-gavel me-1"></i> Review
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada pengajuan yang menunggu approval.</td>
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