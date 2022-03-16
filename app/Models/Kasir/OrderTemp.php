<?php

namespace App\Models\Kasir;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
