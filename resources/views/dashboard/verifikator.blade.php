@extends('layouts.app')

@section('title', 'Dashboard Verifikator')

@section('content')
     <div class="row">
        <div class="col-md-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Verifikasi</h6>
                </div>
                <div class="card-body">
                    <canvas id="verifikatorChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-5">
             <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ringkasan Tugas</h6>
                </div>
                <div class="card-body">
                    <p>Selamat datang, {{ auth()->user()->name }}!</p>
                    <p>Tugas Anda adalah memverifikasi pengajuan yang masuk.</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Pengajuan Masuk
                            <span class="badge bg-primary rounded-pill">{{ $stats['total'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Perlu Diverifikasi
                            <span class="badge bg-warning rounded-pill">{{ $stats['pending'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Telah Diverifikasi
                            <span class="badge bg-success rounded-pill">{{ $stats['verified'] }}</span>
                        </li>
                    </ul>
                    <a href="{{ route('verifikator.verifikasi.index') }}" class="btn btn-primary mt-3 w-100">Mulai Verifikasi</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const verifikatorChartData = {
        labels: ['Perlu Diverifikasi', 'Telah Diverifikasi'],
        datasets: [{
            label: 'Jumlah Pengajuan',
            data: [
                {{ $stats['pending'] }},
                {{ $stats['verified'] }}
            ],
            backgroundColor: [
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)'
            ],
            borderWidth: 1
        }]
    };

    const verifikatorChartConfig = {
        type: 'pie',
        data: verifikatorChartData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Status Verifikasi Anda'
                }
            }
        },
    };

    new Chart(
        document.getElementById('verifikatorChart'),
        verifikatorChartConfig
    );
</script>
@endpush