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

    Route::post('/insert_order', [App\Http\Controllers\Kasir\OrderController::class, 'insertOrder'])->name('insert_order');
    Route::post('/create_invoice', [App\Http\Controllers\Kasir\OrderController::class, 'createInvoice'])->name('create_invoice');
    Route::get('/delete_order/{id}', [App\Http\Controllers\Kasir\OrderController::class, 'deleteOrder'])->name('delete_order');
    
    Route::get('/transaksi/invoice/{id}', [App\Http\Controllers\Kasir\TransaksiController::class, 'checkInvoice'])->name('transaksi.invoice');
    Route::post('/transaksi/updateinvoice/{id}', [App\Http\Controllers\Kasir\TransaksiController::class, 'updateInvoice'])->name('transaksi.updateinvoice');

    Route::get('/transaksi', [App\Http\Controllers\Kasir\TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/bayar/{id}', [App\Http\Controllers\Kasir\TransaksiController::class, 'payOrder'])->name('transaksi.bayar');
    Route::post('/transaksi/updatebayar/{id}', [App\Http\Controllers\Kasir\TransaksiController::class, 'updateOrder'])->name('transaksi.updatebayar');
    
    Route::resource('pelanggan', App\Http\Controllers\Kasir\PelangganKasirController::class);

});

Route::get('logout', function (){
    auth()->logout();
    Session()->flush();
    return Redirect::to('/login');
})->name('logout');