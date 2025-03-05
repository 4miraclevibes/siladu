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
                                @if($detail->status == 'success')
                                    <span class="badge bg-success rounded-pill">
                                        <i class="bi bi-check-circle me-1"></i>Lunas
                                    </span>
                                @elseif($detail->status == 'pending')
                                    <span class="badge bg-warning rounded-pill">
                                        <i class="bi bi-clock me-1"></i>Pending
                                    </span>
                                @else
                                    <span class="badge bg-danger rounded-pill">
                                        <i class="bi bi-x-circle me-1"></i>Gagal
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Kategori:</strong></p>
                            <p class="text-muted">{{ ucfirst($detail->transaction->category) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Jenis Bahan Sampel:</strong></p>
                            <p class="text-muted">{{ $detail->jenis_bahan_sampel }}</p>
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
                            <p class="text-muted">{{ $detail->transaction->user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Email:</strong></p>
                            <p class="text-muted">{{ $detail->transaction->user->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>No. HP:</strong></p>
                            <p class="text-muted">{{ $detail->transaction->phone }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($detail->transaction->category == 'instansi')
            <!-- Informasi Instansi -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-subtitle text-primary mb-3">
                        <i class="bi bi-building me-2"></i>Informasi Instansi
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Nama Instansi:</strong></p>
                            <p class="text-muted">{{ $detail->nama_instansi }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Email:</strong></p>
                            <p class="text-muted">{{ $detail->email_instansi }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Telepon:</strong></p>
                            <p class="text-muted">{{ $detail->telepon_instansi }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Alamat:</strong></p>
                            <p class="text-muted">{{ $detail->alamat_instansi }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!-- Informasi Teknis -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-subtitle text-primary mb-3">
                        <i class="bi bi-gear me-2"></i>Informasi Teknis
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Parameter:</strong></p>
                            <p class="text-muted">{{ $detail->parameter->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Jenis Bahan Sampel:</strong></p>
                            <p class="text-muted">{{ $detail->jenis_bahan_sampel }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Kondisi Sampel:</strong></p>
                            <p class="text-muted">{{ $detail->kondisi_sampel }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Jumlah Sampel:</strong></p>
                            <p class="text-muted">{{ $detail->jumlah_sampel }}</p>
                        </div>
                        <div class="col-12">
                            <p class="mb-1"><strong>Aktivitas:</strong></p>
                            <p class="text-muted">{{ $detail->activity }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Pembayaran -->
            @if($detail->payment)
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
                                    {{ ucfirst($detail->payment->payment_method ?? '-') }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Nominal:</strong></p>
                            <p class="mb-0">
                                <span class="badge bg-dark rounded-pill">
                                    Rp {{ number_format($detail->payment->payment_amount, 0, ',', '.') }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Kode Pembayaran:</strong></p>
                            <p class="mb-0"><code>{{ $detail->payment->payment_code }}</code></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Status:</strong></p>
                            <p class="mb-0">
                                @if($detail->payment->payment_status == 'success')
                                    <span class="badge bg-success rounded-pill">Lunas</span>
                                @elseif($detail->payment->payment_status == 'pending')
                                    <span class="badge bg-warning rounded-pill">Pending</span>
                                @elseif($detail->payment->payment_status == 'draft')
                                    <span class="badge bg-primary rounded-pill">Draft</span>
                                @else
                                    <span class="badge bg-danger rounded-pill">Gagal</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($detail->payment->payment_link && $detail->payment->payment_status == 'pending')
                    <div class="text-end mt-3">
                        <a href="{{ $detail->payment->payment_link }}"
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
                            <p class="text-muted">{{ $detail->no_surat }}</p>
                        </div>
                        @if($detail->file_surat)
                        <div class="col-md-6">
                            <p class="mb-1"><strong>File Surat:</strong></p>
                            <a href="{{ Storage::url($detail->file_surat) }}"
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
