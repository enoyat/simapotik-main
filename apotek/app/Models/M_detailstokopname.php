<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_detailstokopname extends Model
{

    use HasFactory;
    protected $table = 'detailstokopname';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'id';
    public $incrementing  = true;
    public $timestamps    = false;

    protected $guarded = [];
    public function get_barang()
    {
        return $this->belongsTo('App\\Models\\M_barang', 'kdbarang');
    }
    public function get_lokasi()
    {
        return $this->belongsTo('App\\Models\\M_stoklokasi', 'idlokasi');
    }

}
