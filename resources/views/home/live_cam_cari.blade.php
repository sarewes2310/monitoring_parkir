@extends('home.header')
@section('custom_css')
    
@endsection
@section('content')
    <div class="container">
        <div class="row" id="live_cam_row">
            <div class="col-lg-12">
                <div class=" form-cek-live justify-content-center">
                    <h6 class="display-5 ">Silahkan masukkan <b>NIM</b> atau <b>NIP</b> anda untuk melihat live camera</h6>
                </div>
                <div class="mr-auto form-cek-live" id="#">
                    <form action="#" onsubmit="return submitCek();">
                        <div class="form-group">
                            <input type="text" class="form-control" id="input_nim_nip" >
                        </div>
                        <button type="submit" class="btn btn-grad-purple w-100">Cek Tempat Parkir</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-12">
                <div id="hasil_cari">
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script src="js/home/custom_live_cam.js"></script>
@endsection