@extends('layouts.frontend.main')

@section('style')
<style>
    .transaction-list {
        max-height: 800px;
        overflow-y: auto;
    }
    .parameter-name {
        font-size: 14px;
        font-weight: 500;
    }
    .sample-info {
        font-size: 13px;
        color: #6c757d;
    }
    .transaction-date {
        font-size: 12px;
        color: #6c757d;
    }
    .transaction-category {
        font-size: 12px;
        padding: 2px 8px;
        border-radius: 12px;
        background-color: #e9ecef;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('pengajuan') }}" class="btn btn-sm btn-dark mx-1">
            <span class="me-1"><i class="bi bi-clipboard-plus-fill fs-6 text-warning"></i></span> Pengajuan
        </a>
    </div>
    <section class="transactions mb-4">
        <h6 class="mb-3">Semua Transaksi</h6>
        <div class="transaction-list">
            @foreach($transactions as $transaction)
            <div class="card mb-3">
                <div class="card-header bg-light py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="transaction-date">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $transaction->created_at->format('d M Y') }}
                        </div>
                        <span class="transaction-category">
                            {{ ucfirst($transaction->category) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    @if($transaction->category !== 'pribadi')
                    <div class="mb-2 small">
                        <i class="bi bi-building me-1"></i>
                        @if($transaction->category == 'instansi')
                            <span class="text-primary">Instansi:</span>
                        @else
                            <span class="text-primary">Perusahaan:</span>
                        @endif
                        {{ $transaction->instansi }}
                    </div>
                    @endif
                    
                    @foreach($transaction->details as $detail)
                    <div class="border-bottom mb-3 pb-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <div class="parameter-name">
                                    {{ $detail->parameter->name }}
                                </div>
                                <div class="sample-info">
                                    <div><i class="bi bi-box me-1"></i>{{ $detail->jenis_bahan_sampel }}</div>
                                    <div><i class="bi bi-clipboard-check me-1"></i>Kondisi: {{ $detail->kondisi_sampel }}</div>
                                    <div><i class="bi bi-123 me-1"></i>Jumlah: {{ $detail->jumlah_sampel }} sampel</div>
                                </div>
                            </div>
                            <div class="text-end">
                                    @if($detail->status == 'success')
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Lunas
                                        </span>
                                    @elseif($detail->status == 'pending')
                                        <span class="badge bg-warning">
                                            <i class="bi bi-clock me-1"></i>Pending
                                        </span>
                                    @elseif($detail->status == 'process')
                                        <span class="badge bg-primary">
                                            <i class="bi bi-clock me-1"></i>Process
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle me-1"></i>Gagal
                                        </span>
                                    @endif
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            @if($detail->payment && $detail->payment->payment_link && $detail->payment->payment_status == 'pending')
                                <a href="{{ $detail->payment->payment_link }}"
                                   class="btn btn-sm btn-primary"
                                   target="_blank">
                                    <i class="bi bi-credit-card me-1"></i>Bayar
                                </a>
                            @endif
                            <a href="{{ route('transaction.show', $detail->id) }}"
                               class="btn btn-sm btn-info">
                                <i class="bi bi-eye me-1"></i>Detail
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
