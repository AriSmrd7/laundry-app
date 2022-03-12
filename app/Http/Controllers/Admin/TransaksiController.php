<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:ROLE_ADMIN');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksi = DB::table('tb_transaksi')
                        ->select('*')
                        ->join('tb_order', 'tb_transaksi.no_invoice', '=', 'tb_order.id')
                        ->join('users', 'tb_transaksi.id_petugas', '=', 'users.id')
                        ->get();        
    
        return view('admin.transaksi.transaksi',compact('transaksi'))
                        ->with('i', (request()->input('page', 1) - 1) * 5);  
    }

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaksi $transaksi)
    {
        //
    }

    public function checkInvoice($id){
        $check = DB::table('tb_order')
                        ->select('*')
                        ->join('tb_transaksi', 'tb_order.id', '=', 'tb_transaksi.no_invoice')
                        ->join('tb_pewangi', 'tb_order.id_pewangi', '=', 'tb_pewangi.id_pewangi')
                        ->join('tb_pelanggan', 'tb_order.id_pelanggan', '=', 'tb_pelanggan.id_pelanggan')
                        ->join('users', 'tb_order.id_petugas', '=', 'users.id')
                        ->where('tb_order.id','=',$id)
                        ->get();
        $detail = DB::table('tb_order_detail')
                        ->select('*')
                        ->join('tb_order', 'tb_order_detail.no_invoice', '=', 'tb_order.id')
                        ->join('tb_jasa', 'tb_order_detail.id_jasa', '=', 'tb_jasa.id_jasa')
                        ->where('tb_order_detail.no_invoice','=',$id)
                        ->get();

        return view('admin.transaksi.invoice',compact('check','detail'));    
    }
}
