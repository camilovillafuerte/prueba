<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class personal extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $filleable = ['id','cedula','apellido1','apellido2','nombres','correo_personal_institucional'];

    //Relacion de uno a muchos
    public function usuarios(){
    return $this->hasMany(Usuario::class,'personal_id');
}


}
