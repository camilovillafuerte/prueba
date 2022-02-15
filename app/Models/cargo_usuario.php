<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cargo_usuario extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['fusuarios_id','usuario_id','cargos_id'];


    //Relación muchos a muchos
    public function usuarios(){
        return $this -> belongsToMany('App\Models\usuarios');
    }
    public function cargo(){
        return $this -> belongsToMany('App\Models\cargo');
    }

}
