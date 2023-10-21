<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_submsakun extends Model
{
    use HasFactory;
    protected $table = 'submsakun';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'kdsubmsakun';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
			'kdsubmsakun',
			'namasubmsakun',
			'kdmsakun'
    ];    
}
