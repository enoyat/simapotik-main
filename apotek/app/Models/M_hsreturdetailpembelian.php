<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_hsreturdetailpembelian extends Model
{

    use HasFactory;
    protected $table = 'hsreturdetailpembelian';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'idreturdetailpembelian';
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $guarded    = [];
    public $timestamps    = false;
    public function get_retur()
    {
        return $this->belongsTo(M_returpembelian::class, 'idhsretur', 'idhsretur');
    }
    public function get_barang()
    {
        return $this->belongsTo(M_barang::class, 'kdbarang', 'kdbarang');
    }
    public function get_detailpembelian()
    {
        return $this->belongsTo(M_hsdetailpembelian::class, 'idhsdetailpembelian', 'idhsdetailpembelian');
    }

}
