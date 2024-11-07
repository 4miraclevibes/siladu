<footer class="border-top">
    <div class="container">
        <div class="row py-2">
            <div class="col-3 text-center">
                <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                    <i class="bi bi-house-door{{ Route::is('home') ? '-fill' : '' }} fs-5"></i>
                    <p class="mb-0 small">Beranda</p>
                </a>
            </div>
            <div class="col-3 text-center">
                <a href="{{ route('transaction') }}" class="text-decoration-none text-secondary">
                    <i class="bi bi-pencil{{ Route::is('transaction', 'instansi') ? '-fill' : '' }} fs-5"></i>
                    <p class="mb-0 small">Pengajuan</p>
                </a>
            </div>
            <div class="col-3 text-center">
                <a href="{{ route('payment') }}" class="text-decoration-none text-secondary">
                    <i class="bi bi-wallet{{ Route::is('payment') ? '-fill' : '' }} fs-5"></i>
                    <p class="mb-0 small">Pembayaran</p>
                </a>
            </div>
            <div class="col-3 text-center">
                <a href="#" class="text-decoration-none text-secondary">
                    <i class="bi bi-house-door fs-5"></i>
                    <p class="mb-0 small">Beranda</p>
                </a>
            </div>
        </div>
    </div>
</footer>