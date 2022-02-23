<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ Route::currentRouteName() }}</title>
    <!-- icon -->
    <link rel="icon" href="{{ asset('assets/img/icon.ico') }}" type="image/x-icon" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/gematen-lapak-main.css') }}">
    @yield('content-CSS')

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Document</title>

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- MDI Icons -->
    <link rel="stylesheet" href="//cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
</head>

<body>
    <!-- SIDEBAR -->
    <aside id="sidenav" class="d-flex flex-column position-fixed top-0 start-0 bottom-0 ms-3 my-3 unpinned">
        <!-- HEADER -->
        <div id="sidenav-header">
            <i class="mdi mdi-close cursor-pointer position-absolute top-0 end-0 d-none"></i>
            <a href="#" class="d-flex justify-content-center align-items-center p-3 text-decoration-none h-100">
                <img id="sidenav-logo" src="{{ asset('assets/img/icon.ico') }}" class="rounded-circle">
                <span class="mx-3 fw-bold text-white">Lapak Gematen</span>
            </a>
        </div>
        <!-- CONTENT -->
        <div id="sidenav-content" class="flex-grow-1 overflow-auto">
            <ul class="nav flex-column py-3">
                <!-- <li class="nav-item mb-3 w-100">
                    <a class="nav-link {{ str_contains(Request::route()->getName(), 'dashboard') ? 'active' : 'inactive' }} d-flex align-items-center px-5" aria-current="page" href="{{ Route::currentRouteName() != 'dashboard' ? route('admindashboard.index') : '#' }}">
                        <i class="mdi mdi-monitor-dashboard"></i>
                        <span class="mx-3 fw-bold">Dashboard</span>
                    </a>
                </li> -->
                <li class="nav-item mb-3 w-100">
                    <a class="nav-link {{ str_contains(Request::route()->getName(), 'daftar-lapak') ? 'active' : 'inactive' }} d-flex align-items-center px-5" aria-current="page" href="{{ Route::currentRouteName() != 'kategori' ? route('daftar-lapak.index') : '#' }}">
                        <i class="mdi mdi-credit-card-outline"></i>
                        <span class="mx-3 fw-bold">Lapak</span>
                    </a>
                </li>
                <li class="nav-item mb-3 w-100">
                    <a class="nav-link {{ str_contains(Request::route()->getName(), 'kategori-produk') ? 'active' : 'inactive' }} d-flex align-items-center px-5" aria-current="page" href="{{ Route::currentRouteName() != 'kategori' ? route('kategori-produk.index') : '#' }}">
                        <i class="mdi mdi-store-outline"></i>
                        <span class="mx-3 fw-bold">Kategori Produk</span>
                    </a>
                </li>
                <li class="nav-item mb-3 w-100">
                    <a class="nav-link {{ str_contains(Request::route()->getName(), 'verifikasi-lapak') ? 'active' : 'inactive' }} d-flex align-items-center px-5" aria-current="page" href="{{ Route::currentRouteName() != 'verifikasi-lapak' ? route('verifikasi-lapak.index') : '#' }}">
                        <i class="mdi mdi-store-outline"></i>
                        <span class="mx-3 fw-bold">Verifikasi Lapak</span>
                    </a>
                </li>
                <li class="nav-item mb-3 w-100">
                    <a class="nav-link {{ str_contains(Request::route()->getName(), 'verifikasi-transaksi') ? 'active' : 'inactive' }} d-flex align-items-center px-5" aria-current="page" href="{{ Route::currentRouteName() != 'verifikasi-transaksi' ? route('verifikasi-transaksi.index') : '#' }}">
                        <i class="mdi mdi-store-outline"></i>
                        <span class="mx-3 fw-bold">Verifikasi Transaksi</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- FOOTER -->
        <div id="sidenav-footer">
            <a href="" id="logout-text" class="d-flex justify-content-center align-items-center p-3 text-decoration-none h-100">
                <i class="mdi mdi-logout"></i>
                <span class="mx-3 fw-bold text-white">Logout</span>
            </a>
            <form id="logout-form" action="{{  route('logout.post')  }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </aside>
    <!-- Main Content -->
    <div id="main" class="my-3 px-3">
        <section>
            <nav id="main-navbar" class="navbar mb-3">
                <div class="container">
                    <i class="d-flex mdi mdi-menu cursor-pointer text-white d-none"></i>
                    <h3 class="fw-bold text-white">@yield('info-halaman')</h3>
                    <div class="d-flex flex-grow-1 justify-content-end align-items-center">
                        <i class="mdi mdi-account text-white"></i>
                        <span>Halo Admin</span>
                    </div>
                </div>
            </nav>
            @yield('content')
        </section>
    </div>

    @yield('tambahanModal')
    <script>
        $(document).ready(function() {
            $("i.mdi-menu").click(function(e) {
                e.preventDefault();
                if (!$('#sidenav').hasClass('pinned')) {
                    $('#sidenav').removeClass('unpinned');
                    $('#sidenav').addClass('pinned');
                } else {
                    $('#sidenav').removeClass('pinned');
                    $('#sidenav').addClass('unpinned');
                }
            });

            $("i.mdi-close").click(function(e) {
                e.preventDefault();
                if (!$('#sidenav').hasClass('pinned')) {
                    $('#sidenav').removeClass('unpinned');
                    $('#sidenav').addClass('pinned');
                } else {
                    $('#sidenav').removeClass('pinned');
                    $('#sidenav').addClass('unpinned');
                }
            });

            $("#logout-text").click(function(e) {
                e.preventDefault();
                $("#logout-form").submit();
            });
        });
    </script>
    @yield('content-JS')
    <!-- Boostrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</body>

</html>