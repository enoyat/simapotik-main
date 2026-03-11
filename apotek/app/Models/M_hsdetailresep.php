<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_hsdetailresep extends Model
{

    use HasFactory;
    protected $table = 'hsdetailresep';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'idhdetailresep';
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $guarded    = [];
    public $timestamps    = false;
    public function get_penjualan()
    {
        return $this->belongsTo(M_hspenjualan::class, 'idhspenjualan', 'idhspenjualan');
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
