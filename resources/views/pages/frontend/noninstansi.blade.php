@extends('layouts.frontend.main')

@section('style')
<style>
    .required:after {
        content: ' *';
        color: red;
    }
    
    /* Style untuk tampilan mobile yang lebih compact */
    .card {
        margin-bottom: 0.8rem !important;
    }
    
    .card-header {
        padding: 0.5rem 1rem !important;
    }
    
    .card-body {
        padding: 0.8rem !important;
    }
    
    .mb-3 {
        margin-bottom: 0.5rem !important;
    }
    
    .form-label {
        margin-bottom: 0.2rem !important;
        font-size: 0.9rem;
    }
    
    .form-control, .form-select {
        padding: 0.3rem 0.5rem !important;
        font-size: 0.9rem;
    }
    
    .content {
        padding: 0.8rem !important;
    }
    
    h2 {
        font-size: 1.5rem !important;
        margin-bottom: 1rem !important;
    }
    
    h5 {
        font-size: 1rem !important;
        margin-bottom: 0 !important;
    }
    
    textarea {
        height: 60px !important;
    }
</style>
@endsection

@section('content')
<div class="container content">
    <h2>Form Pengajuan Uji - Non Instansi</h2>

    <form action="{{ route('noninstansi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="category" value="noninstansi">
        
        <div class="card mb-4">
            <div class="card-header">
                <h5>Data Penanggung Jawab</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Nama Penanggung Jawab</label>
                        <input type="text" class="form-control" name="nama_penanggung_jawab" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Identitas Penanggung Jawab</label>
                        <input type="number" class="form-control" name="identitas_penanggung_jawab" required>
                        <small class="text-muted">Silakan isi dengan NIM untuk mahasiswa, NIP untuk pegawai UNP, selain itu silakan isi dengan no. KTP</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Email Penanggung Jawab</label>
                        <input type="email" class="form-control" name="email_penanggung_jawab" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">No. HP Penanggung Jawab</label>
                        <input type="number" class="form-control" name="no_hp_penanggung_jawab" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5>Data Pengujian</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Nama Proyek</label>
                        <input type="text" class="form-control" name="nama_proyek" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Parameter Uji</label>
                        <select class="form-select" name="parameter_id" required>
                            <option value="">Pilih Parameter</option>
                            @foreach($parameters as $parameter)
                                <option value="{{ $parameter->id }}">{{ $parameter->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Lokasi Pengambilan Sampel</label>
                        <select class="form-select" name="location_id" required>
                            <option value="">Pilih Lokasi</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Standar Mutu</label>
                        <select class="form-select" name="quality_standart_id" required>
                            <option value="">Pilih Standar Mutu</option>
                            @foreach($qualityStandarts as $qs)
                                <option value="{{ $qs->id }}">{{ $qs->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Jenis Bahan Sampel</label>
                        <input type="text" class="form-control" name="jenis_bahan_sampel" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nomor Surat</label>
                        <input type="text" class="form-control" name="no_surat">
                        <small class="text-muted">(Opsional)</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">File Surat</label>
                        <input type="file" class="form-control" name="file_surat" accept=".png,.jpg,.pdf">
                        <small class="text-muted">File Surat Permohonan (opsional)<br>Max File Size: 1 Mb (png/jpg/pdf)</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5>Status Pengujian</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Status Pengembalian</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status_pengembalian" id="pengembalian_ya" value="ya" required>
                                <label class="form-check-label" for="pengembalian_ya">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status_pengembalian" id="pengembalian_tidak" value="tidak" checked required>
                                <label class="form-check-label" for="pengembalian_tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Status Uji</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status_uji" id="uji_ya" value="ya" required>
                                <label class="form-check-label" for="uji_ya">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status_uji" id="uji_tidak" value="tidak" checked required>
                                <label class="form-check-label" for="uji_tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end mb-4">
            <button type="submit" class="btn btn-primary">Submit Pengajuan</button>
        </div>
    </form>
</div>
@endsection