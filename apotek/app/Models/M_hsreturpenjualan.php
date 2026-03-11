<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_hsreturpenjualan extends Model
{

    use HasFactory;
    protected $table = 'hsreturpenjualan';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'idhsretur';
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $guarded    = [];
    public $timestamps    = false;
    public function get_penjualan()
    {
        return $this->belongsTo(M_hspenjualan::class, 'idhspenjualan', 'idhspenjualan');
    }
    public function get_returdetailpenjualan()
    {
        return $this->hasMany(M_hsreturdetailpenjualan::class, 'idhsreturpenjualan', 'idhsreturpenjualan');
    }

}
