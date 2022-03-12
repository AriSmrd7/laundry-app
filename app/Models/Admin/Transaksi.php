<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'tb_transaksi';
    protected $primaryKey = 'id_transaksi ';
    protected $keyType = 'string';
    protected $fillable = [
        'no_invoice',
        'id_petugas',
        'total_trx',
        'bayar',
        'kembalian',
        'status',
    ];
}
