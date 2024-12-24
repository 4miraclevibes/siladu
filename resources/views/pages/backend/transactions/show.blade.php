@extends('layouts.backend.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary">
                    <h5 class="mb-0 text-white"><i class="bx bx-detail me-2"></i>Detail Transaksi</h5>
                    <a href="{{ route('dashboard.transactions.index') }}" class="btn btn-light btn-sm">
                        <i class="bx bx-arrow-back me-1"></i>Kembali
                    </a>
                </div>

                <div class="card-body mt-2">
                    <div class="row">
                        <!-- Informasi Proyek -->
                        <div class="col-md-12 mb-4">
                            <div class="card shadow-sm border-primary border-top border-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bx bx-building-house text-primary fs-3 me-2"></i>
                                        <h6 class="card-subtitle text-primary mb-0">Informasi Proyek</h6>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="p-3 bg-light rounded">
                                                <p class="mb-2"><i class="bx bx-category me-2"></i><strong>Kategori:</strong> {{ ucfirst($transactionDetail->transaction->category) }}</p>
                                                <p class="mb-0"><i class="bx bx-test-tube me-2"></i><strong>Jenis Bahan Sampel:</strong> {{ $transactionDetail->jenis_bahan_sampel }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 bg-light rounded">
                                                <p class="mb-2">
                                                    <i class="bx bx-check-circle me-2"></i><strong>Pengembalian sample:</strong>
                                                    <span class="badge bg-{{ $transactionDetail->transaction->status_pengembalian_hasil == 'dikembalikan' ? 'success' : 'warning' }} rounded-pill">
                                                        {{ ucfirst($transactionDetail->transaction->status_pengembalian_hasil) }}
                                                    </span>
                                                </p>
                                                <p class="mb-2">
                                                    <i class="bx bx-transfer me-2"></i><strong>Pengembalian sisa sample:</strong>
                                                    <span class="badge bg-{{ $transactionDetail->transaction->status_pengembalian_sisa == 'dikembalikan' ? 'success' : 'warning' }} rounded-pill">
                                                        {{ ucfirst($transactionDetail->transaction->status_pengembalian_sisa) }}
                                                    </span>
                                                </p>
                                                <p class="mb-0">
                                                    <i class="bx bx-info-circle me-2"></i><strong>Status:</strong>
                                                    <span class="badge bg-{{
                                                        $transactionDetail->status == 'pending' ? 'warning' :
                                                        ($transactionDetail->status == 'process' ? 'info' : 'success')
                                                    }} rounded-pill">
                                                        {{ ucfirst($transactionDetail->status) }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Penanggung Jawab -->
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm border-info border-top border-4 h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bx bx-user text-info fs-3 me-2"></i>
                                        <h6 class="card-subtitle text-info mb-0">Penanggung Jawab</h6>
                                    </div>
                                    <div class="p-3 bg-light rounded">
                                        <p class="mb-2"><i class="bx bx-user-circle me-2"></i><strong>Nama:</strong> {{ $transactionDetail->transaction->user->name }}</p>
                                        <p class="mb-2"><i class="bx bx-envelope me-2"></i><strong>Email:</strong> {{ $transactionDetail->transaction->user->email }}</p>
                                        <p class="mb-0"><i class="bx bx-phone me-2"></i><strong>No. HP:</strong> {{ $transactionDetail->transaction->phone }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Instansi -->
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm border-success border-top border-4 h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bx bx-buildings text-success fs-3 me-2"></i>
                                        <h6 class="card-subtitle text-success mb-0">Informasi Instansi</h6>
                                    </div>
                                    <div class="p-3 bg-light rounded">
                                        <p class="mb-2"><i class="bx bx-building me-2"></i><strong>Instansi:</strong> {{ $transactionDetail->transaction->instansi }}</p>
                                        <p class="mb-2"><i class="bx bx-map-pin me-2"></i><strong>Provinsi:</strong> {{ $transactionDetail->transaction->province->name }}</p>
                                        <p class="mb-2"><i class="bx bx-map-pin me-2"></i><strong>Kota:</strong> {{ $transactionDetail->transaction->city->name }}</p>
                                        <p class="mb-0"><i class="bx bx-map me-2"></i><strong>Alamat:</strong> {{ $transactionDetail->transaction->address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Teknis -->
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm border-warning border-top border-4 h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bx bx-cog text-warning fs-3 me-2"></i>
                                        <h6 class="card-subtitle text-warning mb-0">Informasi Teknis</h6>
                                    </div>
                                    <div class="p-3 bg-light rounded">
                                        <p class="mb-2"><i class="bx bx-test-tube me-2"></i><strong>Parameter:</strong> {{ $transactionDetail->parameter->name }}</p>
                                        <p class="mb-2"><i class="bx bx-package me-2"></i><strong>Kondisi Sampel:</strong> {{ $transactionDetail->kondisi_sampel }}</p>
                                        <p class="mb-2"><i class="bx bx-cube me-2"></i><strong>Jumlah Sampel:</strong> {{ $transactionDetail->jumlah_sampel }}</p>
                                        <p class="mb-0"><i class="bx bx-task me-2"></i><strong>Aktivitas:</strong> {{ $transactionDetail->activity }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Surat -->
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm border-danger border-top border-4 h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bx bx-file text-danger fs-3 me-2"></i>
                                        <h6 class="card-subtitle text-danger mb-0">Informasi Surat</h6>
                                    </div>
                                    <div class="p-3 bg-light rounded">
                                        <p class="mb-3"><i class="bx bx-hash me-2"></i><strong>No. Surat:</strong> {{ $transactionDetail->transaction->no_surat }}</p>
                                        @if($transactionDetail->transaction->file_surat)
                                        <a href="{{ Storage::url($transactionDetail->transaction->file_surat) }}"
                                           class="btn btn-outline-danger btn-sm"
                                           target="_blank">
                                            <i class="bx bx-download me-1"></i> Download Surat
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Actions -->
                        <div class="col-md-12">
                            <div class="card shadow-sm border-dark border-top border-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bx bx-task text-dark fs-3 me-2"></i>
                                        <h6 class="card-subtitle text-dark mb-0">Aksi</h6>
                                    </div>
                                    <form action="{{ route('dashboard.transactions.updateStatus', $transactionDetail->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        @if($transactionDetail->status == 'pending')
                                            <button type="submit" name="status" value="process" class="btn btn-info">
                                                <i class="bx bx-play-circle me-1"></i> Proses Transaksi
                                            </button>
                                        @elseif($transactionDetail->status == 'process')
                                            <button type="submit" name="status" value="done" class="btn btn-success">
                                                <i class="bx bx-check-circle me-1"></i> Selesaikan Transaksi
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
