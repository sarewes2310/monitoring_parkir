@extends('users.header')
@section('title')
    Pegawai
@endsection
@section('custom_css')
    <link rel="stylesheet" href="{{ url('css/users/custom_page_pegawai.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="tambah-data">
                    <form class="form-inline">
                        <div class="form-group mb-2 flex-grow-1">
                            <button type="button" class="btn btn-primary">Tambah Member</button>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="inputPassword2" class="sr-only">Ketik NIP</label>
                            <input type="password" class="form-control" id="inputCari" placeholder="NIP dari member">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Cari</button>
                    </form>
                </div>
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">NIM</th>
                            <th scope="col">CID</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Fakultas</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>4611416026</td>
                            <td>621631268361273</td>
                            <td>Akhmad Ridho</td>
                            <td>Matematika dan Ilmu Pengetahuan Alam</td>
                            <td>
                                <a class="badge badge-warning text-wrap mon-f-badge" href="" style="font-size: 1em">
                                    Edit
                                </a>
                                <a class="badge badge-danger text-wrap text-white mon-f-badge" data-toggle="modal" data-target="#hapusModal"  style="font-size: 1em">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- MODAL HAPUS DATA -->
    <div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="hapusModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin menghapus data dari pegawai ini ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger " data-dismiss="modal">Tidak</button>
                    <form action="">
                        <input type="text" name="idHapusData" id="idHapusData" style="display:none">
                        <button type="submit" class="btn btn-primary">Ya</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script src="{{ url('js/users/custom_page_mahasiswa.js') }}"></script>
@endsection