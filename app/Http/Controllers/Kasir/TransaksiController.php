<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Admin\Transaksi;
use App\Models\Kasir\Order;
use App\Models\Kasir\OrderDetail;
use App\Models\Kasir\OrderTemp;
use App\Models\Kasir\TransaksiKasir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{

    public function index(){

        $transaksi = DB::table('tb_transaksi')
                        ->select('*')
                        ->join('tb_order', 'tb_transaksi.no_invoice', '=', 'tb_order.id')
                        ->get();        
    
        return view('kasir.transaksi.transaksi',compact('transaksi'))
                        ->with('i', (request()->input('page', 1) - 1) * 5);  
    }

    public function payOrder($id){
        $bayar = DB::table('tb_transaksi')
                        ->select('tb_transaksi.no_invoice','tb_transaksi.total_trx','tb_transaksi.id_transaksi')
                        ->join('tb_order', 'tb_transaksi.no_invoice', '=', 'tb_order.id')
                        ->where('tb_transaksi.id_transaksi','=',$id)
                        ->get();            
        return view('kasir.transaksi.bayar',compact('bayar'));
    }

    public function updateOrder(Request $request, $id_transaksi)
    {
        $bayar = $request->bayar;
        $kembalian = $request->kembalian;
        $status = 'LUNAS';

        TransaksiKasir::where('id_transaksi', $id_transaksi)
                ->update([
                    'bayar' => $bayar,
                    'kembalian' => $kembalian,
                    'status' => $status
                ]);
      
        return redirect()->route('transaksi.index');
    }
}