<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ParkirRepo;
use App\Repositories\PenggunaRepo;
use App\Repositories\AlatParkirRepo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Parkir extends Controller
{
    protected $pathindex = 'users.transaksi.transaksi';
    protected $pathtambah = 'users.transaksi.tambah';
    protected $pathedit = 'users.transaksi.edit';
    protected $pathcapture = 'E:/xampp/htdocs/monitoring_parkir/storage/app/public/data_file/parkir/';
    protected $debugging = false;

    protected function cekDataKosong(array $data)
    {
        if(count($data['parkir']) > 0) $data['kosong'] = false;
        else $data['kosong'] = true;
        return $data;
    }

    protected function inisialisasi()
    {
        $data['parkir'] = DB::table('parkir')
                ->join('pengguna', 'parkir.pengguna_id', '=', 'pengguna.id')
                ->join('tempat_parkir', 'parkir.tempatparkir_id', '=', 'tempat_parkir.id')
                ->where('parkir.verifikasi', 0)
                ->select('pengguna.nama_pengguna','pengguna.nim_nip', 'parkir.verifikasi', 'parkir.id', 'tempat_parkir.nama_tempat_parkir', 'parkir.foto', 'parkir.tempatparkir_id')
                ->paginate(15);
        //if(count($data['parkir']) > 0) $data['kosong'] = false;
        //else $data['kosong'] = true;
        $data += $this->cekDataKosong($data);
        return $data;
    }

    protected function redirectTo($path, array $data)
    {
        return view($path, $data);
    }
    
    public function index() 
    {
        $data = $this->inisialisasi();
        //var_dump($data['parkir']);
        //return $data['parkir'];
        return $this->redirectTo($this->pathindex, $data);
    }

    public function cari(Request $request)
    {
        $this->cariValidator(array('mac' => $request->all()['inputCari']))->validate();
        $data['parkir'] = $this->getCariData($request->all())->paginate(15);
        //var_dump($data);
        $data += $this->cekDataKosong($data);
        return $this->redirectTo($this->pathindex, $data);
    }

    protected function getCariData(array $data)
    {
        return $data['parkir'] = PenggunaRepo::where('nim_nip', 'like', ''.$data['inputCari'].'%');
    }

    protected function cariValidator(array $data)
    {
        return Validator::make($data,[
            'mac' => ['required', 'string', 'max:255'],
        ]);
    }

    protected function validatorCrud(array $data)
    {
        return Validator::make($data,[
            '' => ['required', 'string', 'max:255'],
        ]);
    }

    protected function editQuery(array $data)
    {
        $dataku = [];
        $ParkirRepo = ParkirRepo::where('id', $data['id'])->first();
        if(is_null($data['verifikasi']) == false) $dataku['verifikasi'] = $data['verifikasi'];
        return $ParkirRepo->where('id', $data['id'])->update($dataku);
    }

    protected function notificationData($mode, $user, $message, $route, Request $request)
    {
        $data['mode'] = $mode;
        $data['user'] = $user;
        $data['message'] = $message;
        $request->session()->flash('status', $data);
        return redirect()->route($route);
    }
    

    public function tambah(Request $request)
    {
        $this->validatorCrud($request->all())->validate();
        $dataReq = $request->all();
        if($this->debugging)
        {
            var_dump($stor);
            var_dump($dataReq);
            var_dump($file_foto);
        }
        else
        {
            if($this->tambahQuery($dataReq))
            {
                return $this->notificationData(1, $request->mac, 'TAMBAH', 'transaksi', $request);
            }else
            {
                return $this->notificationData(404, $request->mac, 'TAMBAH DATA', 'transaksi', $request);
            }
        }
    }

    public function edit(Request $request)
    {
        //$this->validatorCrud($request->all())->validate();
        if($this->debugging)
        {
            var_dump($request->all());
        }else
        {
            $dataReq = $request->all();
            $dataReq['verifikasi'] = 1;
            //return $this->changeModeParkir($dataReq); 
            if($this->changeModeParkir($dataReq))
            {   
                if($this->editQuery($dataReq))return $this->notificationData(2, $request->nama_pengguna, 'buka', 'transaksi', $request);
                else return $this->notificationData(404, $request->nama_pengguna, 'gagal dibuka', 'transaksi', $request);
            }
            else return $this->notificationData(404, $request->nama_pengguna, 'gagal dibuka', 'transaksi', $request);
        }
    }

    protected function changeModeParkir(array $dataReq)
    {
        $AlatParkirRepo = DB::table('map_alat_parkir')
                    ->where('tempatparkir_id', $dataReq["tempatparkir_id"])
                    ->select('alatparkir_id')
                    ->get();
        $dataku['mode'] = 2;
        return AlatParkirRepo::where('id', $AlatParkirRepo[0]->alatparkir_id)->update($dataku);
        //return $AlatParkirRepo[0]->alatparkir_id;
    }

    protected function hapusparkir(array $data)
    {
        return ParkirRepo::where('id',$data['idHapusData'])->delete();
    }

    /*
    public function tampilan_tambah()
    {
        //$data = [];
        return $this->redirectTo($this->pathtambah, []);
    }

    public function tampilan_edit(Request $request)
    {
        $data['parkir'] = ParkirRepo::where('id',$request->id_parkir)->first();
        return $this->redirectTo($this->pathedit, $data);
    }

    public function hapus(Request $request)
    {
        $reqData = $request->all();
        if($this->hapusparkir($reqData)) return $this->notificationData(3, $request->nameHapusData, 'HAPUS', 'transaksi', $request);
        else return $this->notificationData(404, $request->nameHapusData, 'HAPUS', 'transaksi', $request);
    }*/

    protected function tambahQuery(Array $data)
    {
        return ParkirRepo::create([
            'pengguna_id' => $data['pengguna_id'],
            'tempatparkir_id' => $data['tempatparkir_id'],
            'foto' => $data['fotoku'],
            'verifikasi' => 0,
        ]);
    }

    protected function cekDataParkir(Array $data)
    {
        //if(ParkirRepo::where('pengguna_id', $data['pengguna_id'])->where('verifikasi','!=', 0)->count() == 0) return false;
        //else return true;
        return ParkirRepo::where('pengguna_id', $data['pengguna_id'])->where('verifikasi','!=', 0)->count();
    }

    public function parkirMasuk(Request $request)
    {
        $reqData = $request->all();
        //return response()->json(array('cek' => true, 'nama' => $request->mac));
        //$this->tambahValidator();
        
        $data['pengguna'] = PenggunaRepo::where('cid', $reqData['cid'])->first();
        $data['pengguna_id'] = $data['pengguna']['id'];
        $data['nama'] = $data['pengguna']['nama_pengguna'];
        if(is_null($data['pengguna'])) return response()->json(array('cek' => false, 'nama' => ''));
        //return $data;

        $data['tempatparkir_id'] = DB::table('alat_parkir')
                ->join('map_alat_parkir', 'alat_parkir.id', '=', 'map_alat_parkir.alatparkir_id')
                ->where('alat_parkir.mac', $reqData['mac'])
                ->where('alat_parkir.token', $reqData['access_token'])
                ->select('tempatparkir_id')
                ->first()->tempatparkir_id;
        $data['ip_camera'] = DB::table('map_camera_parkir')
                ->join('camera_parkir', 'camera_parkir.id', '=', 'map_camera_parkir.cameraparkir_id')
                ->where('map_camera_parkir.tempatparkir_id', $data['tempatparkir_id'])
                ->select('camera_parkir.ip')
                ->first()->ip;
        if(is_null($data['ip_camera'])) return response()->json(array('cek' => false, 'nama' => ''));
        return response()->json(array('cek' => true, 'nama' => ''));
        //$data['fotoku'] = $this->captureImage($data);
        
        if($this->cekDataParkir($data) == 0)
        {
            //return response()->json(array('cek' => true, 'nama' => $data['tempatparkir_id']));
            if($this->tambahQuery($data))
            {
                return response()->json(array('cek' => true, 'nama' => $data['nama']));
            }else
            {
                return response()->json(array('cek' => false, 'nama' => ''));
            }
        }else
        {
            return response()->json(array('cek' => false, 'nama' => 'sudah'));
        }
    }

    protected function captureImage(Array $data)
    {
        $imagename = Str::random(10).".jpg";
        $run = "ffmpeg -y -i rtsp://admin:admin123@".$data['ip_camera'].":8554/unicast -vframes 1 ".$this->pathcapture.$imagename;
        //var_dump($run);
        shell_exec($run);
        sleep(5);
        $fullpath = 'public/data_file/parkir/'.$imagename;
        return $fullpath;
    }

    protected function tambahValidator()
    {
        return Validator::make($data,[
            'mac' => ['required', 'string', 'max:30'],
            'cid' => ['required', 'string', 'max:80'],
        ]);
    }

    public function cariLiveCam(Request $request)
    {
        $reqData = $request->all();
        $idtempatparkir = DB::table('parkir')
                    ->join('pengguna', 'parkir.pengguna_id', '=', 'pengguna.id')
                    ->where('parkir.verifikasi', 0)
                    ->where('pengguna.nim_nip', $request->input_nim_nip)
                    ->select('tempatparkir_id')
                    ->first();
        //if(is_null($idtempatparkir)) var_dump($idtempatparkir);
        if(is_null($idtempatparkir) == false)
        {
            $data['camera'] = DB::table('map_camera_parkir')
                        ->join('camera_parkir', 'map_camera_parkir.cameraparkir_id', '=', 'camera_parkir.id')
                        ->where('map_camera_parkir.tempatparkir_id', $idtempatparkir->tempatparkir_id)
                        ->first();
            if(is_null($idtempatparkir) == false) 
            {
                $data['cek'] = 2;
                return $this->redirectTo('home.live_cam', $data);
            }
            else 
            {
                $data['cek'] = 1;
                return $this->redirectTo('home.live_cam', $data);
            }
        }else 
        {
            $data['cek'] = 1;
            //var_dump($data);
            return $this->redirectTo('home.live_cam', $data);
        }
    }

    public function changeModeAP(Request $request)
    {
        $dataku = [];
        $AlatParkirRepo = AlatParkirRepo::where('mac', 'DE:AD:BE:EF:FE:ED')->first();
        //if(is_null($data['mode']) == false) $dataku['verifikasi'] = $data['verifikasi'];
        return response()->json(array('callback',$AlatParkirRepo->where('mac', 'DE:AD:BE:EF:FE:ED')->update(array('mode' => 2))));
    }

    protected function editQueryGateKeluar(array $data)
    {
        $dataku = [];
        $ParkirRepo = ParkirRepo::where('tempatparkir_id', $data['tempatparkir_id'])
                    ->where('verifikasi', 0)
                    ->first();
        //if(is_null($data['pengguna_id']) == false) $dataku['pengguna_id'] = $data['pengguna_id'];
        $dataku['verifikasi'] = 1;
        return $ParkirRepo->where('tempatparkir_id', $data['tempatparkir_id'])
                    ->where('verifikasi', 0)
                    ->update($dataku);
    }

    protected function cekDataParkirKeluar(Array $data)
    {
        //if(ParkirRepo::where('pengguna_id', $data['pengguna_id'])->where('verifikasi','!=', 0)->count() == 0) return false;
        //else return true;
        return ParkirRepo::where('pengguna_id', $data['tempatparkir_id'])->where('verifikasi','!=', 1)->count();
    }

    public function parkirKeluar(Request $request)
    {
        $reqData = $request->all();
        $data['tempatparkir_id'] = DB::table('alat_parkir')
                ->join('map_alat_parkir', 'alat_parkir.id', '=', 'map_alat_parkir.alatparkir_id')
                ->where('alat_parkir.mac', $reqData['mac'])
                ->where('alat_parkir.token', $reqData['access_token'])
                ->select('tempatparkir_id')
                ->first()->tempatparkir_id;
        
        if($this->cekDataParkir($data) == 0)
        {
            //return response()->json(array('cek' => true, 'nama' => $data['tempatparkir_id']));
            if($this->editQueryGateKeluar($data))
            {
                return response()->json(array('cek' => true, 'nama' => 'tinggal'));
            }else
            {
                return response()->json(array('cek' => false, 'nama' => ''));
            }
        }else
        {
            return response()->json(array('cek' => false, 'nama' => ''));
        }
    }
    
}
