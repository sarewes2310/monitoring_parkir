@extends('users.header')
@section('title')
    Edit Profile
@endsection
@section('custom_css')
    <link rel="stylesheet" href="{{ url('css/users/custom_page_mahasiswa.css') }}">
@endsection
@section('content')
    <div class="container">
        <form method="POST" action="{{ route('saveprofile') }}" class="#">
            <div class="row justify-content-md-center">
                <div class="col-lg-6">
                    @csrf

                     <!-- INPUT USRNAME DAN NAMA -->
                     <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="nip_nim">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Username dari operator" value="{{ $profile->username }}" required>
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nama dari operator" value="{{ $profile->name }}" required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- INPUT NO TELP -->
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="nip_nim">No Telp</label>
                            <input type="text" class="form-control @error('notelp') is-invalid @enderror" id="notelp" name="notelp" placeholder="Nomer Telephone dari operator" value="{{ $profile->notelp }}" required>
                            @error('notelp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- INPUT PASSWORD -->
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="nip_nim">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password dari pegawai">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror   
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nama">Konfirmasi Passowrd</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password">
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror   
                        </div>
                    </div>

                    <input type="text" name="id" id="id" value="{{ $profile->id }}" style="display:none">
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
                                    <tr id="ket_nim_nip">
                                        <td>Input Username</td>
                                        <td>Berisi Username dari Operator.</td>
                                    </tr>
                                    <tr id="ket_nama_pengguna">
                                        <td>Input Nama</td>
                                        <td>Berisi nama dari Operator.</td>
                                    </tr>
                                    <tr id="ket_notelp">
                                        <td>Input Nomer Telepon</td>
                                        <td>Berisi Nomer Telepon dari Operator.</td>
                                    </tr>
                                    <tr id="ket_password">
                                        <td>Input Password</td>
                                        <td>Berisi password dari Operator.</td>
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
    <script src="text/js">

    </script>
@endsection