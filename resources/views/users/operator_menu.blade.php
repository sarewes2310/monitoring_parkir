<div class="row">
    @php 
        $outTP = json_decode($TP); 
        $outDPH = json_decode($DPH); 
        foreach ($outTP as $key => $value) {
            echo '
            <div class="col-lg-4 bawah-operator">
                <div class="card shadow-sm">
                    <div style="padding: 2% 6%">
                        <h5>Tempat Parkir</h5>
                        <h3><b>'.$value->nama_tempat_parkir.'</b></h3>
                    </div>
                    <div class="card card-grad-blue">
                        <div class="card-body">
                            <h5 class="card-title">Kendaraan Terparkir</h5>
                            <h1><b>'.count($value->parkir).'</b></h1>
                        </div>
                    </div>
            ';
            echo '
                    <div class="card card-grad-red">
                        <div class="card-body">
                            <h5 class="card-title">Data Parkir Hari Ini</h5>
                            <h1><b>'.count($outDPH[$key]->parkir).'</b></h1>
                        </div>
                    </div>
                </div>
            </div>
            ';
        }
    @endphp
</div>
<div class="row">
    @php 
        foreach ($outDPH as $key => $value) {
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
    <div class="col-lg-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <canvas id="myChart" width="400" height="400"></canvas>
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