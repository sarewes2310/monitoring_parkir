<div class="row">
    @php 
        $outTP = json_decode($TP); 
        foreach ($outTP as $key => $value) {
            echo '
                <div class="col-lg-4 bawah-operator">
                    <div class="card shadow-sm card-grad-blue">
                        <div class="card-body">
                            <h3 class="card-title">Kendaraan Terparkir</h3>
                            <p class="card-text">Jumlah dari pengunjung tempat parkir <b>'.$value->nama_tempat_parkir.'</b> adalah</p>
                            <h1><b>'.count($value->parkir).'</b></h1>
                        </div>
                    </div>
                </div>
            ';
        }
    @endphp
</div>
<div class="row">
    @php 
        $outDPH = json_decode($DPH); 
        foreach ($outDPH as $key => $value) {
            echo '
                <div class="col-lg-4 bawah-operator">
                    <div class="card shadow-sm card-grad-red">
                        <div class="card-body">
                            <h3 class="card-title">Data Parkir Hari Ini</h3>
                            <p class="card-text">Jumlah pengunjung hari ini pada tempat parkir <b>'.$value->nama_tempat_parkir.'</b> adalah</p>
                            <h1><b>'.count($value->parkir).'</b></h1>
                        </div>
                    </div>
                </div>
            ';
        }
    @endphp
</div>
<!--<div class="row">
    <div class="col-lg-12 bawah-operator">
        <div class="card shadow-sm myactive">
            <div class="card-body">
                <h3 class="card-title">Rekap Keseluruhan Data Parkir Hari ini</h3>
                <p class="card-text">Jumlah dari total pengunjung hari ini</p>
                <h1><b></b></h1>
            </div>
        </div>
    </div>
</div>-->
<div class="row" style="margin-top: 1rem;margin-bottom: 1rem">

    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <canvas id="myChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm myactive" style="min-height: 100%">
            <div class="card-body">
                <h3 class="card-title"> Detail Rekap Keseluruhan Data Parkir Hari ini</h3>
                <table class="table table-borderless text-white">
                    <thead>
                        <tr>
                            <th scope="col">Nama Tempat Parkir</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $outPC = json_decode($PC); 
                            foreach ($outPC as $key => $value) {
                                echo '
                                <tr>
                                    <td>'.$value->nama.'</td>
                                    <td>'.$value->count.'</td>
                                </tr>
                                ';
                            }
                        @endphp
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row" style="margin-top: 1rem;margin-bottom: 1rem">
    <div class="col-lg-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <canvas id="grafikchart" width="400" height="240" style="height:80vh;"></canvas>
            </div>
        </div>
    </div>
</div>