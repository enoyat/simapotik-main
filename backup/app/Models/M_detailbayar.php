<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_detailbayar extends Model
{
    use HasFactory;
    protected $table = 'detailbayar';
    protected $primaryKey = 'idbayar';
    // In Laravel 6.0+ make sure to also set $keyType
    protected $fillable = [
            'kdbayar',			
            'kdpst',            
            'nim',
            'notagihan',
            'jumlah',
            'f_aktif',
            'f_bayar'

    ];

    public function get_mahasiswa(){
        return $this->belongsTo('App\\Models\\M_mahasiswa', 'nim');
    }
 
    public function get_jurnaltagihan(){
        return $this->hasMany('App\\Models\\M_jurnaltagihan', 'notagihan');
    }
}

