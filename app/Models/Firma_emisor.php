<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Firma_emisor extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id','titulo_academico','nombre_emisor','cargo_emisor','institucion_emisor'];
    public $table = "firma_emisors";

    public function convenios(){
        return $this->hasMany('App\Models\convenios','femisor_id');
    }
}
