<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alergias extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','descripcion','estado'];


      //Relacion de uno a muchos
public function soli(){
    return $this->hasMany('App\Models\especificar_alergias','alergias_id');
}
}