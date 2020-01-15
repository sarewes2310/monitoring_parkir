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
                    <form action="{{ route('cari_live_cam') }}" method="GET">
                        @csrf

                        <div class="form-group">
                            <input type="text" class="form-control" id="input_nim_nip" name="input_nim_nip">
                        </div>
                        <button type="submit" class="btn btn-grad-purple w-100">Cek Tempat Parkir</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-12">
                @if ($cek ?? '')   
                    @if ($camera ?? '')
                        <div id="hasil_cari"  style="margin-bottom:1rem;margin-top:1rem">
                            <div id="title_load">
                                <h5 class="text-center"><span class="badge badge-success">Menunggu...</span></h5>
                            </div>
                        </div>
                    @else
                        <div id="hasil_cari" >
                            <h5 class="text-center"><span class="badge badge-danger">Anda Belum Parkir</span></h5>
                        </div>              
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script src="{{ url('js/home/socketio/v2.3.0/socket.io.slim.js') }}"></script>
    @if ($camera ?? '') <script src="{{ url('js/home/custom_live_cam.js') }}"></script> @endif
@endsection