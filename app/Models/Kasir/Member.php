<?php

namespace App\Models\Kasir;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    use HasFactory;

    protected $table = 'tb_member';
    protected $keyType = 'string';
    protected $fillable = [
        'id_pelanggan',
        'status_member',
        'total_saldo',
        'total_kg',
    ];

    public function memberChecks($id){
        $member = Member::select('id_pelanggan')
                                ->where('id_pelanggan',$id)
                                ->exists();
        return $member;
    }

    
}
