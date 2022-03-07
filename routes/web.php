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
    return view('welcome');
});

Auth::routes();


Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('adminhome');
Route::get('/kasir', [App\Http\Controllers\KasirController::class, 'index'])->name('kasirhome');

Route::get('logout', function (){
    auth()->logout();
    Session()->flush();
    return Redirect::to('/login');
})->name('logout');