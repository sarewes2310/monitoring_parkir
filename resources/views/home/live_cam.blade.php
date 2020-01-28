@extends('home.header')
@section('custom_css')
    
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center" id="live_cam_row">
            <div class="col-9 col-sm-9 col-md-6 col-lg-4">
                <div class="#">
                    <h6 class="display-5 text-center">Silahkan masukkan <b>NIM</b> atau <b>NIP</b> dan <b>Password</b> anda untuk melihat live camera</h6>
                </div>
                <div class="mr-auto" id="#">
                    <form action="{{ route('cari_live_cam') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <input type="text" class="form-control @error('input_nim_nip') is-invalid @enderror" id="input_nim_nip" name="input_nim_nip" placeholder="NIM atau NIP">
                            @error('input_nim_nip')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-grad-purple w-100">Cek Tempat Parkir</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    @if ($cek ?? '')   
                        @if ($camera ?? '')
                            <div class="col-12 col-md-8">
                                <div id="hasil_cari"  style="margin-bottom:1rem;margin-top:1rem">
                                    <div id="title_load">
                                        <h5 class="text-center"><span class="badge badge-success">Menunggu...</span></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div id="deskripsi"  style="margin-bottom:1rem;margin-top:1rem">
                                    <h5>Deskripsi</h5>
                                    <table class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <td>Nama</td>
                                                <td>{{ $nama }}</td>
                                            </tr>
                                            <tr>
                                                <td>Tempat Parkir</td>
                                                <td>{{ $nama_tempatparkir }}</td>
                                            </tr>
                                            <tr>
                                                <td>Waktu Masuk</td>
                                                <td>{{ $masuk }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div id="hasil_cari" class="col">
                                <h5 class="text-center"><span class="badge badge-danger">@if ($cek == 1) Anda Belum Parkir @elseif($cek == 2) Salah Password atau NIM atau NIP @elseif($cek == 3) Tempat Parkir Tidak Ditemukan @endif</span></h5>
                            </div>              
                        @endif
                    @endif
                </div>
                </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script src="{{ url('js/home/socketio/v2.3.0/socket.io.slim.js') }}"></script>
    @if ($camera ?? '') 
        <script>
            var path_live_cam = '{{ $camera->cameraparkir_id }}';
            var server = '192.168.1.100:8080';
            //alert(path_live_cam);
        </script>
        <script src="{{ url('js/home/custom_live_cam.js') }}"></script> 
    @endif
@endsection