<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class enfermedades_cronicas extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','solicitud_id','enfermedades_tratamiento','estado'];


    public function solicitud(){
        return $this->hasMany('App\Models\solicitudes');
    }
}
