<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model{

    use HasFactory;

    public $table = "usuarios";
    public $timestamps = false;

    protected $filleable = ["cedula", "nombres", "apellidos", "telefono", "correo", "contrasena","foto", "estado"];
    protected $hidden = ["contrasena"];
}
