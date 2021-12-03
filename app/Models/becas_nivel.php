<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class becas_nivel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id','nombre','tipo','estado','fecha_creacion'];
}
