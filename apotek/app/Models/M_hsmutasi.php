<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_hsmutasi extends Model
{

    use HasFactory;
    protected $table = 'hsmutasi';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'id';
    protected $guarded    = [];
    public $timestamps    = false;
    public function get_barang()
    {
        return $this->belongsTo(M_barang::class, 'idbarang', 'idbarang');
    }

    public function get_detailmutasi()
    {
        return $this->hasMany(M_hsdetailmutasi::class, 'idhsmutasi', 'id');
    }
    public function get_gudang()
    {
        return $this->belongsTo(M_stoklokasi::class, 'idlokasi', 'idlokasi');
    }
    public function get_gudangtujuan()
    {
        return $this->belongsTo(M_stoklokasi::class, 'idlokasidest', 'idlokasi');
    }

}
