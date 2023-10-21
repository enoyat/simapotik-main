<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_subtransaksi extends Model
{
    use HasFactory;
    protected $table = 'subtransaksi';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
   protected $primaryKey = 'kdsubtransaksi';
    public $incrementing = false;
    
    protected $fillable = [
			'kdsubtransaksi',
            'kdpst',            
            'kdtransaksi',
			'namasubtransaksi',
			'kdakun_d',
			'kdakun_k',
    ];    
     public function get_akundebet(){
        return $this->belongsTo('App\\Models\\M_akun', 'kdakun_d');
    }
    public function get_akunkredit(){
        return $this->belongsTo('App\\Models\\M_akun', 'kdakun_k');
    }
}
