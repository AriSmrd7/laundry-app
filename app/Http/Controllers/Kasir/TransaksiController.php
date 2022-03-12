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
                        ->where('tb_transaksi.no_invoice','=',$id)
                        ->get();            
        return view('kasir.transaksi.bayar',compact('bayar'));
    }

    public function updateOrder(Request $request, $id_transaksi)
    {
        $noInvoice = $request->no_invoice;
        $bayar = $request->bayar;
        $kembalian = $request->kembalian;
        $status = 'LUNAS';

        TransaksiKasir::where('id_transaksi', $id_transaksi)
                ->update([
                    'bayar' => $bayar,
                    'kembalian' => $kembalian,
                    'status' => $status
                ]);
      
        return redirect()->route('transaksi.invoice',$noInvoice);
    }

    public function checkInvoice($id){
        $check = DB::table('tb_order')
                        ->select('*')
                        ->join('tb_transaksi', 'tb_order.id', '=', 'tb_transaksi.no_invoice')
                        ->join('tb_pewangi', 'tb_order.id_pewangi', '=', 'tb_pewangi.id_pewangi')
                        ->join('tb_pelanggan', 'tb_order.id_pelanggan', '=', 'tb_pelanggan.id_pelanggan')
                        ->where('tb_order.id','=',$id)
                        ->get();
        $detail = DB::table('tb_order_detail')
                        ->select('*')
                        ->join('tb_order', 'tb_order_detail.no_invoice', '=', 'tb_order.id')
                        ->join('tb_jasa', 'tb_order_detail.id_jasa', '=', 'tb_jasa.id_jasa')
                        ->where('tb_order_detail.no_invoice','=',$id)
                        ->get();

        return view('kasir.transaksi.invoice',compact('check','detail'));    
    }

    public function updateInvoice(Request $request,$id){

    }
}