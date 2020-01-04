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

// ROUTE HOMEPAGE
Route::group(['prefix' => ''], function () {
    Route::get('', function () {
        return view('home/index');
    })->name('home');
    Route::get('live_cam', function () {
        return view('home/live_cam');
    })->name('live_cam');
    Route::get('loginv2', function () {
        return view('home/login');
    })->name('loginv2');
    Route::get('daftar', function () {
        return view('home/register');
    })->name('daftar');
    Route::get('test', function (App\Repositories\AccessRepo $access) {
        /*$access::create([
            'nama_access' => 'admin',
        ]);*/
        var_dump($access::where('idAccess', 10));
    });
    Route::get('timetest', function () {
        date_default_timezone_set("Asia/Jakarta");
        $date = date("Y-m-d \t H:i:s");
        var_dump($date);
        //$time = new DateTime();
       // echo $time->format('Y-m-d \t h:i:s');
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
    
        // ROUTE PREFIX TRANSAKSI
        Route::group(['prefix' => 'transaksi'], function () {
    
            // TAMPIL DATA
            Route::get('', 'Users\Transaksi@index')->name('transaksi');
            Route::get('cari', 'Users\Transaksi@cari')->name('cariTransaksi');
            
            // TAMBAH DATA
            Route::get('tambah', 'Users\Transaksi@tampilan_tambah')->name('tambah_transaksi');
            Route::post('tambah', 'Users\Transaksi@tambah')->name('simpan_tambah_transaksi');
            
            // EDIT DATA
            Route::get('edit', 'Users\Transaksi@tampilan_edit')->name('edit_transaksi');
            Route::post('edit', 'Users\Transaksi@edit')->name('simpan_edit_transaksi');
    
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
            Route::post('hapus', 'Users\Pegawai@hapusPegawai')->name('hapus_pegawai');
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
            Route::post('hapus', 'Users\Mahasiswa@hapusMahasiswa')->name('hapus_mahasiswa');
        });
    });
});
Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

