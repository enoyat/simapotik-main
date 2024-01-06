<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_jurnaltagihan extends Model
{
    use HasFactory;
    protected $table = 'jurnaltagihan';
    protected $primaryKey = 'notagihan';
    protected $keyType = 'string';
    // In Laravel 6.0+ make sure to also set $keyType
    protected $fillable = [
            'notagihan',			
            'kdpst',            
            'kdtagihan',
            'kdtransaksi',
            'kdtransaksilawan',
            'tgltrans',
            'nim',
            'debet',
            'kredit',
            'keterangan',
            'jumlah',
            'bayar',
            'sisa',
            'f_lunas',
            'f_aktif',
            'f_post',
            'userid',
            'grptagihan',
            'kdbulan',
            'kdtahun',
            'modebayar'
    ];

    public function get_mahasiswa(){
        return $this->belongsTo('App\\Models\\M_mahasiswa', 'nim');
    }
    public function get_mstransaksi(){
        return $this->belongsTo('App\\Models\\M_mstransaksi', 'kdtransaksi');
    }    
    public function get_mstagihan(){
        return $this->belongsTo('App\\Models\\M_mstagihan', 'kdtagihan');
    }
    public function get_jurnalpembayaran(){
        return $this->hasMany('App\\Models\\M_jurnalpembayaran', 'notagihan');
    }
}

