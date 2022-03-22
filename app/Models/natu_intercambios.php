<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class natu_intercambios extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','descripcion','tipo','estado'];


    public function solicitud(){
    return $this->hasMany('App\Models\solicitudes','naturaleza_id');
    }

    public function bene_becas(){
    return $this -> belongsToMany('App\Models\beneficios_becas');
    }
}
