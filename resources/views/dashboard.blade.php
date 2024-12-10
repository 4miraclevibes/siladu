@extends('layouts.backend.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-4">
            <i class="bi bi-speedometer2 me-2"></i>
            Dashboard
        </h4>

        <div class="d-flex gap-2">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-calendar3"></i>
                </span>
                <select class="form-select" id="month" onchange="updateFilter()">
                    <option value="all" {{ $month == 'all' ? 'selected' : '' }}>Semua Bulan</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-calendar-check"></i>
                </span>
                <select class="form-select" id="year" onchange="updateFilter()">
                    <option value="all" {{ $year == 'all' ? 'selected' : '' }}>Semua Tahun</option>
                    @foreach(range(date('Y'), 2020) as $y)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Total Pemasukan -->
        <div class="col-md-3 mb-4">
            <div class="card bg-success shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="card-text mb-2 text-white">Total Pemasukan</p>
                            <h2 class="mb-0 fw-bold text-white">Rp {{ number_format($data['total_income'], 0, ',', '.') }}</h2>
                        </div>
                        <div class="card-icon text-white">
                            <i class="bi bi-cash-coin fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Transaksi -->
        <div class="col-md-3 mb-4">
            <div class="card bg-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="card-text mb-2 text-white">Total Transaksi</p>
                            <h2 class="mb-0 fw-bold text-white">{{ number_format($data['total_transactions']) }}</h2>
                        </div>
                        <div class="card-icon text-white">
                            <i class="bi bi-receipt fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Parameter -->
        <div class="col-md-3 mb-4">
            <div class="card bg-info shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="card-text mb-2 text-white">Total Parameter</p>
                            <h2 class="mb-0 fw-bold text-white">{{ number_format($data['total_parameters']) }}</h2>
                        </div>
                        <div class="card-icon text-white">
                            <i class="bi bi-list-check fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Lokasi -->
        <div class="col-md-3 mb-4">
            <div class="card bg-warning shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="card-text mb-2 text-dark">Total Lokasi</p>
                            <h2 class="mb-0 fw-bold text-dark">{{ number_format($data['total_locations']) }}</h2>
                        </div>
                        <div class="card-icon text-dark">
                            <i class="bi bi-geo-alt fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Pembayaran -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-cash-stack text-primary me-2"></i>
                        <h5 class="card-title mb-0">Status Pembayaran</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Status</th>
                                    <th class="text-end">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data['payment_status'] as $status => $total)
                                <tr>
                                    <td>
                                        <i class="bi bi-circle-fill me-2 {{ $status == 'success' ? 'text-success' : 'text-warning' }}"></i>
                                        {{ $status }}
                                    </td>
                                    <td class="text-end fw-bold">{{ number_format($total) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kategori Transaksi -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-tag text-primary me-2"></i>
                        <h5 class="card-title mb-0">Kategori Transaksi</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Kategori</th>
                                    <th class="text-end">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data['transaction_categories'] as $category => $total)
                                <tr>
                                    <td>
                                        <i class="bi bi-bookmark-fill me-2 text-primary"></i>
                                        {{ $category }}
                                    </td>
                                    <td class="text-end fw-bold">{{ number_format($total) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
.card {
    transition: transform 0.2s ease-in-out;
}
.card:hover {
    transform: translateY(-5px);
}
.card-icon {
    opacity: 0.8;
}
.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.03);
}
.input-group-text {
    background-color: white;
}
.form-select {
    min-width: 130px;
}
</style>
@endsection

@section('scripts')
<script>
function updateFilter() {
    const month = document.getElementById('month').value;
    const year = document.getElementById('year').value;
    window.location.href = `{{ route('dashboard') }}?month=${month}&year=${year}`;
}
</script>
@endsection
