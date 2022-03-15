<?php

namespace App\Http\Controllers;

use App\Models\Kasir\Order;
use App\Models\Kasir\OrderDetail;
use App\Models\Kasir\OrderTemp;
use Illuminate\Http\Request;
use App\Models\Kasir\TransaksiKasir; 

class ClearController extends Controller
{
    public function truncateOrder()
    {  
        Order::query()->truncate();
        OrderDetail::query()->truncate();
        OrderTemp::query()->truncate();
        TransaksiKasir::query()->truncate();
    }
}
