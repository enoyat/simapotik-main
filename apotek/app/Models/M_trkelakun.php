<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_trkelakun extends Model
{
    use HasFactory;
    protected $table = 'trkelakun';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
   protected $primaryKey = 'kdtrkelakun';
    public $incrementing = false;
   public $timestamps = false;
    
    protected $fillable = [
			'kdtrkelakun',
            'kdkelakun',
			'kdakun'
    ];    
    public function get_kelakun(){
        return $this->belongsTo('App\\Models\\M_kelakun', 'kdkelakun');
    }

    public function get_akun(){
        return $this->belongsTo('App\\Models\\M_akun', 'kdakun');
    }
}
