<?php

namespace App\Models\Kasir;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'tb_order';
    protected $keyType = 'string';
    protected $fillable = [
        'tgl_masuk',
        'tgl_selesai',
        'jml_paket',
        'total_harga',
        'id_pewangi',
        'id_pelanggan',
        'id_petugas',
        'status_cucian',
    ];
}
