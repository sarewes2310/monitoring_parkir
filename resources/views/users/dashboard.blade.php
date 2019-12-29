@extends('users.header')
@section('title')
    Dashboard
@endsection
@section('custom_css')
    <!--<link rel="stylesheet" href="css/home/custom_page_masuk.css">-->
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow-sm card-grad-blue">
                    <div class="card-body">
                        <h3 class="card-title">Mahasiswa</h3>
                        <p class="card-text">Jumlah dari pengunjung mahasiswa adalah</p>
                        <h1><b>69</b></h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow-sm card-grad-red">
                    <div class="card-body">
                        <h3 class="card-title">Pegawai</h3>
                        <p class="card-text">Jumlah dari pengunjung pegawai adalah</p>
                        <h1><b>12269</b></h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="admin_row">
            <div class="col">
                <div class="tambah-data">
                    <form class="form-inline justify-content-end">
                        <div class="form-group mx-sm-3 mb-2 ">
                            <label for="inputCari" class="sr-only">Ketik Nama</label>
                            <input type="password" class="form-control" id="inputCari" placeholder="Nama dari admin">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Cari</button>
                    </form>
                </div>
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Admin</th>
                            <th scope="col">Username</th>
                            <th scope="col">Nomer Telepon</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>
                                <div class="badge badge-success text-wrap mon-f-badge" href="">
                                    Sudah Verifikasi
                                </div>
                                <div class="badge badge-warning text-wrap mon-f-badge" href="">
                                    Belum Verifikasi
                                </div>
                            </td>
                            <td>
                                <a class="badge badge-warning text-wrap mon-f-badge"  data-toggle="modal" data-target="#verifModal">
                                    Verifikasi
                                </a>
                                <a class="badge badge-danger text-wrap text-white mon-f-badge"  data-toggle="modal" data-target="#hapusModal">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL VERIFIKASI DATA -->
    <div class="modal fade" id="verifModal" tabindex="-1" role="dialog" aria-labelledby="verifModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Verfikasi Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin memverifikasi data dari admin ini ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger " data-dismiss="modal">Tidak</button>
                    <form action="">
                        <input type="text" name="idVerifData" id="idVerifData" style="display:none">
                        <button type="button" class="btn btn-primary">Ya</button>
                    </form>
                </div>
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
                    Apakah anda yakin ingin menghapus data dari admin ini ?
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
    <script src="{{ url('js/users/custom_page_dashboard.js') }}"></script>
@endsection