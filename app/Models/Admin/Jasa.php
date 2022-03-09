<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jasa extends Model
{
    use HasFactory;
    
    protected $table = 'tb_jasa';
    protected $primaryKey = 'id_jasa';
    protected $keyType = 'string';
    protected $fillable = [
        'nama_jasa',
        'satuan_jasa',
        'harga_jasa'
    ];
}
