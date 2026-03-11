<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_lapjurnal extends Model
{
    use HasFactory;
    protected $table = 'lapjurnal';
    protected $primaryKey = 'kdlapjurnal';
    public $incrementing = false;
    public $timestamps = false;
    // In Laravel 6.0+ make sure to also set $keyType
    protected $fillable = [
            'notrans',			
            'kdpst',            
            'tgltrans',
            'kdakun',
            'possreff',
            'keterangan',
            'debet',
            'kredit'
    ];   
}

