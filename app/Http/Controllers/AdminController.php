<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\Customer;
use App\Models\Admin\Pewangi;
use App\Models\Kasir\Order;
use App\Models\Admin\Jasa;

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

        $pelanggan = Customer::select(['*'])
                    ->count();
        
        $jasa = Jasa::select(['*'])
                    ->count();

        $income = Order::select('*')->sum('total_harga');


        return view('admin.home',compact('pelanggan','order','income','jasa'));
    }
}
