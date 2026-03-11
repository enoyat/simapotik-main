<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_akun extends Model
{
    use HasFactory;
    protected $table = 'akun';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'kdakun';
    public $incrementing = false;
    
    protected $fillable = [
			'kdakun',
            'kdpst',            
			'kdmsakun',
            'kdktgakun',
			'namaakun',
			'typeakun',
			'saldo',
			'posisi',
            'f_bb',
            'f_neraca',
            'f_lr',
            'f_lk'
    ];    
    public function get_msakun(){
        return $this->belongsTo('App\\Models\\M_msakun', 'kdmsakun');
    }
    public function get_ktgakun(){
        return $this->belongsTo('App\\Models\\M_ktgakun', 'kdktgakun');
    }
}
