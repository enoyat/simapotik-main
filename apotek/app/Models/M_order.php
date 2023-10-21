<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_order extends Model
{

    use HasFactory;
    protected $table = 'tborder';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;
    public function get_detailorder()
    {
        return $this->hasMany(M_detailorder::class, 'id', 'idorder');
    }
    public function get_supplier()
    {
        return $this->belongsTo(M_supplier::class, 'idsupplier', 'idsupplier');
    }


}
