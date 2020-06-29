<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\TempatParkirRepo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Custom\CheckStatus;

class TempatParkir extends Controller
{
    protected $pathindex = 'users.tempat_parkir.tempat_parkir';
    protected $pathtambah = 'users.tempat_parkir.tambah';
    protected $pathedit = 'users.tempat_parkir.edit';
    protected $debugging = false;

    protected function cekDataKosong(array $data)
    {
        if(count($data['tempat_parkir']) > 0) $data['kosong'] = false;
        else $data['kosong'] = true;
        return $data;
    }

    protected function inisialisasi()
    {
        $data['tempat_parkir'] = DB::table('tempat_parkir')->paginate(15);
        //if(count($data['tempat_parkir']) > 0) $data['kosong'] = false;
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
        //var_dump($data['tempat_parkir']);
        $data['dataTKI'] = CheckStatus::check();
        return $this->redirectTo($this->pathindex, $data);
    }

    public function cari(Request $request)
    {
        $this->cariValidator(array('nama_tempat_parkir' => $request->all()['inputCari']))->validate();
        $data['tempat_parkir'] = $this->getCariData($request->all())->paginate(15);
        //var_dump($data);
        $data += $this->cekDataKosong($data);
        $data['dataTKI'] = CheckStatus::check();
        return $this->redirectTo($this->pathindex, $data);
    }

    protected function getCariData(array $data)
    {
        return $data['tempat_parkir'] = TempatParkirRepo::where('nama_tempat_parkir', 'like', ''.$data['inputCari'].'%')
        ->orWhere('alamat', 'like', ''.$data['inputCari'].'%');
    }

    protected function cariValidator(array $data)
    {
        return Validator::make($data,[
            'nama_tempat_parkir' => ['required', 'string', 'max:255'],
        ]);
    }

    protected function validatorCrud(array $data)
    {
        return Validator::make($data,[
            'nama_tempat_parkir' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
        ]);
    }

    protected function tambahQuery(array $data)
    {
        return TempatParkirRepo::create([
            'nama_tempat_parkir' => $data['nama_tempat_parkir'],
            'alamat' => $data['alamat'],
        ]);
    }

    protected function editQuery(array $data)
    {
        $dataku = [];
        $TempatParkirRepo = TempatParkirRepo::where('id', $data['id'])->first();
        if(is_null($data['nama_tempat_parkir']) == false) $dataku['nama_tempat_parkir'] = $data['nama_tempat_parkir'];
        if(is_null($data['alamat']) == false) $dataku['alamat'] = $data['alamat'];
        return $TempatParkirRepo->where('id', $data['id'])->update($dataku);
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
            var_dump($stor);
            var_dump($dataReq);
            var_dump($file_foto);
        }
        else
        {
            if($this->tambahQuery($dataReq))
            {
                return $this->notificationData(1, $request->nama_tempat_parkir, 'TAMBAH', 'tempatparkir', $request);
            }else
            {
                return $this->notificationData(404, $request->nama_tempat_parkir, 'TAMBAH DATA', 'tempatparkir', $request);
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
            if($this->editQuery($dataReq)) return $this->notificationData(2, $request->nama_tempat_parkir, 'EDIT', 'tempatparkir', $request);
            else return $this->notificationData(404, $request->nama_tempat_parkir, 'EDIT DATA', 'tempatparkir', $request);
        }
    }

    protected function hapustempat_parkir(array $data)
    {
        return TempatParkirRepo::where('id',$data['idHapusData'])->delete();
    }

    public function tampilan_tambah()
    {
        //$data = [];
        $data['dataTKI'] = CheckStatus::check();
        return $this->redirectTo($this->pathtambah, $data);
    }

    public function tampilan_edit(Request $request)
    {
        $data['tempat_parkir'] = TempatParkirRepo::where('id',$request->id_tempat_parkir)->firstOrFail();
        $data['dataTKI'] = CheckStatus::check();
        return $this->redirectTo($this->pathedit, $data);
    }

    public function hapus(Request $request)
    {
        $reqData = $request->all();
        if($this->hapustempat_parkir($reqData)) return $this->notificationData(3, $request->nameHapusData, 'HAPUS', 'tempatparkir', $request);
        else return $this->notificationData(404, $request->nameHapusData, 'HAPUS', 'tempatparkir', $request);
    }
}
