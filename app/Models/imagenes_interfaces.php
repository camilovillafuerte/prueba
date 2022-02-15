<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class imagenes_interfaces extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','nombre','url_imagen','estado'];


    public $table = "imagenes_interfaces";

    public function interfaz(){
        return $this->hasMany('App\Models\interfaz_contenidos','imagen_id');
    }
    
}
