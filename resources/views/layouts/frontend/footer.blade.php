<footer class="border-top">
    <div class="container">
        <div class="row py-1">
            <div class="col-4 text-center">
                <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                    <i class="bi bi-house-door{{ Route::is('home') ? '-fill' : '' }} fs-5"></i>
                    <p class="mb-0 small" style="font-size: 10px !important;">Home</p>
                </a>
            </div>
            <div class="col-4 text-center">
                <a href="{{ route('transaction') }}" class="text-decoration-none text-secondary">
                    <i class="bi bi-pencil{{ Route::is('transaction', 'instansi', 'noninstansi', 'transaction.show') ? '-fill' : '' }} fs-5"></i>
                    <p class="mb-0 small" style="font-size: 10px !important;">Pengajuan</p>
                </a>
            </div>
            <div class="col-4 text-center">
                <a href="{{ route('payment') }}" class="text-decoration-none text-secondary">
                    <i class="bi bi-wallet{{ Route::is('payment') ? '-fill' : '' }} fs-5"></i>
                    <p class="mb-0 small" style="font-size: 10px !important;">Pembayaran</p>
                </a>
            </div>
        </div>
    </div>
</footer>
