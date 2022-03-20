<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class especificar_alergias extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','solicitud_id','alergias_id','tipo','estado'];


    public function solicitud(){
        return $this->hasMany('App\Models\solicitud_modalidades');
    }
    public function alergias(){
        return $this->hasMany('App\Models\alergias');
    }
}
