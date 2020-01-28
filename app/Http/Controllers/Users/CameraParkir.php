<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CameraParkirRepo;
use App\Repositories\TempatParkirRepo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CameraParkir extends Controller
{
    protected $pathindex = 'users.camera.camera';
    protected $pathtambah = 'users.camera.tambah';
    protected $pathedit = 'users.camera.edit';
    protected $pathcapture = 'E:/xampp/htdocs/monitoring_parkir/storage/app/public/data_file/parkir/';
    protected $debugging = false;

    protected function cekDataKosong(array $data)
    {
        if(count($data['camera_parkir']) > 0) $data['kosong'] = false;
        else $data['kosong'] = true;
        return $data;
    }

    protected function inisialisasi()
    {
        $data['camera_parkir'] = DB::table('camera_parkir')->paginate(15);
        //if(count($data['camera_parkir']) > 0) $data['kosong'] = false;
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
        //var_dump($data['camera_parkir']);
        return $this->redirectTo($this->pathindex, $data);
    }

    public function cari(Request $request)
    {
        $this->cariValidator(array('mac' => $request->all()['inputCari']))->validate();
        $data['camera_parkir'] = $this->getCariData($request->all())->paginate(15);
        //var_dump($data);
        $data += $this->cekDataKosong($data);
        return $this->redirectTo($this->pathindex, $data);
    }

    protected function getCariData(array $data)
    {
        return $data['camera_parkir'] = CameraParkirRepo::where('ip', 'like', ''.$data['inputCari'].'%');
    }

    protected function cariValidator(array $data)
    {
        return Validator::make($data,[
            'ip' => ['required', 'string', 'max:255'],
        ]);
    }

    protected function validatorCrud(array $data)
    {
        return Validator::make($data,[
            'ip' => ['required', 'string', 'max:255'],
            'tipe_camera' => ['required', 'string', 'max:8'],
        ]);
    }

    protected function tambahQuery(array $data)
    {
        return AlatParkirRepo::create([
            'ip' => $data['ip'],
            'tipe' => $data['tipe_camera'],
        ]);
    }

    protected function tambahQuery2(array $data)
    {
        $dataku['tempatparkir_id'] = $data['tempatparkir_id'];
        $dataku['cameraparkir_id'] = $data['cameraparkir_id'];
        return DB::table('map_camera_parkir')->insert($dataku);
    }

    protected function getMap_camera_parkirID(array $data)
    {
        return CameraParkirRepo::where('ip', $data['ip'])->first()->id;
    }

    protected function editQuery(array $data)
    {
        $dataku = [];
        //$AlatParkirRepo = CameraParkirRepo::where('id', $data['id'])->first();
        if(is_null($data['ip']) == false) $dataku['ip'] = $data['ip'];
        if(is_null($data['tipe_camera']) == false) $dataku['tipe'] = $data['tipe_camera'];
        return CameraParkirRepo::where('id', $data['id'])->update($dataku);
    }

    protected function editQuery2(array $data)
    {
        $dataku = [];
        if(is_null($data['tempatparkir_id']) == false) $dataku['tempatparkir_id'] = $data['tempatparkir_id'];
        $dataku['updated_at'] = now();
        return  DB::table('map_camera_parkir')->where('cameraparkir_id', $data['id'])->update($dataku);
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
            //var_dump($stor);
            var_dump($dataReq);
            //var_dump($file_foto);
        }
        else
        {
            //return $this->tambahQuery2($dataReq);
            if($this->tambahQuery($dataReq))
            {
                $dataReq['cameraparkir_id'] = $this->getMap_camera_parkirID($dataReq);
                if($this->tambahQuery2($dataReq))return $this->notificationData(1, $request->ip, 'TAMBAH', 'cameraparkir', $request);
                else return $this->notificationData(404, $request->ip, 'TAMBAH DATA', 'cameraparkir', $request);
            }else
            {
                return $this->notificationData(404, $request->ip, 'TAMBAH DATA', 'cameraparkir', $request);
            }
        }
    }

    public function edit(Request $request)
    {
        $this->validatorCrud($request->all())->validate();
        if($this->debugging)
        {
            var_dump($request->all());
        }else
        {
            $dataReq = $request->all();
            if($this->editQuery($dataReq))
            {   
                if($this->editQuery2($dataReq)) return $this->notificationData(2, $request->ip, 'EDIT', 'cameraparkir', $request);
                else return $this->notificationData(404, $request->ip, 'EDIT DATA', 'cameraparkir', $request);
            }
            else 
            {
                return $this->notificationData(404, $request->ip, 'EDIT DATA', 'cameraparkir', $request);
            }
        }
    }

    protected function hapuscamera_parkir(array $data)
    {
        return CameraParkirRepo::where('id',$data['idHapusData'])->delete();
    }

    public function tampilan_tambah()
    {
        //$data = [];
        $data['tempat_parkir'] = TempatParkirRepo::all();
        //return $data;
        return $this->redirectTo($this->pathtambah, $data);
    }

    public function tampilan_edit(Request $request)
    {
        $data['camera_parkir'] = CameraParkirRepo::where('id',$request->id_camera_parkir)->firstOrFail();
        $data['tempat_parkir'] = TempatParkirRepo::all();
        $data['map_camera_parkir_id'] = DB::table('map_camera_parkir')
                    ->where('cameraparkir_id', $request->id_camera_parkir)
                    ->select('tempatparkir_id')
                    ->get()[0]->tempatparkir_id;
        //return $data;
        return $this->redirectTo($this->pathedit, $data);
    }

    public function hapus(Request $request)
    {
        $reqData = $request->all();
        if($this->hapuscamera_parkir($reqData)) return $this->notificationData(3, $request->nameHapusData, 'HAPUS', 'camera_parkir', $request);
        else return $this->notificationData(404, $request->nameHapusData, 'HAPUS', 'camera_parkir', $request);
    }

    protected function generateToken($data)
    {
        //return Hash::make($value)
    }

    public function getMode(Request $request)
    {
        $reqData = $request->all();
        //$this->modeValidator($reqData);
        //var_dump($reqData);
        //var_dump(AlatParkirRepo::where('mac',$reqData['mac'])->first());
        $data = AlatParkirRepo::where('mac', $reqData['mac'])->where('token', $reqData['access_token'])->first();
        //if(is_null($data))return $data;
        if(is_null($data))
        {
            return response()->json(array('cek' => false));
        }else
        {
            //var_dump($data['mode']);
            if($data->mode == 2)
            {
                return response()->json(array('cek' => true));
            }else
            {
                return response()->json(array('cek' => false));
            }
        }
    }

    public function changeMode(Request $request)
    {
        $reqData = $request->all();
        //var_dump($reqData);
        //$this->modeValidator($reqData);
        /*if($reqData->cek == true) $reqData['cek'] = true;
        else $reqData['cek'] = false;*/
        $reqData['cek'] = true;
        return response()->json($reqData);
        //var_dump(AlatParkirRepo::where('mac',$reqData['mac'])->first());
        /*$data = AlatParkirRepo::where('mac', $reqData['mac'])->first();
        if(is_null($data))
        {
            return response()->json(array('cek' => false));
        }else
        {
            if($data['mode'] == 2)
            {
                return response()->json(array('cek' => true));
            }else
            {
                return response()->json(array('cek' => false));
            }
        }*/
    }

    public function testCapture()
    {
        $imagename = Str::random(60).".jpg";
        shell_exec("ffmpeg -y -i rtsp://admin:admin123@192.168.1.103:8554/unicast -vframes 1 ".$pathcapture.$imagename);
    }
}
