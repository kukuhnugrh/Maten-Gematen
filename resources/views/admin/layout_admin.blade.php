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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/gematen-lapak-main.css') }}?v=<?php echo time(); ?>">
    @yield('content-CSS')

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Document</title>

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- MDI Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css">
</head>

<body>
    @if(session()->has('message'))
    <!-- Flexbox container for aligning the toasts -->
    <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center w-100">

        <!-- Then put toasts within -->
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="..." class="rounded me-2" alt="...">
                <strong class="me-auto">Berhasil</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Password berhasil diubah
            </div>
        </div>
    </div>
    @endif
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
                <li class="nav-item mb-3 w-100">
                    <a class="nav-link {{ str_contains(Request::route()->getName(), 'daftar-lapak') ? 'active' : 'inactive' }} d-flex align-items-center px-5" aria-current="page" href="{{ Route::currentRouteName() != 'kategori' ? route('daftar-lapak.index') : '#' }}">
                        <i class="mdi mdi-store-outline"></i>
                        <span class="mx-3 fw-bold">Daftar Lapak</span>
                    </a>
                </li>
                <li class="nav-item mb-3 w-100">
                    <a class="nav-link {{ str_contains(Request::route()->getName(), 'kategori-produk') ? 'active' : 'inactive' }} d-flex align-items-center px-5" aria-current="page" href="{{ Route::currentRouteName() != 'kategori' ? route('kategori-produk.index') : '#' }}">
                        <i class="mdi mdi-ballot-outline"></i>
                        <span class="mx-3 fw-bold">Kategori Produk</span>
                    </a>
                </li>
                <li class="nav-item mb-3 w-100">
                    <a class="nav-link {{ str_contains(Request::route()->getName(), 'verifikasi-lapak') ? 'active' : 'inactive' }} d-flex align-items-center px-5" aria-current="page" href="{{ Route::currentRouteName() != 'verifikasi-lapak' ? route('verifikasi-lapak.index') : '#' }}">
                        <i class="mdi mdi-shield-check"></i>
                        <span class="mx-3 fw-bold">Verifikasi Lapak</span>
                    </a>
                </li>
                <li class="nav-item mb-3 w-100">
                    <a class="nav-link {{ str_contains(Request::route()->getName(), 'verifikasi-rating') ? 'active' : 'inactive' }} d-flex align-items-center px-5" aria-current="page" href="{{ Route::currentRouteName() != 'verifikasi-rating' ? route('verifikasi-rating.index') : '#' }}">
                        <i class="mdi mdi-star-outline"></i>
                        <span class="mx-3 fw-bold">Verifikasi Rating</span>
                    </a>
                </li>
                <li class="nav-item mb-3 w-100">
                    <a class="nav-link {{ str_contains(Request::route()->getName(), 'riwayat-transaksi') ? 'active' : 'inactive' }} d-flex align-items-center px-5" aria-current="page" href="{{ Route::currentRouteName() != 'riwayat-transaksi' ? route('riwayat-transaksi.index') : '#' }}">
                        <i class="mdi mdi-history"></i>
                        <span class="mx-3 fw-bold">Riwayat Transaksi</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- FOOTER -->
        <div id="sidenav-footer">
            <a href="" id="logout-text" class="d-flex justify-content-center align-items-center p-3 text-decoration-none h-100">
                <i class="mdi mdi-logout"></i>
                <span class="mx-3 fw-bold text-white">Keluar</span>
            </a>
            <form id="logout-form" action="{{  route('logout.post')  }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </aside>
    <!-- Main Content -->
    <div id="main" class="my-3 px-3">
        <section>
            <nav id="main-navbar" class="navbar navbar navbar-expand-lg mb-3">
                <div class="container-fluid">
                    <i class="d-flex mdi mdi-menu cursor-pointer text-white d-none"></i>
                    <h3 class="navbar-brand fw-bold text-white m-0">@yield('info-halaman')</h3>
                    <div class="d-flex flex-grow-1 justify-content-end align-items-center px-3">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown dropstart align-items-center">
                                <a class="nav-link dropdown-toggle m-0 p-0 text-white" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-account text-white text-center"></i>
                                    Halo Admin
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                    @if(session()->get('role') == 'superadmin')
                                    <li><a class="dropdown-item" href="{{ route('register.web') }}">Tambah Admin</a></li>
                                    @endif
                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Reset Password</a></li>
                                </ul>
                            </li>
                        </ul>
                        <!-- <div class="dropstart">
                            <a class="dropdown-toggle text-white" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none;">
                                <i class="mdi mdi-account text-white"></i>
                                Halo Admin
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                @if(session()->get('role') == 'superadmin')
                                <li><a class="dropdown-item" href="{{ route('register.web') }}">Tambah Admin</a></li>
                                @endif
                                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Reset Password</a></li>
                            </ul>
                        </div> -->
                    </div>
                </div>
            </nav>
            @yield('content')
        </section>
    </div>

    <!-- Modal -->
    <form action="{{route('register.post')}}" method="post" id="signup-form">
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Ubah Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="oldpassword" class="form-label fw-bold fs-6">Password Lama</label>
                            <div class="input-group">
                                <input type="password" class="form-control shadow-none @error('confirmpassword') is-invalid @enderror" id="oldpassword" name="oldpassword" required>
                                <span class="input-group-text" id="showPasswordToogle" onclick="showPassword('tooggle-icon-oldpassword', 'oldpassword')"><i id="tooggle-icon-oldpassword" class="fa fa-eye-slash" aria-hidden="true"></i></span>
                            </div>
                            @error('oldpassword')
                            <div class="alert alert-danger">
                                <div class="text-danger fs-6">{{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="newpassword" class="form-label fw-bold fs-6">Password Baru</label>
                            <div class="input-group">
                                <input type="password" class="form-control shadow-none @error('confirmpassword') is-invalid @enderror" id="newpassword" name="newpassword" required>
                                <span class="input-group-text" id="showPasswordToogle" onclick="showPassword('tooggle-icon-newpassword', 'newpassword')"><i id="tooggle-icon-newpassword" class="fa fa-eye-slash" aria-hidden="true"></i></span>
                            </div>
                            @error('newpassword')
                            <div class="alert alert-danger">
                                <div class="text-danger fs-6">{{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="confirmpassword" class="form-label fw-bold fs-6">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <input type="password" class="form-control shadow-none @error('confirmpassword') is-invalid @enderror" id="confirmpassword" name="confirmpassword" required>
                                <span class="input-group-text" id="showPasswordToogle" onclick="showPassword('tooggle-icon-confirmpassword', 'confirmpassword')"><i id="tooggle-icon-confirmpassword" class="fa fa-eye-slash" aria-hidden="true"></i></span>
                            </div>
                            @error('confirmpassword')
                            <div class="alert alert-danger">
                                <div class="text-danger fs-6">{{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary">Ubah</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @yield('tambahanModal')
    @yield('tutorialMenambahKategoriModal')

    <script>
        function showPassword(inputId, elementName) {
            $('#' + inputId).toggleClass("fa-eye fa-eye-slash");
            var inputType = $('[name=' + elementName + ']').attr('type');
            if (inputType == 'password') {
                $('[name=' + elementName + ']').attr('type', 'text');
            } else {
                $('[name=' + elementName + ']').attr('type', 'password');
            }
        }

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