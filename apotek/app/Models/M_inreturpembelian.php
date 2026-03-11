<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_inreturpembelian extends Model
{

    use HasFactory;
    protected $table = 'inreturpembelian';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;
    public function get_pembelian()
    {
        return $this->belongsTo(M_pembelian::class, 'idpembelian', 'id');
    }
    public function get_retur() {
        return $this->belongsTo(M_returpembelian::class, 'idretur','id' );
    }

}
