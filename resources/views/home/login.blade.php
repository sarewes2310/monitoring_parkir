@extends('home.header')
@section('custom_css')
    <link rel="stylesheet" href="css/home/custom_page_masuk.css">
@endsection
@section('content')
    <div class="container" id="live_cam_row">
        <div class="row ">
            <div class="col d-flex justify-content-center">
                <img src="assets/logo/logo_v1.png" alt="" class="logo-page">
            </div>
        </div>
        <div class="row">
            <div class="col d-flex justify-content-center" style="padding-top:1.3rem">
                <div class="center_size_login_page">
                    <p class="text-center">Merupakan halaman yang digunakan untuk masuk ke dalam sistem</p>
                </div>
            </div>
        </div>
        <div class="row col-login">
            <div class="col-lg-12 d-flex justify-content-center col-login">
                <div class="center_size_login_page card mb-3">
                    <div class="card-header btn-grad-orange d-flex justify-content-center">LOGIN ADMIN</div>
                    <div class="card-body text-primary">
                        <div class="mr-auto w-100" id="#">
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                
                                <div class="form-group">
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="username">
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-grad-orange w-100">LOGIN</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 d-flex flex-column">
                <div class="w-100">
                    <h6 class="text-center"><b>ATAU</b></h6>
                </div>
                <div class="w-100 d-flex justify-content-center">
                    <div class="center_size_login_page">
                        <p class="text-center">
                            Belum mempunyai akun daftar pada halaman 
                            <a class="badge btn-grad-purple text-wrap">REGISTER</a> (<b>KHUSUS PEGAWAI PARKIR</b>).
                        </p>    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script src="js/home/custom_page_masuk.js"></script>
@endsection