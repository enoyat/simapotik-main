<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_mstagihan extends Model
{
    use HasFactory;
    protected $table = 'mstagihan';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
   protected $primaryKey = 'kdtagihan';
    public $timestamps = false;
    
    protected $fillable = [
			'kdtagihan',
            'kdpst',            
			'namatagihan',
			'kdtransaksi',
            'kdtransaksilawan',
			'jumlah',
            'modebayar'
    ];    
    public function get_transaksi(){
        return $this->belongsTo('App\\Models\\M_mstransaksi', 'kdtransaksi');
    }
    public function get_transaksilawan(){
        return $this->belongsTo('App\\Models\\M_mstransaksi', 'kdtransaksilawan');
    }

}
