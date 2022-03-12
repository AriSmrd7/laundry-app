<?php

namespace App\Http\Controllers;

use App\Models\Admin\Customer;
use App\Models\Admin\Jasa;
use App\Models\Admin\Pewangi;
use App\Models\Kasir\Order;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:ROLE_KASIR');
    }

    public function index()
    {  
        $order = Order::select(['*'])
                    ->where('id_petugas',Auth::User()->id)
                    ->count();

        $pelanggan = Customer::select(['*'])
                    ->count();
        
        $jasa = Jasa::select(['*'])
                    ->count();

        $pewangi = Pewangi::select(['*'])
                    ->count();

        return view('kasir.home',compact('pelanggan','order','pewangi','jasa'));
    }
}
