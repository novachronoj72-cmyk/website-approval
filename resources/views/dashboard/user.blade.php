@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')
     <div class="row">
        <div class="col-md-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Pengajuan Saya</h6>
                </div>
                <div class="card-body">
                    <canvas id="userChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-5">
             <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ringkasan Pengajuan</h6>
                </div>
                <div class="card-body">
                    <p>Selamat datang, {{ auth()->user()->name }}!</p>
                    <p>Anda dapat mengelola pengajuan Anda di sini.</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Pengajuan Saya
                            <span class="badge bg-primary rounded-pill">{{ $stats['total'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Menunggu Diproses
                            <span class="badge bg-warning rounded-pill">{{ $stats['pending'] }}</span>
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
                     <a href="#" class="btn btn-primary mt-3 w-100">Buat Pengajuan Baru</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const userChartData = {
        labels: ['Menunggu', 'Disetujui', 'Ditolak'],
        datasets: [{
            label: 'Jumlah Pengajuan',
            data: [
                {{ $stats['pending'] }},
                {{ $stats['approved'] }},
                {{ $stats['rejected'] }}
            ],
            backgroundColor: [
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(255, 99, 132, 0.7)'
            ],
            borderWidth: 1
        }]
    };

    const userChartConfig = {
        type: 'bar',
        data: userChartData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: 'Status Pengajuan Saya'
                }
            }
        },
    };

    new Chart(
        document.getElementById('userChart'),
        userChartConfig
    );
</script>
@endpush