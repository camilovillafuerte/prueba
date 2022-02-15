<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class becas_nivel extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','usuario_id','nombre','tipo','estado','fecha_creacion'];


      //Relacion de uno a muchos
public function becas_nivel_body(){
    return $this->hasMany('App\Models\becas_nivel_body','id_becas_nivels');
}
//Relacion de uno a muchos
public function usuarios(){
    return $this->hasMany('App\Models\usuarios','usuario_id');
}
}
