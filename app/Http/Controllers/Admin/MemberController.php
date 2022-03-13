<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Member;
use App\Models\Admin\MemberDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:ROLE_ADMIN');
    }

    public function index(){
        $members = DB::table('tb_member')
                    ->select('tb_member.id','tb_pelanggan.nama','tb_member.status_member','tb_member.total_saldo', 'tb_member.total_kg')
                    ->selectRaw('(SELECT COUNT(*) FROM tb_member_detail WHERE tb_member_detail.id_member = tb_member.id) AS total_paket')
                    ->join('tb_pelanggan', 'tb_member.id_pelanggan', '=', 'tb_pelanggan.id_pelanggan')
                    ->get(); 

        return view('admin.member.member',compact('members')) 
                                        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function addMember(){
        $pelanggans = DB::table('tb_pelanggan')
                        ->select('*')
                        ->whereRaw('id_pelanggan NOT IN (SELECT id_pelanggan FROM tb_member)')
                        ->get(); 
        $prefix = 'MBR-';
        $idMember = IdGenerator::generate(['table' => 'tb_member', 'length' =>8, 'prefix' =>$prefix]);
                        

        return view('admin.member.create',compact('pelanggans','idMember'));
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
       
        return redirect()->route('members.detail',$idMember)
                        ->with('success','berhasil didaftarkan jadi member. Silahkan tambahkan paket untuk member ini. Jika tidak ingin sekarang ');   
    }

    public function detailMember($id){
        $membersInfo = DB::table('tb_member')
                    ->select('tb_member.id','tb_pelanggan.nama','tb_member.status_member','tb_member.total_saldo', 'tb_member.total_kg')
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
        
        return view('admin.member.detail',compact('membersInfo','membersDetail','jasa'));
    }

    public function updateMember(Request $request){
        $detail = New MemberDetail();
        $bayarSubtotal = $request->subtotal;
        $jumlahKg = $request->jumlah;
        $memberId = $request->id_member;

        $detail->id_member = $memberId;
        $detail->id_jasa = $request->id_jasa;
        $detail->subtotal_kg =  $jumlahKg;
        $detail->subtotal_saldo =  $bayarSubtotal;
        $detail->save();

        return redirect()->back()->with('info','Paket berhasil ditambahkan');
    }

    public function delPaket($id){
        MemberDetail::where('id',$id)->delete();

        return redirect()->back()->with('info','Paket berhasil dihapus');
    }
}
