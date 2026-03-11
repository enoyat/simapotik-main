<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_hspenjualan extends Model
{

    use HasFactory;
    protected $table = 'hspenjualan';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'idhspenjualan';
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $guarded    = [];
    public $timestamps    = false;
    public function get_detailpenjualan()
    {
        return $this->hasMany(M_hsdetailpenjualan::class, 'idhspenjualan', 'idhspenjualan');
    }
    public function get_customer()
    {
        return $this->belongsTo(M_customer::class, 'idcustomer', 'idcustomer');
    }
    public function get_detailresep()
    {
        return $this->hasMany(M_hsdetailresep::class, 'idhpenjualan', 'idhspenjualan');
    }

}
