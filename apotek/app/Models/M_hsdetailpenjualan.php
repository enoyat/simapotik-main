<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_hsdetailpenjualan extends Model
{

    use HasFactory;
    protected $table = 'hsdetailpenjualan';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'idhsdetailpenjualan';
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $guarded    = [];
    public $timestamps    = false;
    public function get_penjualan()
    {
        return $this->belongsTo(M_hspenjualan::class, 'idhspenjualan', 'idhspenjualan');
    }
    public function get_barang()
    {
        return $this->belongsTo(M_barang::class, 'kdbarang', 'kdbarang');
    }

}
