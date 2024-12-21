@extends('layouts.frontend.main')

@section('style')
<style>
    .transaction-list {
        max-height: 800px;
        overflow-y: auto;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('noninstansi') }}" class="btn btn-sm btn-dark mx-1">
            <span class="me-1"><i class="bi bi-clipboard-plus-fill fs-6 text-warning"></i></span> Pengajuan
        </a>
    </div>
    <section class="transactions mb-4">
        <h6 class="mb-3">
            Semua Transaksi
        </h6>
        <div class="transaction-list">
            @foreach($transactions as $transaction)
            <div class="card mb-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">{{ $transaction->nama_proyek }}</h6>
                            <p class="card-text text-muted mb-0">{{ $transaction->nama_instansi }}</p>
                            <small class="text-muted">{{ $transaction->created_at->format('d M Y') }}</small>
                        </div>
                        <div class="text-end d-flex flex-column align-items-end">
                            <h6 class="mb-2">
                                @if($transaction->payment)
                                    @if($transaction->payment->payment_status == 'success')
                                        <span class="badge bg-success rounded-pill">
                                            <i class="bi bi-check-circle me-1"></i>Lunas
                                        </span>
                                    @elseif($transaction->payment->payment_status == 'pending')
                                        <span class="badge bg-warning rounded-pill">
                                            <i class="bi bi-clock me-1"></i>Pending
                                        </span>
                                    @else
                                        <span class="badge bg-danger rounded-pill">
                                            <i class="bi bi-x-circle me-1"></i>Gagal
                                        </span>
                                    @endif
                                @endif
                            </h6>
                            <div>
                                @if($transaction->payment && $transaction->payment->payment_link)
                                    <a href="{{ $transaction->payment->payment_link }}"
                                       class="btn btn-sm btn-primary"
                                       target="_blank">
                                        <i class="bi bi-credit-card me-1"></i>Bayar
                                    </a>
                                @endif
                                <a href="{{ route('transaction.show', $transaction->id) }}"
                                   class="btn btn-sm btn-info ms-1">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
