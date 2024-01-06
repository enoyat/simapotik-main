<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_jurnalwdu extends Model
{
    use HasFactory;
    protected $table = 'jurnalwdu';
    protected $primaryKey = 'id';

    // In Laravel 6.0+ make sure to also set $keyType
    protected $fillable = [
			'kdregister',
            'spi',
            'spp',
            'poliklinik',
            'prodikem',
            'lab',
            'sks',
            'wdu',
            'f_bayar',
            'f_lunas'
    ];
    public function get_register(){
        return $this->belongsTo('App\\Models\\M_registrasi', 'kdregister');
    }

}

