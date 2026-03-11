<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_kelakun extends Model
{
    use HasFactory;
    protected $table = 'kelakun';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'kdkelakun';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
			'kdkelakun',
			'nmkelakun'
    ];    
}
