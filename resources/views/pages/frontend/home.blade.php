@extends('layouts.frontend.main')

@section('style')
<style>
    .stats-card {
        border-radius: 15px;
        transition: all 0.3s ease;
        border: none;
    }
    .stats-card:hover {
        transform: translateY(-5px);
    }
    .card-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
    }
    .filter-section {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .form-select {
        border-radius: 10px;
        border: 1px solid #dee2e6;
        padding: 8px 12px;
        font-size: 14px;
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
        display: none;
        align-items: center;
        gap: 10px;
        font-size: 15px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        z-index: 999;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Dashboard Saya</h4>
        <div class="text-muted">{{ date('d F Y') }}</div>
    </div>

    <!-- Filter -->
    <div class="filter-section">
        <form action="{{ route('home') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-6">
                <label class="form-label small text-muted">Bulan</label>
                <select name="month" class="form-select" onchange="this.form.submit()">
                    <option value="all" {{ $month == 'all' ? 'selected' : '' }}>Semua Bulan</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <label class="form-label small text-muted">Tahun</label>
                <select name="year" class="form-select" onchange="this.form.submit()">
                    <option value="all" {{ $year == 'all' ? 'selected' : '' }}>Semua Tahun</option>
                    @foreach(range(date('Y'), 2020) as $y)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <!-- Statistik Utama -->
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card stats-card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="card-icon bg-primary-subtle text-primary me-3">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Total Pengujian</div>
                            <h3 class="mb-0">{{ number_format($totalTransactionDetails) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Pembayaran -->
    <div class="card stats-card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title mb-4">
                <i class="bi bi-wallet2 text-primary me-2"></i>
                Status Pembayaran
            </h5>
            <div class="row g-3">
                @forelse($paymentStatus as $status => $total)
                    <div class="col-6">
                        <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-3">
                            <div>
                                <div class="status-badge
                                    {{ $status == 'success' ? 'bg-success-subtle text-success' : 
                                       ($status == 'pending' ? 'bg-warning-subtle text-warning' : 'bg-danger-subtle text-danger') }}">
                                    {{ ucfirst($status) }}
                                </div>
                            </div>
                            <div class="h4 mb-0">{{ number_format($total) }}</div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">
                        Belum ada data pembayaran
                    </div>
                @endforelse
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
    let deferredPrompt;
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        document.getElementById('installButton').style.display = 'flex';
    });

    document.getElementById('installButton').addEventListener('click', async () => {
        if (deferredPrompt) {
            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;
            deferredPrompt = null;
            document.getElementById('installButton').style.display = 'none';
        }
    });

    window.addEventListener('appinstalled', () => {
        document.getElementById('installButton').style.display = 'none';
    });
</script>
@endsection

