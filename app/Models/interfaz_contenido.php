<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class interfaz_contenido extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id','id_interfaz','nombre','descripcion','urlimagen'];

}
