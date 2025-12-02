@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="row">
        <div class="col-md-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Pengajuan (Admin)</h6>
                </div>
                <div class="card-body">
                    <canvas id="adminChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-5">
             <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ringkasan</h6>
                </div>
                <div class="card-body">
                    <p>Selamat datang, {{ auth()->user()->name }}!</p>
                    <p>Anda memiliki wewenang penuh atas sistem.</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Pengajuan
                            <span class="badge bg-primary rounded-pill">{{ $stats['total'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Menunggu Verifikasi
                            <span class="badge bg-warning rounded-pill">{{ $stats['pending'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Menunggu Approval Anda
                            <span class="badge bg-info rounded-pill">{{ $stats['verified'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Disetujui
                            <span class="badge bg-success rounded-pill">{{ $stats['approved'] }}</span>
                        </li>
                        <li class="list-g-item d-flex justify-content-between align-items-center">
                            Ditolak
                            <span class="badge bg-danger rounded-pill">{{ $stats['rejected'] }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Data untuk chart
    const adminChartData = {
        labels: ['Menunggu Verifikasi', 'Menunggu Approval', 'Disetujui', 'Ditolak'],
        datasets: [{
            label: 'Jumlah Pengajuan',
            data: [
                {{ $stats['pending'] }},
                {{ $stats['verified'] }},
                {{ $stats['approved'] }},
                {{ $stats['rejected'] }}
            ],
            backgroundColor: [
                'rgba(255, 206, 86, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(255, 99, 132, 0.7)'
            ],
            borderColor: [
                'rgba(255, 206, 86, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 1
        }]
    };

    // Konfigurasi chart
    const adminChartConfig = {
        type: 'doughnut',
        data: adminChartData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Status Pengajuan'
                }
            }
        },
    };

    // Render chart
    new Chart(
        document.getElementById('adminChart'),
        adminChartConfig
    );
</script>
@endpush