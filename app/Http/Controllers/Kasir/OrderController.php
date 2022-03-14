<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Kasir\Order;
use App\Models\Kasir\OrderDetail;
use App\Models\Kasir\OrderTemp;
use App\Models\Kasir\TransaksiKasir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:ROLE_KASIR');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = Order::latest()->paginate(5);
        $pelanggan = DB::table('tb_pelanggan')
                        ->select('*')
                        ->get();       
        $jasa = DB::table('tb_jasa')
                        ->select('*')
                        ->get();  
        $pewangi = DB::table('tb_pewangi')
                        ->select('*')
                        ->get();
        $ordertemp = DB::table('tb_order_temp')
                        ->select('*')
                        ->join('tb_jasa', 'tb_order_temp.id_jasa', '=', 'tb_jasa.id_jasa')
                        ->get();
        $ordertotal = DB::table('tb_order_temp')
                        ->selectRaw('SUM(subtotal) as totalharga')
                        ->selectRaw('COUNT(id_jasa) as totalpaket')
                        ->get('SUM(subtotal) as totalharga');  
        
        
        $prefix = 'INV-';
        $noinvoice = IdGenerator::generate(['table' => 'tb_order', 'length' => 9, 'prefix' =>$prefix]);
             
                                
        return view('kasir.order.order',compact('order','pelanggan','jasa','pewangi','ordertemp','ordertotal','noinvoice'))
            ->with('i', (request()->input('page', 1) - 1) * 5);        
    }

    public function insertOrder(Request $request){
        $request->validate([
            'no_invoice' => 'required',
            'id_jasa' => 'required',
            'satuan' => 'required',
            'harga' => 'required',
            'jumlah' => 'required',
            'subtotal' => 'required',
        ]);
      
        OrderTemp::create($request->all());

        return redirect()->route('order.index');
    }

    public function deleteOrder($id){        
        OrderTemp::where('id_temp',$id)->delete();
        return redirect()->route('order.index');
    }

    public function createInvoice(Request $request){
        $ordertemp = DB::table('tb_order_temp')
                    ->select('*')
                    ->get();

        foreach($ordertemp as $listOrder){
            $allOrders[] =[
                'no_invoice' => $listOrder->no_invoice,
                'id_jasa' => $listOrder->id_jasa,
                'satuan' => $listOrder->satuan,
                'harga' => $listOrder->harga,
                'jumlah' => $listOrder->jumlah,
                'subtotal' => $listOrder->subtotal,
                'created_at' => $listOrder->created_at
            ];
        }
        OrderDetail::insert($allOrders);
        OrderTemp::query()->truncate();

        $noInvoice = $request->no_invoice;

        $order = New Order();
        $order->id = $noInvoice;
        $order->tgl_masuk = $request->tgl_masuk;
        $order->tgl_selesai = $request->tgl_selesai;
        $order->jam_masuk = $request->jam_masuk;
        $order->jam_selesai = $request->jam_selesai;
        $order->jml_paket = $request->jml_paket;
        $order->total_harga = $request->total_harga;
        $order->id_pewangi = $request->id_pewangi;
        $order->id_pelanggan = $request->id_pelanggan;
        $order->id_petugas = Auth::user()->id;
        $order->status_cucian = 'Diproses';
        $order->save();

        $transaksi = New TransaksiKasir();
        $transaksi->no_invoice = $noInvoice;
        $transaksi->id_petugas = Auth::user()->id;
        $transaksi->total_trx = $request->total_harga;
        $transaksi->bayar = 0;
        $transaksi->kembalian = 0;
        $transaksi->status = 'BELUM LUNAS';
        $transaksi->save();

        return redirect()->route('transaksi.invoice',$noInvoice);

    }
}
