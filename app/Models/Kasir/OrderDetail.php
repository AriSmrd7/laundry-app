<?php

namespace App\Models\Kasir;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    public $table = 'tb_order_detail';
    public $primaryKey = NULL;
    public $incrementing = FALSE;
    public $keyType = 'string';
    public $fillable = [
        'no_invoice',
        'id_jasa',
        'satuan',
        'harga',
        'jumlah',
        'subtotal',
    ];
}
