<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class funcionalidad_usuario extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['cargou_id','cedula','funcion_id'];


    //Relación muchos a muchos
    public function usuarios(){
        return $this -> belongsToMany('App\Models\usuarios','cedula');
    }
    public function funcionalidad(){
        return $this -> belongsToMany('App\Models\funcionalidad','funcion_id');
    }
   
}
