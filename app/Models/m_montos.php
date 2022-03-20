<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_montos extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','descripcion','tipo','estado'];


      //Relacion de uno a muchos
public function soli(){
    return $this->hasMany('App\Models\solicitud_modalidades','montos_id');
}
}
