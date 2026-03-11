<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_logcallback extends Model
{
    use HasFactory;
    protected $table = 'logcallback';
        protected $fillable = [
            'kdregister',
            'log',
            'va',
            'tgl'
    ];
}
