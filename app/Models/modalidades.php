<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modalidades extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','tipo_modalidad','tipo','estado'];

    public function solicitud1(){
        return $this->hasMany('App\Models\solicitud_modalidades','modalidad1_id');
    }
    public function solicitud2(){
        return $this->hasMany('App\Models\solicitud_modalidades','modalidad2_id');
    }


    public function solicitudbecas1(){
        return $this->hasMany('App\Models\solicitud_becas','modalidad1_id');
    }
    public function solicitudbecas2(){
        return $this->hasMany('App\Models\solicitud_becas','modalidad2_id');
    }
}
