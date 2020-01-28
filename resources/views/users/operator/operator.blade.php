@extends('users.header')
@section('title')
    Operator
@endsection
@section('custom_css')
    <link rel="stylesheet" href="{{ url('css/users/custom_page_pegawai.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                @if (session('status')) 
                    @if (session('status')['mode'] != 404)
                        <div class="alert alert-success" role="alert">
                            Operator <b>{{ session('status')['user'] }}</b> telah di <b>{{ session('status')['message'] }}</b>.
                        </div>
                    @else
                        <div class="alert alert-danger" role="alert">
                            Gagal melakukan aksi <b>{{ session('status')['message'] }}</b> pada operator <b>{{ session('status')['user'] }}</b>.
                        </div>
                    @endif
                @endif

                <div class="tambah-data">
                    <form class="form-inline" method="GET" action="{{ route('cariMahasiswa') }}">
                        @csrf
                        <div class="form-group mb-2 flex-grow-1">
                            <a class="btn btn-primary" href="{{ route('tambah_operator') }}">Tambah Member</a>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <input type="text" class="form-control" id="inputCari" name="inputCari" placeholder="Nama dari member">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Cari</button>
                    </form>
                </div>
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Operator</th>
                            <th scope="col">Username</th>
                            <th scope="col">Nomer Telepon</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($kosong)
                            <tr>
                                <td colspan="6"> <p  class="d-flex justify-content-center">Operator Tidak Ada</p></td>
                            </tr>
                        @else    
                            @foreach ($operator as $item)                            
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->username }}</td>
                                    <td>{{ $item->notelp }}</td>
                                    <td>
                                        <a class="badge badge-warning text-wrap mon-f-badge" href="{{ route('edit_operator') }}"
                                            onclick="event.preventDefault();
                                                    document.getElementsByTagName('form')[{{ $loop->index + 2 }}].submit();">
                                            Edit
                                        </a>
                                        <form action="{{ route('edit_operator') }}" method="GET" style="display: none;">
                                            @csrf
                                            <input type="text" name="id_operator" value="{{ $item->id }}">
                                        </form>
                                        <a class="badge badge-danger text-wrap text-white mon-f-badge"  data-toggle="modal" data-target="#hapusModal" onclick="return getID('{{ $item->id }}','{{ $item->name }}')">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{ $operator->links() }}
            </div>
        </div>
    </div>
    
    <!-- MODAL HAPUS DATA -->
    <div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="hapusModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin menghapus data dari operator bernama <b id="namaMaha"></b> ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger " data-dismiss="modal">Tidak</button>
                    <form action="{{ route('hapus_operator') }}" method="POST">
                        @csrf
                        <input type="text" name="idHapusData" id="idHapusData" style="display:none">
                        <input type="text" name="nameHapusData" id="nameHapusData" style="display:none">
                        <button type="submit" class="btn btn-primary">Ya</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script>
        menu_bar_active = '#menu_operator';

        function getID(id, nama){
            $('#idHapusData').val(id);
            $('#nameHapusData').val(nama);
            $('#namaMaha').html(nama);
            //console.log($('#idHapusData').val());
            //console.log($('#nameHapusData').val());
        }

        $("#foto").on('change', function(){
            var fileName = $(this).val();
            $(this).next('.custom-file-label').html(fileName);
        });
    </script>
@endsection