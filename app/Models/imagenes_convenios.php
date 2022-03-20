<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class imagenes_convenios extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','nombre','url_imagen','estado'];
    public $table = "imagenes_convenios";

    public function convenios(){
        return $this->hasMany('App\Models\convenios','imagen1_id');
    }
    public function convenios2(){
        return $this->hasMany('App\Models\convenios','imagen2_id');
    }
    public function solicitud_modalidad(){
        return $this->hasMany('App\Models\solicitud_modalidades','logo_id');
    }
}