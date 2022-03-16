<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberDetail extends Model
{
    use HasFactory;

    public $table = 'tb_member_detail';
    public $primaryKey = NULL;
    public $incrementing = FALSE;
    public $keyType = 'string';
    public $fillable = [
        'id_member',
        'id_jasa',
        'id_pelanggan',
        'subtotal_kg',
        'subtotal_saldo',
    ];
}
