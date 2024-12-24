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
            <th class="text-white">Jumlah Sampel</th>
            <th class="text-white">Kategori</th>
            <th class="text-white">Status</th>
            <th class="text-white">Status Pembayaran</th>
            <th class="text-white">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($transactions as $transaction)
            @foreach ($transaction->details as $detail)
            <tr>
              <th scope="row">{{ $loop->parent->iteration }}</th>
              <td>{{ $transaction->user->name }}</td>
              <td>{{ $transaction->instansi ?? '-' }}</td>
              <td>{{ $detail->parameter->name }}</td>
              <td>{{ $detail->jumlah_sampel }}</td>
              <td>{{ $detail->transaction->category }}</td>
              <td>
                @if($detail->status == 'pending')
                  <span class="badge bg-warning">Pending</span>
                @elseif($detail->status == 'process')
                  <span class="badge bg-info">Process</span>
                @else
                  <span class="badge bg-success">Done</span>
                @endif
              </td>
              <td>
                  @if($detail->payment->payment_status == 'success')
                      <span class="badge bg-success">Lunas</span>
                  @elseif($detail->payment->payment_status == 'pending')
                      <span class="badge bg-warning">Pending</span>
                  @else
                      <span class="badge bg-danger">Gagal</span>
                  @endif
              </td>
              <td>
                <div class="btn-group">
                  <form action="{{ route('dashboard.transactions.updateStatus', $detail->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('PATCH')
                    @if($detail->status == 'pending')
                      <button type="submit" name="status" value="accept" class="btn btn-info btn-sm">Terima</button>
                    @elseif($detail->status == 'accept')
                      <button type="submit" name="status" value="process" class="btn btn-info btn-sm">Proses</button>
                    @elseif($detail->status == 'process')
                      <button type="submit" name="status" value="selesai" class="btn btn-success btn-sm">Selesai</button>
                    @endif
                  </form>
                  <a href="{{ route('dashboard.transactions.show', $detail->id) }}" class="btn btn-primary btn-sm ms-2">Detail</a>
                </div>
              </td>
            </tr>
            @endforeach
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
