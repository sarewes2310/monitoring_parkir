@extends('users.header')
@section('title')
    Edit Data Tempat Parkir
@endsection
@section('custom_css')
    <link rel="stylesheet" href="{{ url('css/users/custom_page_tempat_parkir.css') }}">
@endsection
@section('content')
    <div class="container">
        <form method="POST" action="{{ route('simpan_edit_alat_parkir') }}" enctype="multipart/form-data" class="was-validated">
            <div class="row justify-content-md-center">
                <div class="col-lg-6">
                    @csrf
                    
                    <!-- INPUT NIP DAN NAMA -->
                    <div class="form-row">
                        
                        <div class="col-md-12 mb-3">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control @error('mac') is-invalid @enderror" id="mac" name="mac" placeholder="Nama dari tempat_parkir" required value="{{ $alat_parkir->mac }}">
                            @error('mac')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <input type="text" name="id" id="id" value="{{ $alat_parkir->id }}" style="display:none">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
    <script src="{{ url('js/users/custom_page_parkir.js') }}"></script>
@endsection