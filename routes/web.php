<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// ROUTE HOMEPAGE
Route::middleware(['guest'])->group(function(){
    Route::group(['prefix' => ''], function () {
        Route::get('', function () {
            return view('home/index');
        })->name('home');
        Route::get('loginv2', function () {
            return view('home/login');
        })->name('loginv2');
        Route::get('daftar', function () {
            return view('home/register');
        })->name('daftar');
        Route::get('test', function () {
            $imagename = Hash::make(Str::random(60)).".jpg";
            exec("ffmpeg -rtsp_flags listen -timeout 30 -y -i rtsp://admin:admin123@192.168.1.102:8554/unicast -vframes 1 E:/xampp/htdocs/monitoring_parkir/storage/app/public/data_file/parkir/".$imagename, $output, $return);
            if($return != 0){
                return "error";
            }
        });
        Route::get('timetest', function () {
            date_default_timezone_set("Asia/Jakarta");
            $date = date("Y-m-d \t H:i:s");
            var_dump($date);
            //$time = new DateTime();
           // echo $time->format('Y-m-d \t h:i:s');
        });
    
        Route::group(['prefix' => 'live_cam'], function () {
            Route::get('', function () {
                return view('home/live_cam', ['test' => 'jancok']);
            })->name('live_cam'); 
            Route::post('cari', 'Users\Parkir@cariLiveCam')->name('cari_live_cam'); 
        });
    });
});

