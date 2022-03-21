<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Laporan extends Model
{
    use HasFactory;
    
    protected $table = 'view_laporan_order_selesai';
    protected $primaryKey = null;
    protected $fillable = [
        'no_invoice',
        'nama',
        'jml_paket',
        'total_trx',
        'bayar',
        'kembalian',
        'jam_masuk',
        'tgl_masuk',
        'jam_selesai',
        'tgl_selesai',
        'name',
    ];

}
