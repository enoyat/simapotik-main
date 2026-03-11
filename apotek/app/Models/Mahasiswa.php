<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'mhs';
    protected $primaryKey = 'kdregister';
   // protected $keyType = 'string';
   // public $timestamps = false;
    protected $guarded = [];
    public function get_jalur(){
        return $this->belongsTo(M_jalur::class, 'kdjalur', 'kdjalur');
    }
    public function get_semester(){
        return $this->belongsTo(M_semester::class, 'thsms', 'semester');
    }
    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class, 'id_jenj_didik', 'id_jenj_didik');
    }
    public function penghasilan()
    {
        return $this->belongsTo(Penghasilan::class, 'id_penghasilan', 'id_penghasilan');
    }
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'id_wil', 'id_wil');
    }
    public function jenistinggal()
    {
        return $this->belongsTo(JenisTinggal::class, 'id_jns_tinggal', 'id_jns_tinggal');
    }
    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'id_pekerjaan', 'id_pekerjaan');
    }
    public function transportasi()
    {
        return $this->belongsTo(Transportasi::class, 'id_alat_transportasi', 'id_alat_transportasi');
    }

    public function get_prodi(){
        return $this->belongsTo('App\\Models\\Mspst', 'kdpst');
    }
    public function get_biaya(){
        return $this->belongsTo('App\\Models\\M_biaya', 'kdpst', 'kdpst');
    }
    public function get_periode(){
        return $this->belongsTo('App\\Models\\M_semester', 'thsms', 'semester');

    }
    public function get_tagihan(){
    	return $this->hasMany('App\\Models\\M_jurnaltagihan', 'kdregister');
    }


}
