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
    Route::get('login', function () {
        return view('home/login');
    })->name('login');
    Route::get('daftar', function () {
        return view('home/daftar');
    })->name('daftar');
});

// ROUTE ACCOUNT USER
Route::group(['prefix' => 'user'], function () {
    Route::post('login', function ($id) {
        
    });
    Route::post('logout', function ($id) {
        
    });
    Route::get('dashboard', function () {
        return view('users/dashboard');    
    })->name('dashboard');
    Route::get('pegawai', function () {
        return view('users/pegawai');    
    })->name('pegawai');
    Route::get('mahasiswa', function () {
        return view('users/mahasiswa');    
    })->name('mahasiswa');
    Route::get('transaksi', function () {
        return view('users/transaksi');    
    })->name('transaksi');
});