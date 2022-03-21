<?php

use App\Http\Controllers\Kasir\OrderController;
use App\Models\Kasir\OrderTemp;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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
    Route::resource('customer', App\Http\Controllers\Admin\CustomerController::class);
    Route::resource('petugas', App\Http\Controllers\Admin\PetugasController::class);
    Route::resource('order-transaksi', App\Http\Controllers\Admin\TransaksiController::class);

    Route::get('/orders/{id}', [App\Http\Controllers\Admin\TransaksiController::class, 'checkInvoice'])->name('orders.invoice');

    Route::get('/member', [App\Http\Controllers\Admin\MemberController::class, 'index'])->name('members.index');
    Route::get('/member/create', [App\Http\Controllers\Admin\MemberController::class, 'addMember'])->name('members.create');
    Route::post('/member/store', [App\Http\Controllers\Admin\MemberController::class, 'storeMember'])->name('members.store');
    Route::get('/member/detail/{id}', [App\Http\Controllers\Admin\MemberController::class, 'detailMember'])->name('members.detail');
    Route::post('/member/detail/{id}/update', [App\Http\Controllers\Admin\MemberController::class, 'updateMember'])->name('members.update');
    Route::get('/member/detail/detele/paket/{id}', [App\Http\Controllers\Admin\MemberController::class, 'delPaket'])->name('members.delete');
    Route::get('/member/{id}/delete', [App\Http\Controllers\Admin\MemberController::class, 'delMember'])->name('members.delmember');

    Route::get('/laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan.index');

});

Route::group(['prefix'=>'kasir'], function () {

    Route::resource('order', App\Http\Controllers\Kasir\OrderController::class);

    Route::get('/validate_order', [App\Http\Controllers\Kasir\OrderController::class, 'validateOrder'])->name('validateOrder');
    
    Route::get('/check_member/{id}', [App\Http\Controllers\Kasir\OrderController::class, 'checkMember'])->name('checkMember');

    Route::get('/sisa_member/{id}/{paket}', [App\Http\Controllers\Kasir\OrderController::class, 'sisaMember'])->name('sisaMember');


    Route::post('/insert_order', [App\Http\Controllers\Kasir\OrderController::class, 'insertOrder'])->name('insert_order');
    Route::post('/create_invoice', [App\Http\Controllers\Kasir\OrderController::class, 'createInvoice'])->name('create_invoice');
    Route::get('/delete_order/{id}', [App\Http\Controllers\Kasir\OrderController::class, 'deleteOrder'])->name('delete_order');
    
    Route::get('/transaksi/cari/', [App\Http\Controllers\Kasir\TransaksiController::class, 'searchInvoice'])->name('transaksi.search');
    Route::get('/transaksi/invoice/{id}', [App\Http\Controllers\Kasir\TransaksiController::class, 'checkInvoice'])->name('transaksi.invoice');
    Route::post('/transaksi/updateinvoice/{id}', [App\Http\Controllers\Kasir\TransaksiController::class, 'updateInvoice'])->name('transaksi.updateinvoice');

    Route::get('/transaksi', [App\Http\Controllers\Kasir\TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/bayar/{id}', [App\Http\Controllers\Kasir\TransaksiController::class, 'payOrder'])->name('transaksi.bayar');
    Route::post('/transaksi/updatebayar/{id}', [App\Http\Controllers\Kasir\TransaksiController::class, 'updateOrder'])->name('transaksi.updatebayar');
    
    Route::get('/transaksi/status/{id}', [App\Http\Controllers\Kasir\TransaksiController::class, 'getStatus'])->name('transaksi.status');
    Route::post('/transaksi/updatestatus/{id}', [App\Http\Controllers\Kasir\TransaksiController::class, 'updateStatus'])->name('transaksi.updatestatus');
    
    Route::resource('pelanggan', App\Http\Controllers\Kasir\PelangganKasirController::class);

    Route::get('/get-order',[App\Http\Controllers\Kasir\OrderController::class,'getOrderData'])->name('get_order_data');

    Route::get('/member-kasir', [App\Http\Controllers\Kasir\MemberController::class, 'index'])->name('members-kasir.index');
    Route::get('/member-kasir/create', [App\Http\Controllers\Kasir\MemberController::class, 'addMember'])->name('members-kasir.create');
    Route::post('/member-kasir/store', [App\Http\Controllers\Kasir\MemberController::class, 'storeMember'])->name('members-kasir.store');
    Route::get('/member-kasir/detail/{id}', [App\Http\Controllers\Kasir\MemberController::class, 'detailMember'])->name('members-kasir.detail');
    Route::post('/member-kasir/detail/{id}/update', [App\Http\Controllers\Kasir\MemberController::class, 'updateMember'])->name('members-kasir.update');
    Route::get('/member-kasir/detail/detele/paket/{id}', [App\Http\Controllers\Kasir\MemberController::class, 'delPaket'])->name('members-kasir.delete');
    Route::get('/member-kasir/{id}/delete', [App\Http\Controllers\Kasir\MemberController::class, 'delMember'])->name('members-kasir.delmember');
});

Route::get('logout', function (){
    auth()->logout();
    Session()->flush();
    return Redirect::to('/login');
})->name('logout');