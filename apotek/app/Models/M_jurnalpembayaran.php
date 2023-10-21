<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_jurnalpembayaran extends Model
{
    use HasFactory;
    protected $table = 'jurnalpembayaran';
    protected $primaryKey = 'nobayar';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
			'nobayar',
            'kdpst',            
			'notagihan',
            'kdtransaksi',
            'tgltrans',
            'kdregister',
            'debet',
            'kredit',
            'keterangan',
            'jumlah',
            'f_lunas',
            'f_post',
            'va',
            'userid'
    ];
    public function get_registrasi(){
        return $this->belongsTo('App\\Models\\M_registrasi', 'kdregister');
    }

    public function get_jurnaltagihan(){
        return $this->belongsTo('App\\Models\\M_jurnaltagihan', 'notagihan');
    }
}

