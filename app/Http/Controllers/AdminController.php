<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\Pelanggan;
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

        $pelanggan = Pelanggan::select(['*'])
                    ->count();
        
        $jasa = Jasa::select(['*'])
                    ->count();

        $pewangi = Pewangi::select(['*'])
                    ->count();

        return view('admin.home',compact('pelanggan','order','pewangi','jasa'));
    }
}
