<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\PenggunaRepo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class Pegawai extends Controller
{
    protected $pathindex = 'users.pegawai.pegawai';
    protected $pathtambah = 'users.pegawai.tambah';
    protected $pathedit = 'users.pegawai.edit';
    protected $pathupload = 'public/data_file/pegawai';
    protected $debugging = false;

    protected function cekDataKosong(array $data)
    {
        if(count($data['pegawai']) > 0) $data['kosong'] = false;
        else $data['kosong'] = true;
        return $data;
    }

    protected function inisialisasi()
    {
        $data['pegawai'] = DB::table('pengguna')->where('statuspengguna_id', 2)->paginate(15);
        //if(count($data['pegawai']) > 0) $data['kosong'] = false;
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
        //var_dump($data['pegawai']);
        return $this->redirectTo($this->pathindex, $data);
    }

    public function cari(Request $request)
    {
        $this->cariValidator(array('nama_pengguna' => $request->all()['inputCari']))->validate();
        $data['pegawai'] = $this->getCariData($request->all())->paginate(15);
        $data += $this->cekDataKosong($data);
        return $this->redirectTo($this->pathindex, $data);
    }

    protected function getCariData(array $data)
    {
        return $data['pegawai'] = DB::table('pengguna')->where('statuspengguna_id', 2)
        ->where('nama_pengguna', 'like', ''.$data['inputCari'].'%')
        ->orWhere('nim_nip', 'like', ''.$data['inputCari'].'%');
    }

    protected function cariValidator(array $data)
    {
        return Validator::make($data,[
            'nama_pengguna' => ['required', 'string', 'max:255'],
        ]);
    }

    protected function validatorCrud(array $data, $tipe)
    {
        if($tipe){
            return Validator::make($data,[
                'nim_nip' => ['required', 'numeric'],
                'nama_pengguna' => ['required', 'string', 'max:40'],
                'alamat' => ['required', 'string', 'max:255'],
                'cid' => ['required', 'string', 'max:20'],
                'foto' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }else{
            return Validator::make($data,[
                'nim_nip' => ['required', 'numeric'],
                'nama_pengguna' => ['required', 'string', 'max:40'],
                'alamat' => ['required', 'string', 'max:255'],
                'cid' => ['required', 'string', 'max:20'],
                'foto' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            ]);
        }
    }

    protected function tambahQuery(array $data)
    {
        return PenggunaRepo::create([
            'statuspengguna_id' => 2,
            'cid' => $data['cid'],
            'nim_nip' => $data['nim_nip'],
            'nama_pengguna' => $data['nama_pengguna'],
            'alamat' => $data['alamat'],
            'fakultas' => $data['fakultas'],
            'foto' => $data['foto'],
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
        $penggunaRepo = PenggunaRepo::where('id', $data['id'])->first();
        if(is_null($data['cid']) == false) $dataku['cid'] = $data['cid'];
        if(is_null($data['nim_nip']) == false) $dataku['nim_nip'] = $data['nim_nip'];
        if(is_null($data['nama_pengguna']) == false) $dataku['nama_pengguna'] = $data['nama_pengguna'];
        if(is_null($data['fakultas']) == false) $dataku['fakultas'] = $data['fakultas'];
        if(is_null($data['alamat']) == false) $dataku['alamat'] = $data['alamat'];
        if(is_null($data['foto']) == false) $dataku['foto'] = $data['foto'];
        if($data['password'] != "") $dataku['password'] = Hash::make($data['password']);
        return $penggunaRepo->where('id', $data['id'])->update($dataku);
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
        $file_foto = $request->file('foto');
        $file_path = $file_foto->store($this->pathupload);
        
        if($file_foto->isValid()){
            $dataReq['foto'] = $file_path;
        }

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
                return $this->notificationData(1, $request->nama_pengguna, 'TAMBAH', 'pegawai', $request);
            }else
            {
                return $this->notificationData(404, $request->nama_pengguna, 'TAMBAH DATA', 'pegawai', $request);
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
            if(is_numeric($dataReq['foto'] = $this->upload_image($request)) == false)
            {
                if($this->editQuery($dataReq)) return $this->notificationData(2, $request->nama_pengguna, 'EDIT', 'pegawai', $request);
                else return $this->notificationData(404, $request->nama_pengguna, 'EDIT DATA', 'pegawai', $request);
            }
            return  $this->notificationData(404, $request->nama_pengguna, 'EDIT DATA', 'pegawai', $request);
        }
    }

    protected function hapusPegawai(array $data)
    {
        return PenggunaRepo::where('id',$data['idHapusData'])->delete();
    }

    public function tampilan_tambah()
    {
        $data = [];
        return $this->redirectTo($this->pathtambah, $data);
    }

    public function tampilan_edit(Request $request)
    {
        $data['pegawai'] = PenggunaRepo::where('id',$request->id_pegawai)->firstOrFail();
        //return $request->all();
        return $this->redirectTo($this->pathedit, $data);
    }

    public function hapus(Request $request)
    {
        $reqData = $request->all();
        if($this->hapusPegawai($reqData)) return $this->notificationData(3, $request->nameHapusData, 'HAPUS DATA', 'pegawai', $request);
        else return $this->notificationData(404, $request->nameHapusData, 'HAPUS DATA', 'pegawai', $request);
    }
}
