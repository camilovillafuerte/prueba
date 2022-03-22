<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class enfermedades extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    public $timestamps = false;
    protected $fillable = ['id','solicitud_id','nombre_enfermedad','tratamiento',
    'alergias','poliza_seguro'];


    public function solicitud(){
        return $this->hasMany('App\Models\solicitudes');
    }
}
