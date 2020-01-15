@extends('users.header')
@section('title')
    Edit Data Alat Parkir
@endsection
@section('custom_css')
    <link rel="stylesheet" href="{{ url('css/users/custom_page_tempat_parkir.css') }}">
@endsection
@section('content')
    <div class="container">
        <form method="POST" action="{{ route('simpan_edit_tempatparkir') }}" enctype="multipart/form-data" class="was-validated">
            <div class="row justify-content-md-center">
                <div class="col-lg-6">
                    @csrf
                    
                    <!-- INPUT NIP DAN NAMA -->
                    <div class="form-row">
                        
                        <div class="col-md-12 mb-3">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control @error('nama_tempat_parkir') is-invalid @enderror" id="nama_tempat_parkir" name="nama_tempat_parkir" placeholder="Nama dari tempat_parkir" required value="{{ $tempat_parkir->nama_tempat_parkir }}">
                            @error('nama_tempat_parkir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- INPUT ALAMAT -->
                    <div class="mb-3">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" placeholder="Alamat rumah atau kost" required>{{ $tempat_parkir->alamat }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <input type="text" name="id" id="id" value="{{ $tempat_parkir->id }}" style="display:none">
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
                                    <tr id="ket_nama_alat_parkir">
                                        <td>Input Nama</td>
                                        <td>Berisi nama dari alat parkir.</td>
                                    </tr>
                                    <tr id="ket_alamat">
                                        <td>Input Alamat</td>
                                        <td>
                                            Berisi alamat rumah atau kost dari Mahasiswa. Jika mahasiswa dari luar daerah silahkan isi tempat kost.
                                        </td>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
    <script src="{{ url('js/users/custom_page_parkir.js') }}"></script>
@endsection