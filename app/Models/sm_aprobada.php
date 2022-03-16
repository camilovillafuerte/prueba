<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sm_aprobada extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','solicitud_id','personal_id','PDF', 'estado'];

    //Relacion de uno a muchos
    public function solicitud(){  
    return $this->hasMany('App\Models\solicitud_modalidades',);
    }
    //Relacion de uno a muchos
    public function Personal() {
    return $this->hasMany('App\Models\personal');
    }

}
