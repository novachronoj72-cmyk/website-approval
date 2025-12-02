@extends('layouts.app')

@section('title', 'Log Aktivitas Sistem')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Log Aktivitas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 10%;">#</th>
                            <th scope="col" style="width: 20%;">Waktu</th>
                            <th scope="col" style="width: 15%;">User</th>
                            <th scope="col" style="width: 40%;">Aktivitas</th>
                            <th scope="col" style="width: 15%;">IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td>{{ $loop->iteration + ($logs->currentPage() - 1) * $logs->perPage() }}</td>
                            <td>{{ $log->created_at->format('d M Y, H:i:s') }}</td>
                            <td>{{ $log->user->name ?? 'Sistem' }}</td>
                            <td>{{ $log->aktivitas }}</td>
                            <td>{{ $log->ip_address }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada log aktivitas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
@endsection