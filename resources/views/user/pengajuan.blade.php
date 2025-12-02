@extends('layouts.app')

@section('title', 'Pengajuan Saya')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Pengajuan</h6>
            <a href="{{ route('user.pengajuan.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus me-1"></i> Buat Pengajuan Baru
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuan as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($pengajuan->currentPage() - 1) * $pengajuan->perPage() }}</td>
                            <td>{{ $item->judul }}</td>
                            <td><span class="badge bg-secondary">{{ $item->kategori->nama_kategori }}</span></td>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                            <td>
                                @if($item->status === \App\Enums\PengajuanStatus::PENDING)
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($item->status === \App\Enums\PengajuanStatus::VERIFIED)
                                    <span class="badge bg-info">Terverifikasi</span>
                                @elseif($item->status === \App\Enums\PengajuanStatus::APPROVED)
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('user.pengajuan.show', $item) }}" class="btn btn-info btn-sm text-white" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    
                                    {{-- Edit & Hapus hanya jika status PENDING --}}
                                    @if($item->status === \App\Enums\PengajuanStatus::PENDING)
                                        <a href="{{ route('user.pengajuan.edit', $item) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm delete-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal"
                                                data-url="{{ route('user.pengajuan.destroy', $item) }}"
                                                title="Batalkan">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada pengajuan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
             <!-- Pagination -->
            <div class="d-flex justify-content-end">
                {{ $pengajuan->links() }}
            </div>
        </div>
    </div>

    @include('partials.delete-modal')
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteModal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const url = button.getAttribute('data-url');
            deleteForm.setAttribute('action', url);
        });
    });
</script>
@endpush