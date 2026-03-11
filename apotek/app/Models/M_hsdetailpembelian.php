<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_hsdetailpembelian extends Model
{

    use HasFactory;
    protected $table = 'hsdetailpembelian';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'idhsdetailpembelian';
    protected $keyType    = 'string';
    protected $guarded    = [];
    public $timestamps    = false;
    public function get_pembelian()
    {
        return $this->belongsTo(M_pembelian::class, 'idhspembelian', 'idhspembelian');
    }
    public function get_barang()
    {
        return $this->belongsTo(M_barang::class, 'kdbarang', 'kdbarang');
    }

}
