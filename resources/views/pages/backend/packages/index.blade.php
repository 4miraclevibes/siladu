@extends('layouts.backend.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">Create</button>
    </div>
  </div>
  <div class="card mt-2">
    <h5 class="card-header">Tabel Package</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Nama</th>
            <th class="text-white">Satuan</th>
            <th class="text-white">Harga</th>
            <th class="text-white">Laboratory</th>
            <th class="text-white">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($packages as $package)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $package->name }}</td>
            <td>{{ $package->satuan }}</td>
            <td>Rp {{ number_format($package->harga, 0, ',', '.') }}</td>
            <td>{{ $package->laboratory->name }}</td>
            <td>
                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $package->id }}">Detail</button>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $package->id }}">Edit</button>
                <form action="{{ route('packages.destroy', $package->id) }}" method="POST" style="display:inline-block;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- / Content -->

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Package</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('packages.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" class="form-control" name="name" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Satuan</label>
            <input type="text" class="form-control" name="satuan" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" class="form-control" name="harga" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Catatan</label>
            <textarea class="form-control" name="catatan" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Laboratory</label>
            <select class="form-select" name="laboratory_id" required>
              <option value="">Pilih Laboratory</option>
              @foreach($laboratories as $laboratory)
                <option value="{{ $laboratory->id }}">{{ $laboratory->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Modal -->
@foreach($packages as $package)
<div class="modal fade" id="editModal{{ $package->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Package</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('packages.update', $package->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" class="form-control" name="name" value="{{ $package->name }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Satuan</label>
            <input type="text" class="form-control" name="satuan" value="{{ $package->satuan }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" class="form-control" name="harga" value="{{ $package->harga }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Catatan</label>
            <textarea class="form-control" name="catatan" rows="3">{{ $package->catatan }}</textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Laboratory</label>
            <select class="form-select" name="laboratory_id" required>
              <option value="">Pilih Laboratory</option>
              @foreach($laboratories as $laboratory)
                <option value="{{ $laboratory->id }}" {{ $package->laboratory_id == $laboratory->id ? 'selected' : '' }}>
                  {{ $laboratory->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

<!-- Detail Modal -->
@foreach($packages as $package)
<div class="modal fade" id="detailModal{{ $package->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Package</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-4 fw-bold">Nama</div>
          <div class="col-8">{{ $package->name }}</div>
        </div>
        <div class="row mb-3">
          <div class="col-4 fw-bold">Satuan</div>
          <div class="col-8">{{ $package->satuan }}</div>
        </div>
        <div class="row mb-3">
          <div class="col-4 fw-bold">Harga</div>
          <div class="col-8">Rp {{ number_format($package->harga, 0, ',', '.') }}</div>
        </div>
        <div class="row mb-3">
          <div class="col-4 fw-bold">Laboratory</div>
          <div class="col-8">{{ $package->laboratory->name }}</div>
        </div>
        @if($package->catatan)
        <div class="row mb-3">
          <div class="col-4 fw-bold">Catatan</div>
          <div class="col-8">{{ $package->catatan }}</div>
        </div>
        @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endforeach
@endsection