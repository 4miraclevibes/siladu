@extends('layouts.frontend.main')

@section('style')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .chart-container {
        position: relative;
        margin: auto;
        height: 300px;
        width: 100%;
    }
    
    .install-button {
        position: fixed;
        bottom: 80px;
        right: 20px;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        color: #333;
        border: none;
        border-radius: 16px;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1),
                    0 1px 3px rgba(0,0,0,0.08);
        z-index: 999;
        display: none;
        gap: 10px;
        font-size: 15px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .install-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    }

    .install-button i.bi-google-play {
        color: #4CAF50;
        font-size: 18px;
    }

    .install-button i.bi-apple {
        color: #333;
        font-size: 20px;
    }

    .install-button::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 16px;
        padding: 1px;
        background: linear-gradient(135deg, rgba(76,175,80,0.2), rgba(0,0,0,0.05));
        -webkit-mask: linear-gradient(#fff 0 0) content-box, 
                     linear-gradient(#fff 0 0);
        mask: linear-gradient(#fff 0 0) content-box, 
              linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Grafik Transaksi -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Statistik Transaksi {{ date('Y') }}</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="transactionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Pembayaran -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Status Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="paymentChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<button id="installButton" class="install-button">
    <i class="bi bi-google-play"></i>
    <i class="bi bi-apple"></i>
    Install App
</button>
@endsection

@section('script')
<script>
// Grafik Transaksi
new Chart(document.getElementById('transactionChart'), {
    type: 'line',
    data: {
        labels: @json(array_keys($transactionsByMonth)),
        datasets: [{
            label: 'Jumlah Transaksi',
            data: @json(array_values($transactionsByMonth)),
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        },
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Transaksi per Bulan'
            }
        }
    }
});

// Grafik Status Pembayaran
new Chart(document.getElementById('paymentChart'), {
    type: 'doughnut',
    data: {
        labels: @json(array_keys($paymentStatus)),
        datasets: [{
            data: @json(array_values($paymentStatus)),
            backgroundColor: [
                'rgba(255, 99, 132, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(255, 205, 86, 0.8)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Status Pembayaran'
            }
        }
    }
});
</script>
<script>
        let deferredPrompt;

        window.addEventListener('beforeinstallprompt', (e) => {
            // Prevent Chrome 67 and earlier from automatically showing the prompt
            e.preventDefault();
            // Stash the event so it can be triggered later.
            deferredPrompt = e;
            // Show the install button
            document.getElementById('installButton').style.display = 'flex';
        });

        document.getElementById('installButton').addEventListener('click', async () => {
            if (deferredPrompt) {
                // Show the install prompt
                deferredPrompt.prompt();
                // Wait for the user to respond to the prompt
                const { outcome } = await deferredPrompt.userChoice;
                // We no longer need the prompt. Clear it up.
                deferredPrompt = null;
                // Hide the install button
                document.getElementById('installButton').style.display = 'none';
            }
        });

        // Hide the install button if app is already installed
        window.addEventListener('appinstalled', () => {
            document.getElementById('installButton').style.display = 'none';
        });
</script>
@endsection