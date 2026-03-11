<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_hspembelian extends Model
{

    use HasFactory;
    protected $table = 'hspembelian';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat

    protected $primaryKey = 'idhspembelian';
    protected $keyType    = 'string';
    protected $guarded    = [];
    public $timestamps    = false;
    public function get_detailpembelian()
    {
        return $this->hasMany(M_hsdetailpembelian::class, 'idhspembelian', 'idhspembelian');
    }
    public function get_supplier()
    {
        return $this->belongsTo(M_supplier::class, 'idsupplier', 'idsupplier');
    }

}
