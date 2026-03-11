<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_hsdetailmutasi extends Model
{

    use HasFactory;
    protected $table = 'hsdetailmutasi';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'idhsdetailmutasi';
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $guarded    = [];
    public $timestamps    = false;

    public function get_barang()
    {
        return $this->belongsTo(M_barang::class, 'kdbarang', 'kdbarang');
    }
    public function get_mutasi()
    {
        return $this->belongsTo(M_hsmutasi::class, 'idhsmutasi', 'idhsmutasi');
    }

}
