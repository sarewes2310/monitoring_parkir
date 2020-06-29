<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MONTIR</title>
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">-->
    <link rel="stylesheet" href="{{ url('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href=" {{ url('/css/users/custom_header.css') }} ">
    <!--<link rel="stylesheet" href="{{ url('/fonts/css/fontawesome.css') }}">-->
    @yield('custom_css')
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-light border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">
                <img src="{{ url('assets/logo/logo_v1.png') }}" class="logo-navbar" alt="">
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action bg-light" id="menu_dashboard">Dashboard</a>
                @if (Auth::user()->access_id == 1)
                    <a href="{{ route('mahasiswa') }}" class="list-group-item list-group-item-action bg-light" id="menu_mahasiswa">Mahasiswa</a>
                    <a href="{{ route('pegawai') }}" class="list-group-item list-group-item-action bg-light" id="menu_pegawai">Pegawai</a>
                    <a href="{{ route('operator') }}" class="list-group-item list-group-item-action bg-light" id="menu_operator">Operator</a>
                    <a href="{{ route('transaksi') }}" class="list-group-item list-group-item-action bg-light" id="menu_transaksi">Transaksi</a>
                @else
                    @foreach ($dataTKI as $item)
                        <a href="{{ route('transaksi2', $item->id) }}" class="list-group-item list-group-item-action bg-light" id="menu_transaksi_{{ $item->id }}">Transaksi {{ $item->nama_tempat_parkir }}</a>
                    @endforeach
                @endif
                <a href="{{ route('tempatparkir') }}" class="list-group-item list-group-item-action bg-light" id="menu_parkir">Tempat Parkir</a>
                <a href="{{ route('alat_parkir') }}" class="list-group-item list-group-item-action bg-light" id="menu_alatparkir">Alat Parkir</a>
                <a href="{{ route('cameraparkir') }}" class="list-group-item list-group-item-action bg-light" id="menu_camera">Camera</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->
        
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-white">
                <button id="menu-toggle" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="#">
                    @yield('title')
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse justify-content-end  navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown" id="menu_bar_masuk">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Hello, {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            @yield('content')
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col text-left">
                    <h5 class="text-white">Tentang</h5>
                    <p>Aplikasi yang dibuat untuk memudahkan dalam memanajemen tempat parkir dengan mudah dengan dilengkapi fitur realtime camera</p>
                </div>
                <div class="col text-left">
                    <h5 class="text-white">Contact</h5>
                    
                    <p>Email: hubungi@montir.com</p>
                    <p>Telp: +6282-3236-97012</p>
                </div>
                <div class="col text-left">
                    <div>
                        <h4 class="text-white"><b>Keluhan</b></h4>
                        <p>
                            Mengalami kendala saat menggunakan tempat parkir atau memonitor tempat parkir dapat menemui petugas parkir 
                            terdekat atau hubungi kontak yang tertera pada website.
                        </p>
                    </div>
                    <!--<form action="">
                        <div class="form-group">
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan keluhan anda">
                        </div>
                        <button type="submit" class="btn btn-warning footer-btn">Submit</button>
                    </form>-->
                </div>
            </div>
            <div class="col">
                <p>@2019 Copyright By MONTIR</p>
            </div>
        </div>
    </footer>
    <!-- JAVASCRIPT -->
    <!--<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>-->
    <script src="{{ url('js/jquery/v3.4.1/jquery-3.4.1.slim.min.js') }}" ></script>
    <script src="{{ url('js/propper/v1.16.0/popper.min.js') }}"></script>
    <script src="{{ url('js/bootstrap/v4.4.1/bootstrap.min.js') }}"></script>
    <script src="{{ url('js/leaflet/v1.6.0/leaflet.js') }}"></script>
    <script src="{{ url('js/home/custom_header.js') }}"></script>
    <script src="{{ url('js/users/custom_header.js') }}"></script>
    @yield('custom_js')
    <script src="{{ url('js/users/control_menu_navbar.js') }}"></script>
</body>
</html>