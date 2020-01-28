@extends('users.header')
@section('title')
    Edit Data Camera Parkir
@endsection
@section('custom_css')
    <link rel="stylesheet" href="{{ url('css/users/custom_page_tempat_parkir.css') }}">
@endsection
@section('content')
    <div class="container">
        <form method="POST" action="{{ route('simpan_edit_cameraparkir') }}" enctype="multipart/form-data" class="was-validated">
            <div class="row justify-content-md-center">
                <div class="col-lg-6">
                    @csrf
                    
                    <!-- INPUT NIP DAN NAMA -->
                    <div class="form-row">
                        
                        <div class="col-md-12 mb-3">
                            <label for="nama">IP Address Camera Parkir</label>
                            <input type="text" class="form-control @error('ip') is-invalid @enderror" id="ip" name="ip" placeholder="IP Address dari camera parkir" required value="{{ $camera_parkir->ip }}">
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
                                <!--<option value="1">A</option>
                                <option value="2">B</option>-->
                                @foreach ($tempat_parkir as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == $map_camera_parkir_id) selected @endif>{{ $item->nama_tempat_parkir }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tipe_camera">Pilih Tipe Camera Parkir</label>
                            <select id="tipe_camera" name="tipe_camera" class="form-control">
                              <option selected>Choose...</option>
                              <option value="livecam" @if ($camera_parkir->tipe == "livecam") selected @endif>Livecam</option>
                              <option value="shooter" @if ($camera_parkir->tipe == "shooter") selected @endif>Shooter</option>
                            </select>
                        </div>
                    </div>

                    <input type="text" name="id" id="id" value="{{ $camera_parkir->id }}" style="display:none">
                    <div style="padding-top:0.5rem;">
                        <button type="submit" class="btn btn-lg card-grad-red mb-2 w-100">Edit</button>
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
                                    <tr id="ket_mac">
                                        <td>Input Nama</td>
                                        <td>Berisi nama dari tempat_parkir.</td>
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
    <script>
        //$('#tempatparkir_id').val();
    </script>
@endsection