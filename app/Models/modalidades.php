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
        return $this->hasMany('App\Models\solicitudes','modalidad1_id');
    }
    public function solicitud2(){
        return $this->hasMany('App\Models\solicitudes','modalidad2_id');
    }


}
