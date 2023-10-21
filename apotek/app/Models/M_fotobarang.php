<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_fotobarang extends Model
{

    use HasFactory;
    protected $table = 'fotobarang';
	public $timestamps = false;
    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'kdfoto';

    protected $fillable = [
			'kdfoto',
			'foto',
			'kdbarang'
    ];
}
