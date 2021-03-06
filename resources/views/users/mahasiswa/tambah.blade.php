@extends('users.header')
@section('title')
    Tambah Data Mahasiswa
@endsection
@section('custom_css')
    <link rel="stylesheet" href="{{ url('css/users/custom_page_pegawai.css') }}">
@endsection

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('simpan_tambah_mahasiswa') }}" enctype="multipart/form-data" class="was-validated">
            <div class="row justify-content-md-center">
                <div class="col-lg-6">
                    @csrf
                    
                    <!-- INPUT NIP DAN NAMA -->
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="nip_nim">NIM</label>
                            <input type="text" class="form-control @error('nim_nip') is-invalid @enderror" id="nim_nip" name="nim_nip" placeholder="NIM dari mahasiswa" required>
                            @error('nim_nip')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control @error('nama_pengguna') is-invalid @enderror" id="nama_pengguna" name="nama_pengguna" placeholder="Nama dari mahasiswa" required>
                            @error('nama_pengguna')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- INPUT UNIT / FAKULTAS-->
                    <div class="mb-3">
                        <label for="alamat">Fakultas</label>
                        <textarea class="form-control @error('fakultas') is-invalid @enderror" id="fakultas" name="fakultas" placeholder="Nama Fakultas" required></textarea>
                        @error('fakultas')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- INPUT ALAMAT -->
                    <div class="mb-3">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" placeholder="Alamat rumah atau kost" required></textarea>
                        @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- INPUT PASSWORD -->
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="nip_nim">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password dari pegawai" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror   
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nama">Konfirmasi Passowrd</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password" required>
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror   
                        </div>
                    </div>

                    <!-- INPUT CID -->
                    <div class="form-row align-items-center">
                        <div class="col-lg-10">
                            <label class="sr-only" for="cid">CID</label>
                            <input type="text" class="form-control mb-2 @error('cid') is-invalid @enderror" id="cid" name="cid" placeholder="CID dari RFID Tag" required>
                            @error('cid')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-primary mb-2 w-100" onclick="return getRFID()">CEK</button>
                        </div>
                    </div>

                    <!-- INPUT FOTO -->
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('foto') is-invalid @enderror" id="foto" name="foto" required>
                        <label class="custom-file-label" for="foto">Pilih foto mahasiswa...</label>
                        @error('foto')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
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
                                    <tr id="ket_nim_nip">
                                        <td>Input NIM</td>
                                        <td>Berisi NIM dari Mahasiswa.</td>
                                    </tr>
                                    <tr id="ket_nama_pengguna">
                                        <td>Input Nama</td>
                                        <td>Berisi nama dari Mahasiswa.</td>
                                    </tr>
                                    <tr id="ket_fakultas">
                                        <td>Input Fakultas</td>
                                        <td>Berisi asal Fakultas dari Mahasiswa.</td>
                                    </tr>
                                    <tr id="ket_alamat">
                                        <td>Input Alamat</td>
                                        <td>
                                            Berisi alamat rumah atau kost dari Mahasiswa. Jika mahasiswa dari luar daerah silahkan isi tempat kost.
                                        </td>
                                    </tr>
                                    <tr id="ket_cid">
                                        <td>Input CID</td>
                                        <td>Berisi ID dari RFID. Untuk penambahan silahkan ikuti petunjuk di alat setelah menekan tombol ADD.</td>
                                    </tr>
                                    <tr id="ket_foto">
                                        <td>Input Foto</td>
                                        <td>Berisi foto dari mahasiswa.</td>
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
    <script src="{{ url('js/users/custom_page_mahasiswa.js') }}"></script>
@endsection