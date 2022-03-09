<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pewangi extends Model
{
    use HasFactory;

    protected $table = 'tb_pewangi';
    protected $primaryKey = 'id_pewangi';
    protected $keyType = 'string';
    protected $fillable = [
        'nama_pewangi',
    ];
}
