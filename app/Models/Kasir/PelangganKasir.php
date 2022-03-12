<?php

namespace App\Models\Kasir;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelangganKasir extends Model
{
    use HasFactory;

    protected $table = 'tb_pelanggan';
    protected $primaryKey = 'id_pelanggan';
    protected $keyType = 'string';
    protected $fillable = [
        'nama',
        'telepon',
        'alamat'
    ];
}
