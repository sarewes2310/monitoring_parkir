<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MONTIR</title>
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">-->
    <link rel="stylesheet" href="{{ url('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/home/custom_header.css') }}">
    <link rel="stylesheet" href="/fonts/css/fontawesome.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    @yield('custom_css')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <a class="navbar-brand" href="#">
            <img src="{{ url('assets/logo/logo_v1.png') }}" class="logo-navbar" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav text-right w-100">
                <li class="nav-item ml-auto" id="menu_bar_home">
                    <a class="nav-link" href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item" id="menu_bar_live">
                    <a class="nav-link" href="{{ route('live_cam') }}">Live Camera</a>
                </li>
                <li class="nav-item dropdown" id="menu_bar_masuk">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Masuk
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                        <a class="dropdown-item" href="{{ route('daftar') }}">Register</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    @yield('content')
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
    <!--<script src="{{ url('js/propper/v1.16.0/popper.min.js') }}" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="{{ url('js/bootstrap/v4.4.1/bootstrap.min.js') }}" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="{{ url('js/leaflet/v1.6.0/leaflet.js') }}" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>-->
    <script src="{{ url('js/jquery/v3.4.1/jquery-3.4.1.slim.min.js') }}" ></script>
    <script src="{{ url('js/propper/v1.16.0/popper.min.js') }}"></script>
    <script src="{{ url('js/bootstrap/v4.4.1/bootstrap.min.js') }}"></script>
    <script src="{{ url('js/leaflet/v1.6.0/leaflet.js') }}"></script>
    <script src="{{ url('js/home/custom_header.js') }}"></script>
    @yield('custom_js')
    <script src="{{ url('js/home/control_menu_navbar.js') }}"></script>
</body>
</html>