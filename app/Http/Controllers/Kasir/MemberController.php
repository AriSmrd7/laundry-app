<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Kasir\Member;
use App\Models\Kasir\MemberDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:ROLE_KASIR');
    }

    public function index(){
        $members = DB::table('tb_member')
                    ->select('tb_member.id','tb_pelanggan.nama','tb_member.status_member','tb_member.total_saldo', 'tb_member.total_kg')
                    ->selectRaw('(SELECT COUNT(*) FROM tb_member_detail WHERE tb_member_detail.id_member = tb_member.id) AS total_paket')
                    ->join('tb_pelanggan', 'tb_member.id_pelanggan', '=', 'tb_pelanggan.id_pelanggan')
                    ->paginate(5);

        return view('kasir.member.member',compact('members')) 
                                        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function addMember(){
        $pelanggans = DB::table('tb_pelanggan')
                        ->select('*')
                        ->whereRaw('id_pelanggan NOT IN (SELECT id_pelanggan FROM tb_member)')
                        ->get(); 
        $prefix = 'MBR-';
        $idMember = IdGenerator::generate(['table' => 'tb_member', 'length' =>8, 'prefix' =>$prefix]);
                        

        return view('kasir.member.create',compact('pelanggans','idMember'));
    }

    public function storeMember(Request $request){

        $idMember = $request->id;
        $member = new Member();
        $member->id = $request->id;
        $member->id_pelanggan = $request->id_pelanggan;
        $member->status_member = 'Y';
        $member->total_saldo = 0;
        $member->total_kg = 0;
        $member->save();
       
        return redirect()->route('members-kasir.detail',$idMember)
                        ->with('success','berhasil didaftarkan jadi member. Silahkan tambahkan paket untuk member ini. Jika tidak ingin sekarang ');   
    }

    public function detailMember($id){
        $membersInfo = DB::table('tb_member')
                    ->select('tb_member.id','tb_pelanggan.nama','tb_member.id_pelanggan','tb_member.status_member','tb_member.total_saldo', 'tb_member.total_kg')
                    ->selectRaw('(SELECT COUNT(*) FROM tb_member_detail WHERE tb_member_detail.id_member = tb_member.id) AS total_paket')
                    ->join('tb_pelanggan', 'tb_member.id_pelanggan', '=', 'tb_pelanggan.id_pelanggan')
                    ->where('tb_member.id','=',$id)
                    ->get(); 
        $membersDetail =DB::table('tb_member_detail')
                    ->select('*')
                    ->join('tb_jasa', 'tb_member_detail.id_jasa', '=', 'tb_jasa.id_jasa')
                    ->where('tb_member_detail.id_member','=',$id)
                    ->get();   
        $jasa =DB::table('tb_jasa')
                    ->select('*')
                    ->get(); 
        
        return view('kasir.member.detail',compact('membersInfo','membersDetail','jasa'));
    }

    public function updateMember(Request $request){

        $bayarSubtotal = $request->subtotal;
        $jumlahKg = $request->jumlah;
        $memberId = $request->id_member;
        $id_pelanggan = $request->id_pelanggan;
        $jasaId = $request->id_jasa;

        $pakets = DB::select( DB::raw("SELECT * FROM tb_member_detail WHERE id_jasa = :jasaId AND id_member = :memberId"), array(
            'jasaId' => $jasaId,
            'memberId' => $memberId,
        ));        
        foreach($pakets as $rowPakets){

        }
        
        if ($pakets){
            MemberDetail::where('id_jasa',$jasaId)->update(array(
                'subtotal_kg'=>$jumlahKg + $rowPakets->subtotal_kg,
                'subtotal_saldo'=>$bayarSubtotal + $rowPakets->subtotal_saldo,
            ));
        }
        else{
            $detail = New MemberDetail();
            $detail->id_member = $memberId;
            $detail->id_jasa = $jasaId;
            $detail->id_pelanggan = $id_pelanggan;
            $detail->subtotal_kg =  $jumlahKg;
            $detail->subtotal_saldo =  $bayarSubtotal;
            $detail->save();
        }
        return redirect()->route('members-kasir.detail',$memberId)->with('info','Paket berhasil ditambahkan');
    }

    public function delPaket($id){
        MemberDetail::where('id',$id)->delete();

        return redirect()->back()->with('info','Paket berhasil dihapus');
    }

    public function delMember($id){
        Member::where('id',$id)->delete();
        MemberDetail::where('id_member',$id)->delete();

        return redirect()->route('members-kasir.index');
    }
}
