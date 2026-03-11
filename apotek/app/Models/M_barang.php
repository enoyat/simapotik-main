<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_barang extends Model
{

    use HasFactory;
    protected $table = 'barang';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'kdbarang';
    public $incrementing  = false;

    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';

    protected $guarded = [];
    public function get_kategori()
    {
        return $this->belongsTo('App\\Models\\M_kategori', 'kdkategori');
    }
    public function get_foto()
    {
        return $this->hasMany('App\\Models\\M_fotobarang', 'kdbarang');
    }
    public function jmlstok()
    {
        return $this->hasMany('App\\Models\\M_stok', 'kdbarang');
    }

    public function get_jenis()
    {
        return $this->belongsTo('App\\Models\\M_jenis', 'idjenis');
    }
    public function get_golongan()
    {
        return $this->belongsTo('App\\Models\\M_golongan', 'idgolongan');
    }
    public function jmlstokhistory()
    {
        return $this->hasMany(M_detailstokopname::class, 'kdbarang');
    }

}
