@extends('layouts.backend.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <h5 class="card-header">
        <i class="bx bx-money me-2"></i>Data Pembayaran
    </h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table table-hover" id="example">
        <thead>
          <tr class="text-nowrap bg-primary">
            <th class="text-white">No</th>
            <th class="text-white">Nama Proyek</th>
            <th class="text-white">Metode Pembayaran</th>
            <th class="text-white">Nominal</th>
            <th class="text-white">Status</th>
            <th class="text-white">Kode Pembayaran</th>
            <th class="text-white">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($payments as $payment)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $payment->transaction->nama_proyek }}</td>
            <td>
                <span class="badge bg-primary rounded-pill">
                    {{ ucfirst($payment->payment_method) }}
                </span>
            </td>
            <td>
                <span class="badge bg-dark rounded-pill">
                    Rp {{ number_format($payment->payment_amount, 0, ',', '.') }}
                </span>
            </td>
            <td>
                @if($payment->payment_status == 'paid')
                    <span class="badge bg-success rounded-pill">
                        <i class="bx bx-check-circle me-1"></i>Lunas
                    </span>
                @elseif($payment->payment_status == 'pending')
                    <span class="badge bg-warning rounded-pill">
                        <i class="bx bx-time-five me-1"></i>Pending
                    </span>
                @else
                    <span class="badge bg-danger rounded-pill">
                        <i class="bx bx-x-circle me-1"></i>Gagal
                    </span>
                @endif
            </td>
            <td>
                <code>{{ $payment->payment_code }}</code>
            </td>
            <td>
                <div class="btn-group">
                    @if($payment->payment_link)
                    <a href="{{ $payment->payment_link }}" 
                       class="btn btn-info btn-sm"
                       target="_blank"
                       data-bs-toggle="tooltip"
                       title="Link Pembayaran">
                        <i class="bx bx-link"></i>
                    </a>
                    @endif
                    <a href="{{ route('dashboard.transactions.show', $payment->transaction_id) }}" 
                       class="btn btn-primary btn-sm ms-1"
                       data-bs-toggle="tooltip"
                       title="Detail Transaksi">
                        <i class="bx bx-detail"></i>
                    </a>
                </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });
  });
</script>
@endpush