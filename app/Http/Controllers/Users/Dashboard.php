<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Users;
use App\Repositories\PenggunaRepo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Dashboard extends Controller
{
    protected $path = 'users.dashboard';

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
        $data['mahasiswa'] = PenggunaRepo::where('idStatusPengguna', 1)->count();
        $data['pegawai'] = PenggunaRepo::where('idStatusPengguna', 2)->count();
        #$data['mode'] = null;
        #$data['user'] = null;
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
        $users->akun_verified_at = date("Y-m-d \t H:i:s");

        // UPDATE VERIFIKASI USER
        if($this->verifikasi($users))
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

    protected function verifikasi(Users $users)
    {
        return $users::save();
    }

    protected function cek(array $data)
    {
        return Users::find($data['idVerifData']);
    }
}
