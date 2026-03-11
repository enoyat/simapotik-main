<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_ktgtransaksi extends Model
{
    use HasFactory;
    protected $table = 'ktgtransaksi';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'kdktgtransaksi';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
			'kdktgtransaksi',
			'namaktgtransaksi'
    ];    
}
