<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class convenios_clausulas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id','id_convenios','id_clausulas','id_contenidos'];


    //Relación muchos a muchos
    public function convenios(){
        return $this -> belongsToMany('App\Models\convenios');
    }
    public function clausulas(){
        return $this -> belongsToMany('App\Models\clausulas');
    }
    public function contenidos(){
        return $this -> belongsToMany('App\Models\contenidos');
    }
}
