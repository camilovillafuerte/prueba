<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class s_aprobadas extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','solicitud_id','PDF','tipo','estado'];

    //Relacion de uno a muchos
    public function solicitud(){  
    return $this->hasMany('App\Models\solicitudes','solicitud_id');
    }
   

}
