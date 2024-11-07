@extends('layouts.backend.main')

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Dashboard</h4>
    
    <div class="row">
        <!-- Grafik Transaksi per Bulan -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Transaksi per Bulan ({{ date('Y') }})</h5>
                </div>
                <div class="card-body">
                    <canvas id="transactionChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Parameter Terpopuler -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Parameter Terpopuler</h5>
                </div>
                <div class="card-body">
                    <canvas id="parameterChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Lokasi Terpopuler -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Lokasi Terpopuler</h5>
                </div>
                <div class="card-body">
                    <canvas id="locationChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Status Pembayaran -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Status Pembayaran</h5>
                </div>
                <div class="card-body">
                    <canvas id="paymentChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Kategori Transaksi -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Kategori Transaksi</h5>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Definisikan fungsi getMonthName di awal script
function getMonthName(month) {
    const months = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    return months[month - 1] || '';
}

// Grafik Transaksi per Bulan
new Chart(document.getElementById('transactionChart'), {
    type: 'line',
    data: {
        labels: @json(array_keys($transactionsByMonth)),
        datasets: [{
            label: 'Jumlah Transaksi',
            data: @json(array_values($transactionsByMonth)),
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }]
    }
});

// Grafik Parameter Terpopuler
new Chart(document.getElementById('parameterChart'), {
    type: 'bar',
    data: {
        labels: @json($popularParameters->pluck('name')),
        datasets: [{
            label: 'Jumlah Penggunaan',
            data: @json($popularParameters->pluck('transactions_count')),
            backgroundColor: 'rgba(54, 162, 235, 0.5)'
        }]
    }
});

// Grafik Lokasi Terpopuler
new Chart(document.getElementById('locationChart'), {
    type: 'bar',
    data: {
        labels: @json($popularLocations->pluck('name')),
        datasets: [{
            label: 'Jumlah Penggunaan',
            data: @json($popularLocations->pluck('transactions_count')),
            backgroundColor: 'rgba(255, 99, 132, 0.5)'
        }]
    }
});

// Grafik Status Pembayaran
new Chart(document.getElementById('paymentChart'), {
    type: 'pie',
    data: {
        labels: @json(array_keys($paymentStatus)),
        datasets: [{
            data: @json(array_values($paymentStatus)),
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)'
            ]
        }]
    }
});

// Grafik Kategori Transaksi
new Chart(document.getElementById('categoryChart'), {
    type: 'doughnut',
    data: {
        labels: @json(array_keys($transactionCategories)),
        datasets: [{
            data: @json(array_values($transactionCategories)),
            backgroundColor: [
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)'
            ]
        }]
    }
});
</script>
@endsection