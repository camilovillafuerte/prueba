<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class imagenes_intefaces extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id','nombre','url_imagen','estado'];


    public $table = "imagenes_interfaces";

    public function interfaz(){
        return $this->hasMany('App\Models\interfaz_contenidos','imagen_id');
    }
    
}
