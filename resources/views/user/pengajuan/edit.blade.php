@extends('layouts.app')

@section('title', 'Edit Pengajuan')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Pengajuan</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.pengajuan.update', $pengajuan) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Judul -->
                        <div class="mb-3">
                            <label class="form-label">Judul Pengajuan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul', $pengajuan->judul) }}" required>
                            @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="mb-3">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('kategori_id') is-invalid @enderror" name="kategori_id" required>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->id }}" {{ old('kategori_id', $pengajuan->kategori_id) == $kat->id ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Detail <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" rows="5" required>{{ old('deskripsi', $pengajuan->deskripsi) }}</textarea>
                            @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Lampiran -->
                        <div class="mb-3">
                            <label class="form-label">Ganti Lampiran (Opsional)</label>
                            <input type="file" class="form-control @error('lampiran') is-invalid @enderror" name="lampiran">
                            @if($pengajuan->lampiran)
                                <div class="form-text text-info">
                                    File saat ini: <a href="{{ asset('storage/' . $pengajuan->lampiran) }}" target="_blank">Lihat File</a>. Biarkan kosong jika tidak ingin mengubah.
                                </div>
                            @endif
                            @error('lampiran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <hr>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('user.pengajuan.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Update Pengajuan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection