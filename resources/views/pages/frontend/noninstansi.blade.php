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
                        <label class="form-label required">No. WhatsApp Penanggung Jawab</label>
                        <input type="number" class="form-control" name="no_hp_penanggung_jawab" required>
                        <small class="text-muted">
                            Format: Dimulai dengan 628 (contoh: 628123456789).
                            Jangan gunakan awalan +62 atau 0
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5>Data Wilayah</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Provinsi</label>
                        <select class="form-select" name="province_id" id="province_id" required>
                            <option value="">Pilih Provinsi</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Kabupaten/Kota</label>
                        <select class="form-select" name="city_id" id="city_id" required>
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Kecamatan</label>
                        <select class="form-select" name="district_id" id="district_id" required>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Desa/Kelurahan</label>
                        <select class="form-select" name="village_id" id="village_id" required>
                            <option value="">Pilih Desa/Kelurahan</option>
                        </select>
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
                        <label class="form-label required">Parameter Uji</label>
                        <select class="form-select" name="parameter_id" required>
                            <option value="">Pilih Parameter</option>
                            @foreach($parameters as $parameter)
                                <option value="{{ $parameter->id }}">{{ $parameter->name }}</option>
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
                                <input class="form-check-input" type="radio" name="pengembalian_sampel" id="pengembalian_sampel_ya" value="ya" required>
                                <label class="form-check-label" for="pengembalian_sampel_ya">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pengembalian_sampel" id="pengembalian_sampel_tidak" value="tidak" checked required>
                                <label class="form-check-label" for="pengembalian_sampel_tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Status Uji</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pengembalian_sisa_sampel" id="pengembalian_sisa_sampel_ya" value="ya" required>
                                <label class="form-check-label" for="pengembalian_sisa_sampel_ya">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pengembalian_sisa_sampel" id="pengembalian_sisa_sampel_tidak" value="tidak" checked required>
                                <label class="form-check-label" for="pengembalian_sisa_sampel_tidak">Tidak</label>
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

@section('script')
<script>
$('#province_id').on('change', function() {
    var provinceId = $(this).val();
    $('#city_id').empty();
    $('#district_id').empty();
    $('#village_id').empty();

    if(provinceId) {
        $.get('/getCities/' + provinceId, function(cities) {
            $('#city_id').append('<option value="">Pilih Kota/Kabupaten</option>');
            $.each(cities, function(key, city) {
                $('#city_id').append('<option value="'+ city.id +'">'+ city.name +'</option>');
            });
        });
    }
});

$('#city_id').on('change', function() {
    var cityId = $(this).val();
    $('#district_id').empty();
    $('#village_id').empty();

    if(cityId) {
        $.get('/getDistricts/' + cityId, function(districts) {
            $('#district_id').append('<option value="">Pilih Kecamatan</option>');
            $.each(districts, function(key, district) {
                $('#district_id').append('<option value="'+ district.id +'">'+ district.name +'</option>');
            });
        });
    }
});

$('#district_id').on('change', function() {
    var districtId = $(this).val();
    $('#village_id').empty();

    if(districtId) {
        $.get('/getVillages/' + districtId, function(villages) {
            $('#village_id').append('<option value="">Pilih Desa/Kelurahan</option>');
            $.each(villages, function(key, village) {
                $('#village_id').append('<option value="'+ village.id +'">'+ village.name +'</option>');
            });
        });
    }
});
</script>
@endsection
