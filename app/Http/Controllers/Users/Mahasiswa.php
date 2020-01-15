<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\PenggunaRepo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class Mahasiswa extends Controller
{
    protected $pathindex = 'users.mahasiswa.mahasiswa';
    protected $pathtambah = 'users.mahasiswa.tambah';
    protected $pathedit = 'users.mahasiswa.edit';
    protected $pathupload = 'public/data_file/mahasiswa';
    protected $debugging = false;

    protected function cekDataKosong(array $data)
    {
        if(count($data['mahasiswa']) > 0) $data['kosong'] = false;
        else $data['kosong'] = true;
        return $data;
    }

    protected function inisialisasi()
    {
    $data['mahasiswa'] = DB::table('pengguna')->where('statuspengguna_id',1)->paginate(15);
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
        $this->cariValidator(array('nama_pengguna' => $request->all()['inputCari']))->validate();
        $data['mahasiswa'] = $this->getCariData($request->all())->paginate(15);
        $data += $this->cekDataKosong($data);
        return $this->redirectTo($this->pathindex, $data);
    }

    protected function getCariData(array $data)
    {
        return $data['mahasiswa'] = DB::table('pengguna')->where('statuspengguna_id',1)
        ->where('nama_pengguna', 'like', ''.$data['inputCari'].'%')
        ->orWhere('nim_nip', 'like', ''.$data['inputCari'].'%');
    }

    protected function cariValidator(array $data)
    {
        return Validator::make($data,[
            'nama_pengguna' => ['required', 'string', 'max:255'],
        ]);
    }

    protected function validatorCrud(array $data)
    {
        return Validator::make($data,[
            'nim_nip' => ['required', 'string', 'max:60'],
            'nama_pengguna' => ['required', 'string', 'max:40'],
            'alamat' => ['required', 'string', 'max:255'],
            'cid' => ['required', 'string', 'max:20'],
            'foto' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:2048']
        ]);
    }

    protected function tambahQuery(array $data)
    {
        return PenggunaRepo::create([
            'statuspengguna_id' => 1,
            'cid' => $data['cid'],
            'nim_nip' => $data['nim_nip'],
            'nama_pengguna' => $data['nama_pengguna'],
            'alamat' => $data['alamat'],
            'fakultas' => $data['fakultas'],
            'foto' => $data['foto'],
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
        $this->validatorCrud($request->all())->validate();
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
                /*$data['mode'] = 1;
                $data['user'] = $request->nama_pengguna;
                $request->session()->flash('status', $data);
                return redirect()->route('mahasiswa');*/
                return $this->notificationData(1, $request->nama_pengguna, 'TAMBAH', 'mahasiswa', $request);
            }else
            {
                return $this->notificationData(404, $request->nama_pengguna, 'TAMBAH DATA', 'mahasiswa', $request);
            } 
        }
    }

    public function edit(Request $request)
    {
        $this->validatorCrud($request->all())->validate();
        if($this->debugging)
        {
            var_dump($request->all());
            var_dump(is_null($request->foto));
        }else
        {
            $dataReq = $request->all();
            if(is_numeric($dataReq['foto'] = $this->upload_image($request)) == false)
            {
                if($this->editQuery($dataReq)) return $this->notificationData(2, $request->nama_pengguna, 'EDIT', 'mahasiswa', $request);
                else return $this->notificationData(404, $request->nama_pengguna, 'EDIT DATA', 'mahasiswa', $request);
            }
            return  $this->notificationData(404, $request->nama_pengguna, 'EDIT DATA', 'mahasiswa', $request);
        }
    }

    protected function hapusMahasiswa(array $data)
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
        $dataedit['mahasiswa'] = PenggunaRepo::where('id',$request->id_mahasiswa)->first();
        return $this->redirectTo($this->pathedit, $dataedit);
    }

    public function hapus(Request $request)
    {
        $reqData = $request->all();
        if($this->hapusMahasiswa($reqData)) return $this->notificationData(3, $request->nameHapusData, 'HAPUS DATA', 'mahasiswa', $request);
        else return $this->notificationData(404, $request->nameHapusData, 'HAPUS DATA', 'mahasiswa', $request);
    }
}
