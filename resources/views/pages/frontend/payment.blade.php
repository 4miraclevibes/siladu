@extends('layouts.frontend.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h5 class="mb-3">Riwayat Pembayaran</h5>
            @forelse($payments as $payment)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="card-title mb-1">{{ $payment->user->name }}</h6>
                            <p class="text-muted mb-0">
                                <small>
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ $payment->created_at->format('d M Y') }}
                                </small>
                            </p>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-1">
                                <span class="badge bg-dark rounded-pill px-3">
                                    Rp {{ number_format($payment->payment_amount, 0, ',', '.') }}
                                </span>
                            </h6>
                            <p class="mb-0">
                                @if($payment->payment_status == 'success')
                                    <span class="badge bg-success rounded-pill px-3">
                                        <i class="bi bi-check-circle me-1"></i>Lunas
                                    </span>
                                @elseif($payment->payment_status == 'pending')
                                    <span class="badge bg-warning rounded-pill px-3">
                                        <i class="bi bi-clock me-1"></i>Pending
                                    </span>
                                @elseif($payment->payment_status == 'draft')
                                    <span class="badge bg-primary rounded-pill px-3">
                                        <i class="bi bi-clock me-1"></i>Draft
                                    </span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3">
                                        <i class="bi bi-x-circle me-1"></i>Gagal
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex flex-column">
                                <small class="text-muted mb-1">Metode Pembayaran</small>
                                <span class="badge bg-primary rounded-pill w-auto align-self-start px-3">
                                    {{ ucfirst($payment->payment_method) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column align-items-end">
                                <small class="text-muted mb-1">Kode Pembayaran</small>
                                <code class="fs-6">{{ $payment->payment_code }}</code>
                            </div>
                        </div>
                    </div>

                    @if($payment->payment_status == 'pending')
                        <div class="text-end mt-4">
                            <button type="button" 
                                class="btn btn-primary px-4"
                                data-bs-toggle="modal" 
                                data-bs-target="#generatePayment{{ $payment->id }}">
                                <i class="bi bi-credit-card me-2"></i>Submit Pembayaran
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Modal Generate Payment -->
            <div class="modal fade" id="generatePayment{{ $payment->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('payment.update', $payment->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">Generate Pembayaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <select name="payment_method" class="form-select" required>
                                        <option value="">Pilih metode pembayaran</option>
                                        <option value="cash">Cash</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="payment_proof" class="form-label">Bukti Pembayaran</label>
                                    <input type="file" name="payment_proof" class="form-control" id="payment_proof" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
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