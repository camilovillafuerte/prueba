<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usuarios extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['cedula','nombres','apellidos','telefono','correo','contrasena','foto','estado'];


    //Relacion de uno a muchos
public function convenios(){
    return $this->hasMany('App\Models\convenios','cedula_usuario','cedula');
}

//Relación muchos a muchos
public function funcionalidad_usuario(){
    return $this -> belongsToMany('App\Models\funcionalidad_usuario','cedula');
}

//Relación muchos a muchos
public function cargo_usuario(){
    return $this -> belongsToMany('App\Models\cargo_usuario','cedula');
}
}
