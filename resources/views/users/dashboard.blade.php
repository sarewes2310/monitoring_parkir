@extends('users.header')
@section('title')
    Dashboard
@endsection
@section('custom_css')
    <link rel="stylesheet" href="css/home/chart.min.css">
    <link rel="stylesheet" href="css/home/custom_page_masuk.css">
@endsection
@section('content')
    <div class="container">
        <div class="mr-auto">

            @if (Auth::user()->access_id == 1)
                @component('users.admin_menu') 
                    @slot('mahasiswa')
                        {{ $mahasiswa }}   
                    @endslot
                    @slot('pegawai')
                        {{ $pegawai }}   
                    @endslot
                @endcomponent
            @else
                @component('users.operator_menu',['TP' => $dataTP, 
                                                'DPH' => $dataDPH,
                                                'PC' => $dataPC]) 
                @endcomponent
            @endif
            
            @yield('dashboard_item')
            
            @if (Auth::user()->access_id == 1)
                <div class="row" id="admin_row">
                    <div class="col">
                        @if (session('status')) 
                            @if (session('status')['mode'] != null)
                                <div class="alert alert-success" role="alert">
                                    Admin {{ session('status')['user'] }} telah di 
                                    @if (session('status')['mode'] == 1)
                                        verifikasi.
                                    @else
                                        hapus.
                                    @endif
                                </div>
                            @endif
                            @if(session('status')['mode'] != null)
                                @if (session('status')['mode'] == 404)
                                    <div class="alert alert-danger" role="alert">
                                        Gagal melakukan aksi {{ session('status')['user'] }}.
                                    </div>
                                @endif
                            @endif
                        @endif
        
                        <div class="tambah-data">
                            <form class="form-inline justify-content-end" action="{{ route('cariAdmin') }}" method="GET" >
                                @csrf
                                
                                <div class="form-group mx-sm-3 mb-2 ">
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="nameAdmin" name="nameAdmin" placeholder="Nama dari admin">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
                                @if ($kosong)
                                    <tr>
                                        <td colspan="6"> <p  class="d-flex justify-content-center">Admin Tidak Ada</p></td>
                                    </tr>
                                @else    
                                    @foreach ($admin as $item)                            
                                        <tr>
                                            <th scope="row">{{ $loop->index + 1 }}</th>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->username }}</td>
                                            <td>{{ $item->notelp }}</td>
                                            <td>
                                                @if ($item->akun_verified_at == NULL)
                                                    <div class="badge badge-warning text-wrap mon-f-badge">
                                                        Belum Verifikasi
                                                    </div>
                                                @else
                                                    <div class="badge badge-success text-wrap mon-f-badge">
                                                        Sudah Verifikasi
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->akun_verified_at == NULL)
                                                    <a class="badge badge-warning text-wrap mon-f-badge"  data-toggle="modal" data-target="#verifModal" onclick="return getID('{{ $item->id }}', '{{ $item->name }}', 1)">
                                                        Verifikasi
                                                    </a>
                                                @endif
                                                <a class="badge badge-danger text-wrap text-white mon-f-badge"  data-toggle="modal" data-target="#hapusModal" onclick="return getID('{{ $item->id }}', '{{ $item->name }}', 2)">
                                                    Hapus
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        {{ $admin->links() }}
                    </div>
                </div>
            @endif

        </div>
    </div>

    @if (Auth::user()->access_id == 1)
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
                    Apakah anda yakin ingin memverifikasi data dari admin <b id="nameadmin"></b> ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger " data-dismiss="modal">Tidak</button>
                    <form action="{{ route('verifikasiAdmin') }}" method="POST">
                        @csrf
                        <input type="text" name="idVerifData" id="idVerifData" style="display:none">
                        <input type="text" name="nameVerifData" id="nameVerifData" style="display:none">
                        <button type="submit" class="btn btn-primary">Ya</button>
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
                    <form action="{{ route('hapusAdmin') }}" method="POST">
                        @csrf
                        <input type="text" name="idHapusData" id="idHapusData" style="display:none">
                        <input type="text" name="nameHapusData" id="nameHapusData" style="display:none">
                        <button type="submit" class="btn btn-primary">Ya</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

@section('custom_js')
    <script src="{{ url('js/users/custom_page_dashboard.js') }}"></script>
    <script src="{{ url('js/users/chart.min.js') }}"></script>    
    @if (Auth::user()->access_id == 2)
    <script>
        function getRandomInt(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min)) + min; //The maximum is exclusive and the minimum is inclusive
        }
        function generateColor(length, o) {
            output = [];
            for (let index = 0; index < length; index++) {
                let random_color = getRandomInt(0,256);
                output[index] = 'rgba('+getRandomInt(0,256)+', '+getRandomInt(0,256)+', '+getRandomInt(0,256)+', '+o+')';
            }
            return output
        }
        var ctx = document.getElementById('myChart');
        var data = JSON.parse(@json($dataPC));
        var data_length = data.length;
        var chart_data = [];
        var chart_labels = [];
        for (let index = 0; index < data_length; index++) {
            chart_data[index] = data[index].count;
            chart_labels[index] = data[index].nama;
        }

        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: chart_labels,
                datasets: [{
                    label: 'Detail Rekap Keseluruhan Data Parkir Hari ini',
                    data: chart_data,
                    backgroundColor: generateColor(data_length, '0.2'),
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true
            }
        });

        var ctx2 = document.getElementById('grafikchart');
        var data2 = JSON.parse(@json($dataPC));
        var data_length2 = data2.length;
        var chart_data2 = [];
        var chart_labels2 = [];
        for (let index = 0; index < data_length2; index++) {
            chart_data2[index] = data2[index].count;
            chart_labels2[index] = data2[index].nama;
        }

        var MONTHS = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
		var config = {
			type: 'line',
			data: {
				labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
				datasets: [{
					label: 'My First dataset',
					backgroundColor: window.chartColors.red,
					borderColor: window.chartColors.red,
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor()
					],
					fill: false,
				}, {
					label: 'My Second dataset',
					fill: false,
					backgroundColor: window.chartColors.blue,
					borderColor: window.chartColors.blue,
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor()
					],
				}]
			},
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'Chart.js Line Chart'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					x: {
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Month'
						}
					},
					y: {
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Value'
						}
					}
				}
			}
		};

        var grafikChart = new Chart(ctx, config);
        
    </script>
    @endif
@endsection