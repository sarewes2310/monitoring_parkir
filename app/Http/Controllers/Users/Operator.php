<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\PenggunaRepo;
use App\Users;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class Operator extends Controller
{
    protected $pathindex = 'users.operator.operator';
    protected $pathtambah = 'users.operator.tambah';
    protected $pathedit = 'users.operator.edit';
    protected $pathupload = 'public/data_file/operator';
    protected $debugging = false;

    protected function cekDataKosong(array $data)
    {
        if(count($data['operator']) > 0) $data['kosong'] = false;
        else $data['kosong'] = true;
        return $data;
    }

    protected function inisialisasi()
    {
        $data['operator'] = DB::table('users')->where('access_id',2)->paginate(15);
        //if(count($data['mahasiswa']) > 0) $data['kosong'] = false;
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
        //var_dump($data['mahasiswa']);
        return $this->redirectTo($this->pathindex, $data);
    }

    public function cari(Request $request)
    {
        $this->cariValidator(array('name' => $request->all()['inputCari']))->validate();
        $data['operator'] = $this->getCariData($request->all())->paginate(15);
        $data += $this->cekDataKosong($data);
        return $this->redirectTo($this->pathindex, $data);
    }

    protected function getCariData(array $data)
    {
        return $data['operator'] = DB::table('operator')->where('access_id',2)
        ->where('name', 'like', ''.$data['inputCari'].'%');
    }

    protected function cariValidator(array $data)
    {
        return Validator::make($data,[
            'name' => ['required', 'string', 'max:255'],
        ]);
    }
    
    protected function validatorCrud(array $data, $tipe)
    {
        if($tipe){
            return Validator::make($data,[
                'username' => ['required', 'string', 'max:40'],
                'name' => ['required', 'string', 'max:40'],
                'notelp' => ['required', 'string', 'min:11', 'max:16'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }else{
            return Validator::make($data,[
                'username' => ['required', 'string', 'max:40'],
                'name' => ['required', 'string', 'max:40'],
                'notelp' => ['required', 'string', 'min:11', 'max:16'],
            ]);
        }
    }

    protected function tambahQuery(array $data)
    {
        return Users::create([
            'access_id' => 2,
            'username' => $data['username'],
            'notelp' => $data['notelp'],
            'name' => $data['name'],
            'verifikasi' => 1,
            'akun_verified_at' => now(), 
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function upload_image(Request $request)
    {
        if(is_null($request->foto) == false)
        {
            $file_foto = $request->file('foto');
            $file_path = $file_foto->store($this->pathupload);
            if($file_foto->isValid())return $file_path;
            else return 404;
        }else return null;
    }

    protected function editQuery(array $data)
    {
        $dataku = [];
        //q$penggunaRepo = PenggunaRepo::where('id', $data['id'])->first();
        if(is_null($data['name']) == false) $dataku['name'] = $data['name'];
        if(is_null($data['username']) == false) $dataku['username'] = $data['username'];
        if(is_null($data['notelp']) == false) $dataku['notelp'] = $data['notelp'];
        if($data['password'] != "") $dataku['password'] = Hash::make($data['password']);
        return Users::where('id', $data['id'])->update($dataku);
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
        $this->validatorCrud($request->all(), 1)->validate();
        //if($this->debugging) var_dump($request->all());
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
                return $this->notificationData(1, $request->name, 'TAMBAH', 'operator', $request);
            }else
            {
                return $this->notificationData(404, $request->name, 'TAMBAH DATA', 'operator', $request);
            } 
        }
    }

    public function edit(Request $request)
    {
        $this->validatorCrud($request->all(), $request->password == "" &&  $request->password_confirmation == "" ? 0 : 1)->validate();
        if($this->debugging)
        {
            var_dump($request->all());
            var_dump(is_null($request->foto));
        }else
        {
            $dataReq = $request->all();
            if($this->editQuery($dataReq)) return $this->notificationData(2, $request->name, 'EDIT', 'operator', $request);
            else return $this->notificationData(404, $request->name, 'EDIT DATA', 'operator', $request);
        }
    }

    protected function hapusOperator(array $data)
    {
        return Users::where('id',$data['idHapusData'])->delete();
    }

    public function tampilan_tambah()
    {
        $data = [];
        return $this->redirectTo($this->pathtambah, $data);
    }

    public function tampilan_edit(Request $request)
    {
        $dataedit['operator'] = Users::where('id',$request->id_operator)->firstOrFail();
        return $this->redirectTo($this->pathedit, $dataedit);
    }

    public function hapus(Request $request)
    {
        $reqData = $request->all();
        if($this->hapusOperator($reqData)) return $this->notificationData(3, $request->nameHapusData, 'HAPUS DATA', 'operator', $request);
        else return $this->notificationData(404, $request->nameHapusData, 'HAPUS DATA', 'operator', $request);
    }
}
