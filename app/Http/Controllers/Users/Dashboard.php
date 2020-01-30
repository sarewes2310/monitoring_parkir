<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Users;
use App\Repositories\PenggunaRepo;
use App\Repositories\ParkirRepo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    protected $path = 'users.dashboard';
    protected $debugging = false;

    protected function inisialisasi()
    {
        $data['admin'] = DB::table('users')->paginate(15);
        if(count($data['admin']) > 0) $data['kosong'] = false;
        else $data['kosong'] = true;
        $data += $this->inisialisasi_jumlah_pengguna();
        return $data;
    }

    public function index() 
    {
        $data = $this->inisialisasi();
        return $this->redirectTo($data);
    }

    protected function redirectTo(array $data)
    {
        return view($this->path, $data);
    }

    public function cariAdmin(Request $request)
    {
        $this->ValidatorCariAdmin(array('name' => $request->all()['nameAdmin']))->validate();
        //var_dump($request->all()['nameAdmin']);
        $data = $this->cari($request->all());
        $data += $this->inisialisasi_jumlah_pengguna();
        //var_dump($data);
        $this->cariCek($request->all()) ? $data['kosong'] = false : $data['kosong'] = true;
        return $this->redirectTo($data);
    }
    
    protected function cari(array $datainput)
    {
        $data['admin'] = Users::where('name', 'like', '%'.$datainput['nameAdmin'].'%')->paginate(15);
        return $data;
    }

    protected function cariCek(array $datainput)
    {
        if(Users::where('name', 'like', '%'.$datainput['nameAdmin'].'%')->count() > 0) return true;
        else return false;
    }

    protected function inisialisasi_jumlah_pengguna()
    {
        $data['mahasiswa'] = PenggunaRepo::where('statuspengguna_id', 1)->count();
        $data['pegawai'] = PenggunaRepo::where('statuspengguna_id', 2)->count();
        #$data['mode'] = null;
        #$data['user'] = null;
        if(Auth::user()->access_id == 2)
        {
            $data += [
                'ktp' => ParkirRepo::where('verifikasi', 0)->whereDate('created_at', date('Y-m-d'))->count(),
                'dph' => ParkirRepo::whereDate('created_at', date('Y-m-d'))->count(),
                'rdp' => ParkirRepo::count(),
                'chart_mahasiswa' => DB::table('pengguna')->join('parkir', 'pengguna.id', 'parkir.pengguna_id')->where('statuspengguna_id', 1)->whereDate('parkir.created_at', date('Y-m-d'))->count(),
                'chart_pegawai'   => DB::table('pengguna')->join('parkir', 'pengguna.id', 'parkir.pengguna_id')->where('statuspengguna_id', 2)->whereDate('parkir.created_at', date('Y-m-d'))->count(),
            ];
        }
        return $data;
    }

    protected function ValidatorCariAdmin(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
        ]);
    }

    public function hapusAdmin(Request $request)
    {
        $reqData = $request->all();
        if($this->hapus($reqData))
        {
            #$data = $this->inisialisasi();
            $data['mode'] = 2;
            $data['user'] = $reqData['nameHapusData'];
            /*return redirect()->action(
                'Users\Dashboard@index',$data
            );*/
            $request->session()->flash('status', $data);
            return redirect()->route('dashboard');
        }else
        {
            $data = $this->inisialisasi();
            $data['mode'] = 404;
            $data['user'] = "hapus data admin " + $reqData['nameHapusData'];
            $request->session()->flash('status', $data);
            return redirect()->route('dashboard');
        }
    }

    protected function hapus(array $data)
    {
        return Users::destroy($data['idHapusData']);
    }

    public function verifikasiAdmin(Request $request)
    {
        $data['mode'] = 404;
        $reqData = $request->all();
        
        // CEK KETERSEDIAAN USER
        $users = $this->cek($reqData);
        if($users->count() <= 0) 
        {
            $data['user'] = "hapus data admin " + $reqData['nameVerifData'];
            $request->session()->flash('status', $data);
            return redirect()->route('dashboard');
        }
        
        date_default_timezone_set("Asia/Jakarta");
        $input['akun_verified_at'] = date("Y-m-d H:i:s");
        $input['verifikasi'] = 1;   
        //return $data;

        // UPDATE VERIFIKASI USER
        if($this->verifikasi($users, $input))
        {
            $data['mode'] = 1;
            $data['user'] = $reqData['nameVerifData'];
            $request->session()->flash('status', $data);
            return redirect()->route('dashboard');
        }else
        {
            $data = $this->inisialisasi();
            $data['mode'] = 404;
            $data['user'] = "verifikasi data admin " + $reqData['nameVerifData'];
            $request->session()->flash('status', $data);
            return redirect()->route('dashboard');
        }
    }

    protected function verifikasi(Users $users, array $data)
    {
        return $users::where('id', $users->id)->update($data);
    }

    protected function cek(array $data)
    {
        return Users::find($data['idVerifData']);
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

    public function profile()
    {
        //$reqData = Auth::user();
        $data['profile'] = Auth::user();
        return view('users.profile', $data);
    }

    public function saveprofile(Request $request)
    {
        $this->validatorCrud($request->all(), $request->password == "" &&  $request->password_confirmation == "" ? 0 : 1)->validate();
        if($this->debugging)
        {
            var_dump($request->all());
            var_dump(is_null($request->foto));
        }else
        {
            $dataReq = $request->all();
            if($this->editQuery($dataReq)) return \redirect('user/dashboard');
            else return $this->notificationData(404, $request->name, 'EDIT DATA', 'operator', $request);
        }
    }
}