Route::middleware(['auth'])->group(function(){
    // ROUTE ACCOUNT USER
    Route::group(['prefix' => 'user'], function () {
        
        // ROUTE PREFIX USERS
        Route::get('dashboard', 'Users\Dashboard@index')->name('dashboard');
        Route::post('hapus', 'Users\Dashboard@hapusAdmin')->name('hapusAdmin');
        Route::post('verifikasi', 'Users\Dashboard@verifikasiAdmin')->name('verifikasiAdmin');
        Route::get('dashboard/cari', 'Users\Dashboard@cariAdmin')->name('cariAdmin');
        Route::get('profile', 'Users\Dashboard@profile')->name('profile');
        Route::post('profile', 'Users\Dashboard@saveprofile')->name('saveprofile');

        Route::get('test_session', function () {
            return Auth::user();
        });
    
        // ROUTE PREFIX OPERATOR
        Route::group(['prefix' => 'operator'], function () {

            // TAMPIL DATA
            Route::get('', 'Users\Operator@index')->name('operator');
            Route::get('dashboard/cari', 'Users\Operator@cari')->name('cariOperator');
            
            // TAMBAH DATA
            Route::get('tambah', 'Users\Operator@tampilan_tambah')->name('tambah_operator');
            Route::post('tambah', 'Users\Operator@tambah')->name('simpan_tambah_operator');
            
            // EDIT DATA
            Route::get('edit', 'Users\Operator@tampilan_edit')->name('edit_operator');
            Route::post('edit', 'Users\Operator@edit')->name('simpan_edit_operator');
    
            // HAPUS DATA
            Route::post('hapus', 'Users\Operator@hapus')->name('hapus_operator');
        });
        
        // ROUTE PREFIX TRANSAKSI
        Route::group(['prefix' => 'transaksi'], function () {
    
            // TAMPIL DATA
            Route::get('', 'Users\Parkir@index')->name('transaksi');
            Route::get('cari', 'Users\Parkir@cari')->name('cariTransaksi');
            
            // TAMBAH DATA
            Route::get('tambah', 'Users\Parkir@tampilan_tambah')->name('tambah_transaksi');
            Route::post('tambah', 'Users\Parkir@tambah')->name('simpan_tambah_transaksi');
            
            // EDIT DATA
            Route::get('edit', 'Users\Parkir@tampilan_edit')->name('edit_transaksi');
            Route::post('edit', 'Users\Parkir@edit')->name('simpan_edit_transaksi');
    
            // HAPUS DATA
            Route::post('hapus', 'Users\Parkir@hapus')->name('hapus_transaksi');
    
        });
        
        // ROUTE PREFIX PEGAWAI
        Route::group(['prefix' => 'pegawai'], function () {

            // TAMPIL DATA
            Route::get('', 'Users\Pegawai@index')->name('pegawai');
            Route::get('dashboard/cari', 'Users\Pegawai@cari')->name('cariPegawai');
            
            // TAMBAH DATA
            Route::get('tambah', 'Users\Pegawai@tampilan_tambah')->name('tambah_pegawai');
            Route::post('tambah', 'Users\Pegawai@tambah')->name('simpan_tambah_pegawai');
            
            // EDIT DATA
            Route::get('edit', 'Users\Pegawai@tampilan_edit')->name('edit_pegawai');
            Route::post('edit', 'Users\Pegawai@edit')->name('simpan_edit_pegawai');
    
            // HAPUS DATA
            Route::post('hapus', 'Users\Pegawai@hapus')->name('hapus_pegawai');
        });
    
        // ROUTE PREFIX MAHASISWA
        Route::group(['prefix' => 'mahasiswa'], function () {
    
            // TAMPIL DATA
            Route::get('', 'Users\Mahasiswa@index')->name('mahasiswa');
            Route::get('cari', 'Users\Mahasiswa@cari')->name('cariMahasiswa');
            
            // TAMBAH DATA
            Route::get('tambah', 'Users\Mahasiswa@tampilan_tambah')->name('tambah_mahasiswa');
            Route::post('tambah', 'Users\Mahasiswa@tambah')->name('simpan_tambah_mahasiswa');
            
            // EDIT DATA
            Route::get('edit', 'Users\Mahasiswa@tampilan_edit')->name('edit_mahasiswa');
            Route::post('edit', 'Users\Mahasiswa@edit')->name('simpan_edit_mahasiswa');
    
            // HAPUS DATA
            Route::post('hapus', 'Users\Mahasiswa@hapus')->name('hapus_mahasiswa');
        });

        // ROUTE PREFIX TEMPAT PARKIR
        Route::group(['prefix' => 'tempat_parkir'], function () {
    
            // TAMPIL DATA
            Route::get('', 'Users\TempatParkir@index')->name('tempatparkir');
            Route::get('cari', 'Users\TempatParkir@cari')->name('cariTempatparkir');
            
            // TAMBAH DATA
            Route::get('tambah', 'Users\TempatParkir@tampilan_tambah')->name('tambah_tempatparkir');
            Route::post('tambah', 'Users\TempatParkir@tambah')->name('simpan_tambah_tempatparkir');
            
            // EDIT DATA
            Route::get('edit', 'Users\TempatParkir@tampilan_edit')->name('edit_tempatparkir');
            Route::post('edit', 'Users\TempatParkir@edit')->name('simpan_edit_tempatparkir');
    
            // HAPUS DATA
            Route::post('hapus', 'Users\TempatParkir@hapus')->name('hapus_tempatparkir');
        });

        // ROUTE PREFIX ALAT PARKIR
        Route::group(['prefix' => 'alat_parkir'], function () {
    
            // TAMPIL DATA
            Route::get('', 'Users\AlatParkir@index')->name('alat_parkir');
            Route::get('cari', 'Users\AlatParkir@cari')->name('cariAlat_parkir');
            
            // TAMBAH DATA
            Route::get('tambah', 'Users\AlatParkir@tampilan_tambah')->name('tambah_alat_parkir');
            Route::post('tambah', 'Users\AlatParkir@tambah')->name('simpan_tambah_alat_parkir');
            
            // EDIT DATA
            Route::get('edit', 'Users\AlatParkir@tampilan_edit')->name('edit_alat_parkir');
            Route::post('edit', 'Users\AlatParkir@edit')->name('simpan_edit_alat_parkir');
    
            // HAPUS DATA
            Route::post('hapus', 'Users\AlatParkir@hapus')->name('hapus_alat_parkir');

        });

        // ROUTE PREFIX CAMERA PARKIR
        Route::group(['prefix' => 'cameraparkir'], function () {
    
            // TAMPIL DATA
            Route::get('', 'Users\CameraParkir@index')->name('cameraparkir');
            Route::get('cari', 'Users\CameraParkir@cari')->name('cariCameraparkir');
            
            // TAMBAH DATA
            Route::get('tambah', 'Users\CameraParkir@tampilan_tambah')->name('tambah_cameraparkir');
            Route::post('tambah', 'Users\CameraParkir@tambah')->name('simpan_tambah_cameraparkir');
            
            // EDIT DATA
            Route::get('edit', 'Users\CameraParkir@tampilan_edit')->name('edit_cameraparkir');
            Route::post('edit', 'Users\CameraParkir@edit')->name('simpan_edit_cameraparkir');
    
            // HAPUS DATA
            Route::post('hapus', 'Users\CameraParkir@hapus')->name('hapus_cameraparkir');

        });
    });
});

Route::get('mode', 'Users\AlatParkir@getMode')->name('getmode_alat_parkir');
Route::get('testchangemode', 'Users\Parkir@changeModeAP')->name('gantimode_alat_parkir');
//Route::get('testcapture', 'Users\AlatParkir@testCapture')->name('captureimage');
Route::get('parkirmasuk', 'Users\Parkir@parkirMasuk')->name('parkirmasuk');
Route::get('parkirkeluar', 'Users\Parkir@parkirKeluar')->name('parkirkeluar');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

