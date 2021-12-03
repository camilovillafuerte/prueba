<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class convenios_clausulas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id','id_convenios','id_clausulas','id_contenidos'];
}
