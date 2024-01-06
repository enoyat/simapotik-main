<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mspst extends Model
{
    use HasFactory;
    protected $table = 'mspst';
    protected $primaryKey = 'kdpst';
    protected $guarded = [];

}
