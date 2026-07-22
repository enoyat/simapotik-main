<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Pembelian extends Model
{

    use HasFactory;
    protected $table = 'pembelian';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'id';
    protected $guarded = [];
    // public $timestamps = false;
    public function get_detailpembelian()
    {
        return $this->hasMany(M_detailpembelian::class, 'idpembelian', 'id');
    }
    public function get_supplier()
    {
        return $this->belongsTo(M_supplier::class, 'idsupplier', 'idsupplier');
    }
}
