<?php

namespace App\Models\Kasir;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiKasir extends Model
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
        'utang',
        'kembalian',
        'status',
    ];
}
