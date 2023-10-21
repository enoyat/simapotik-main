<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_databerkas extends Model
{
    use HasFactory;
    protected $table = 'databerkas';
    protected $primaryKey = 'idberkas';
    protected $fillable = [
			'idberkas',
			'kdregister',
			'kdberkas',
			'fileberkas'
    ];
	public function get_berkas(){
        return $this->belongsTo('App\\Models\\M_berkas', 'kdberkas');
    }
}
