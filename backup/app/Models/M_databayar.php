<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_databayar extends Model
{
    use HasFactory;
    protected $table = 'databayar';
    protected $primaryKey = 'kdbayar';
    public $incrementing = false;

    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';
    // In Laravel 6.0+ make sure to also set $keyType
    protected $fillable = [
            'kdbayar',
            'kdpst',            
            'tgltrans',			
            'nim',
            'jumlah',
            'va',
            'modebayar',
            'f_bayar',
            'f_status'
    ];

    public function get_mahasiswa(){
        return $this->belongsTo('App\\Models\\M_mahasiswa', 'nim');
    }
}

