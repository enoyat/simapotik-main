<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_hsreturdetailpenjualan extends Model
{

    use HasFactory;
    protected $table = 'hsreturdetailpenjualan';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'id';
    protected $guarded    = [];
    public $timestamps    = false;
    public function get_retur()
    {
        return $this->belongsTo(M_hsreturpenjualan::class, 'idhsretur', 'idhsretur');
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
