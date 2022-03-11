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
            ->with('i', (request()->input('page', 1) - 1) * 5);        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kasir\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kasir\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kasir\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kasir\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
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

        $order = New Order();
        $order->id = $request->no_invoice;
        $order->tgl_masuk = $request->tgl_masuk;
        $order->tgl_selesai = $request->tgl_selesai;
        $order->jml_paket = $request->jml_paket;
        $order->total_harga = $request->total_harga;
        $order->id_pewangi = $request->id_pewangi;
        $order->id_pelanggan = $request->id_pelanggan;
        $order->id_petugas = Auth::user()->id;
        $order->status_cucian = 'Dalam Antrian';
        $order->save();

        $transaksi = New TransaksiKasir();
        $transaksi->no_invoice = $request->no_invoice;
        $transaksi->id_petugas = Auth::user()->id;
        $transaksi->total_harga = $request->total_harga;
        $transaksi->bayar = 0;
        $transaksi->kembalian = 0;
        $transaksi->status = 'BELUM LUNAS';
        $transaksi->save();

        return redirect()->route('order.index');

    }
}
