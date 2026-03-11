<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_neracasaldo extends Model
{
    use HasFactory;
    protected $table = 'neracasaldo';
    protected $primaryKey = 'idneraca';
    // In Laravel 6.0+ make sure to also set $keyType
    protected $fillable = [
            'kdperiode',
            'kdpst',            
            'kdakun',			
            'debet',
            'kredit'
    ];

    public function get_akun(){
        return $this->belongsTo('App\\Models\\M_akun', 'kdakun');
    }    
}

