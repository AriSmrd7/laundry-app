<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Kasir\Member;
use App\Models\Kasir\Order;
use App\Models\Kasir\OrderDetail;
use App\Models\Kasir\OrderTemp;
use App\Models\Kasir\TransaksiKasir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:ROLE_KASIR');
    }
    
    public function index(){

        $transaksi = DB::table('tb_transaksi')
                        ->select('*')
                        ->join('tb_order', 'tb_transaksi.no_invoice', '=', 'tb_order.id')
                        ->join('tb_pelanggan', 'tb_order.id_pelanggan', '=', 'tb_pelanggan.id_pelanggan')
                        ->where('tb_transaksi.id_petugas',Auth::user()->id)
                        ->paginate(10);        
    
        return view('kasir.transaksi.transaksi',compact('transaksi'))
                        ->with('i', (request()->input('page', 1) - 1) * 10);  
    }

    public function payOrder($id){
        $bayar = DB::table('tb_transaksi')
                        ->select('tb_transaksi.no_invoice','tb_transaksi.total_trx','tb_transaksi.bayar','tb_transaksi.utang','tb_transaksi.id_transaksi','tb_order.id_pelanggan')
                        ->join('tb_order', 'tb_transaksi.no_invoice', '=', 'tb_order.id')
                        ->where('tb_transaksi.no_invoice','=',$id)
                        ->get();            
        $idm = TransaksiKasir::select('tb_order.id_pelanggan')
                            ->join('tb_order', 'tb_transaksi.no_invoice', '=', 'tb_order.id')
                            ->join('tb_member', 'tb_order.id_pelanggan', '=', 'tb_member.id_pelanggan')
                            ->where('tb_transaksi.no_invoice','=',$id)
                            ->exists();

        $r = new Member();
        $member = $r->memberChecks($idm);

        return view('kasir.transaksi.bayar',compact('bayar','member'));
    }

    public function updateOrder(Request $request, $id_transaksi)
    {
        $noInvoice = $request->no_invoice;
        $idPel = $request->id_pelanggan;
        $lunas = $request->lunas;
        $utang = $request->utang;
        $bayar = $request->bayar;
        $kembalian = $request->kembalian;
        $bayar2 = $request->bayar2;
        $kembalian2 = $request->kembalian2;
        $sisa = 0;

        $status = 'LUNAS';

        $r = new Member();
        $member = $r->memberChecks($idPel);

        if($member){
            TransaksiKasir::where('id_transaksi', $id_transaksi)
            ->update([
                'bayar' => $bayar + $lunas,
                'utang' => 0,
                'kembalian' => $kembalian,
                'status' => $status
            ]);
        }
        else{
            TransaksiKasir::where('id_transaksi', $id_transaksi)
            ->update([
                'bayar' => $bayar2,
                'kembalian' => $kembalian2,
                'status' => $status
            ]);
        }

      
        return redirect()->route('transaksi.invoice',$noInvoice);
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

        return view('kasir.transaksi.invoice',compact('check','detail'));    
    }

    public function getStatus($id){
        $status = DB::table('tb_order')
                        ->select('*')
                        ->join('tb_transaksi', 'tb_order.id', '=', 'tb_transaksi.no_invoice')
                        ->join('tb_pewangi', 'tb_order.id_pewangi', '=', 'tb_pewangi.id_pewangi')
                        ->join('tb_pelanggan', 'tb_order.id_pelanggan', '=', 'tb_pelanggan.id_pelanggan')
                        ->where('tb_order.id','=',$id)
                        ->get();    
        return view('kasir.transaksi.status',compact('status'));
    }

    public function updateStatus(Request $request, $id){
        $noInvoice = $request->no_invoice;
        $status_cucian = $request->status_cucian;

        Order::where('id', $id)
                ->update([
                    'status_cucian' => $status_cucian,
                ]);
      
        return redirect()->route('transaksi.invoice',$noInvoice);
    }

    public function searchInvoice(Request $request)
	{
		// menangkap data pencarian
		$cari = $request->cari;
 
    		// mengambil data dari table pegawai sesuai pencarian data

        $transaksi = DB::table('tb_transaksi')
                        ->select('*')
                        ->join('tb_order', 'tb_transaksi.no_invoice', '=', 'tb_order.id')
                        ->join('tb_pelanggan', 'tb_order.id_pelanggan', '=', 'tb_pelanggan.id_pelanggan')
                        ->where('tb_transaksi.id_petugas',Auth::user()->id)
                        ->where('no_invoice','like',"%".$cari."%")
                        ->orWhere('nama','like',"%".$cari."%")
                        ->orWhere('total_trx','like',"%".$cari."%")
                        ->orWhere('bayar','like',"%".$cari."%")
                        ->orWhere('status','like',"%".$cari."%")
                        ->orWhere('status_cucian','like',"%".$cari."%")
                        ->paginate();
 
    		// mengirim data pegawai ke view index
		return view('kasir.transaksi.transaksi',['transaksi' => $transaksi])->with('i');
 
	}

    public function deleteInvoice($id){
        if($id !== '' OR $id !== NULL){
            TransaksiKasir::where('no_invoice',$id)->delete();
            Order::where('id',$id)->delete();
            OrderDetail::where('no_invoice',$id)->delete();

            return redirect()->route('transaksi.index')->with('success','Data transaksi berhasil dihapus');    
        }
        else{
            return redirect()->route('transaksi.index')->with('error','Data gagal dihapus');    
        }
    }

    public function printInvoice(){
        return view('kasir.transaksi.print');
    }

}