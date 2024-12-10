<nav class="navbar border-bottom">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="https://siladu.unp.ac.id/assets/logo.png" alt="Logo" height="30">
        </a>
        <ul class="navbar-nav d-flex flex-row align-items-center">
            @guest
                <li class="nav-item">
                    <a class="nav-link btn-auth" href="{{ route('login') }}">
                        <i class="bi bi-box-arrow-in-right me-1"></i>
                        Masuk
                    </a>
                </li>
            @else
                @if(Auth::user()->role->name == 'admin')
                    <li class="nav-item me-3">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i>
                            Dashboard
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link btn-auth btn-logout" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right me-1"></i>
                        Keluar
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @endguest
        </ul>
    </div>
</nav>

@section('style')
<style>
    .navbar {
        background-color: #ffffff;
        box-shadow: 0 2px 4px rgba(0,0,0,.1);
    }
    .nav-link {
        color: #333333;
    }
    .btn-auth {
        background-color: #28a745;
        color: white !important;
        border-radius: 50px;
        padding: 8px 20px;
        transition: all 0.3s ease;
        font-size: 14px;
        display: flex;
        align-items: center;
    }
    .btn-auth:hover {
        background-color: #218838;
        transform: translateY(-1px);
        box-shadow: 0 2px 5px rgba(0,0,0,.2);
    }
    .btn-logout {
        background-color: #dc3545;
    }
    .btn-logout:hover {
        background-color: #c82333;
    }
</style>
@endsection

