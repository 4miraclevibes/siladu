@extends('layouts.backend.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
        <div class="btn-group">
            <a href="{{ route('dashboard.transactions.index') }}" class="btn btn-primary btn-sm me-2">Semua</a>
            <a href="{{ route('dashboard.transactions.index', ['category' => 'instansi']) }}" class="btn btn-warning btn-sm me-2">Instansi</a>
            <a href="{{ route('dashboard.transactions.index', ['category' => 'non_instansi']) }}" class="btn btn-dark btn-sm">Non Instansi</a>
        </div>
    </div>
  </div>
  <div class="card mt-2">
    <h5 class="card-header">Tabel Transaksi</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Penanggung Jawab</th>
            <th class="text-white">Instansi</th>
            <th class="text-white">Parameter</th>
            <th class="text-white">Status</th>
            <th class="text-white">Status Pembayaran</th>
            <th class="text-white">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($transactions as $transaction)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $transaction->nama_penanggung_jawab }}</td>
            <td>{{ $transaction->nama_instansi }}</td>
            <td>{{ $transaction->parameter->name }}</td>
            <td>
              @if($transaction->status == 'pending')
                <span class="badge bg-warning">Pending</span>
              @elseif($transaction->status == 'process')
                <span class="badge bg-info">Process</span>
              @else
                <span class="badge bg-success">Done</span>
              @endif
            </td>
            <td>
                @if($transaction->payment->payment_status == 'paid')
                    <span class="badge bg-success">Lunas</span>
                @else
                    <span class="badge bg-danger">Belum Lunas</span>
                @endif
            </td>
            <td>
              <div class="btn-group">
                <form action="{{ route('dashboard.transactions.updateStatus', $transaction->id) }}" method="POST" style="display:inline-block;">
                  @csrf
                  @method('PATCH')
                  @if($transaction->status == 'pending')
                    <button type="submit" name="status" value="accept" class="btn btn-info btn-sm">Terima</button>
                  @elseif($transaction->status == 'accept')
                    <button type="submit" name="status" value="process" class="btn btn-info btn-sm">Proses</button>
                  @elseif($transaction->status == 'process')
                    <button type="submit" name="status" value="selesai" class="btn btn-success btn-sm">Selesai</button>
                  @endif
                </form>
                <a href="{{ route('dashboard.transactions.show', $transaction->id) }}" class="btn btn-primary btn-sm ms-2">Detail</a>
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
