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
            <th class="text-white">Nama Pelanggan</th>
            <th class="text-white">Metode Pembayaran</th>
            <th class="text-white">Nominal</th>
            <th class="text-white">Status</th>
            <th class="text-white">Kode Pembayaran</th>
            <th class="text-white">Payment Proof</th>
            <th class="text-white">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($payments as $payment)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $payment->user->name }}</td>
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
                @if($payment->payment_status == 'success')
                    <span class="badge bg-success rounded-pill">
                        <i class="bx bx-check-circle me-1"></i>Lunas
                    </span>
                @elseif($payment->payment_status == 'pending')
                    <span class="badge bg-warning rounded-pill">
                        <i class="bx bx-time-five me-1"></i>Pending
                    </span>
                @elseif($payment->payment_status == 'draft')
                    <span class="badge bg-primary rounded-pill">
                        <i class="bx bx-time-five me-1"></i>Draft
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
            <td><a href="{{ Storage::url($payment->payment_proof) }}"></a></td>
            <td>
                <div class="btn-group">
                    <a href="{{ route('dashboard.transactions.show', $payment->transactionDetail->id) }}" 
                       class="btn btn-primary btn-sm ms-1"
                       data-bs-toggle="tooltip"
                       title="Detail Transaksi">
                        <i class="bx bx-detail"></i>
                    </a>
                    <button type="button" class="btn btn-warning btn-sm ms-1" data-bs-toggle="modal" data-bs-target="#updatePayment{{ $payment->id }}">
                        <i class="bx bx-edit"></i>
                    </button>
                </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@foreach ($payments as $payment)
<div class="modal fade" id="updatePayment{{ $payment->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('dashboard.payments.update', $payment->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Perbarui Status Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="payment_status" class="form-label">Status Pembayaran</label>
                        <select name="payment_status" class="form-select" required>
                            <option value="draft" {{ $payment->payment_status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="success" {{ $payment->payment_status == 'success' ? 'selected' : '' }}>Lunas</option>
                            <option value="pending" {{ $payment->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="failed" {{ $payment->payment_status == 'failed' ? 'selected' : '' }}>Gagal</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
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