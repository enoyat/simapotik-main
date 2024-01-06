<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_detailresep extends Model
{

    use HasFactory;
    protected $table = 'detailresep';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;
    public function get_penjualan()
    {
        return $this->belongsTo(M_penjualan::class, 'idpenjualan', 'id');
    }
    public function get_jenispasien()
    {
        return $this->belongsTo(M_jenispasien::class, 'idjenispasien', 'idjenispasien');
    }
    public function get_poly()
    {
        return $this->belongsTo(M_poly::class, 'idpoly', 'idpoly');
    }
    public function get_dokter()
    {
        return $this->belongsTo(M_dokter::class, 'iddokter', 'iddokter');
    }

}
