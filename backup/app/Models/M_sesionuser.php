<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_sesionuser extends Model
{

    use HasFactory;
    protected $table = 'sesionuser';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = [];
}
