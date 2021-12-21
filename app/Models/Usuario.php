<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $filleable = ['cedula','nombres','apellidos','genero','telefono','correo','contrasena','foto','estado'];
    protected $hidden = ["contrasena"];

    //Relacion de uno a muchos
    public function convenios(){
        return $this->hasMany(convenios::class,'usuario_id');
    }

    //Relación muchos a muchos
    public function funcionalidad_usuario(){
        return $this ->belongsToMany(funcionalidad_usuario::class,'usuario_id');
    }

    //Relación muchos a muchos
    public function cargo_usuario(){
        return $this -> belongsToMany(cargo_usuario::class,'usuario_id');
    }
}
