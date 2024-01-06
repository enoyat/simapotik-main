<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_returdetailpenjualan extends Model
{

    use HasFactory;
    protected $table = 'returdetailpenjualan';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;
    public function get_retur()
    {
        return $this->belongsTo(M_returpenjualan::class, 'idretur', 'id');
    }
    public function get_barang()
    {
        return $this->belongsTo(M_barang::class, 'kdbarang', 'kdbarang');
    }
    public function get_detailpenjualan()
    {
        return $this->belongsTo(M_detailpenjualan::class, 'iddetailpenjualan', 'id');
    }


}
