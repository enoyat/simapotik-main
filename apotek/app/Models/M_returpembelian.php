<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_returpembelian extends Model
{

    use HasFactory;
    protected $table = 'returpembelian';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;
    public function get_pembelian()
    {
        return $this->belongsTo(M_pembelian::class, 'idpembelian', 'id');
    }
    public function get_returdetailpembelian() {
        return $this->hasMany(M_returdetailpembelian::class, 'id', 'idretur');
    }

}
