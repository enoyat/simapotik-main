<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_logva extends Model
{
    use HasFactory;
    protected $table = 'logva';
        protected $fillable = [
            'kdregister',
            'log',
            'init_sig'
    ];
}
