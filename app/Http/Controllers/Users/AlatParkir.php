<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\AlatParkirRepo;
use App\Repositories\TempatParkirRepo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Custom\CheckStatus;

class AlatParkir extends Controller
{
    protected $pathindex = 'users.alat_parkir.alat_parkir';
    protected $pathtambah = 'users.alat_parkir.tambah';
    protected $pathedit = 'users.alat_parkir.edit';
    protected $pathcapture = 'E:/xampp/htdocs/monitoring_parkir/storage/app/public/data_file/parkir/';
    protected $debugging = false;

    protected function cekDataKosong(array $data)
    {
        if(count($data['alat_parkir']) > 0) $data['kosong'] = false;
        else $data['kosong'] = true;
        return $data;
    }

    protected function inisialisasi()
    {
        $data['alat_parkir'] = DB::table('alat_parkir')
        ->join('map_alat_parkir', 'alat_parkir.id', 'map_alat_Parkir.alatparkir_id')
        ->join('tempat_parkir', 'tempat_parkir.id', 'map_alat_Parkir.tempatparkir_id')
        ->paginate(15);
        //if(count($data['alat_parkir']) > 0) $data['kosong'] = false;
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
        //var_dump($data['alat_parkir']);
        $data['dataTKI'] = CheckStatus::check();
        return $this->redirectTo($this->pathindex, $data);
    }

    public function cari(Request $request)
    {
        $this->cariValidator(array('mac' => $request->all()['inputCari']))->validate();
        $data['alat_parkir'] = $this->getCariData($request->all())->paginate(15);
        //var_dump($data);
        $data += $this->cekDataKosong($data);
        $data['dataTKI'] = CheckStatus::check();
        return $this->redirectTo($this->pathindex, $data);
    }

    protected function getCariData(array $data)
    {
        return $data['alat_parkir'] = AlatParkirRepo::where('mac', 'like', ''.$data['inputCari'].'%');
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
            'mac' => ['required', 'string', 'max:255'],
        ]);
    }

    protected function tambahQuery(array $data)
    {
        return AlatParkirRepo::create([
            'mac' => $data['mac'],
            'mode' => 1,
            'token' => Str::random(60),
            'tipe' => $data['tipe'],
        ]);
    }

    protected function tambahQuery2(array $data)
    {
        $dataku['tempatparkir_id'] = $data['tempatparkir_id'];
        $dataku['alatparkir_id'] = $data['alatparkir_id'];
        return DB::table('map_alat_parkir')->insert($dataku);
    }

    protected function getMap_alat_parkirID(array $data)
    {
        return AlatParkirRepo::where('mac', $data['mac'])->first()->id;
    }

    protected function editQuery(array $data)
    {
        $dataku = [];
        //$AlatParkirRepo = AlatParkirRepo::where('id', $data['id'])->first();
        if(is_null($data['mac']) == false) $dataku['mac'] = $data['mac'];
        if(is_null($data['tipe']) == false) $dataku['tipe'] = $data['tipe'];
        return AlatParkirRepo::where('id', $data['id'])->update($dataku);
    }

    protected function editQuery2(array $data)
    {
        $dataku = [];
        $MapAlatParkir = DB::table('map_alat_parkir');
        if(is_null($data['tempatparkir_id']) == false) $dataku['tempatparkir_id'] = $data['tempatparkir_id'];
        $dataku['updated_at'] = now();
        return $MapAlatParkir->where('alatparkir_id', $data['id'])->update($dataku);
        //if(is_null($data['tempatparkir_id']) == false) $dataku['tempatparkir_id'] = $data['tempatparkir_id'];
        //return $AlatParkirRepo->where('id', $AlatParkirRepo['id'])->update($dataku);
    }

    protected function notificationData($mode, $user, $message, $route, Request $request)
    {
        $data['mode'] = $mode;
        $data['user'] = $user;
        $data['message'] = $message;
        $data['dataTKI'] = CheckStatus::check();
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
                $dataReq['alatparkir_id'] = $this->getMap_alat_parkirID($dataReq);
                if($this->tambahQuery2($dataReq))return $this->notificationData(1, $request->mac, 'TAMBAH', 'alat_parkir', $request);
                else return $this->notificationData(404, $request->mac, 'TAMBAH DATA', 'alat_parkir', $request);
            }else
            {
                return $this->notificationData(404, $request->mac, 'TAMBAH DATA', 'alat_parkir', $request);
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
                if($this->editQuery2($dataReq)) return $this->notificationData(2, $request->mac, 'EDIT', 'alat_parkir', $request);
                else return $this->notificationData(404, $request->mac, 'EDIT DATA', 'alat_parkir', $request);
                //return $this->editQuery2($dataReq);
            }
            else
            {
                return $this->notificationData(404, $request->mac, 'EDIT DATA', 'alat_parkir', $request);
            } 
        }
    }

    protected function hapusalat_parkir(array $data)
    {
        return AlatParkirRepo::where('id',$data['idHapusData'])->delete();
    }

    public function tampilan_tambah()
    {
        //$data = [];
        $data['tempat_parkir'] = TempatParkirRepo::all();
        $data['dataTKI'] = CheckStatus::check();
        //return $data;
        return $this->redirectTo($this->pathtambah, $data);
    }

    public function tampilan_edit(Request $request)
    {
        $data['alat_parkir'] = AlatParkirRepo::where('id',$request->id_alat_parkir)->firstOrFail();
        $data['tempat_parkir'] = TempatParkirRepo::all();
        $data['map_alat_parkir_id'] = DB::table('map_alat_parkir')
                    ->where('alatparkir_id', $request->id_alat_parkir)
                    ->select('tempatparkir_id')
                    ->get()[0]->tempatparkir_id;
        //return $data;
        $data['dataTKI'] = CheckStatus::check();
        return $this->redirectTo($this->pathedit, $data);
    }

    public function hapus(Request $request)
    {
        $reqData = $request->all();
        if($this->hapusalat_parkir($reqData)) return $this->notificationData(3, $request->nameHapusData, 'HAPUS', 'alat_parkir', $request);
        else return $this->notificationData(404, $request->nameHapusData, 'HAPUS', 'alat_parkir', $request);
    }

    protected function generateToken($data)
    {
        //return Hash::make($value)
    }

    public function getMode(Request $request)
    {
        $reqData = $request->all();
        //$this->modeValidator($reqData);
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
}
