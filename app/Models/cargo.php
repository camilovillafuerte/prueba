<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cargo extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['cargos_id','cargo','estado'];
    public $table = "cargos";


    /*//Relación muchos a muchos
    public function cargo_usuario(){
        return $this -> belongsToMany('App\Models\Usuario','cargos_id');
    }*/

    public function Cargos()
    {
        return $this->hasMany('App\Models\Usuario','cargos_id');
    }
}
