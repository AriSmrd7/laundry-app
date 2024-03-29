<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Kasir\Member;
use App\Models\Kasir\MemberDetail;
use App\Models\Kasir\Order;
use App\Models\Kasir\OrderDetail;
use App\Models\Kasir\OrderTemp;
use App\Models\Kasir\TransaksiKasir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Validator;
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

        $tempcache = OrderTemp::select('*')->get();
        OrderTemp::destroy($tempcache->pluck('id_temp')->toArray());

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

    
    public function validateOrder() {
        $validate = new OrderTemp();
        $checks = $validate->orderChecks();

        return Response::json($checks);
    }

    public function insertOrder(Request $request){
        
        $noInv = $request->no_invoice;
        $idJasa = $request->id_jasa;
        $idPelanggan = $request->id_pelanggan;
        $jumlahKg = $request->jumlah;
        $sisaKg = $request->sisa_kg;
        $subtotal = $request->subtotal;
        
        $orders = DB::select( DB::raw("SELECT * FROM tb_order_temp WHERE id_jasa = :jasaId AND id_pelanggan = :pelangganId"), array(
            'jasaId' => $idJasa,
            'pelangganId' => $idPelanggan,
        ));   

        foreach($orders as $rowOrders){
        }

        if ($orders){
            OrderTemp::where('id_jasa',$idJasa)->update(array(
                'jumlah'=>$jumlahKg + $rowOrders->jumlah,
                'subtotal'=>$subtotal + $rowOrders->subtotal,
            ));
        }else{
            OrderTemp::create([
                'no_invoice' => $noInv,
                'id_jasa' => $idJasa,
                'nama_jasa' => $request->nama_jasa,
                'id_pelanggan' => $idPelanggan,
                'satuan' => $request->satuan,
                'harga' => $request->harga,
                'jumlah' => $jumlahKg,
                'subtotal' => $subtotal,
            ]);
        }

        return response()->json([
            'no_invoice' => $request->no_invoice,
            'id_jasa' => $request->id_jasa,
            'nama_jasa' => $request->nama_jasa,
            'id_pelanggan' => $request->id_pelanggan,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,
            'subtotal' => $request->subtotal,
        ]);
    }

    public function deleteOrder($id){        
        OrderTemp::where('id_temp',$id)->delete();
        return redirect()->route('order.index');
    }

    public function createInvoice(Request $request){
        $ordertemp = DB::table('tb_order_temp')
                    ->select('*')
                    ->get();
        
        $jmlPaket = DB::table('tb_order_temp')->count('id_jasa');
        $totalHarga = DB::table('tb_order_temp')->sum('subtotal');

        foreach($ordertemp as $listOrder){
            $allOrders[] =[
                'no_invoice' => $listOrder->no_invoice,
                'id_jasa' => $listOrder->id_jasa,
                'id_pelanggan' => $listOrder->id_pelanggan,
                'satuan' => $listOrder->satuan,
                'harga' => $listOrder->harga,
                'jumlah' => $listOrder->jumlah,
                'subtotal' => $listOrder->subtotal,
                'created_at' => $listOrder->created_at
            ];
        }
        OrderDetail::insert($allOrders);

        $noInvoice = $request->no_invoice;
        $date = $request->tgl_selesai;
        $tgl_selesai = Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');
        $idPelanggans = $request->id_pelanggan;

        $order = New Order();
        $order->id = $noInvoice;
        $order->tgl_masuk = $request->tgl_masuk;
        $order->tgl_selesai = $tgl_selesai;
        $order->jam_masuk = $request->jam_masuk;
        $order->jam_selesai = $request->jam_selesai;
        $order->jml_paket = $jmlPaket;
        $order->total_harga = $totalHarga;
        $order->id_pewangi = $request->id_pewangi;
        $order->id_pelanggan = $idPelanggans;
        $order->id_petugas = Auth::user()->id;
        $order->status_cucian = 'Diproses';
        $order->save();

        $check = new Member();
        $trueMember = $check->memberChecks($idPelanggans);

        $saldoMember = new OrderTemp();
        $lunasMember = $saldoMember->autopayMember();
        $tagihanMember = $saldoMember->creditMember();
        $utangMember = $saldoMember->notpaidMember($lunasMember,$tagihanMember);

        $transaksi = New TransaksiKasir();
        if($trueMember)
        {
            $transaksi->utang = $utangMember;
            $transaksi->bayar = $lunasMember;
            if($utangMember >= 0){
                $transaksi->status = 'BELUM LUNAS';
            }
            else{
                $transaksi->status = 'LUNAS';
            }
        }
        else
        {
            $transaksi->status = 'BELUM LUNAS';
            $transaksi->utang = 0;
            $transaksi->bayar = 0 ;
        }
        $transaksi->no_invoice = $noInvoice;
        $transaksi->id_petugas = Auth::user()->id;
        $transaksi->total_trx = $totalHarga;
        $transaksi->kembalian = 0;
        $transaksi->save();

        OrderTemp::query()->truncate();


        return redirect()->route('transaksi.invoice',$noInvoice);

    }

    public function checkMember($id) {
        $member = Member::select( 'id', 'id_pelanggan','total_saldo','total_kg')
                        ->where('id_pelanggan',$id)
                        ->get();  
        return Response::json($member);
    }

    public function sisaMember($id,$paket) {
        $memberInfo = MemberDetail::select( 'id_member','id_jasa', 'id_pelanggan','subtotal_saldo','subtotal_kg')
                            ->where('id_pelanggan',$id)
                            ->where('id_jasa',$paket)
                            ->get();  
        return Response::json($memberInfo);
    }

    public function getOrderData(Request $request){
        if ($request->ajax()) {
            $data = OrderTemp::select('id_temp','nama_jasa','jumlah','harga','subtotal')->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = "<button class='btn btn-danger btn-delete' data-remote='/kasir/delete_order/{$row->id_temp}'>X</button>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
