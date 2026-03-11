<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_toko extends Model
{
    use HasFactory;
    protected $table = 'toko';
    protected $primaryKey = 'toko';
    public $incrementing = false;
    protected $guarded = [];
}
