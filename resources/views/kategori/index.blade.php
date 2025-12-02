@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kategori</h6>
            <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus me-1"></i> Tambah Kategori
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
                            <th scope="col">#</th>
                            <th scope="col">Nama Kategori</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategori as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($kategori->currentPage() - 1) * $kategori->perPage() }}</td>
                            <td>{{ $item->nama_kategori }}</td>
                            <td>{{ $item->deskripsi ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.kategori.edit', $item) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <button class="btn btn-danger btn-sm delete-btn" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal"
                                        data-url="{{ route('admin.kategori.destroy', $item) }}"
                                        title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Data kategori tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end">
                {{ $kategori->links() }}
            </div>
        </div>
    </div>

    <!-- Include Modal Hapus -->
    @include('partials.delete')

@endsection

@push('scripts')
<script>
    // Script untuk Modal Konfirmasi Hapus
    document.addEventListener('DOMContentLoaded', function () {
        const deleteModal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');

        deleteModal.addEventListener('show.bs.modal', function (event) {
            // Tombol yang memicu modal
            const button = event.relatedTarget;
            // Ambil URL dari atribut data-url
            const url = button.getAttribute('data-url');
            // Set action form hapus
            deleteForm.setAttribute('action', url);
        });
    });
</script>
@endpush