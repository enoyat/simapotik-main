<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_ktgakun extends Model
{
    use HasFactory;
    protected $table = 'ktgakun';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'kdktgakun';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
			'kdktgakun',
			'namaktgakun'
    ];    
}
