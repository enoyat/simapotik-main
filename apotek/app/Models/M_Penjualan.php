<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Penjualan extends Model
{

    use HasFactory;
    protected $table = 'penjualan';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;
    public function get_detailpenjualan()
    {
        return $this->hasMany(M_detailpenjualan::class, 'idpenjualan', 'id');
    }
    public function get_customer()
    {
        return $this->belongsTo(M_customer::class, 'idcustomer', 'idcustomer');
    }
    public function get_detailresep() {
        return $this->hasMany(M_detailresep::class, 'idpenjualan', 'id');
    }


}
