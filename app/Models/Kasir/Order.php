<?php

namespace App\Models\Kasir;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'tb_order';
    protected $primaryKey = 'id_order';
    protected $keyType = 'string';
    /**protected $fillable = [
        'nama',
        'telepon',
        'alamat'
    ];**/
}
