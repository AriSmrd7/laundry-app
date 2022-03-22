<?php

namespace App\Models\Kasir;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderTemp extends Model
{
    use HasFactory;

    protected $table = 'tb_order_temp';
    protected $primaryKey = 'id_temp';
    protected $keyType = 'string';
    protected $fillable = [
        'no_invoice',
        'id_jasa',
        'nama_jasa',
        'id_pelanggan',
        'satuan',
        'harga',
        'jumlah',
        'subtotal',
    ];


    public function memberValid(){
        $temp = OrderTemp::select('tb_order_temp.no_invoice', 'tb_order_temp.id_jasa', 'tb_order_temp.nama_jasa', 'tb_order_temp.id_pelanggan', 'tb_order_temp.satuan', 'tb_order_temp.harga', 'tb_order_temp.jumlah', 'tb_order_temp.subtotal')
                        ->leftJoin('tb_member_detail', function ($join) {
                            $join->on('tb_order_temp.id_pelanggan', '=', 'tb_member_detail.id_pelanggan')
                                 ->on('tb_order_temp.id_jasa', '=','tb_member_detail.id_jasa');
                        })
                        ->whereNotNull('tb_member_detail.id_jasa')
                        ->whereNotNull('tb_member_detail.id_pelanggan')
                        ->get();
        return $temp;
    }

    public function autopayMember(){
        $temp = OrderTemp::select(DB::raw('sum(tb_order_temp.subtotal) as totallunas'))
                        ->leftJoin('tb_member_detail', function ($join) {
                            $join->on('tb_order_temp.id_pelanggan', '=', 'tb_member_detail.id_pelanggan')
                                 ->on('tb_order_temp.id_jasa', '=','tb_member_detail.id_jasa');
                        })
                        ->whereNotNull('tb_member_detail.id_jasa')
                        ->whereNotNull('tb_member_detail.id_pelanggan')
                        ->first();
        return $temp->totallunas;
    }

    public function creditMember(){
        $temp = OrderTemp::select(DB::raw('sum(tb_order_temp.subtotal) as totaltagihan'))
                          ->first();
        return $temp->totaltagihan;
    }

    public function notpaidMember($bayarMember, $tagihanMember){
        $temp = $tagihanMember - $bayarMember;
        return $temp;
    }

    
    public function orderChecks(){
        $check = OrderTemp::select('*')->exists();
        return $check;
    }

    public function memberChecks($idPelanggan){
        $check = MemberDetail::select('*')
                ->where('tb_member_detail.id_pelanggan','=',$idPelanggan)
                ->exists();
        return $check;
    }

    public function checkSaldo($idPelanggan, $idJasa){
        $temp = MemberDetail::select(DB::raw('tb_member_detail.subtotal_kg as sisakg'))
                        ->where('tb_member_detail.id_jasa','=',$idJasa)
                        ->where('tb_member_detail.id_pelanggan','=',$idPelanggan)
                        ->first();    
        return $temp->sisakg;
    }

}
