<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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

Route::get('/', function () {
    return view('auth.login');
})->middleware('auth');

Auth::routes();


Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('adminhome');
Route::get('/kasir', [App\Http\Controllers\KasirController::class, 'index'])->name('kasirhome');


Route::group(['prefix'=>'admin'], function () {

    Route::resource('jasa', App\Http\Controllers\Admin\JasaController::class);
    Route::resource('pewangi', App\Http\Controllers\Admin\PewangiController::class);
    Route::resource('pelanggan', App\Http\Controllers\Admin\PelangganController::class);
    Route::resource('petugas', App\Http\Controllers\Admin\PetugasController::class);
    Route::resource('transaksi', App\Http\Controllers\Admin\TransaksiController::class);
    Route::resource('pesanan', App\Http\Controllers\Admin\PesananController::class);

});

Route::group(['prefix'=>'kasir'], function () {

    Route::resource('order', App\Http\Controllers\Kasir\OrderController::class);

});

Route::get('logout', function (){
    auth()->logout();
    Session()->flush();
    return Redirect::to('/login');
})->name('logout');