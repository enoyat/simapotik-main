<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_berkas extends Model
{
    use HasFactory;
    protected $table = 'mstberkas';
    protected $primaryKey = 'kdberkas';
}
