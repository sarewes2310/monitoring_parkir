@extends('home.header')

@section('custom_css')
    
@endsection

@section('content')
    <div class="container-flux">
        <div class="row header-title">
            <div class="col">
                <div class="jumbotron bg-white">
                    <div class="row">
                        <div class="col-lg-5">
                            <img src="assets/header/jumbutron_v1.png" class="img-fluid" alt="">
                        </div>
                        <div class="col-lg-7">
                            <h1 class="display-4"><b>Maling</b> merajalela ?</h1>
                            <p class="lead">
                                <b>MONTIR</b> hadir menjadi solusi untuk mengatasi permasalahan tersebut. menyongsong konsep IOT pada tempat parkir 
                                menyajikan kemudahan dalam memanajemen dan memonitor tempat parkir.
                            </p>
                            <a class="btn btn-grad-purple btn-lg" href="#" role="button">Telusuri</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-center title-page">
                <h5 class="display-5">Apa saja fitur yang terdapat pada <b>MONTIR</b>?</h5>
            </div>
            <div class="col-lg-4">
                <div class="d-flex justify-content-center p-2">
                    <div class="#">
                        <h6 class="card-subtitle mb-2 text-muted text-center">Camera Realtime</h6>
                        <p class="card-text text-center">Tempat parkir akan dipasangkan camera untuk menampilkan visualisasi dari tempat parkir secara realtime</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="d-flex justify-content-center p-2">
                    <div class="">
                        <i class="fas fa-camera"></i>
                        <h6 class="card-subtitle mb-2 text-muted text-center">RFID Tag</h6>
                        <p class="card-text text-center">Tempat parkir menggunakan kartu RFID untuk masuk ke dalam tempat parkir sehingga mengurangi penggunaan kertas.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="d-flex justify-content-center p-2">
                    <div class="#">
                        <h6 class="card-subtitle mb-2 text-muted text-center">Laporan</h6>
                        <p class="card-text text-center">Data pengguna dari tempat parkir ditampilkan dalam sebuah file yang dapat di unduh sehingga memudahkan dalam memanajemen tempat parkir</p>
                    </div>
                    <!--<div class="card" style="width: 70%">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Laporan</h6>
                            <p class="card-text">Data pengguna dari tempat parkir ditampilkan dalam sebuah file yang dapat di unduh sehingga memudahkan dalam memanajemen tempat parkir</p>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-center title-page">
                <h5 class="display-5">Dimana lokasi dari <b>MONTIR</b>?</h5>
            </div>
            <div class="col">
                <div id="map-container">
                    <div id="mapid"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script src="js/home/map_header.js"></script>
@endsection