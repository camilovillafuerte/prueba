<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class convenios extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id','cedula_usuario','titulo_convenio','f_creaciondoc','estado','tipo_documento','PDF'];


    //Relacion de uno a muchos
public function tipo_convenios(){
    return $this->hasMany('App\Models\tipo_convenios','id_convenios');
}

//Relacion de uno a muchos
public function usuarios(){
    return $this->hasMany('App\Models\usuarios','cedula');
}

//Relación muchos a muchos
public function convenios_clausulas(){
    return $this -> belongsToMany('App\Models\convenios_clausulas');
}
}