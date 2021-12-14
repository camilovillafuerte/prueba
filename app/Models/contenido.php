<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contenido extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id','des_cont','tipo'];


    //Relación muchos a muchos
    public function convenios_clasulas(){
        return $this -> belongsToMany('App\Models\convenios_clausulas');
    }
}
