@extends('home.header')
@section('custom_css')
    <link rel="stylesheet" href="css/home/custom_page_masuk.css">
@endsection
@section('content')
    <div class="container" id="live_cam_row">
        <div class="row col-login">
            <div class="col-lg-12 d-flex justify-content-center col-login">
                <div class="center_size_login_page">
                    <img src="assets/logo/logo_v1.png" alt="" class="img">
                </div>
                <div class="center_size_login_page card border-primary mb-3">
                    <div class="card-header d-flex justify-content-center">Masukkan Data Anda</div>
                    <div class="card-body text-primary">
                        <div class="mr-auto w-100" id="#">
                            <form action="#" onsubmit="return submitLogin();">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="i_name" name="i_name" placeholder="nama anda">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="i_notelp" name="i_notelp" placeholder="nomer handphone">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="i_username" name="i_username" placeholder="username">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="i_password" name="i_password" placeholder="password">
                                </div>
                                <button type="submit" class="btn btn-purple w-100">REGISTER</button>
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
                            Sudah mempunyai akun silahkan login pada halaman 
                            <a class="badge badge-primary text-wrap">LOGIN</a> (<b>KHUSUS PEGAWAI PARKIR</b>).
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