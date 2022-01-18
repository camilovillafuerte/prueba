<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class firmas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id','titulo_academico','nombres','cargo','institucion'];
    public $table = "firmas";

    public function convenios(){
        return $this->hasMany('App\Models\convenios','femisor_id');
    }
    public function convenios2(){
        return $this->hasMany('App\Models\convenios','freceptor_id');
    }
}
