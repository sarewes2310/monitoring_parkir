<div class="row">

    <div class="col-lg-4">
        <div class="card shadow-sm card-grad-blue">
            <div class="card-body">
                <h3 class="card-title">Kendaraan Terparkir</h3>
                <p class="card-text">Jumlah dari pengunjung mahasiswa adalah</p>
                <h1><b>{{ $ktp }}</b></h1>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm card-grad-red">
            <div class="card-body">
                <h3 class="card-title">Data Parkir Hari Ini</h3>
                <p class="card-text">Jumlah dari pengunjung pegawai adalah</p>
                <h1><b>{{ $dph }}</b></h1>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm myactive">
            <div class="card-body">
                <h3 class="card-title">Rekap Data Parkir</h3>
                <p class="card-text">Jumlah dari pengunjung pegawai adalah</p>
                <h1><b>{{ $rdp }}</b></h1>
            </div>
        </div>
    </div>

</div>
<div class="row" style="margin-top: 1rem;margin-bottom: 1rem">

    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <canvas id="myChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm" style="min-height: 100%">
            <div class="card-body">
                <h3 class="card-title"> Detail Rekap Data Parkir</h3>
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">Nama Pengendara</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Mahasiswa</td>
                            <td>{{ $chart_mahasiswa}}</td>
                        </tr>
                        <tr>
                            <td>Pegawai</td>
                            <td>{{ $chart_pegawai }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>