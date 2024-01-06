<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_datadokumen extends Model
{
    use HasFactory;
    protected $table = 'datadokumen';
    protected $primaryKey = 'iddokumen';
    protected $fillable = [
			'iddokumen',
			'kdregister',
			'kddokumen',
			'filedokumen'
    ];
	public function get_dokumen(){
        return $this->belongsTo('App\\Models\\M_dokumen', 'kddokumen');
    }

}
