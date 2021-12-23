<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cargo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['cargos_id','cargo','estado'];


    //Relación muchos a muchos
    public function cargo_usuario(){
        return $this -> belongsToMany('App\Models\cargo_usuario','cargos_id');
    }
}
