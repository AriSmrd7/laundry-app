<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\Customer;
use App\Models\Admin\Pewangi;
use App\Models\Kasir\Order;
use App\Models\Admin\Jasa;
use App\Models\Admin\Transaksi;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:ROLE_ADMIN');
    }

    public function index()
    {  
        $order = Order::select(['*'])
                    ->count();

        $customer = Customer::select(['*'])
                    ->count();
        
        $jasa = Jasa::select(['*'])
                    ->count();

        $income = Transaksi::select('*')->sum('bayar');


        return view('admin.home',compact('customer','order','income','jasa'));
    }
}
