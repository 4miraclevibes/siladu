@extends('layouts.frontend.main')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">Detail Transaksi</h5>
                <a href="{{ route('transaction') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>

            <!-- Informasi Proyek -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="card-subtitle text-primary">
                            <i class="bi bi-briefcase me-2"></i>Informasi Proyek
                        </h6>
                        <div>
                            @if($transaction->payment)
                                @if($transaction->payment->payment_status == 'paid')
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
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Nama Proyek:</strong></p>
                            <p class="text-muted">{{ $transaction->nama_proyek }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Kategori:</strong></p>
                            <p class="text-muted">{{ ucfirst($transaction->category) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Jenis Bahan Sampel:</strong></p>
                            <p class="text-muted">{{ $transaction->jenis_bahan_sampel }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Status Uji:</strong></p>
                            <p class="mb-0">
                                <span class="badge bg-{{ $transaction->status_uji == 'selesai' ? 'success' : 'warning' }} rounded-pill">
                                    {{ ucfirst($transaction->status_uji) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Penanggung Jawab -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-subtitle text-primary mb-3">
                        <i class="bi bi-person me-2"></i>Penanggung Jawab
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Nama:</strong></p>
                            <p class="text-muted">{{ $transaction->nama_penanggung_jawab }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Identitas:</strong></p>
                            <p class="text-muted">{{ $transaction->identitas_penanggung_jawab }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Email:</strong></p>
                            <p class="text-muted">{{ $transaction->email_penanggung_jawab }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>No. HP:</strong></p>
                            <p class="text-muted">{{ $transaction->no_hp_penanggung_jawab }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Instansi -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-subtitle text-primary mb-3">
                        <i class="bi bi-building me-2"></i>Informasi Instansi
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Nama Instansi:</strong></p>
                            <p class="text-muted">{{ $transaction->nama_instansi }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Email:</strong></p>
                            <p class="text-muted">{{ $transaction->email_instansi }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Telepon:</strong></p>
                            <p class="text-muted">{{ $transaction->telepon_instansi }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Alamat:</strong></p>
                            <p class="text-muted">{{ $transaction->alamat_instansi }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Teknis -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-subtitle text-primary mb-3">
                        <i class="bi bi-gear me-2"></i>Informasi Teknis
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Parameter:</strong></p>
                            <p class="text-muted">{{ $transaction->parameter->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Lokasi:</strong></p>
                            <p class="text-muted">{{ $transaction->location->name }}</p>
                        </div>
                        <div class="col-md-12">
                            <p class="mb-1"><strong>Standar Kualitas:</strong></p>
                            <p class="text-muted">{{ $transaction->qualityStandart->name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Pembayaran -->
            @if($transaction->payment)
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-subtitle text-primary mb-3">
                        <i class="bi bi-credit-card me-2"></i>Informasi Pembayaran
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Metode Pembayaran:</strong></p>
                            <p class="mb-0">
                                <span class="badge bg-primary rounded-pill">
                                    {{ ucfirst($transaction->payment->payment_method) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Nominal:</strong></p>
                            <p class="mb-0">
                                <span class="badge bg-dark rounded-pill">
                                    Rp {{ number_format($transaction->payment->payment_amount, 0, ',', '.') }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Kode Pembayaran:</strong></p>
                            <p class="mb-0"><code>{{ $transaction->payment->payment_code }}</code></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Status:</strong></p>
                            <p class="mb-0">
                                @if($transaction->payment->payment_status == 'paid')
                                    <span class="badge bg-success rounded-pill">Lunas</span>
                                @elseif($transaction->payment->payment_status == 'pending')
                                    <span class="badge bg-warning rounded-pill">Pending</span>
                                @else
                                    <span class="badge bg-danger rounded-pill">Gagal</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($transaction->payment->payment_link && $transaction->payment->payment_status == 'pending')
                    <div class="text-end mt-3">
                        <a href="{{ $transaction->payment->payment_link }}" 
                           class="btn btn-primary"
                           target="_blank">
                            <i class="bi bi-credit-card me-1"></i>Lanjutkan Pembayaran
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Informasi Surat -->
            <div class="card">
                <div class="card-body">
                    <h6 class="card-subtitle text-primary mb-3">
                        <i class="bi bi-file-text me-2"></i>Informasi Surat
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>No. Surat:</strong></p>
                            <p class="text-muted">{{ $transaction->no_surat }}</p>
                        </div>
                        @if($transaction->file_surat)
                        <div class="col-md-6">
                            <p class="mb-1"><strong>File Surat:</strong></p>
                            <a href="{{ Storage::url($transaction->file_surat) }}" 
                               class="btn btn-outline-primary btn-sm"
                               target="_blank">
                                <i class="bi bi-download me-1"></i>Download Surat
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
