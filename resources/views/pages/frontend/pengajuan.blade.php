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
    <h2>Form Pengajuan Uji - Pengajuan</h2>

    <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card mb-4">
            <div class="card-header">
                <h5>Kategori Pengajuan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label required">Kategori</label>
                        <select class="form-select" name="category" id="category" required>
                            <option value="">Pilih Kategori</option>
                            <option value="instansi">Instansi</option>
                            <option value="perusahaan">Perusahaan</option>
                            <option value="pribadi">Pribadi</option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3" id="instansiField" style="display: none;">
                        <label class="form-label required">Nama Instansi</label>
                        <input type="text" class="form-control" name="instansi" placeholder="Masukkan nama instansi">
                    </div>
                    <div class="col-md-12 mb-3" id="perusahaanField" style="display: none;">
                        <label class="form-label required">Nama Perusahaan</label>
                        <input type="text" class="form-control" name="instansi" placeholder="Masukkan nama perusahaan">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label required">No. WhatsApp</label>
                        <input type="number" class="form-control" name="phone" required>
                        <small class="text-muted">
                            Format: Dimulai dengan 628 (contoh: 628123456789).
                            Jangan gunakan awalan +62 atau 0
                        </small>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Nomor Surat</label>
                        <input type="text" class="form-control" name="no_surat">
                        <small class="text-muted">(Opsional)</small>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">File Surat</label>
                        <input type="file" class="form-control" name="file_surat" accept=".png,.jpg,.pdf">
                        <small class="text-muted">File Surat Permohonan (opsional)<br>Max File Size: 1 Mb (png/jpg/pdf)</small>
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
                    <div class="col-md-12 mb-3">
                        <label class="form-label required">Provinsi</label>
                        <select class="form-select" name="province_id" id="province_id" required>
                            <option value="">Pilih Provinsi</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label required">Kabupaten/Kota</label>
                        <select class="form-select" name="city_id" id="city_id" required>
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label required">Kecamatan</label>
                        <select class="form-select" name="district_id" id="district_id" required>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label required">Alamat Lengkap</label>
                        <textarea class="form-control shadow-none" name="address" required 
                                  placeholder="Masukkan alamat lengkap (nama jalan, nomor rumah, RT/RW, dll)"></textarea>
                        <small class="text-muted">Masukkan alamat detail lokasi Anda</small>
                    </div>
                </div>
            </div>
        </div>

        <div id="containerPengujian">
            <div class="pengujian-item mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Data Pengujian</h5>
                        <button type="button" class="btn btn-outline-danger rounded-circle hapus-pengujian" style="display: none;">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label required">Parameter Uji</label>
                                <select class="form-select shadow-none parameter-select" name="details[0][parameter_id]" required>
                                    <option value="">Pilih Parameter</option>
                                    @foreach($parameters as $parameter)
                                        <option value="{{ $parameter->id }}" data-harga="{{ $parameter->package->harga }}">{{ $parameter->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label required">Bahan Sampel</label>
                                <input type="text" class="form-control shadow-none" name="details[0][jenis_bahan_sampel]" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label required">Jumlah Sampel</label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-outline-secondary btn-minus">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="number" class="form-control text-center shadow-none jumlah-sampel" 
                                           name="details[0][jumlah_sampel]" 
                                           value="1" 
                                           readonly 
                                           required>
                                    <button type="button" class="btn btn-outline-secondary btn-plus">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label required">Kondisi Sampel</label>
                                <input type="text" class="form-control shadow-none" 
                                       name="details[0][kondisi_sampel]" 
                                       placeholder="Masukkan kondisi sampel"
                                       required>
                                <small class="text-muted">Contoh: Baik, Rusak, Kadaluarsa, dll</small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label required">Aktivitas</label>
                                <textarea class="form-control shadow-none" name="details[0][activity]" required 
                                          placeholder="Jelaskan aktivitas pengujian yang diinginkan"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="border rounded p-2 bg-light">
                                    Biaya Pengujian: <strong class="biaya-pengujian">Rp 0</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end mb-4">
            <button type="button" class="btn btn-primary" id="tambahPengujian">
                <i class="bi bi-plus-lg"></i> Tambah
            </button>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5>Status Pengujian</h5>
            </div>
            <div class="card-body">
                <div class="border rounded p-2 bg-light mb-3">
                    <small>
                        <i class="bi bi-info-circle text-info"></i> 
                        Status ini akan berlaku untuk semua sampel yang diajukan
                    </small>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label required">Pengembalian Sampel Sisa</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status_pengembalian_sisa" id="status_pengembalian_sisa_ya" value="1" required>
                                <label class="form-check-label" for="status_pengembalian_sisa_ya">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status_pengembalian_sisa" id="status_pengembalian_sisa_tidak" value="0" checked required>
                                <label class="form-check-label" for="status_pengembalian_sisa_tidak">Tidak</label>
                            </div>
                        </div>
                        <small class="text-muted">Apakah Anda ingin sisa sampel dikembalikan setelah pengujian?</small>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label required">Pengembalian Sampel Hasil</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status_pengembalian_hasil" id="status_pengembalian_hasil_ya" value="1" required>
                                <label class="form-check-label" for="status_pengembalian_hasil_ya">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status_pengembalian_hasil" id="status_pengembalian_hasil_tidak" value="0" checked required>
                                <label class="form-check-label" for="status_pengembalian_hasil_tidak">Tidak</label>
                            </div>
                        </div>
                        <small class="text-muted">Apakah Anda ingin sampel hasil pengujian dikembalikan?</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end mb-4">
            <button type="submit" class="btn btn-primary btn-sm">Submit Pengajuan</button>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
$('#category').on('change', function() {
    let category = $(this).val();
    
    // Sembunyikan semua field instansi
    $('#instansiField, #perusahaanField').hide();
    $('#instansiField input, #perusahaanField input').prop('required', false);
    
    // Tampilkan field sesuai kategori
    if(category === 'instansi') {
        $('#instansiField').show();
        $('#instansiField input').prop('required', true);
    } else if(category === 'perusahaan') {
        $('#perusahaanField').show();
        $('#perusahaanField input').prop('required', true);
    }
});

$('#province_id').on('change', function() {
    var provinceId = $(this).val();
    $('#city_id').empty();
    $('#district_id').empty();

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

    if(cityId) {
        $.get('/getDistricts/' + cityId, function(districts) {
            $('#district_id').append('<option value="">Pilih Kecamatan</option>');
            $.each(districts, function(key, district) {
                $('#district_id').append('<option value="'+ district.id +'">'+ district.name +'</option>');
            });
        });
    }
});

$(document).ready(function() {
    let pengujianIndex = 0;

    // Update biaya saat parameter dipilih atau jumlah berubah
    function updateBiaya(container) {
        let harga = container.find('.parameter-select option:selected').data('harga') || 0;
        let jumlah = parseInt(container.find('.jumlah-sampel').val());
        let totalBiaya = harga * jumlah;
        container.find('.biaya-pengujian').text('Rp ' + totalBiaya.toLocaleString('id-ID'));
    }

    // Handler untuk perubahan parameter
    $(document).on('change', '.parameter-select', function() {
        updateBiaya($(this).closest('.card-body'));
    });

    // Handler untuk tombol plus
    $(document).on('click', '.btn-plus', function() {
        let input = $(this).siblings('input.jumlah-sampel');
        input.val(parseInt(input.val()) + 1);
        updateBiaya($(this).closest('.card-body'));
    });

    // Handler untuk tombol minus
    $(document).on('click', '.btn-minus', function() {
        let input = $(this).siblings('input.jumlah-sampel');
        let value = parseInt(input.val());
        if (value > 1) {
            input.val(value - 1);
            updateBiaya($(this).closest('.card-body'));
        }
    });

    // Update script tambahPengujian
    $("#tambahPengujian").click(function() {
        pengujianIndex++;
        let newItem = $(".pengujian-item:first").clone();
        
        newItem.find('[name^="details[0]"]').each(function() {
            let name = $(this).attr('name').replace('[0]', '[' + pengujianIndex + ']');
            $(this).attr('name', name);
        });
        
        // Reset nilai
        newItem.find('select').val('');
        newItem.find('.jumlah-sampel').val('1');
        newItem.find('.biaya-pengujian').text('Rp 0');
        newItem.find('.activity').val('');
        newItem.find('.kondisi-select').val('');
        newItem.find('.hapus-pengujian').show();
        
        $("#containerPengujian").append(newItem);
        updateDeleteButtons();
    });

    // Fungsi untuk menghapus form pengujian
    $(document).on('click', '.hapus-pengujian', function() {
        $(this).closest('.pengujian-item').remove();
        updateDeleteButtons();
    });

    // Fungsi untuk mengatur visibility tombol hapus
    function updateDeleteButtons() {
        if ($('.pengujian-item').length === 1) {
            $('.hapus-pengujian').hide();
        } else {
            $('.hapus-pengujian').show();
        }
    }
});
</script>
@endsection
