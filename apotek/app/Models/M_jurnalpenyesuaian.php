<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_jurnalpenyesuaian extends Model
{
    use HasFactory;
    protected $table = 'jurnalpenyesuaian';
    protected $primaryKey = 'notrans';
    protected $keyType = 'string';
    // In Laravel 6.0+ make sure to also set $keyType
    protected $fillable = [
            'notrans',			
            'kdpst',            
            'kdtransaksi',
            'kdperiode',
            'tgltrans',
            'debet',
            'kredit',
            'keterangan',
            'jumlah',
            'f_post',
            'userid'
    ];

    public function get_mstransaksi(){
        return $this->belongsTo('App\\Models\\M_mstransaksi', 'kdtransaksi');
    }    
}

