<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Firma_receptor extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id','titulo_academico','nombre_receptor','cargo_receptor','institucion_receptor'];
    public $table = "firma_receptors";

    public function convenios(){
        return $this->hasMany('App\Models\convenios','freceptor_id');
    }
}
