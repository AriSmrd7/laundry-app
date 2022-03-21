<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Laporan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Admin\Transaksi;
use Carbon\Carbon;

class LaporanController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:ROLE_ADMIN');
    }

    public function index(Request $request){
        if ($request->ajax()) {
            $data = Transaksi::select('tb_transaksi.no_invoice','tb_pelanggan.nama','tb_order.jml_paket','tb_transaksi.total_trx','tb_transaksi.bayar','tb_transaksi.kembalian','tb_order.jam_masuk','tb_order.tgl_masuk','tb_order.jam_selesai','tb_order.tgl_selesai','users.name','tb_transaksi.created_at')
                    ->join('tb_order', 'tb_transaksi.no_invoice', '=', 'tb_order.id')
                    ->join('users', 'tb_transaksi.id_petugas', '=', 'users.id')
                    ->join('tb_pelanggan', 'tb_order.id_pelanggan', '=', 'tb_pelanggan.id_pelanggan')
                    ->get();
                    return DataTables::of($data)->addIndexColumn()
                    ->editColumn('created_at', function($data){ $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d/m/Y H:i A'); return $formatedDate; })
                    ->make(true);        
            }
        return view('admin.laporan.laporan');
    }
}
