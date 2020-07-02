@extends('users.header')
@section('title')
    Alat Parkir
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
                            Gerbang untuk <b>{{ session('status')['user'] }}</b> telah di <b>{{ session('status')['message'] }}</b>.
                        </div>
                    @else
                        <div class="alert alert-danger" role="alert">
                            Gagal melakukan aksi <b>{{ session('status')['message'] }}</b> pada transaksi <b>{{ session('status')['user'] }}</b>.
                        </div>
                    @endif
                @endif

                <div class="tambah-data">
                @if(Auth::user()->access_id == 2)
                    <form class="form-inline" method="GET" action="{{ route('cariTransaksi2', $idtp) }}">
                @else
                    <form class="form-inline" method="GET" action="{{ route('cariTransaksi') }}">
                @endif
                        @csrf
                        <div class="form-group mx-sm-3 mb-2">
                            <input type="text" class="form-control" id="inputCari" name="inputCari" placeholder="CID Mahasiswa atau Pegawai">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Cari</button>
                    </form>
                </div>
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Nim / NIP</th>
                            <th scope="col">Tempat Parkir</th>
                            <th scope="col">Verifikasi</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($kosong)
                            <tr>
                                <td colspan="6"> <p  class="d-flex justify-content-center">Transaksi Tidak Ada</p></td>
                            </tr>
                        @else    
                            @foreach ($parkir as $item)                            
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td>{{ $item->nama_pengguna }}</td>
                                    <td>{{ $item->nim_nip }}</td>
                                    <td>{{ $item->nama_tempat_parkir }}</td>
                                    <td>
                                        @if ($item->verifikasi == 0)
                                            <div class="badge badge-success text-wrap mon-f-badge">
                                                Masih Parkir
                                            </div>
                                        @else
                                            <div class="badge badge-success text-wrap mon-f-badge">
                                                Tidak Parkir
                                            </div>
                                        @endif    
                                    </td>
                                    <td>
                                        <!--<a class="badge badge-warning text-wrap mon-f-badge" href="{{ route('edit_alat_parkir') }}"
                                            onclick="event.preventDefault();
                                                    document.getElementById('edit-form').submit();">
                                            Edit
                                        </a>
                                        <form id="edit-form" action="{{ route('edit_alat_parkir') }}" method="GET" style="display: none;">
                                            @csrf
                                            <input type="text" name="id_alat_parkir" id="id_alat_parkir" value="{{ $item->id }}">
                                        </form>-->
                                        <a class="badge badge-danger text-wrap text-white mon-f-badge"  data-toggle="modal" data-target="#verifModal" onclick="return getID('{{ $item->id }}','{{ $item->nama_pengguna }}','{{ url(Storage::url($item->foto)) }}','{{ $item->tempatparkir_id }}')">
                                            BUKA
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{ $parkir->links() }}
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
                    <div style="margin-bottom:10px">
                        Apakah anda yakin ingin membuka plang pintu untuk pengguna <b id="namePengguna"></b> ?
                    </div>
                    <div>
                        <img id="tampilFoto" class="rounded mx-auto d-block" style="width:100%">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger " data-dismiss="modal">Tidak</button>
                    <form action="{{ route('simpan_edit_transaksi') }}" method="POST">
                        @csrf
                        <input type="text" name="id" id="id" style="display:none">
                        <input type="text" name="nama_pengguna" id="nama_pengguna" style="display:none">
                        <input type="text" name="tempatparkir_id" id="tempatparkir_id" style="display:none">
                        <button type="submit" class="btn btn-primary">Ya</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    @if(Auth::user()->access_id == 2)
        <script type="text/javascript">
            menu_bar_active = '#menu_transaksi_' + @json($idtp);
            console.log(menu_bar_active);
        </script>
    @else
        <script type="text/javascript">
            menu_bar_active = '#menu_transaksi';
            console.log(menu_bar_active);
        </script>
    @endif
    <script src="{{ url('js/users/custom_page_transaksi.js') }}"></script>
@endsection