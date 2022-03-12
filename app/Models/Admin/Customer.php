<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
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
