<footer class="border-top">
    <div class="container">
        <div class="row py-1">
            <div class="col-4 text-center">
                <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                    <i class="bi bi-house-door{{ Route::is('home') ? '-fill' : '' }} fs-2"></i>
                    <p class="mb-0 small" style="font-size: 10px !important;">Home</p>
                </a>
            </div>
            <div class="col-4 text-center">
                <a href="{{ route('transaction') }}" class="text-decoration-none text-secondary">
                    <i class="bi bi-pencil{{ Route::is('transaction', 'pengajuan', 'pengajuan.show') ? '-fill' : '' }} fs-2"></i>
                    <p class="mb-0 small" style="font-size: 10px !important;">Pengajuan</p>
                </a>
            </div>
            <div class="col-4 text-center">
                <a href="{{ route('payment') }}" class="text-decoration-none text-secondary">
                    <i class="bi bi-wallet{{ Route::is('payment') ? '-fill' : '' }} fs-2"></i>
                    <p class="mb-0 small" style="font-size: 10px !important;">Pembayaran</p>
                </a>
            </div>
            {{-- <div class="col-3 text-center">
                <a href="{{ route('profile.edit') }}" class="text-decoration-none text-secondary">
                    <i class="bi bi-person{{ Route::is('profile.edit') ? '-fill' : '' }} fs-2"></i>
                    <p class="mb-0 small" style="font-size: 10px !important;">Profil</p>
                </a>
            </div> --}}
        </div>
    </div>
</footer>
