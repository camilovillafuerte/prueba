<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipo_convenios extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id','nombre_tc','descripcion_tc','id_convenios','id_convenios_especificos'];

    //Relacion de uno a muchos inversa
public function convenios(){
    return $this->hasMany('App\Models\convenios');
}
}
