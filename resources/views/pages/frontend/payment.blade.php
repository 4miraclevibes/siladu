@extends('layouts.frontend.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h5 class="mb-3">Riwayat Pembayaran</h5>
            @forelse($payments as $payment)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1">{{ $payment->transaction->nama_proyek }}</h6>
                            <p class="text-muted mb-0">
                                <small>
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ $payment->created_at->format('d M Y') }}
                                </small>
                            </p>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-2">
                                <span class="badge bg-dark rounded-pill">
                                    Rp {{ number_format($payment->payment_amount, 0, ',', '.') }}
                                </span>
                            </h6>
                            <p class="mb-0">
                                @if($payment->payment_status == 'paid')
                                    <span class="badge bg-success rounded-pill">
                                        <i class="bi bi-check-circle me-1"></i>Lunas
                                    </span>
                                @elseif($payment->payment_status == 'pending')
                                    <span class="badge bg-warning rounded-pill">
                                        <i class="bi bi-clock me-1"></i>Pending
                                    </span>
                                @else
                                    <span class="badge bg-danger rounded-pill">
                                        <i class="bi bi-x-circle me-1"></i>Gagal
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">Metode Pembayaran</small>
                            <p class="mb-0">
                                <span class="badge bg-primary rounded-pill">
                                    {{ ucfirst($payment->payment_method) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 text-end">
                            <small class="text-muted">Kode Pembayaran</small>
                            <p class="mb-0">
                                <code>{{ $payment->payment_code }}</code>
                            </p>
                        </div>
                    </div>
                    @if($payment->payment_link && $payment->payment_status == 'pending')
                    <div class="text-end mt-3">
                        <a href="{{ $payment->payment_link }}" 
                           class="btn btn-primary btn-sm"
                           target="_blank">
                            <i class="bi bi-credit-card me-1"></i>Lanjutkan Pembayaran
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="bi bi-credit-card text-muted fs-1"></i>
                <p class="text-muted mt-2">Belum ada riwayat pembayaran</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection