<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_mstransaksi extends Model
{
    use HasFactory;
    protected $table = 'mstransaksi';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
   protected $primaryKey = 'kdtransaksi';
    public $incrementing = false;
    
    protected $fillable = [
			'kdtransaksi',
            'kdpst',            
			'namatransaksi',
			'kdakun_d',
			'kdakun_k',
			'kdktgtransaksi'
    ];    
    public function get_akundebet(){
        return $this->belongsTo('App\\Models\\M_akun', 'kdakun_d');
    }
    public function get_akunkredit(){
        return $this->belongsTo('App\\Models\\M_akun', 'kdakun_k');
    }
    public function get_subtransaksi(){
        return $this->hasMany('App\\Models\\M_subtransaksi', 'kdtransaksi');
    }
    public function get_ktgtransaksi(){
        return $this->belongsTo('App\\Models\\M_ktgtransaksi', 'kdktgtransaksi');
    }

}
