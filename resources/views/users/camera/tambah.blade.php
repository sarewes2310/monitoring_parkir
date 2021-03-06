@extends('users.header')
@section('title')
    Tambah Data Camera Parkir
@endsection
@section('custom_css')
    <link rel="stylesheet" href="{{ url('css/users/custom_page_pegawai.css') }}">
@endsection

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('simpan_tambah_cameraparkir') }}" enctype="multipart/form-data" class="was-validated">
            <div class="row justify-content-md-center">
                <div class="col-lg-6">
                    @csrf

                    <!-- INPUT NAMA -->
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="nama">IP Address Camera Parkir</label>
                            <input type="text" class="form-control @error('ip') is-invalid @enderror" id="ip" name="ip" placeholder="IP Address dari camera parkir" required>
                            @error('ip')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tempatparkir_id">Pilih Posisi Tempat Parkir</label>
                            <select id="tempatparkir_id" name="tempatparkir_id" class="form-control">
                                <option selected>Choose...</option>
                                @foreach ($tempat_parkir as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_tempat_parkir }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tipe_camera">Pilih Tipe Camera Parkir</label>
                            <select id="tipe_camera" name="tipe_camera" class="form-control">
                              <option selected>Choose...</option>
                              <option value="livecam">Livecam</option>
                              <option value="shooter">Shooter</option>
                            </select>
                        </div>
                    </div>

                    <div style="padding-top:0.5rem;">
                        <button type="submit" class="btn btn-lg card-grad-red mb-2 w-100">Tambah</button>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Deskripsi</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="ket_ipaddress">
                                        <td>Input IP Address</td>
                                        <td>Berisi ip address dari camera parkir.</td>
                                    </tr>
                                    <tr id="ket_nama_tempatparkir">
                                        <td>Input Tempat Parkir</td>
                                        <td>Berisi nama dari tempat parkir.</td>
                                    </tr>
                                    <tr id="ket_tipe_camera">
                                        <td>Input Tipe Camera</td>
                                        <td>Berisi tipe atau jenis dari camera parkir.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('custom_js')
    <script src="{{ url('js/users/custom_page_cameraparkir.js') }}"></script>
@endsection