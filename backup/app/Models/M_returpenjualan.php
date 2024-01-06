<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_returpenjualan extends Model
{

    use HasFactory;
    protected $table = 'returpenjualan';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;
    public function get_penjualan()
    {
        return $this->belongsTo(M_penjualan::class, 'idpenjualan', 'id');
    }
    public function get_returdetailpenjualan() {
        return $this->hasMany(M_returdetailpenjualan::class, 'id', 'idretur');
    }

}
