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
                    <!--<video id="video"></video>-->
                    <!--<OBJECT classid="clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921"
                        codebase="http://downloads.videolan.org/pub/videolan/vlc/latest/win32/axvlc.cab"
                        width="640" height="480" id="vlc" events="True">
                        <param name="Src" value="rtsp://192.168.1.102:8554/unicast" />
                        <param name="ShowDisplay" value="True" />
                        <param name="AutoLoop" value="False" />
                        <param name="AutoPlay" value="True" />
                        <embed id="vlcEmb"  type="application/x-google-vlc-plugin" version="VideoLAN.VLCPlugin.2" autoplay="yes" loop="no" width="640" height="480"
                            target="rtsp://192.168.1.102:8554/unicast"></embed>
                    </OBJECT>-->
                    <video src="rtsp://192.168.1.102:8554/unicast">
                        Your browser does not support the VIDEO tag and/or RTP streams.
                    </video>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script src="js/home/custom_live_cam.js"></script>
@endsection